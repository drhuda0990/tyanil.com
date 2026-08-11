<?php

namespace App\Http\Controllers;

use App\AdditionalFeatures;
use Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Customer;
use App\City;
use App\General;
use App\Definition;
use Illuminate\Support\Facades\Storage;
use App\PaymentRequest;
use App\PaymentResponse;
use App\GeneralSetting;
use App\Cart;
use App\CustomerAddress;
use App\Discount;
use App\Rules\NumWords;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\SerInvoiceItemsFeature;
use App\ServiceInvoiceItem;
use App\Service;
use App\ServiceInvoice;
use App\StoreNotification;
use App\Services\PaymentService;
use App\Support\InternalNotificationService;
use App\Support\StoreSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Session;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;
use Illuminate\Auth\Events\Registered;
use Firebase\JWT\JWT;
use MacsiDigital\Zoom\Meeting;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function invoice($id, $deails = 0)
    {
        $gSetting = StoreSettings::get();
        $invoice   = ServiceInvoice::find(decrypt($id));
        if ($invoice) {
            $customer = $invoice->customer;
            $serviceInvoice = ServiceInvoice::invoicePrice($invoice->id);
            $total = $serviceInvoice['total'];
            $shipment_price = $serviceInvoice['shipment'];
            $tax = '1.' . $gSetting->tax;
            $taxamount = $total - ($total / $tax);
            $taxamount = round($taxamount, 2);
            $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
                new Seller($gSetting->name), // seller name        
                new TaxNumber($gSetting->commercial_register), // seller tax number
                new InvoiceDate(date(DATE_ISO8601, strtotime($invoice->created_at))), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
                new InvoiceTotalAmount($total), // invoice total amount
                new InvoiceTaxAmount($taxamount) // invoice tax amount
                // TODO :: Support others tags
            ])->render();
        }
        $SQL = array(
            "invoice"         => $invoice,
            "customer"         => $customer,
            "total"         => $total,
            "tax"         => $taxamount,
            'displayQRCodeAsBase64' => $displayQRCodeAsBase64,
        );
        if ($deails == 1) {
            return view('customer.detailsInvoice', $SQL);
        } else {
            return view('customer.invoice', $SQL);
        }
    }

    public function manualLogin()
    {
        $user = Customer::firstOrCreate(['phone' => '500000001']);
        $user->forceFill(
            [
                'name' => 'Demo Customer',
                'email' => 'customer@example.test',
                'password' => Hash::make('password'),
                'activate' => 1,
            ]
        )->save();

        Auth::guard('customer')->login($user);
        General::addCustomerCart();

        return redirect()->intended(route('customer.cart'));
    }
    public function login()
    {
        return view('homepage.login');
    }
    public function loginInst()
    {
        return view('homepage.loginInst');
    }
    public function dashboard()
    {
        $customerServices = Auth::guard('customer')->user()->services;
        return view('customer.dashboard', compact('customerServices'));
    }

    public function notifications()
    {
        $customer = Auth::guard('customer')->user();
        $notifications = StoreNotification::where('audience', 'customer')
            ->where('customer_id', $customer->id)
            ->latest()
            ->paginate(15);

        return view('customer.notifications', compact('notifications'));
    }

    public function notificationRead($id)
    {
        $customer = Auth::guard('customer')->user();
        $notification = StoreNotification::where('audience', 'customer')
            ->where('customer_id', $customer->id)
            ->where('id', decrypt($id))
            ->firstOrFail();

        $notification->markAsRead();

        return $notification->action_url
            ? redirect($notification->action_url)
            : redirect()->route('customer.notifications');
    }
    public function info()
    {
        return view('customer.info');
    }

    public function itemDetails(request $request, $id)
    {
        $customer = Auth::guard('customer')->user();
        $serviceInvoiceItem = ServiceInvoiceItem::find(decrypt($id));
        if ($request->isMethod('post') && $serviceInvoiceItem->customer_id == $customer->id) {
            $this->validate($request, [
                'details'           => 'required',
            ]);
            $serviceInvoiceItem->details           = $request->details;
            $serviceInvoiceItem->save();
            $body = 'تحديث تفاصيل خدمة قام العميل:' . $customer->name . '     بتحديث تفاصيل الخدمة التالية:' . $serviceInvoiceItem->title;
            General::ServiceAdminNotify($serviceInvoiceItem->service, 'تحديث تفاصيل خدمة', $body, 1, 1);
            InternalNotificationService::serviceItemUpdated($serviceInvoiceItem);
            return redirect()->back()->with('info', 'تم تحديث طلبك بنجاح');
        } else {
            abort(404);
        }
    }
    public function infoPost(request $request)
    {
        if ($request->isMethod('post')) {
            $customer = Auth::guard('customer')->user();
            $firstTime = $customer->email == null ? 1 : 0;
            $this->validate($request, [
                'name'           => ['string', 'required', new NumWords(2)],
                'email'    =>  'email|unique:customers,email,' . $customer->id,
            ]);
            $customer->email           = $request->email;
            $customer->name           = $request->name;
            $customer->save();
            if ($firstTime == 1) {
                return redirect()->back()->with('needAddress', $firstTime);
            } else {
                return redirect()->back()->with('info', 'تم تحديث ملفك الشخصي بنجاح');
            }
        } else {
            abort(404);
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();  // Log out the customer

        $request->session()->invalidate();  // Invalidate the session
        $request->session()->regenerateToken();  // Regenerate the CSRF token

        return redirect('/');  // Redirect to the home page or login page
    }
    public function services()
    {
        return view('customer.services');
    }

    public function loginPost(Request $request)
    {
        if ($request->filled('password')) {
            $this->validate($request, [
                'login' => 'required_without:phone|string|max:255',
                'phone' => 'required_without:login|string|max:255',
                'password' => 'required|string',
            ]);

            $customer = $this->findCustomerForLogin($request->input('login', $request->phone));

            if (!$customer || !$customer->activate || !$customer->password || !Hash::check($request->password, $customer->password)) {
                return redirect()->back()->with('info', 'بيانات الدخول غير صحيحة');
            }

            Auth::guard('customer')->login($customer, $request->boolean('remember'));
            General::addCustomerCart();

            if (count(Auth::guard('customer')->user()->carts) > 0) {
                return redirect()->intended(route('customer.cart'));
            }

            return redirect()->intended(route('customer.dashboard'));
        }

        if (request()->url() == route('customer.login')) {
            $phone = $this->normalizeCustomerPhone($request->phone);
            if (!$phone) {
                return redirect()->back()
                    ->withErrors(['phone' => 'رقم الجوال يجب أن يكون بصيغة سعودية صحيحة مثل 5XXXXXXXX'])
                    ->withInput();
            }

            $request->merge(['phone' => $phone]);
            $this->validate($request, [
                'phone'     =>   [
                    'required',
                    'regex:/^5[0-9]{8}$/', // Ensures phone starts with 5 and has exactly 9 digits
                ]
            ]);

            // Generate a random OTP
            $otp = rand(100000, 999999);
            $customer = Customer::where('phone', $request->phone)->first();

            if (!$customer) {
                event(new Registered($customer = Customer::create([
                    'phone'         => $request->phone,
                ])));
            }
            // dd($customer);
            $customer->last_code = $otp;
            $customer->save();
            // Store OTP and phone number in the session
            Session::put('code_send', $otp);
            Session::put('id_login', $customer->id);
            $title = "رمز الدخول لمتجر تيانيل : ";
            $body = $otp;
            $get_return = General::sendSMS($title, $body,  'customer Login', $customer->phone);
            $type_send_text = "تم إرسال الرمز إلى جوالك ";

            // Redirect to the OTP verification form
            return redirect()->back()->with('code_send', 'تم إرسال الكود بنجاح.');
        }
    }

    public function registerPost(Request $request)
    {
        $phone = $this->normalizeCustomerPhone($request->phone);
        if (!$phone) {
            return redirect()->back()
                ->withErrors(['phone' => 'رقم الجوال يجب أن يكون بصيغة سعودية صحيحة مثل 5XXXXXXXX'])
                ->withInput();
        }

        $request->merge([
            'phone' => $phone,
            'email' => strtolower(trim((string) $request->email)),
        ]);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:254|unique:customers,email',
            'phone' => 'required|string|regex:/^5[0-9]{8}$/|unique:customers,phone',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        $customer = new Customer();
        $customer->forceFill([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'activate' => 1,
            'newsletter' => $request->boolean('newsletter'),
        ])->save();

        event(new Registered($customer));
        $this->sendWelcomeEmail($customer);
        Auth::guard('customer')->login($customer);
        General::addCustomerCart();

        if (count(Auth::guard('customer')->user()->carts) > 0) {
            return redirect()->intended(route('customer.cart'))->with('message', 'تم إنشاء حسابك بنجاح');
        }

        return redirect()->intended(route('customer.dashboard'))->with('message', 'تم إنشاء حسابك بنجاح');
    }

    public function emailVerificationNotice()
    {
        $customer = Auth::guard('customer')->user();

        if ($customer && $customer->hasVerifiedEmail()) {
            return redirect()->route('customer.dashboard');
        }

        return view('auth.customer.verify');
    }

    public function emailVerificationVerify(Request $request, $id, $hash)
    {
        $customer = Customer::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($customer->getEmailForVerification()))) {
            abort(403);
        }

        if (! $customer->hasVerifiedEmail()) {
            $customer->markEmailAsVerified();
            $customer->email_verified = 1;
            $customer->save();
        }

        if (! Auth::guard('customer')->check()) {
            Auth::guard('customer')->login($customer);
        }

        return redirect()->route('customer.dashboard')->with('message', 'تم تفعيل بريدك الإلكتروني بنجاح');
    }

    public function emailVerificationResend(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        if (! $customer) {
            return redirect()->route('customer.login');
        }

        if ($customer->hasVerifiedEmail()) {
            return redirect()->route('customer.dashboard')->with('message', 'بريدك الإلكتروني مفعل بالفعل');
        }

        $customer->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }

    public function emailUnsubscribe(Request $request, Customer $customer)
    {
        $customer->prevent_advertising_emails = 1;
        $customer->save();

        if ($request->isMethod('post')) {
            return response('unsubscribed', 200)->header('Content-Type', 'text/plain; charset=UTF-8');
        }

        return view('auth.customer.unsubscribe', compact('customer'));
    }

    private function sendWelcomeEmail(Customer $customer): void
    {
        if (empty($customer->email)) {
            return;
        }

        $template = Definition::where('slug', 'welcome_email')
            ->where('activate', 1)
            ->value('content');

        if (! $template) {
            $template = '<p>مرحباً [customer_name]،</p><p>أهلاً بك في تيانيل. حسابك جاهز لتسوق منتجات نسائية مختارة بعناية، ويمكنك متابعة طلباتك وعناوين الشحن من لوحة حسابك.</p><p>نتمنى لك تجربة تسوق راقية.</p>';
        }

        $body = str_replace(
            ['[customer_name]', '[site_url]', '[store_name]', '[account_url]'],
            [e($customer->name ?: 'عميلتنا'), e(url('/')), e(config('app.name', 'تيانيل')), e(route('customer.dashboard'))],
            $template
        );

        General::sendMail('مرحباً بك في تيانيل', $body, 'customer welcome', $customer->email);
    }

    private function findCustomerForLogin(?string $identifier): ?Customer
    {
        $identifier = trim((string) $identifier);
        $phone = $this->normalizeCustomerPhone($identifier);

        return Customer::where(function ($query) use ($identifier, $phone) {
            $query->where('email', strtolower($identifier))
                ->orWhere('identity', $identifier);

            if ($phone) {
                $query->orWhere('phone', $phone);
            } else {
                $query->orWhere('phone', $identifier);
            }
        })->first();
    }

    private function normalizeCustomerPhone(?string $phone): ?string
    {
        $phone = preg_replace('/\D+/', '', (string) $phone);

        if (str_starts_with($phone, '00966')) {
            $phone = substr($phone, 5);
        } elseif (str_starts_with($phone, '966')) {
            $phone = substr($phone, 3);
        } elseif (str_starts_with($phone, '0')) {
            $phone = substr($phone, 1);
        }

        return preg_match('/^5[0-9]{8}$/', $phone) ? $phone : null;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function loginCode(Request $request)
    {
        $this->validate($request, [
            'id_login'      => 'required|string',
            'code_send'     => 'required|numeric|min:5',
        ]);
        $id_login    = $request->id_login;
        $code_send      = $request->code_send;

        $customer = Customer::where('id', '=', $id_login)->where('last_code', '=', $code_send)->first();
        if (empty($customer)) {
            $type_send_text = "الكود المرسل غير صحيح";
            return redirect()->back()
                ->with('code_send', $type_send_text)
                ->with('id_login', $id_login)
                ->with('info', $type_send_text);
        } else {
            // dd($customer,Auth::guard('customer'));
            if (Auth::guard('customer')->loginUsingId($customer->id)) {
                General::addCustomerCart();
                if (count(Auth::guard('customer')->user()->carts) > 0) {
                    return redirect()->intended(route('customer.cart'));
                } else {
                    return redirect()->intended(route('customer.dashboard'));
                }
            }
        }
    }

    protected function create(array $data)
    {
        return Customer::create([
            'phone'         => $data['phone'],
        ]);
    }
    public function cart()
    {
        $paymentService = new PaymentService();

        $customer = Auth::guard('customer')->user();
        $cities = City::orderBy('city_arName')->get();
        $checkoutAddress = null;
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($customer) {
            if ($customer)
                $all_carts = Auth::guard('customer')->user()->carts;
            if (Auth::guard('customer')->user()->cashCartBackUsage) {
                Auth::guard('customer')->user()->cashCartBackUsage()->delete();
            }
            $checkoutAddress = $customer->customerAddresses()->latest()->first();
        } else {
            $all_carts   =  Cart::where([['user_ip', $ip], ['customer_id', null]])->get();
        }

        foreach ($all_carts as $cart) {
            if ($cart->time != null) {
                $existRegTime = General::existRegTime($cart->service->id, $cart->time);
                if ($existRegTime) {
                    $cart->time = null;
                    $cart->save();
                }
            }
            if ($cart->service) {
                if ($cart->service->activate != 1) {
                    $cart->delete();
                    continue;
                }
                if ($cart->service->advertizment_service == 1) {
                    $cart->delete();
                    continue;
                }
                if ($cart->service->not_available == 1) {
                    $cart->delete();
                    continue;
                }
                if ($cart->service->is_sold_out) {
                    $cart->delete();
                    continue;
                }
                if (Service::servicePrice($cart->service_id) != $cart->amount) {
                    $cart->amount = Service::servicePrice($cart->service_id);
                    $cart->service_price = Service::servicePrice($cart->service_id);
                    $cart->save();
                }
            } else {
                $cart->delete();
            }
        }

        //   dd($carts);
        $carts = $this->cartItems();
        $cartTotalPrice = $paymentService->cartTotalPrice($carts);
        $itemsTotal = $cartTotalPrice['items_total'];
        $shipmentPrice = $cartTotalPrice['shipment_price'];
        $totalPrice = $cartTotalPrice['total_price'];
        $existShipment = $cartTotalPrice['existShipment'];
        $paymentOptions = $this->availableCheckoutPaymentOptions($this->generalSettings());
        $defaultPaymentMethod = array_key_first($paymentOptions);

        return view('customer.cart', compact('carts', 'itemsTotal', 'shipmentPrice', 'totalPrice', 'existShipment', 'cities', 'checkoutAddress', 'paymentOptions', 'defaultPaymentMethod'));
    }
    public function cartRemove($id)
    {
        $idDecrypt = decrypt($id);
        $customer = Auth::guard('customer')->user();
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($idDecrypt != 0) {
            if ($customer) {
                $cart = Cart::where([['customer_id', $customer->id], ['service_id', $idDecrypt]])->first();
            } else {
                $cart = Cart::where([['user_ip', $ip], ['service_id', $idDecrypt]])->first();
            }
            if ($cart) {
                $cart->delete();
            }
        } else {
            if ($customer) {
                Auth::guard('customer')->user()->carts()->delete();
            } else {
                $carts = Cart::where('user_ip', $ip)->get();
                foreach ($carts as $cart) {
                    $cart->delete();
                }
            }
        }
        return redirect()->back()->with(['message' => 'تم الحذف بنجاح']);
    }
    public function cartItems()
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $carts = Auth::guard('customer')->user()->carts;
        } else {
            $carts   =  Cart::where([['user_ip', $ip], ['customer_id', null]])->get();
        }
        return $carts;
    }
    public static function cartItemPrice($carts)
    {
        $total_price = 0;
        $additional_feature_price = 0;
        foreach ($carts as $cart) {
            if (json_decode($cart->additional_features) != null) {
                $additional_features = General::extractFromArray($cart->additional_features);
                foreach ($additional_features as $additional_feature) {
                    $additional_feature = AdditionalFeatures::find($additional_feature);
                    if ($additional_feature) {
                        $additional_feature_price +=  $additional_feature->price;
                    }
                }
            }
            $total_price += $cart->amount;
        }

        $total_price += $additional_feature_price;
        return ['total_price' => $total_price];
    }

    public function cart_apply_post(Request $request)
    {
        $result = $this->addToCart($request);

        if ($result !== true) {
            return redirect()->back()->with('message', $result);
        }

        return redirect()->back()->with(
            'cartAdded',
            'تم الإضافة بنجاح'
        );
    }
    public function addToCart($request)
    {
        $service = Service::find(decrypt($request->id));
        if (!$service) {
            abort(404);
        }
        if (!$service->isPurchasable()) {
            return $service->is_sold_out
                ? 'نفذت كمية هذا المنتج حالياً'
                : 'هذا المنتج غير متاح حالياً';
        }
        $service_price = Service::servicePrice(decrypt($request->id));
        $amount = $service_price;
        //-------------------- Check Get Discount
        $ip = $_SERVER['REMOTE_ADDR'];
        $customer = Auth::guard('customer')->user();
        $cartQuantity = $this->cartQuantityForService($service, $customer, $ip);

        if (!$service->hasAvailableQuantity($cartQuantity + 1)) {
            return 'الكمية المتاحة من المنتج "' . $service->title . '" هي ' . (int) $service->quantity;
        }
        // if ($customer) {
        //     $cart   = Cart::where([['service_id', $service->id], ['customer_id', Auth::guard('customer')->id()]])->first();
        // } else {
        //     $cart   = Cart::where([['service_id', $service->id], ['user_ip', $ip]])->first();
        // }
        // if (!$cart) {
        $cart   = new Cart();
        // }
        // dd($request->features);
        $cart->title             = $service->title;
        $cart->additional_features = json_encode($request->features);
        $cart->service_id         = $service->id;
        $cart->book_type         = null;
        $cart->customer_id        = Auth::guard('customer')->user() ? Auth::guard('customer')->user()->id : null;
        $cart->amount            = $amount;
        $cart->service_price      = $service_price;
        $cart->user_ip = $ip;
        // $cart->term_accept = $request->term_accept;
        // $cart->how_know_us = $request->how_know_us;
        // $cart->note = $request->note;
        $cart->save();

        return true;
    }
    public function code_id(Request $request)
    {
        $message_content = "";
        $id_code   = strtolower($request->code_text);
        //   dd(Auth::guard('customer')->user());
        $id_customer = Auth::guard('customer')->user() ? Auth::guard('customer')->user()->id : null;
        //------------------
        $get_discount = $this->get_discount($id_code);
        //------------------

        $get_discount['discount_input'] =
            "
          <input type='hidden' value='" . $get_discount['discount_id'] . "' name='discount_id' form='form_submit_cart'>
        ";
        //------------------
        return $get_discount;
    }
    public function get_discount($id_code, $id = null)
    {
        $Status = $discount_value = $price_dis = 0;
        $message_content = $discount_id = $discount_code = $message_content2 = "";
        $get_discount = Discount::where([['code', '=', $id_code], ['activate', 1]])->first();
        if ($id) {
            $get_discount = Discount::where([['id', '=', $id_code], ['activate', 1]])->first();
        }
        if (empty($get_discount)) { // Check Code is Existing

            $message_content = "لم يتم إيجاد بيانات الكود المدخل";

            goto message_content;
        }

        $discount_id  = encrypt($get_discount->id);
        $discount_code = $get_discount->code;
        //------------------

        $carts = $this->cartItems();
        $paymentService = new PaymentService();
        $cartTotalPrice = $paymentService->cartTotalPrice($carts);
        $price = $cartTotalPrice['total_price'];
        $discount_value = $get_discount->discount;
        $discount_eq = ($price / 100) * $discount_value;
        $price_dis = $price - $discount_eq;
        //------------------


        //------------------
        // if (!(empty($get_discount->customer_id))) { // Check Code is Trainee
        //   if ($get_discount->service != $id_customer) {
        //     $message_content = "
        //           <span class='color-red'>
        //             443 -
        //             الكود المدخل غير صحيح
        //           </span>
        //         ";
        //     goto message_content;
        //   }
        // }
        //------------------
        if ($get_discount->date_activate == 1) { // Check Code is Date

            $Date_today = date('Y-m-d');
            $Date_today_str = date('Y-m-d', strtotime($Date_today));

            $date_1 = $get_discount->date_1;
            $date_2 = $get_discount->date_2;

            $date_1_str = date('Y-m-d', strtotime($date_1));
            $date_2_str = date('Y-m-d', strtotime($date_2));

            if (($Date_today >= $date_1_str) && ($Date_today <= $date_2_str)) {
                //echo "is between";
            } else {
                $price_dis = $price;
                $message_content = "الكود المدخل غير صحيح";
                goto message_content;
            }
        }
        //------------------
        $Status = 1;
        if ($discount_value == 0) {
            $message_content = "تم إضافة كود المسوق بنجاح";
        } else {
            $message_content = "مبروك تم تطبيق الكود";
            $message_content2 = "
            <div >
              <big class='color-second'>
              مبروك لقد حصلت على خصم
              " . $discount_value . " %
              </big>
              <br>
               السعر من
              " . $price . "
              إلى
              " . $price_dis . "
            </div>
          ";
        }
        //------------------
        message_content:
        return [
            'success'         => true,
            'status'          => $Status,
            'message'         => $message_content,
            'message_content2' => $message_content2,
            'discount_id'     => $discount_id,
            'discount_code'   => $discount_code,
            'discount_amount' => $price_dis,
            'discounts'       => $discount_value,
        ];
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    public function cartSubmit(Request $request)
    {
        $paymentService = new PaymentService();
        if (Auth::guard('customer')->user()->carts() != null) {
            $customer = Auth::guard('customer')->user();
            $generalSettings = $this->generalSettings();
            $tapSecretAPIKey = $generalSettings->tapSectretKey;
            $carts = $this->cartItems();
            if ($stockMessage = $this->cartStockMessage($carts)) {
                return redirect()->route('customer.cart')->with('message', $stockMessage);
            }

            $cartTotalPrice = $paymentService->cartTotalPrice($carts);
            $existShipment = $cartTotalPrice['existShipment'];
            if ($existShipment) {
                $address = $this->storeCheckoutAddress($request, $customer);
                $request->merge(['address' => $address->id]);
            }
            $key = "Bearer $tapSecretAPIKey";
            $curl = curl_init();
            $url = \Request::fullUrl();
            $url2 = route('tap.check');
            $currency = "SAR";
            $shipment_price = 0;
            // dd($tapSecretAPIKey);
            $discount_id = $request->discount_id;
            $discountModel = null;
            $cid = $customer->id . rand(10, 100);
            $amount = 0;
            $shipment_price_saved = 0;
            foreach (Auth::guard('customer')->user()->carts as $cart) {
                // if ($cart->amount == 0) {
                //     // dd('here');
                //     $paymentRequest = $this->newPaymentRequest(null, $request, $cart->amount, $cart, $discount_id, '');
                //     $this->customerServiceOrder($paymentRequest, 0, 0, 0, $cart, 'free');
                // }
                $cart->time = null;
                $cart->payment_code = $cid;
                //     $cart->shipment_price = $this->shipmentPrice();
                $cart->save();
                // }
            }
            Auth::guard('customer')->user()->load('carts'); // refresh relationship after deleting


            $amount = $cartTotalPrice['total_price'];
            if ($discount_id) {
                $discount_id = decrypt($discount_id);
                $discountModel = Discount::find($discount_id);
                $get_discount = $this->get_discount($discount_id, 1);
                // dd($get_discount);
                $amount = $get_discount['discount_amount'];
            }
            if ($amount == 0) {
                $freePayment = $this->localPaymentData(0, 'FREE');
                $paymentRequest = $this->newPaymentRequest($freePayment, $request, 0, collect($carts), $discount_id, 'free');
                $paymentService->customerServiceOrder($paymentRequest, $paymentRequest->payment_id, $freePayment, $this->localPaymentDefinition());

                return redirect()->route('customer.cart')->with(
                    'message',
                    'تم  إضافة الطلب بنجاح '
                );
            }

            // if (count(Auth::guard('customer')->user()->carts) == 0) {
            //     return redirect()->route('customer.dashboard')->with(
            //         'message',
            //         'تم  إضافة الطلب بنجاح '
            //     );
            // }


            $amount = number_format((float)$amount, 2, '.', '');
            $paymentMethod = $this->resolveCheckoutPaymentMethod($request, $generalSettings);

            if ($paymentMethod === 'tamara') {
                $tamaraCheckout = $this->startTamaraCheckout($request, $customer, $carts, $cartTotalPrice, (float) $amount, $discountModel);

                if (! $tamaraCheckout['success']) {
                    return redirect()->route('customer.cart')
                        ->withInput()
                        ->with('message', $tamaraCheckout['message']);
                }

                return redirect($tamaraCheckout['payment_url']);
            }

            if ($paymentMethod === 'moyasar' && $this->moyasarPaymentIsReady($generalSettings)) {
                $moyasarPayment = $this->localPaymentData((float) $amount, 'INITIATED');
                $paymentRequest = $this->newPaymentRequest($moyasarPayment, $request, $amount, $carts, $discount_id, 'moyasar');
                $paymentRequest->payment_url = route('moyasar.form', ['paymentRequest' => $paymentRequest->id]);
                $paymentRequest->save();

                return redirect($paymentRequest->payment_url);
            }

            if (!$this->tapPaymentIsReady($generalSettings)) {
                $manualPayment = $this->localPaymentData((float) $amount, 'MANUAL');
                $paymentRequest = $this->newPaymentRequest($manualPayment, $request, $amount, $carts, $discount_id, 'manual');
                $paymentService->customerServiceOrder($paymentRequest, $paymentRequest->payment_id, $manualPayment, $this->localPaymentDefinition());

                return redirect()->route('customer.dashboard')->with(
                    'message',
                    'تم إنشاء الطلب بنجاح. الدفع الإلكتروني غير مفعل حالياً، ويمكن للمدير متابعة الطلب من لوحة التحكم.'
                );
            }
            // dd($amount, $discount_id);
            $phone = $customer->phone;
            $email = $customer->email;
            $name = $customer->name;
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.tap.company/v2/charges",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\"amount\":$amount,\"currency\":\"$currency\",\"threeDSecure\":true,\"save_card\":false,\"receipt\":{\"email\":false,\"sms\":true},\"reference\":{\"transaction\":\"$cid\",\"order\":\"$cid\"},\"customer\":{\"first_name\":\"$name\",\"last_name\":\"$name\",\"email\":\"$email\",\"phone\":{\"number\":\"$phone\"}},\"source\":{\"id\":\"src_all\"},\"post\":{\"url\":\"$url\"},\"redirect\":{\"url\":\"$url2\"}}",
                CURLOPT_HTTPHEADER => array(
                    "authorization: $key",
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            $data = json_decode($response);

            $response = json_decode($response, true);
            // dd($data);
            curl_close($curl);

            if (isset($response['errors'])) {
                //   dd($response['errors']);
                return back()->with('message', 'حدث خطأ ما');
            }

            if ($err) {

                return back()->with('message', 'حدث خطأ ما');
            } else {
                $existPaymentRequest = PaymentRequest::where('payment_id', $data->id)->first();

                if (!$existPaymentRequest) {
                    $paymentRequest = $this->newPaymentRequest($data, $request, $amount, $carts, $discount_id, 'tap');
                    $redirectUrl = $data->transaction->url;
                    return redirect($redirectUrl);
                } else {

                    return back()->with('message', ' تم استخدام هذه العملية مسبقاً');
                }
            }
        } else {
            return redirect()->back()->with(['message' => 'السلة فارغة']);
        }
    }

    public function check(Request $request)
    {
        $tap_id = $request->tap_id;
        $paymentService = new PaymentService();
        $customer = Auth::guard('customer')->user();
        return $paymentService->tapCheck($tap_id, $customer);
        // dd($request);
    }

    public function moyasarForm(PaymentRequest $paymentRequest)
    {
        $customer = Auth::guard('customer')->user();

        if (! $customer || (int) $paymentRequest->customer_id !== (int) $customer->id || $paymentRequest->payment_type !== 'moyasar') {
            abort(404);
        }

        $settings = $this->moyasarSettings($this->generalSettings());

        if (! $settings['enabled'] || empty($settings['public_key'])) {
            return redirect()->route('customer.cart')->with('message', 'بوابة الدفع غير مفعلة حالياً');
        }

        return view('customer.moyasar', [
            'paymentRequest' => $paymentRequest,
            'amountHalalas' => $this->moyasarAmountInHalalas($paymentRequest->amount),
            'publicKey' => $settings['public_key'],
            'merchantId' => $settings['merchant_id'],
            'callbackUrl' => $this->moyasarCallbackUrl($paymentRequest),
            'isLiveKeyOnHttp' => $this->isLocalLiveMoyasarPage($settings['public_key']),
        ]);
    }

    public function moyasarCallback(Request $request, PaymentRequest $paymentRequest)
    {
        $customer = Auth::guard('customer')->user();

        if (! $customer || (int) $paymentRequest->customer_id !== (int) $customer->id || $paymentRequest->payment_type !== 'moyasar') {
            abort(404);
        }

        $moyasarPaymentId = (string) $request->query('id', '');

        if ($moyasarPaymentId === '') {
            return redirect()->route('customer.cart')->with('message', 'لم تصل بيانات عملية الدفع من مزود الخدمة');
        }

        if (ServiceInvoice::where('refrence_id', $moyasarPaymentId)->exists()) {
            return redirect()->route('customer.dashboard')->with('message', 'تم إستكمال الدفع بنجاح');
        }

        $settings = $this->moyasarSettings($this->generalSettings());

        if (empty($settings['secret_key'])) {
            return redirect()->route('customer.cart')->with('message', 'بوابة الدفع غير مهيأة بالكامل');
        }

        $paymentData = $this->fetchMoyasarPayment($moyasarPaymentId, $settings['secret_key']);

        if ($paymentData['error'] || ! $paymentData['data']) {
            Log::warning('Moyasar payment lookup failed', [
                'payment_request_id' => $paymentRequest->id,
                'payment_id' => $moyasarPaymentId,
                'error' => $paymentData['error'],
            ]);

            return redirect()->route('customer.cart')->with('message', 'تعذر التحقق من عملية الدفع');
        }

        $data = $paymentData['data'];
        $status = strtolower((string) ($data->status ?? ''));
        $currency = strtoupper((string) ($data->currency ?? ''));
        $gatewayAmount = (int) ($data->amount ?? 0);
        $expectedAmount = $this->moyasarAmountInHalalas($paymentRequest->amount);

        $paymentRequest->payment_id = $data->id ?? $moyasarPaymentId;
        $paymentRequest->status = $data->status ?? 'unknown';
        $paymentRequest->response = json_encode($data);
        $paymentRequest->save();

        if ($status !== 'paid' || $currency !== 'SAR' || $gatewayAmount !== $expectedAmount) {
            Log::warning('Moyasar payment rejected by local verification', [
                'payment_request_id' => $paymentRequest->id,
                'payment_id' => $moyasarPaymentId,
                'status' => $status,
                'currency' => $currency,
                'gateway_amount' => $gatewayAmount,
                'expected_amount' => $expectedAmount,
            ]);

            return redirect()->route('customer.cart')->with('message', 'لم تكتمل عملية الدفع أو أن بيانات العملية غير مطابقة');
        }

        $paymentResponse = PaymentResponse::firstOrNew([
            'payment_id' => $moyasarPaymentId,
            'payment_type' => 'moyasar',
        ]);

        if (! $paymentResponse->exists) {
            $newPaymentResponse = collect($paymentRequest->toArray())
                ->except(['id', 'created_at', 'updated_at', 'cart_items', 'check_num'])
                ->toArray();

            $paymentResponse->forceFill($newPaymentResponse);
        }

        $paymentResponse->response = json_encode($data);
        $paymentResponse->status = $data->status;
        $paymentResponse->customer_id = $customer->id;
        $paymentResponse->save();

        $orderData = json_decode(json_encode($data));
        $orderData->amount = $gatewayAmount / 100;

        $paymentDefinition = General::get_definition_id('electric_payment') ?: 0;
        $paymentService = new PaymentService();
        $paymentService->customerServiceOrder($paymentRequest, $moyasarPaymentId, $orderData, $paymentDefinition);

        return redirect()->route('customer.dashboard')->with('message', 'تم إستكمال الدفع بنجاح');
    }

    public static function generalSettings()
    {
        return StoreSettings::get();
    }

    private function moyasarPaymentIsReady($generalSettings): bool
    {
        $settings = $this->moyasarSettings($generalSettings);

        return $settings['enabled'] && ! empty($settings['public_key']) && ! empty($settings['secret_key']);
    }

    private function moyasarSettings($generalSettings): array
    {
        $enabled = $generalSettings->moyasarPaymentActivate;

        if ($enabled === null) {
            $enabled = config('services.moyasar.enabled');
        }

        return [
            'enabled' => filter_var($enabled, FILTER_VALIDATE_BOOLEAN),
            'merchant_id' => $generalSettings->moyasarMerchantId ?: config('services.moyasar.merchant_id'),
            'public_key' => $generalSettings->moyasarPublicKey ?: config('services.moyasar.public_key'),
            'secret_key' => $generalSettings->moyasarSecretKey ?: config('services.moyasar.secret_key'),
        ];
    }

    private function tapPaymentIsReady($generalSettings): bool
    {
        return (bool) $generalSettings->tapPaymentActivate && !empty($generalSettings->tapSectretKey);
    }

    private function moyasarAmountInHalalas($amount): int
    {
        return (int) round(((float) $amount) * 100);
    }

    private function moyasarCallbackUrl(PaymentRequest $paymentRequest): string
    {
        $appUrl = rtrim((string) config('app.url'), '/');

        if ($appUrl && ! str_contains($appUrl, '127.0.0.1') && ! str_contains($appUrl, 'localhost')) {
            return $appUrl . route('moyasar.callback', ['paymentRequest' => $paymentRequest->id], false);
        }

        return route('moyasar.callback', ['paymentRequest' => $paymentRequest->id]);
    }

    private function isLocalLiveMoyasarPage(string $publicKey): bool
    {
        $host = request()->getHost();

        return in_array($host, ['127.0.0.1', 'localhost', '::1'], true)
            && str_starts_with($publicKey, 'pk_live_');
    }

    private function fetchMoyasarPayment(string $paymentId, string $secretKey): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.moyasar.com/v1/payments/' . rawurlencode($paymentId),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $secretKey . ':',
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($error) {
            return ['data' => null, 'error' => $error];
        }

        $data = json_decode($response);

        if ($statusCode >= 400 || ! $data) {
            return ['data' => null, 'error' => $response ?: 'Invalid Moyasar response'];
        }

        return ['data' => $data, 'error' => null];
    }

    private function availableCheckoutPaymentOptions($generalSettings): array
    {
        $options = [];

        if ($this->moyasarPaymentIsReady($generalSettings)) {
            $options['moyasar'] = [
                'title' => 'بطاقة بنكية / Apple Pay',
                'description' => 'مدى، فيزا، ماستركارد و Apple Pay عبر بوابة الدفع الحالية.',
                'icon' => 'fa-solid fa-credit-card',
            ];
        }

        if ($this->tamaraPaymentIsReady($generalSettings)) {
            $options['tamara'] = [
                'title' => 'تمارا',
                'description' => 'ادفعي الآن أو قسمي مشترياتك حسب الخيارات المتاحة لك من تمارا.',
                'icon' => 'fa-solid fa-wallet',
            ];
        }

        return $options;
    }

    private function resolveCheckoutPaymentMethod(Request $request, $generalSettings): string
    {
        $requested = (string) $request->input('payment_method', '');

        if ($requested === 'tamara' && $this->tamaraPaymentIsReady($generalSettings)) {
            return 'tamara';
        }

        if ($requested === 'moyasar' && $this->moyasarPaymentIsReady($generalSettings)) {
            return 'moyasar';
        }

        if ($this->moyasarPaymentIsReady($generalSettings)) {
            return 'moyasar';
        }

        if ($this->tamaraPaymentIsReady($generalSettings)) {
            return 'tamara';
        }

        return 'tap';
    }

    private function tamaraPaymentIsReady($generalSettings): bool
    {
        $settings = $this->tamaraSettings($generalSettings);

        return $settings['enabled'] && ! empty($settings['api_url']) && ! empty($settings['token']);
    }

    private function tamaraSettings($generalSettings): array
    {
        $enabled = $generalSettings->tamaraPaymentActivate;

        if ($enabled === null) {
            $enabled = config('services.tamara.enabled');
        }

        return [
            'enabled' => filter_var($enabled, FILTER_VALIDATE_BOOLEAN),
            'api_url' => rtrim((string) ($generalSettings->tamaraApiUrl ?: config('services.tamara.api_url', 'https://api.tamara.co')), '/'),
            'token' => $generalSettings->tamaraToken ?: config('services.tamara.token'),
            'notification_token' => $generalSettings->tamaraNotificationToken ?: config('services.tamara.notification_token'),
            'public_key' => $generalSettings->tamaraPublicKey ?: config('services.tamara.public_key'),
        ];
    }

    private function startTamaraCheckout(Request $request, Customer $customer, $carts, array $cartTotalPrice, float $amount, ?Discount $discountModel): array
    {
        $settings = $this->tamaraSettings($this->generalSettings());
        $address = $request->address
            ? CustomerAddress::where('customer_id', $customer->id)->where('id', $request->address)->first()
            : null;

        $eligibility = $this->checkTamaraEligibility($settings, $customer, $address, $amount);

        if (! $eligibility['eligible']) {
            Log::info('Tamara eligibility rejected checkout', [
                'customer_id' => $customer->id,
                'amount' => $amount,
                'response' => $eligibility['response'] ?? null,
                'error' => $eligibility['error'] ?? null,
            ]);

            return [
                'success' => false,
                'message' => 'تمارا غير متاحة لهذا الطلب حالياً. يمكنك اختيار بطاقة بنكية أو Apple Pay لإكمال الدفع.',
            ];
        }

        $draftPayment = $this->localPaymentData($amount, 'INITIATED');
        $paymentRequest = $this->newPaymentRequest($draftPayment, $request, number_format($amount, 2, '.', ''), $carts, $request->discount_id ? decrypt($request->discount_id) : null, 'tamara');
        $payload = $this->tamaraCheckoutPayload($paymentRequest, $customer, $address, $carts, $cartTotalPrice, $amount, $discountModel);
        $checkout = $this->tamaraApiRequest($settings, 'POST', '/checkout', $payload);

        if ($checkout['error'] || empty($checkout['data']['checkout_url']) || empty($checkout['data']['order_id'])) {
            Log::warning('Tamara checkout creation failed', [
                'payment_request_id' => $paymentRequest->id,
                'status_code' => $checkout['status_code'] ?? null,
                'error' => $checkout['error'],
                'response' => $checkout['data'],
            ]);

            return [
                'success' => false,
                'message' => 'تعذر إنشاء عملية الدفع عبر تمارا حالياً. فضلاً جرّبي طريقة دفع أخرى.',
            ];
        }

        $tamaraData = (object) [
            'id' => $checkout['data']['order_id'],
            'order_id' => $checkout['data']['order_id'],
            'checkout_id' => $checkout['data']['checkout_id'] ?? null,
            'status' => $checkout['data']['status'] ?? 'new',
            'amount' => $amount,
            'transaction' => (object) [
                'url' => $checkout['data']['checkout_url'],
            ],
        ];

        $paymentRequest->payment_id = $tamaraData->order_id;
        $paymentRequest->payment_url = $tamaraData->transaction->url;
        $paymentRequest->request = json_encode($payload);
        $paymentRequest->response = json_encode($checkout['data']);
        $paymentRequest->status = $tamaraData->status;
        $paymentRequest->save();

        return [
            'success' => true,
            'payment_url' => $tamaraData->transaction->url,
        ];
    }

    private function checkTamaraEligibility(array $settings, Customer $customer, ?CustomerAddress $address, float $amount): array
    {
        $payload = [
            'country' => 'SA',
            'order_value' => $this->tamaraMoney($amount),
            'phone_number' => $this->tamaraPhone($address->phone ?? $customer->phone ?? ''),
            'is_vip' => false,
        ];

        $result = $this->tamaraApiRequest($settings, 'POST', '/checkout/payment-options-pre-check', $payload);
        $data = $result['data'];

        if ($result['error'] || ! is_array($data)) {
            return [
                'eligible' => false,
                'error' => $result['error'],
                'response' => $data,
            ];
        }

        $explicitFalse = array_key_exists('has_available_payment_options', $data)
            && filter_var($data['has_available_payment_options'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === false;

        $availableCollections = [
            $data['available_payment_options'] ?? null,
            $data['available_payment_labels'] ?? null,
            $data['payment_options'] ?? null,
        ];

        $hasAvailableOption = filter_var($data['has_available_payment_options'] ?? null, FILTER_VALIDATE_BOOLEAN)
            || collect($availableCollections)->contains(fn ($value) => is_array($value) && count($value) > 0);

        return [
            'eligible' => $hasAvailableOption && ! $explicitFalse,
            'error' => null,
            'response' => $data,
        ];
    }

    private function tamaraCheckoutPayload(PaymentRequest $paymentRequest, Customer $customer, ?CustomerAddress $address, $carts, array $cartTotalPrice, float $amount, ?Discount $discountModel): array
    {
        [$firstName, $lastName] = $this->tamaraCustomerName($address->name ?? $customer->name ?? 'Tyaniel Customer');
        $shippingAmount = (float) ($cartTotalPrice['shipment_price'] ?? 0);
        $items = [];

        foreach ($carts as $cart) {
            if (! $cart->service) {
                continue;
            }

            $items[] = [
                'reference_id' => (string) $cart->service->id,
                'type' => 'physical',
                'name' => Str::limit($cart->service->title, 120, ''),
                'sku' => 'TY-' . $cart->service->id,
                'quantity' => 1,
                'unit_price' => $this->tamaraMoney((float) $cart->amount),
                'tax_amount' => $this->tamaraMoney(0),
                'total_amount' => $this->tamaraMoney((float) $cart->amount),
                'image_url' => $this->absoluteUrl($cart->service->image_url),
            ];
        }

        if (($cartTotalPrice['additional_feature_price'] ?? 0) > 0) {
            $items[] = [
                'reference_id' => 'additional-features-' . $paymentRequest->id,
                'type' => 'physical',
                'name' => 'إضافات المنتجات',
                'sku' => 'TY-ADD-' . $paymentRequest->id,
                'quantity' => 1,
                'unit_price' => $this->tamaraMoney((float) $cartTotalPrice['additional_feature_price']),
                'tax_amount' => $this->tamaraMoney(0),
                'total_amount' => $this->tamaraMoney((float) $cartTotalPrice['additional_feature_price']),
            ];
        }

        $addressData = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'line1' => (string) ($address->address ?? 'Tyaniel order'),
            'line2' => (string) ($address->street ?? ''),
            'region' => (string) ($address->street ?? ''),
            'city' => (string) ($address->city_id ?? 'Riyadh'),
            'country_code' => 'SA',
            'phone_number' => $this->tamaraPhone($address->phone ?? $customer->phone ?? ''),
        ];

        $payload = [
            'order_reference_id' => 'TY-' . $paymentRequest->id,
            'order_number' => 'TY-' . $paymentRequest->id,
            'total_amount' => $this->tamaraMoney($amount),
            'description' => 'طلب من متجر تيانيل',
            'country_code' => 'SA',
            'payment_type' => 'PAY_BY_INSTALMENTS',
            'locale' => app()->getLocale() === 'en' ? 'en_US' : 'ar_SA',
            'items' => $items,
            'consumer' => [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone_number' => $this->tamaraPhone($address->phone ?? $customer->phone ?? ''),
                'email' => $address->email ?? $customer->email ?? null,
            ],
            'billing_address' => $addressData,
            'shipping_address' => $addressData,
            'tax_amount' => $this->tamaraMoney(0),
            'shipping_amount' => $this->tamaraMoney($shippingAmount),
            'merchant_url' => [
                'success' => $this->absoluteRoute('tamara.callback', ['paymentRequest' => $paymentRequest->id, 'result' => 'success']),
                'failure' => $this->absoluteRoute('tamara.callback', ['paymentRequest' => $paymentRequest->id, 'result' => 'failure']),
                'cancel' => $this->absoluteRoute('tamara.callback', ['paymentRequest' => $paymentRequest->id, 'result' => 'cancel']),
                'notification' => $this->tamaraWebhookUrl(),
            ],
            'platform' => 'tyanil-laravel',
            'is_mobile' => request()->header('Sec-CH-UA-Mobile') === '?1',
            'expires_in_minutes' => 60,
        ];

        if ($discountModel) {
            $cartTotal = (float) ($cartTotalPrice['total_price'] ?? $amount);
            $discountAmount = max(0, $cartTotal - $amount);
            if ($discountAmount > 0) {
                $payload['discount'] = [
                    'name' => $discountModel->code ?: 'Tyaniel discount',
                    'amount' => $this->tamaraMoney($discountAmount),
                ];
            }
        }

        return $payload;
    }

    public function tamaraCallback(Request $request, PaymentRequest $paymentRequest, string $result)
    {
        $customer = Auth::guard('customer')->user();

        if ($paymentRequest->payment_type !== 'tamara') {
            abort(404);
        }

        if ($customer && (int) $paymentRequest->customer_id !== (int) $customer->id) {
            abort(404);
        }

        if ($result !== 'success') {
            $paymentRequest->status = strtoupper($result);
            $paymentRequest->response = json_encode($request->all());
            $paymentRequest->save();

            return redirect()->route('customer.cart')->with('message', 'لم تكتمل عملية الدفع عبر تمارا');
        }

        $orderId = $this->tamaraOrderIdFromPayload($request->all()) ?: $paymentRequest->payment_id;

        if (! $orderId) {
            return redirect()->route('customer.cart')->with('message', 'لم تصل بيانات عملية تمارا بشكل صحيح');
        }

        if (ServiceInvoice::where('refrence_id', $orderId)->exists()) {
            return redirect()->route($customer ? 'customer.dashboard' : 'customer.login')->with('message', 'تم إستكمال الدفع بنجاح');
        }

        $settings = $this->tamaraSettings($this->generalSettings());
        $lookup = $this->fetchTamaraOrder($settings, $orderId);

        if ($lookup['error'] || ! $this->isTamaraSuccessStatus($this->tamaraStatusFromData($lookup['data']))) {
            Log::warning('Tamara callback verification failed', [
                'payment_request_id' => $paymentRequest->id,
                'order_id' => $orderId,
                'error' => $lookup['error'],
                'response' => $lookup['data'],
            ]);

            return redirect()->route('customer.cart')->with('message', 'تعذر التحقق من عملية الدفع عبر تمارا');
        }

        $this->completeTamaraPayment($paymentRequest, $orderId, $lookup['data']);

        return redirect()->route($customer ? 'customer.dashboard' : 'customer.login')->with('message', 'تم إستكمال الدفع بنجاح');
    }

    public function tamaraWebhook(Request $request)
    {
        $settings = $this->tamaraSettings($this->generalSettings());

        if (! $this->validTamaraWebhookToken($request, $settings)) {
            Log::warning('Tamara webhook rejected: invalid token');

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $payload = $request->all();
        $orderId = $this->tamaraOrderIdFromPayload($payload);

        if (! $orderId) {
            return response()->json(['message' => 'Missing order id'], 422);
        }

        $paymentRequest = PaymentRequest::where('payment_type', 'tamara')
            ->where('payment_id', $orderId)
            ->latest()
            ->first();

        if (! $paymentRequest) {
            return response()->json(['message' => 'Payment request not found'], 404);
        }

        $status = $this->tamaraStatusFromData($payload);

        if ($this->isTamaraSuccessStatus($status)) {
            $this->completeTamaraPayment($paymentRequest, $orderId, $payload);
        } else {
            $paymentRequest->status = strtoupper($status ?: 'WEBHOOK');
            $paymentRequest->response = json_encode($payload);
            $paymentRequest->save();
        }

        return response()->json(['message' => 'ok']);
    }

    private function completeTamaraPayment(PaymentRequest $paymentRequest, string $orderId, array $data): void
    {
        if (ServiceInvoice::where('refrence_id', $orderId)->exists()) {
            return;
        }

        $paymentResponse = PaymentResponse::firstOrNew([
            'payment_id' => $orderId,
            'payment_type' => 'tamara',
        ]);

        if (! $paymentResponse->exists) {
            $newPaymentResponse = collect($paymentRequest->toArray())
                ->except(['id', 'created_at', 'updated_at', 'cart_items', 'check_num'])
                ->toArray();

            $paymentResponse->forceFill($newPaymentResponse);
        }

        $status = $this->tamaraStatusFromData($data) ?: 'approved';
        $paymentResponse->response = json_encode($data);
        $paymentResponse->status = strtoupper($status);
        $paymentResponse->customer_id = $paymentRequest->customer_id;
        $paymentResponse->save();

        $paymentRequest->status = strtoupper($status);
        $paymentRequest->response = json_encode($data);
        $paymentRequest->save();

        $orderData = json_decode(json_encode($data));
        $orderData->amount = (float) $paymentRequest->amount;

        $paymentDefinition = General::get_definition_id('electric_payment') ?: 0;
        $paymentService = new PaymentService();
        $paymentService->customerServiceOrder($paymentRequest, $orderId, $orderData, $paymentDefinition);
    }

    private function fetchTamaraOrder(array $settings, string $orderId): array
    {
        return $this->tamaraApiRequest($settings, 'GET', '/orders/' . rawurlencode($orderId));
    }

    private function tamaraApiRequest(array $settings, string $method, string $path, ?array $payload = null): array
    {
        $curl = curl_init();

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $settings['token'],
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL => $settings['api_url'] . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 35,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $headers,
        ]);

        if ($payload !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        }

        $response = curl_exec($curl);
        $error = curl_error($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $data = json_decode((string) $response, true);

        if ($error) {
            return ['data' => $data, 'error' => $error, 'status_code' => $statusCode];
        }

        if ($statusCode >= 400 || ! is_array($data)) {
            return ['data' => $data, 'error' => $response ?: 'Invalid Tamara response', 'status_code' => $statusCode];
        }

        return ['data' => $data, 'error' => null, 'status_code' => $statusCode];
    }

    private function tamaraOrderIdFromPayload(array $payload): ?string
    {
        $paths = [
            ['order_id'],
            ['orderId'],
            ['id'],
            ['data', 'order_id'],
            ['data', 'orderId'],
            ['order', 'order_id'],
            ['order', 'orderId'],
            ['event', 'order_id'],
            ['event', 'orderId'],
        ];

        foreach ($paths as $path) {
            $value = $payload;

            foreach ($path as $segment) {
                if (! is_array($value) || ! array_key_exists($segment, $value)) {
                    $value = null;
                    break;
                }

                $value = $value[$segment];
            }

            if (is_scalar($value) && (string) $value !== '') {
                return (string) $value;
            }
        }

        return null;
    }

    private function tamaraStatusFromData(?array $data): string
    {
        if (! is_array($data)) {
            return '';
        }

        $candidates = [
            $data['status'] ?? null,
            $data['order_status'] ?? null,
            $data['payment_status'] ?? null,
            $data['event_type'] ?? null,
            $data['event'] ?? null,
            $data['data']['status'] ?? null,
            $data['data']['order_status'] ?? null,
            $data['order']['status'] ?? null,
        ];

        foreach ($candidates as $candidate) {
            if (is_scalar($candidate) && (string) $candidate !== '') {
                return strtolower((string) $candidate);
            }
        }

        return '';
    }

    private function isTamaraSuccessStatus(string $status): bool
    {
        return Str::contains(strtolower($status), [
            'approved',
            'authorised',
            'authorized',
            'captured',
            'fully_captured',
        ]);
    }

    private function validTamaraWebhookToken(Request $request, array $settings): bool
    {
        $expected = (string) ($settings['notification_token'] ?? '');
        $provided = (string) $request->query('tamaraToken', '');

        if ($expected === '' || $provided === '') {
            return false;
        }

        if (hash_equals($expected, $provided)) {
            return true;
        }

        try {
            JWT::decode($provided, $expected, ['HS256']);

            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }

    private function tamaraMoney(float $amount): array
    {
        return [
            'amount' => round($amount, 2),
            'currency' => 'SAR',
        ];
    }

    private function tamaraPhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?: '';

        if (str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);
        }

        if (str_starts_with($digits, '966')) {
            return '+' . $digits;
        }

        if (str_starts_with($digits, '0')) {
            return '+966' . substr($digits, 1);
        }

        if (strlen($digits) === 9 && str_starts_with($digits, '5')) {
            return '+966' . $digits;
        }

        return $digits ? '+' . $digits : '+966500000000';
    }

    private function tamaraCustomerName(string $name): array
    {
        $parts = preg_split('/\s+/', trim($name), 2);
        $firstName = $parts[0] ?: 'Tyaniel';
        $lastName = $parts[1] ?? $firstName;

        return [$firstName, $lastName];
    }

    private function tamaraWebhookUrl(): string
    {
        $settings = $this->tamaraSettings($this->generalSettings());
        $token = $settings['notification_token'];
        $url = $this->absoluteRoute('tamara.webhook');

        return $token ? $url . '?tamaraToken=' . rawurlencode($token) : $url;
    }

    private function absoluteRoute(string $name, array $parameters = []): string
    {
        $appUrl = rtrim((string) config('app.url'), '/');

        if ($appUrl && ! str_contains($appUrl, '127.0.0.1') && ! str_contains($appUrl, 'localhost')) {
            return $appUrl . route($name, $parameters, false);
        }

        return route($name, $parameters);
    }

    private function absoluteUrl(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        return rtrim((string) config('app.url'), '/') . '/' . ltrim($url, '/');
    }

    private function localPaymentData(float $amount, string $status): object
    {
        return (object) [
            'id' => strtolower($status) . '_' . now()->format('YmdHis') . '_' . random_int(1000, 9999),
            'status' => $status,
            'amount' => $amount,
            'transaction' => (object) [
                'url' => '',
            ],
        ];
    }

    private function localPaymentDefinition(): int
    {
        return General::get_definition_id('manual_payment') ?: (General::get_definition_id('electric_payment') ?: 1);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function address($id)
    {
        $cities = City::orderBy('city_arName')->get();
        $address = CustomerAddress::find(decrypt($id));
        if (!$address) {
            abort(404);
        }
        if (Auth::guard('customer')->user()->id != $address->customer_id) {
            bort(404);
        }
        return view('customer.address', compact('address', 'cities'));
    }
    public function addressDelete($id)
    {
        $address = CustomerAddress::find(decrypt($id));
        if (!$address) {
            abort(404);
        }
        if (Auth::guard('customer')->user()->id != $address->customer_id) {
            abort(404);
        }
        $address->delete();

        return redirect()->back()->with('info', 'تم الحذف بنجاح');
    }
    public function allAddress()
    {
        $allAddress = Auth::guard('customer')->user()->customerAddresses;
        if (!$allAddress) {
            abort(404);
        }
        return view('customer.allAddress', compact('allAddress'));
    }
    public function newAddress()
    {
        $cities = City::orderBy('city_arName')->get();

        return view('customer.address', compact('cities'));
    }


    public function addressUpdate(Request $request)
    {


        $this->validate($request, [
            'phone'      => 'required',
            'name'      => 'required',
            'email'      => 'required',
            'country'      => 'required',
            'city'      => 'required',
            'street'      => 'required',
            'address'      => 'required',
        ]);
        if ($request->country != 'المملكة العربية السعوديه') {
            return redirect()->back()->with('info', 'ندعم الشحن داخل المملكة العربية السعودية فقط');
        }
        $customerAddress = CustomerAddress::find(decrypt($request->id));
        if (!$customerAddress) {
            abort(404);
        }
        if (Auth::guard('customer')->user()->id != $customerAddress->customer_id) {
            abort(404);
        }
        $customerAddress->update($request->except('_token', 'city', 'country', 'id') + ['country_id' => $request->country, 'city_id' => $request->city]);


        //**********************************//

        return redirect()->route('customer.allAddress')->with('message', 'تم تحديث العنوان بنجاح');
    }

    public function newAddressPost(Request $request)
    {
        // dd($request);

        $this->validate($request, [
            'phone'      => 'required',
            'name'      => 'required',
            'email'      => 'required',
            'country'      => 'required',
            'city'      => 'required',
            'street'      => 'required',
            'address'      => 'required',
        ]);
        if ($request->country != 'المملكة العربية السعوديه') {
            return redirect()->back()->with('info', 'ندعم الشحن داخل المملكة العربية السعودية فقط');
        }
        $customerAddress = CustomerAddress::create($request->except('_token', 'city', 'country') + ['country_id' => $request->country, 'city_id' => $request->city, 'customer_id' => Auth::guard('customer')->user()->id]);


        //**********************************//

        return redirect()->route('customer.allAddress')->with('message', 'تم إضافة العنوان بنجاح');
    }

    private function storeCheckoutAddress(Request $request, Customer $customer): CustomerAddress
    {
        $this->validate($request, [
            'checkout_name' => 'required|string|max:255',
            'checkout_phone' => 'required|string|max:30',
            'checkout_email' => 'required|email|max:255',
            'checkout_country' => 'required|string|max:255',
            'checkout_city' => 'required|string|max:255',
            'checkout_street' => 'required|string|max:255',
            'checkout_address' => 'required|string|max:1000',
        ], [
            'checkout_name.required' => 'اسم مستلم الشحنة مطلوب',
            'checkout_phone.required' => 'رقم الجوال مطلوب لإتمام الشحن',
            'checkout_email.required' => 'البريد الإلكتروني مطلوب لإرسال تحديثات الطلب',
            'checkout_email.email' => 'البريد الإلكتروني غير صحيح',
            'checkout_city.required' => 'المدينة مطلوبة',
            'checkout_street.required' => 'الحي مطلوب',
            'checkout_address.required' => 'العنوان الوطني مطلوب لإتمام عملية التوصيل',
        ]);

        if (! in_array($request->checkout_country, ['المملكة العربية السعوديه', 'المملكة العربية السعودية'], true)) {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                redirect()->back()
                    ->withInput()
                    ->with('noCartAddress', 'ندعم الشحن داخل المملكة العربية السعودية فقط')
            );
        }

        $data = [
            'name' => $request->checkout_name,
            'phone' => $request->checkout_phone,
            'email' => $request->checkout_email,
            'country_id' => 'المملكة العربية السعوديه',
            'city_id' => $request->checkout_city,
            'street' => $request->checkout_street,
            'address' => $request->checkout_address,
            'customer_id' => $customer->id,
        ];

        $address = null;
        if ($request->filled('checkout_address_id')) {
            $address = CustomerAddress::where('customer_id', $customer->id)
                ->where('id', $request->checkout_address_id)
                ->first();
        }

        if ($address) {
            $address->update($data);

            return $address;
        }

        return CustomerAddress::create($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    public function cart_update(Request $request)
    {
        // dd($request);
        $cart = Cart::find(decrypt($request->cart_id));
        if (!$cart) {
            abort(404);
        }
        $cart->additional_features = json_encode($request->features);
        $cart->save();
        return redirect()->back()->with(
            'info',
            'تم التحديث بنجاح'
        );
    }
    public function download($media)
    {
        try {
            $mediaId = decrypt($media);
        } catch (\Exception $e) {
            abort(404);
        }

        $media = Media::findOrFail($mediaId);
        $filePath = $media->getPath();
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $media->file_name);
    }

    private function cartQuantityForService(Service $service, ?Customer $customer, string $ip): int
    {
        $query = Cart::where('service_id', $service->id);

        if ($customer) {
            $query->where('customer_id', $customer->id);
        } else {
            $query->where('user_ip', $ip)->whereNull('customer_id');
        }

        return $query->count();
    }

    private function cartStockMessage($carts): ?string
    {
        $requestedQuantities = [];

        foreach ($carts as $cart) {
            $service = $cart->service;

            if (!$service || !$service->isPurchasable()) {
                return 'توجد منتجات غير متاحة في السلة، فضلاً حدّث السلة ثم حاول مرة أخرى';
            }

            $requestedQuantities[$service->id] = ($requestedQuantities[$service->id] ?? 0) + 1;
        }

        foreach ($requestedQuantities as $serviceId => $requestedQuantity) {
            $service = Service::find($serviceId);

            if ($service && !$service->hasAvailableQuantity($requestedQuantity)) {
                return 'الكمية المتاحة من المنتج "' . $service->title . '" هي ' . (int) $service->quantity;
            }
        }

        return null;
    }

    public function newPaymentRequest($data, $request, $amount, $carts, $discount_id, $payment)
    {
        $paymentRequest = new PaymentRequest();
        $paymentRequest->customer_id = Auth::guard('customer')->user()->id;
        $paymentRequest->payment_type = $payment;
        $paymentRequest->request = json_encode($data);
        $paymentRequest->payment_id = $data->id ?? '';
        $paymentRequest->customer_address = $request->address;
        $paymentRequest->amount = $amount;
        $paymentRequest->cart_items = $this->cartItems();
        // dd($carts->pluck('id')->toArray());
        $paymentRequest->cart_ids = json_encode($carts->pluck('id')->toArray());
        $paymentRequest->status = $data->status ?? '';
        $paymentRequest->discount_id = $discount_id;
        $paymentRequest->payment_url = $data->transaction->url ?? '';
        $paymentRequest->save();
        return $paymentRequest;
    }
}
