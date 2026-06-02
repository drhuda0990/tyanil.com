<?php

namespace App\Services;

use App\AdditionalFeatures;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\JitsiMeeting;
use Illuminate\Support\Facades\Log; // Add this
use App\InstituteAdmin;
use App\Definition;
use App\PaymentRequest;
use App\Cart;
use App\Customer;
use App\CustomerAddress;
use Session;
use Carbon\Carbon;
use App\GeneralSetting;
use App\Discount;
use App\General;
use App\PaymentResponse;
use App\SerInvoiceItemsFeature;
use App\ServiceInvoice;
use App\ServiceInvoiceItem;
use App\Support\InternalNotificationService;
use App\Support\StoreSettings;

class PaymentService
{

    public function generalSettings()
    {
        return StoreSettings::get();
    }
    public function tapCheck($payment_id, $customer)
    {
        $success = $this->handleTapCheck($payment_id, $customer);
        if ($success) {
            return redirect()->route('customer.dashboard')->with(
                'message',
                'تم إستكمال الدفع بنجاح'
            );
        } else {
            return redirect()->route('customer.cart')->with(
                'message',
                'حدث خطأ ما يرجى التأكد من صحة بياناتك'
            );
        }
    }
    public function purchasedCoursesExtract($purchased_courses)
    {
        $purchased_courses = explode("_", $purchased_courses);
        $carts = [];
        $courses = [];
        foreach ($purchased_courses as $order) {
            $str = explode("cart", $order);
            if (empty($str[1])) {
                $str = explode("course", $order);
                if (!empty($str[1])) {
                    array_push($courses, $str[1]);
                }
            } else {
                array_push($carts, $str[1]);
            }
        }
        return $carts;
    }
    public function handleTapCheck($tap_id, $customer)
    {

        $generalSettings = $this->generalSettings();
        $tapSecretAPIKey = $generalSettings->tapSectretKey;

        $key = "Bearer $tapSecretAPIKey";

        $tap_id = $tap_id;
        $paymentRequestModel = PaymentRequest::where([['payment_id', $tap_id], ['customer_id', $customer->id]])->first();
        $curl = curl_init();
        // dd($paymentRequest);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.tap.company/v2/charges/$tap_id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            CURLOPT_HTTPHEADER => array(
                "authorization: $key"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $data = json_decode($response);
        // dd($data);
        $response = json_decode($response, true);
        $payment_definition = General::get_definition_id('electric_payment');
        if (!$payment_definition) {
            $payment_definition = 0;
        }
        curl_close($curl);
        $tap_id = $tap_id;
        if (isset($response['errors'])) {
            return false;
        }
        if ($err) {
            return false;
        } else {
            $paymentRequest = $paymentRequestModel->toArray();
            $newPaymentResponse = collect($paymentRequest)->except(['id', 'created_at', 'updated_at', 'cart_items', 'check_num'])->toArray();
            $newPaymentResponse = PaymentResponse::create($newPaymentResponse);
            $newPaymentResponse->response = json_encode($data);
            $newPaymentResponse->status = $data->status;
            $newPaymentResponse->customer_id = $customer->id;
            $newPaymentResponse->save();
            if ($data->status == 'CAPTURED') {
                $this->customerServiceOrder($paymentRequestModel, $tap_id, $data, $payment_definition);
                //---------------------
                return true;
            } else {
                return false;
            }
        }
    }
    public function cartTotalPrice($carts)
    {
        $total_price = 0;
        $ExistShipment = false;
        $generalSettings = $this->generalSettings();
        $additional_feature_price = 0;
        foreach ($carts as $cart) {
            if (!$ExistShipment && $cart->service->required_shipment) {
                $ExistShipment = true;
            }
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
        if ($ExistShipment) {
            $total_price += $generalSettings->shipment_price;
        }
        $total_price += $additional_feature_price;
        return ['total_price' => $total_price, 'existShipment' => $ExistShipment];
    }
    public function customerServiceOrder($paymentRequest, $refrence_id, $data, $payment_definition)
    {
        $customer =  Customer::find($paymentRequest->customer_id);
        $discount_model = null;

        $cart_ids = $paymentRequest->cart_ids;
        // dd($carts);
        // Remove the square brackets
        $cart_ids = trim($cart_ids, '[]');
        $title = '';
        // Convert the string to an array
        $cart_ids = explode(',', $cart_ids);
        // Convert the elements to integers (optional if you need them as integers)
        $cart_ids = array_map('intval', $cart_ids);
        $carts = [];
        foreach ($cart_ids as $cart) {
            $cart = Cart::find($cart);
            if ($cart) {
                $title .= $cart->title . PHP_EOL;
                array_push($carts, $cart);
            }
        }
        // dd($cart_ids,$carts);

        $cartTotalPrice = $this->cartTotalPrice($carts);
        $cartTotal = $cartTotalPrice['total_price'];
        $price_dis = 0;
        $requestAmount = (float) $paymentRequest->amount;
        $gatewayAmount = is_object($data) && isset($data->amount) ? (float) $data->amount : $requestAmount;
        if ($paymentRequest->amount != 0) {
            if ($paymentRequest->discount_id) {
                $discount_model = Discount::find($paymentRequest->discount_id);
                $discount_value = $discount_model->discount;
                $discount_eq = ($cartTotal / 100) * $discount_value;
                $price_dis = $cartTotal - $discount_eq;
            }

        }

            if (($requestAmount == 0) || (($requestAmount == $gatewayAmount) && (($gatewayAmount == $cartTotal) || ($gatewayAmount == $price_dis)))) {
                // dd($paymentRequest->amount, $data->amount, $cartTotal, $price_dis);

                $generalSettings = $this->generalSettings();
                $serviceInvoice   = new ServiceInvoice();
                $serviceInvoice->title             = $title;
                $serviceInvoice->term_accept = 1;
                $serviceInvoice->customer_id        = $customer->id;
                $serviceInvoice->amount            = $paymentRequest->amount;
                $serviceInvoice->method            = $payment_definition;
                $serviceInvoice->service_price      =  $paymentRequest->amount;
                // $serviceInvoice->address           = $cart->address;
                // $serviceInvoice->phone             = $cart->phone;
                // $serviceInvoice->shipment_price      = $cart->shipment_price;
                $serviceInvoice->discount_id       = $discount_model ? $discount_model->id : null;
                $serviceInvoice->paid_amount = $paymentRequest->amount;
                if ($paymentRequest->customer_address) {
                    $address = CustomerAddress::where([['id', $paymentRequest->customer_address], ['customer_id', $customer->id]])->first();
                    if ($address) {
                        $serviceInvoice->email           = $address->email;
                        $serviceInvoice->phone             = $address->phone;
                        $serviceInvoice->name      = $address->name;
                        $serviceInvoice->street      = $address->street;
                        $serviceInvoice->address      = $address->address;
                        $serviceInvoice->city      = $address->city_id;
                        $serviceInvoice->shipment_price = $discount_model ? ($generalSettings->shipment_price - (($generalSettings->shipment_price * $discount_model->discount) / 100)) : $generalSettings->shipment_price;
                        $serviceInvoice->customer_address_id = $paymentRequest->customer_address;
                    }
                }
                $serviceInvoice->discount_code     = $discount_model ? $discount_model->code : null;
                $serviceInvoice->discount          = $discount_model ? $cartTotal - $paymentRequest->amount : null;
                $serviceInvoice->discount_percent         = $discount_model ? $discount_model->discount : null;
                $serviceInvoice->activate             = true;
                $serviceInvoice->refrence_id = $refrence_id;
                $serviceInvoice->payment_data = json_encode($data);
                $serviceInvoice->save();
            }
        $body = 'فاتورة جديدة قام العميل:' . PHP_EOL  . $customer->name . '     بطلب الخدمات التالية:' . PHP_EOL  . $title;
        if (isset($serviceInvoice)) {
            InternalNotificationService::orderCreated($serviceInvoice);
        }

        foreach ($cart_ids as $cart) {
            $cart = Cart::find($cart);
            if ($cart) {
                General::ServiceAdminNotify($cart->service, 'فاتورة خدمة جديدة', $body, 1, 1);
                $serviceInvoiceItem   = new ServiceInvoiceItem();
                $serviceInvoiceItem->title             = $cart->service->title;
                $serviceInvoiceItem->service_id = $cart->service->id;
                $serviceInvoiceItem->service_invoice_id = $serviceInvoice->id ?? null;
                $serviceInvoiceItem->s_price = $cart->amount;
                $serviceInvoiceItem->book_type = $cart->book_type;
                $serviceInvoiceItem->time = $cart->time;
                $serviceInvoiceItem->purchase_price = $discount_model ? ($cart->amount - (($cart->amount * $discount_model->discount) / 100)) : $cart->amount;
                $serviceInvoiceItem->customer_id        = $customer->id;
                $serviceInvoiceItem->activate        = 1;
                $serviceInvoiceItem->save();
                if ($cart->additional_features && count($cart->service->activateAdditionalFeatures) > 0) {
                    $cart_additional_features = json_decode($cart->additional_features, true) ?? [];
                    foreach ($cart_additional_features as $adFeature) {
                        $feature = AdditionalFeatures::find($adFeature);
                        if ($feature) {
                            $serInvoiceItemsFeature   = new SerInvoiceItemsFeature();
                            $serInvoiceItemsFeature->title = $feature->title;
                            $serInvoiceItemsFeature->price = $feature->price;
                            $serInvoiceItemsFeature->details = $feature->details;
                            $serInvoiceItemsFeature->customer_id = $customer->id;
                            $serInvoiceItemsFeature->service_invoice_item_id = $serviceInvoiceItem->id;
                            $serInvoiceItemsFeature->additional_feature_id = $feature->id;
                            $serInvoiceItemsFeature->service_invoice_id = $serviceInvoice->id ?? null;
                            $serInvoiceItemsFeature->service_id = $cart->service->id;
                            $serInvoiceItemsFeature->save();
                        }
                    }
                }
                $addtion_txt = '';
                if ($serviceInvoiceItem->book_type == 2 && $cart->service) {
                    if ($cart->service->attachment) {
                        $addtion_txt .= PHP_EOL . 'رابط النسخة الإلكترونية:' . PHP_EOL . Storage::disk('books')->url($cart->service->attachment) . PHP_EOL;
                    }
                }
                $this->send_notification_customer($cart->service, $customer, $addtion_txt);
                if ($cart->service->tutorial && $cart->time != null) {
                    $this->createMeeting($cart, $serviceInvoiceItem->id);
                }
                $cart->delete();
            }
        }
    }
    public function createMeeting($cart, $serviceInvoiceItemId)
    {
        // Generate token
        $roomName = 'test-meeting-' . $cart->id;
        $customer = Customer::find($cart->customer_id);

        $user = [
            'name' => $customer->name,
            // 'email' => $customer->email,

        ];
        $data = General::extractDateTime($cart->time);
        $token = $this->generateJitsiToken($roomName, $user, $data['date'] . ' 23:59:00');

        // Meeting URL
        $meetingUrl = env('JITSI_BASE_URL2') . "/$roomName?jwt=$token";
        // dd($meetingUrl);
        // dd($data['date']);
        $meeting = new JitsiMeeting();
        $meeting->customer_id = $customer->id;
        $meeting->service_id = $cart->service_id;
        $meeting->service_invoice_items_id = $serviceInvoiceItemId;
        $meeting->title = $roomName;
        $meeting->meeting_url = $meetingUrl;
        $meeting->details = $cart->time;
        $meeting->start_date = $data['date'];
        $meeting->end_date = $data['date'];
        $meeting->start_time = $data['sTime'];
        $meeting->end_time = $data['eTime'];
        $meeting->save();
    }


    function generateJitsiToken($room, $user = [], $endTime = null)
    {
        $expireAt = strtotime($endTime);

        $payload = [
            'aud' => env('JITSI_APP_ID'), // App ID
            'iss' => env('JITSI_APP_ID'), // App ID
            'sub' => env('JITSI_BASE_URL'),  // Jitsi subdomain
            'room' => $room,             // Room name
            'exp' => $expireAt,
            'context' => [
                'user' => [
                    'name' => $user['name'] ?? 'Guest',
                    'email' => $user['email'] ?? null, // Include email here
                    'avatar' => $user['avatar'] ?? null,
                ],
            ],
        ];
        // dd($payload,env('JITSI_SECRET'));
        return \Firebase\JWT\JWT::encode($payload, env('JITSI_SECRET'), 'HS256');
    }
    public static function send_notification_customer($service, $customer, $addtion_txt = null)
    {
        $title       = $service->title;
        $section     = "Send Notification";

        $Email_User =  $customer->email;
        $Phone_User =  $customer->phone;

        $General = new General();
        //------- إرسال إيميل

        $notification_sms = Definition::where('id', '=', $service->purchase_message)->pluck('content')->first();
        $notification_email = Definition::where('id', '=', $service->purchase_email)->pluck('content')->first();
        if (!(empty($notification_email))) {
            $body       = $notification_email . $addtion_txt;
            $to         = $Email_User;
            $get_return = $General->sendMail($title, $body, $section, $to, null);
        }
        if (!(empty($notification_sms))) {
            $body       = $notification_sms;
            $get_return       = $General->sendSMS($title, $body, $section,  $Phone_User);
        }
        return 1;
    }


    public function purchasedCourses()
    {
        $purchased_courses = '';
        foreach (Auth::guard('trainee')->user()->carts as $item) {
            $purchased_courses .= '_cart' . $item->id . '_course' . $item->course->id;
        }
        return $purchased_courses;
    }
}
