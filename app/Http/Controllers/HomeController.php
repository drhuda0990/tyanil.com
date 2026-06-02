<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\General;
use App\Cart;
use Illuminate\Support\Facades\Http;
use App\Post;
use Spatie\Analytics\Period;
use Spatie\Analytics\Facades\Analytics;
use Carbon\Carbon;
use App\Partner;
use App\ServiceCategory;
use App\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Service;
use App\Support\InternalNotificationService;
use Illuminate\Support\Facades\DB;
use App\Team;
use Illuminate\Validation\Rule;
use App\City;
use App\Countries;
use App\Advertisement;
use App\Definition;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dimensions = ['yearMonth'];
        $metrics = ['sessions'];
        $startDate = Carbon::createFromDate(2024, 12, 5, null);
        $endDate = Carbon::now();
        $sum = 10000;
        if (config('analytics.property_id') && file_exists(config('analytics.service_account_credentials_json'))) {
            try {
                $Period = Period::create($startDate, $endDate);
                // $analytics = Analytics::get($Period, $metrics, $dimensions);
                $analyticsData = Analytics::fetchVisitorsAndPageViews($Period);
                foreach ($analyticsData as $key => $value) {
                    $sum += $value['screenPageViews'];
                }
            } catch (\Throwable $exception) {
                report($exception);
            }
        }
        // \Log::info($analytics);

        // dd($sum,$analyticsData,$analytics);
        $mainCategories = ServiceCategory::where([['activate', 1], ['main_category', 1]])->orderBy('order_num')->get();
        $teams = Team::where('is_published', 1)->get();
        $partners = Partner::where('is_published', 1)->get();
        $services = Service::where('services.activate', 1)
            ->leftJoin('service_categories', 'services.service_category_id', '=', 'service_categories.id')
            ->select('services.*')
            ->orderByRaw('COALESCE(service_categories.order_num, 999)')
            ->orderBy('services.service_category_id')
            ->orderBy('services.id')
            ->get();
        $advertisements = Advertisement::where('activate', 1)->get();
        $SQL = [
            "mainCategories" => $mainCategories,
            "partners" => $partners,
            "visitor" => $sum,
            "advertisements" => $advertisements,
            "services" => $services,
            "teams" => $teams
        ];
        return view('homepage.index', $SQL);
    }



    public function saveCountries()
    {
        // // Fetch all countries from a public API
        // $response = Http::get('https://restcountries.com/v3.1/all');
        // $countries = $response->json();

        // foreach ($countries as $country) {
        //     $nameEn = $country['name']['common'];
        //     $code = $country['cca2'];

        //     // Translate the country name to Arabic
        //     $arabicName = $this->translateToArabic($nameEn);

        //     // Save country to database
        //     Countries::updateOrCreate(
        //         ['country_code' => $code],
        //         ['country_enName' => $nameEn, 'country_arName' => $arabicName]
        //     );
        // }

        $cities = $this->importCities();
    }



    public function importCities()
    {
        // Path to the JSON file
        $filePath = storage_path('app/cities.json');

        // Check if the file exists
        if (!file_exists($filePath)) {
            dd(['error' => 'File not found'], 404);
        }

        // Read the JSON file
        $jsonData = file_get_contents($filePath);
        $cities = json_decode($jsonData, true); // Decode to associative array

        if (json_last_error() !== JSON_ERROR_NONE) {
            dd(['error' => 'Invalid JSON format'], 400);
        }

        // Prepare data for batch insert
        $citiesToInsert = [];
        foreach ($cities as $cityData) {
            $citiesToInsert[] = [
                'city_enName' => $cityData['name_en'],
                'city_arName' => $cityData['name_ar'],
                'country_code' => 'SA',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert cities into the database in batches
        DB::table('cities')->insert($citiesToInsert);
        dd(['message' => 'Cities imported successfully!'], 200);
    }

    // Example usage
    public function translateToArabic($text)
    {
        $response = Http::post('https://translation.googleapis.com/language/translate/v2?key=AIzaSyDigbEd9Zdk1fON_DsfKGNJyVgpGyVzqjQ', [
            'q' => $text,
            'target' => 'ar',
        ]);

        $data = $response->json();
        return $data['data']['translations'][0]['translatedText'] ?? $text;
    }



    public function categoryServices($id, $sub = null)
    {
        $category = null;
        if ($id == 'all') {
            $services = Service::where('activate', 1)->orderBy('id')->get();
        } else {
            try {
                $id = decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                // القيمة غير مشفرة أو تالفة
                $id = $id; // نستخدمها كما هي
            }
            $category = ServiceCategory::where([['activate', 1], ['id', $id]])->first();
            if (!$category) {
                abort(404);
            }
            if ($sub == 'all') {
                $services = $category->activateServices;

                foreach ($category->serviceActivateSubCategories as $subCategory) {
                    $services = $services->merge($subCategory->activateServices);
                }

                $services = $services->unique('id')->values();
            } else {
                $services = $category->activateServices;
            }
        }
        $SQL = [
            'category' => $category,
            "services" => $services,
        ];
        return view('homepage.services', $SQL);
    }
    public function service($id)
    {
        try {
            $id = decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // القيمة غير مشفرة أو تالفة
            $id = $id; // نستخدمها كما هي
        }
        $service = Service::where('activate', 1)
            ->where(function ($query) use ($id) {
                if (is_numeric($id)) {
                    $query->where('id', $id);
                }

                $query->orWhere('slug', $id);
            })
            ->first();
        if (!$service) {
            abort(404);
        }
        $ratings = $service->ratings();

        $avg = round($ratings->avg('stars'), 1);

        $total = $ratings->count();

        $stars = [
            5 => $ratings->clone()->where('stars', 5)->count(),
            4 => $ratings->clone()->where('stars', 4)->count(),
            3 => $ratings->clone()->where('stars', 3)->count(),
            2 => $ratings->clone()->where('stars', 2)->count(),
            1 => $ratings->clone()->where('stars', 1)->count(),
        ];

        $reviews = $service->ratings()
            ->where('status', 1)
            ->with('customer')
            ->paginate(10);
        return view('homepage.service', compact('service', 'avg', 'total', 'stars', 'reviews'));
    }
    public function post(Request $request, $id)
    {
        $Post_id   = Post::where([['is_published', 1], ['id', $id]])->first();
        if (empty($Post_id)) {
            abort(404);
        }


        $SQL = array(
            "Post_id"         => $Post_id,
        );

        return view('homepage.post', $SQL);
    }
    public function contacts()
    {
        $types   = Definition::where([['type_id', 5], ['activate', 1]])->get();
        $SQL = array(
            "types"         => $types,
        );
        return view('homepage.contact', $SQL);
    }

    public function contacts_post(Request $request)
    {
        $types   = Definition::where([['type_id', 5], ['activate', 1]])->get();
        $validTypeIds = $types->pluck('id')->toArray();

        $this->validate($request, [
            'name'        => ['required', 'regex:/^[\p{Arabic} ]+$/u'],
            'email'       => 'required|email',
            'phone'       => 'numeric',
            'subject'     => 'required',
            'type'     => ['required', Rule::in($validTypeIds)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content'    => ['required', 'regex:/^[\p{Arabic} ]+$/u'],
        ]);
        // dd($request);
        $contact = Contact::create($request->except('_token', 'submit', 'image'));
        if ($request->hasFile('image')) {
            $contact->addMediaFromRequest('image')->toMediaCollection('contact_image');
        }
        InternalNotificationService::contactCreated($contact);
        //   $section    = "Contacts Page";
        //   $to         = $Institute;
        //   $title      = $subject . " | " . $request->name;
        //   $body       = " الموضوع : " . $subject . "\r\n" . " | اسم المرسل : " . $request->name . "\r\n" . " | البريد الإلكتروني : " . $request->email . "\r\n" . " | الجوال : " . $request->phone . "\r\n" . " | تاريخ الميلاد : " . $request->birthday . " | الجنسية : " . $request->nationality . "\r\n" . " | الرسالة : " . $request->messagge;
        //   $get_return = General::sendMail($title, $body, $section, $to);

        //**********************************//

        return back()->with('info', 'شكرًا لك على رسالتك ، سيتم الرد عليها في أقرب وقت');
    }
    public function categoryShow($id, $slug = null)
    {
        try {
            $id = decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // القيمة غير مشفرة أو تالفة
            $id = $id; // نستخدمها كما هي
        }
        $mainCategory = ServiceCategory::find($id);
        if (!$mainCategory) {
            abort(404);
        }

        $services = $mainCategory->activateServices;
        foreach ($mainCategory->serviceActivateSubCategories as $subCategory) {
            $services = $services->merge($subCategory->activateServices);
        }

        $services = $services->unique('id')->values();

        return view('homepage.categoryShow', compact('mainCategory', 'services'));
    }
    public function search(Request $request)
    {
        $services = Service::where('activate', 1)->get();
        if ($request->search_input) {
            $services    = General::get_search_services($request->search_input);
        }

        $SQL = [
            'category' => null,
            "services" => $services,
            "title" => "نتائج البحث",
        ];
        return view('homepage.services', $SQL);
    }
    public function showDocument($media)
    {
        try {
            $mediaId = decrypt($media);
        } catch (\Exception $e) {
            abort(404);
        }

        $media = Media::findOrFail($mediaId);
        // dd($media);
        // $filePath = $media->getPath();
        return response()->file(
            $media->getPath(),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $media->file_name . '"',
            ]
        );
    }

    public function sitemap()
    {
        $baseUrl = $this->sitemapBaseUrl();
        $urls = [
            $this->sitemapEntry($baseUrl . '/', now(), '1.00'),
            $this->sitemapEntry($baseUrl . '/contacts', now(), '0.70'),
        ];

        $categories = ServiceCategory::where('activate', 1)->get();
        foreach ($categories as $category) {
            $path = '/category/' . $category->id;
            if ($category->slug) {
                $path .= '/' . rawurlencode($category->slug);
            }

            $urls[] = $this->sitemapEntry($baseUrl . $path, $category->updated_at, '0.80');
        }

        $services = Service::where('activate', 1)->get();
        foreach ($services as $service) {
            $urls[] = $this->sitemapEntry(
                $baseUrl . '/service/' . rawurlencode($service->seo_route_key),
                $service->updated_at,
                '0.90'
            );
        }

        $posts = Post::where('is_published', 1)->get();
        foreach ($posts as $post) {
            $urls[] = $this->sitemapEntry($baseUrl . '/page/' . $post->id, $post->updated_at, '0.60');
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        $xml .= implode('', $urls);
        $xml .= '</urlset>' . PHP_EOL;

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function sitemapBaseUrl(): string
    {
        $url = rtrim((string) config('app.url'), '/');

        if (!$url || str_contains($url, '127.0.0.1') || str_contains($url, 'localhost')) {
            return 'https://www.tyanil.com';
        }

        return $url;
    }

    private function sitemapEntry(string $loc, $lastmod = null, string $priority = '0.80'): string
    {
        $lastmod = $lastmod ? \Illuminate\Support\Carbon::parse($lastmod)->toAtomString() : now()->toAtomString();

        return '  <url>' . PHP_EOL
            . '    <loc>' . htmlspecialchars($loc, ENT_XML1, 'UTF-8') . '</loc>' . PHP_EOL
            . '    <lastmod>' . htmlspecialchars($lastmod, ENT_XML1, 'UTF-8') . '</lastmod>' . PHP_EOL
            . '    <priority>' . $priority . '</priority>' . PHP_EOL
            . '  </url>' . PHP_EOL;
    }
}
