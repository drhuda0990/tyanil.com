<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TyanielProductsAndSaudiCitiesSeeder extends Seeder
{
    private const STORE_NAME = 'تيانيل';

    public function run(): void
    {
        $now = now();

        DB::transaction(function () use ($now) {
            $this->seedProducts($now);
            $this->seedSaudiCities($now);
        });
    }

    private function seedProducts($now): void
    {
        $purchaseSms = DB::table('definitions')->where('slug', 'purchase_sms')->value('id');
        $purchaseEmail = DB::table('definitions')->where('slug', 'purchase_email')->value('id');

        foreach ($this->products() as $product) {
            $existingId = DB::table('services')->where('image', $product['image'])->value('id');
            $summary = '<p>' . e($product['summary']) . '</p>';
            $body = $this->productBody($product);

            DB::table('services')->updateOrInsert(
                ['image' => $product['image']],
                [
                    'title' => $product['title'],
                    'summry' => $summary,
                    'price_1' => (string) $product['price'],
                    'price_2' => null,
                    'body' => $body,
                    'tags' => $product['tags'],
                    'video' => null,
                    'service_mail_1_date' => null,
                    'service_mail_2_date' => null,
                    'service_mail_1' => null,
                    'service_mail_2' => null,
                    'purchase_message' => $purchaseSms,
                    'purchase_email' => $purchaseEmail,
                    'disable_coupon' => 0,
                    'is_available_hidden' => 1,
                    'required_shipment' => '1',
                    'activate' => 1,
                    'not_available' => 0,
                    'service_category_id' => $product['service_category_id'],
                    'times' => json_encode([]),
                    'tutorial' => 0,
                    'price_start_from' => 0,
                    'times_available' => null,
                    'times_from_date' => null,
                    'times_to_date' => null,
                    'service_admins' => json_encode([]),
                    'advertizment_service' => 0,
                    'redirect_url' => null,
                    'attachment' => null,
                    'embided_book' => null,
                    'book_type' => '0',
                    'slug' => $this->uniqueSlug($this->baseSlug($product['title']), $existingId),
                    'meta_title' => Str::limit($product['title'] . ' | ' . self::STORE_NAME, 70, ''),
                    'meta_description' => Str::limit($this->plainText($product['summary']), 155, ''),
                    'quantity' => $product['quantity'],
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }

    private function seedSaudiCities($now): void
    {
        $path = storage_path('app/cities.json');

        if (!is_file($path)) {
            return;
        }

        $cities = json_decode(file_get_contents($path), true);

        if (!is_array($cities)) {
            return;
        }

        $uniqueCities = [];

        foreach ($cities as $index => $city) {
            $arabicName = trim((string) ($city['name_ar'] ?? ''));
            $englishName = trim((string) ($city['name_en'] ?? ''));

            if ($arabicName === '' || isset($uniqueCities[$arabicName])) {
                continue;
            }

            $uniqueCities[$arabicName] = [
                'country_code' => 'SA',
                'city_code' => (string) ($city['city_id'] ?? ($index + 1)),
                'city_enName' => $englishName ?: $arabicName,
                'city_arName' => $arabicName,
                'updated_at' => $now,
                'created_at' => $now,
            ];
        }

        ksort($uniqueCities, SORT_NATURAL);

        foreach ($uniqueCities as $city) {
            DB::table('cities')->updateOrInsert(
                [
                    'country_code' => 'SA',
                    'city_arName' => $city['city_arName'],
                ],
                $city
            );
        }
    }

    private function products(): array
    {
        return [
            [
                'title' => 'حقيبة كروشيه وردية بتدرج ليموني',
                'summary' => 'حقيبة كتف كروشيه وردية بتدرج ليموني ناعم وحزام طويل محاك، قطعة خفيفة تضيف لمسة مشرقة للإطلالات اليومية.',
                'description' => 'تصميم يدوي يجمع الوردي الهادئ مع لمسة ليمونية في الوسط، مناسب للطلعات النهارية والفساتين الناعمة.',
                'features' => ['خيوط كروشيه متماسكة بملمس ناعم.', 'حزام كتف طويل ومحاك بالكامل.', 'حجم مناسب للجوال والمحفظة والمقتنيات الصغيرة.', 'تصميم أنثوي مبهج وسهل التنسيق.'],
                'price' => 360,
                'quantity' => 6,
                'service_category_id' => 3,
                'image' => 'tyaniel/bags/bag-pastel-lemon-shoulder-new.jpeg',
                'tags' => 'حقائب كروشيه,شنط,وردي,ليموني,يدوي',
            ],
            [
                'title' => 'حقيبة كروشيه فوشيا باللؤلؤ',
                'summary' => 'حقيبة يد فوشيا محاكة بتفاصيل لؤلؤية ومقبض علوي، اختيار فاخر لإطلالة أنثوية لافتة.',
                'description' => 'لون فوشيا غني مع حبات لؤلؤ موزعة بعناية يمنح الحقيبة حضوراً راقياً يناسب المناسبات والزيارات.',
                'features' => ['خيوط كروشيه فوشيا بنسيج بارز.', 'زخارف لؤلؤية أمامية بتوزيع أنيق.', 'مقبض علوي عاجي سهل الحمل.', 'حجم عملي للمناسبات الخفيفة.'],
                'price' => 430,
                'quantity' => 5,
                'service_category_id' => 3,
                'image' => 'tyaniel/bags/bag-fuchsia-pearl-top-handle-new.jpeg',
                'tags' => 'حقائب كروشيه,شنط,فوشيا,لؤلؤ,فاخر',
            ],
            [
                'title' => 'حقيبة كروشيه عاجية وسماوية',
                'summary' => 'حقيبة كروشيه بتدرجات عاجية وسماوية وكحلية مع زهرة جانبية، تصميم راق وهادئ للاستخدام اليومي.',
                'description' => 'قطعة متوازنة تجمع الألوان الهادئة مع تفصيلة زهرة محاكة، مناسبة للنهار والإطلالات الصيفية الناعمة.',
                'features' => ['ألوان عاجية وسماوية وكحلية متناسقة.', 'زهرة كروشيه جانبية بتفاصيل بارزة.', 'مقبض علوي عاجي مريح.', 'نقشة محاكة مفتوحة وخفيفة.'],
                'price' => 460,
                'quantity' => 4,
                'service_category_id' => 3,
                'image' => 'tyaniel/bags/bag-ivory-sky-navy-flower-new.jpeg',
                'tags' => 'حقائب كروشيه,شنط,عاجي,سماوي,كحلي',
            ],
            [
                'title' => 'حقيبة كروشيه موف بزهور صفراء',
                'summary' => 'حقيبة كروشيه موف بسلسلة ذهبية وتفاصيل زهور صفراء مع محفظة صغيرة متناسقة، إطلالة مكتملة بنعومة.',
                'description' => 'تصميم يجمع الحقيبة والمحفظة الصغيرة بتفاصيل محاكة ذهبية وصفراء تمنحها فخامة يومية واضحة.',
                'features' => ['لون موف ناعم مع زهور صفراء محاكة.', 'سلسلة ذهبية ولمسات معدنية فاخرة.', 'محفظة صغيرة متناسقة مع الحقيبة.', 'قفل أمامي عملي وأنيق.'],
                'price' => 410,
                'quantity' => 5,
                'service_category_id' => 3,
                'image' => 'tyaniel/bags/bag-mauve-flower-charm-set-new.jpeg',
                'tags' => 'حقائب كروشيه,شنط,موف,زهور,سلسلة',
            ],
            [
                'title' => 'حقيبة كروشيه دائرية عاجية بنفسجية',
                'summary' => 'حقيبة دائرية كروشيه بلون عاجي مع زهرة بنفسجية وسلسلة شفافة، قطعة رقيقة بتفاصيل فنية.',
                'description' => 'شكل دائري مميز مع زهرة بنفسجية مركزية يجعلها مناسبة للإطلالات الهادئة والزيارات الخفيفة.',
                'features' => ['تصميم دائري صغير وخفيف.', 'نقشة كروشيه عاجية مفتوحة.', 'زهرة بنفسجية أمامية بارزة.', 'حزام سلسلة شفاف بلمعة ناعمة.'],
                'price' => 390,
                'quantity' => 6,
                'service_category_id' => 3,
                'image' => 'tyaniel/bags/bag-ivory-purple-round-chain-new.jpeg',
                'tags' => 'حقائب كروشيه,شنط,دائرية,عاجي,بنفسجي',
            ],
            [
                'title' => 'حذاء كروشيه وردي ناعم',
                'summary' => 'حذاء كروشيه وردي خفيف ومريح بملمس ناعم، مناسب للاستخدام المنزلي الأنيق والهدايا اللطيفة.',
                'description' => 'قطعة ناعمة للأقدام تجمع الراحة مع شكل أنثوي هادئ، وتناسب الأجواء المنزلية أو التغليف كهدية.',
                'features' => ['خيوط وردية ناعمة ومريحة.', 'تصميم خفيف يسهل ارتداؤه.', 'نعل محاك بملمس لطيف.', 'مناسب للهدايا والاستخدام اليومي داخل المنزل.'],
                'price' => 320,
                'quantity' => 8,
                'service_category_id' => 4,
                'image' => 'tyaniel/shoes/shoe-soft-pink-crochet-slippers-new.jpeg',
                'tags' => 'أحذية,كروشيه,وردي,حذاء,ناعم',
            ],
            [
                'title' => 'حقيبة كروشيه وردة وردية',
                'summary' => 'حقيبة كروشيه على شكل وردة وردية بحزام ناعم، قطعة رومانسية لافتة لمحبات التفاصيل الأنثوية.',
                'description' => 'تصميم الوردة يمنح الحقيبة شخصية فريدة، ويجعلها مناسبة للمناسبات الصغيرة والإطلالات الوردية الناعمة.',
                'features' => ['شكل وردة محاكة بتدرجات وردية.', 'حزام يدوي خفيف مع لمسات معدنية.', 'حجم صغير مناسب للمقتنيات الأساسية.', 'قطعة مميزة للتصوير والهدايا.'],
                'price' => 440,
                'quantity' => 4,
                'service_category_id' => 3,
                'image' => 'tyaniel/bags/bag-pink-rose-bloom-chain-new.jpeg',
                'tags' => 'حقائب كروشيه,شنط,وردة,وردي,هدايا',
            ],
            [
                'title' => 'حزام كروشيه بنفسجي أنيق',
                'summary' => 'حزام كروشيه بنفسجي بتصميم عريض وملمس محاك، يضيف تحديداً ناعماً للفساتين والعبايات.',
                'description' => 'قطعة أزياء عملية تمنح الإطلالة لمسة مختلفة دون مبالغة، وتناسب تنسيق الفساتين الواسعة أو القطع القطنية.',
                'features' => ['خيوط كروشيه بنفسجية بنقشة متماسكة.', 'تصميم عريض يبرز الخصر برقة.', 'سهل التنسيق مع الألوان الفاتحة والمحايدة.', 'مناسب للإطلالات اليومية والمناسبات الخفيفة.'],
                'price' => 260,
                'quantity' => 7,
                'service_category_id' => 2,
                'image' => 'tyaniel/fashion/fashion-purple-crochet-belt-new.jpeg',
                'tags' => 'أزياء,حزام,كروشيه,بنفسجي,إكسسوار أزياء',
            ],
            [
                'title' => 'حقيبة كروشيه موف كلاسيكية',
                'summary' => 'حقيبة كروشيه موف بمقبض كتف محاك وقفل ذهبي وزهرة عاجية، تصميم كلاسيكي راق.',
                'description' => 'حقيبة يومية أنيقة بلون موف هادئ وتفاصيل ذهبية، تناسب العبايات والإطلالات الراقية غير المتكلفة.',
                'features' => ['لون موف كلاسيكي بنسيج متماسك.', 'قفل ذهبي أمامي لامع.', 'زهور عاجية جانبية محاكة.', 'حزام كتف محاك مع خرز معدني ناعم.'],
                'price' => 420,
                'quantity' => 5,
                'service_category_id' => 3,
                'image' => 'tyaniel/bags/bag-mauve-classic-flower-lock-new.jpeg',
                'tags' => 'حقائب كروشيه,شنط,موف,كلاسيكي,ذهبي',
            ],
            [
                'title' => 'حقيبة كروشيه سوداء ميني',
                'summary' => 'حقيبة كروشيه سوداء صغيرة بحزام يدوي، عملية وخفيفة للإطلالات المختصرة.',
                'description' => 'قطعة ميني بسيطة وعملية للقطع الصغيرة، تضيف لمسة حرفية سوداء تناسب اليوميات والتنسيقات الجريئة.',
                'features' => ['لون أسود عميق وسهل التنسيق.', 'حجم صغير وخفيف للحمل.', 'حزام يدوي قصير.', 'تفاصيل محاكة تمنحها شخصية فنية.'],
                'price' => 340,
                'quantity' => 7,
                'service_category_id' => 3,
                'image' => 'tyaniel/bags/bag-black-mini-artisan-new.jpeg',
                'tags' => 'حقائب كروشيه,شنط,أسود,ميني,يومي',
            ],
            [
                'title' => 'حقيبة كروشيه عنابية وعاجية',
                'summary' => 'حقيبة كروشيه عنابية وعاجية بمقبض مجدول وزهور أمامية، تصميم فاخر يليق بالمناسبات.',
                'description' => 'ألوان عنابية وعاجية مع تفاصيل زهور تمنحها حضوراً أنيقاً، وهي من القطع الفاخرة المناسبة للإهداء.',
                'features' => ['مزيج عنابي وعاجي بتباين فاخر.', 'مقبض مجدول بلون عاجي.', 'زهور محاكة وأزرار ذهبية أمامية.', 'حجم عملي للمناسبات والزيارات.'],
                'price' => 470,
                'quantity' => 4,
                'service_category_id' => 3,
                'image' => 'tyaniel/bags/bag-burgundy-ivory-bloom-new.jpeg',
                'tags' => 'حقائب كروشيه,شنط,عنابي,عاجي,فاخر',
            ],
        ];
    }

    private function productBody(array $product): string
    {
        $features = collect($product['features'])
            ->map(fn ($feature) => '<li>' . e($feature) . '</li>')
            ->implode('');

        return '<p>' . e($product['description']) . '</p>'
            . '<h4>مواصفات المنتج</h4><ul>' . $features . '</ul>'
            . '<h4>الشحن والعناية</h4>'
            . '<p>يشحن المنتج داخل المملكة العربية السعودية وفق سياسة الشحن المعتمدة في متجر تيانيل. للحفاظ على جمال القطعة، تنظف بلطف بقطعة قماش ناعمة وتحفظ بعيداً عن الرطوبة والعطور المباشرة.</p>';
    }

    private function plainText(string $value): string
    {
        return trim((string) preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }

    private function baseSlug(string $value): string
    {
        $slug = Str::slug(trim(strip_tags($value)), '-', 'ar');

        if (trim($slug) === '') {
            $slug = preg_replace('/[^\p{Arabic}\p{L}\p{N}]+/u', '-', $value);
            $slug = Str::lower(trim((string) $slug, '-'));
        }

        $slug = preg_replace('/-+/u', '-', (string) $slug);

        return trim($slug, '-') ?: 'product';
    }

    private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = Str::limit($baseSlug, 170, '');
        $candidate = $slug;
        $counter = 2;

        while ($this->slugExists($candidate, $ignoreId)) {
            $suffix = '-' . $counter++;
            $candidate = Str::limit($slug, 170 - strlen($suffix), '') . $suffix;
        }

        return $candidate;
    }

    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $query = DB::table('services')->where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '<>', $ignoreId);
        }

        return $query->exists();
    }
}
