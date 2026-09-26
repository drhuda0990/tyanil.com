<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TyanielCrochetShawlCollectionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $purchaseMessageId = DB::table('definitions')->where('slug', 'purchase_sms')->value('id');
        $purchaseEmailId = DB::table('definitions')->where('slug', 'purchase_email')->value('id');

        DB::transaction(function () use ($now, $purchaseMessageId, $purchaseEmailId) {
            foreach ($this->products() as $product) {
                $existingId = DB::table('services')->where('image', $product['image'])->value('id');
                $attributes = [
                    'title' => $product['title'],
                    'summry' => '<p>' . e($product['summary']) . '</p>',
                    'price_1' => '100',
                    'price_2' => null,
                    'body' => $this->productBody($product),
                    'tags' => $product['tags'],
                    'video' => null,
                    'service_mail_1_date' => null,
                    'service_mail_2_date' => null,
                    'service_mail_1' => null,
                    'service_mail_2' => null,
                    'purchase_message' => $purchaseMessageId,
                    'purchase_email' => $purchaseEmailId,
                    'disable_coupon' => 0,
                    'is_available_hidden' => 1,
                    'required_shipment' => '1',
                    'activate' => 1,
                    'not_available' => 0,
                    'service_category_id' => 2,
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
                    'slug' => $this->uniqueSlug($product['slug'], $existingId),
                    'meta_title' => Str::limit($product['title'] . ' | تيانيل', 70, ''),
                    'meta_description' => Str::limit($product['summary'], 155, ''),
                    'quantity' => 6,
                    'updated_at' => $now,
                ];

                if (! $existingId) {
                    $attributes['created_at'] = $now;
                }

                DB::table('services')->updateOrInsert(
                    ['image' => $product['image']],
                    $attributes
                );

                if ($product['gallery_image']) {
                    $service = Service::where('image', $product['image'])->first();

                    if ($service) {
                        $this->attachGalleryImage($service, $product['gallery_image']);
                    }
                }
            }
        });
    }

    private function products(): array
    {
        return [
            [
                'title' => 'شال كروشيه عاجي مزين بالورود',
                'summary' => 'شال نسائي مثلث باللون العاجي، مزين بورود كروشيه بارزة وشراشيب ناعمة لإطلالة هادئة وراقية.',
                'description' => 'شال كروشيه نسائي بلون عاجي ناعم، يجمع بين النقشة المفرغة والورود البارزة مع شراشيب متناسقة تمنحه حضوراً أنيقاً وسهل التنسيق.',
                'features' => [
                    'حياكة كروشيه يدوية متقنة.',
                    'تصميم مثلث مرن وسهل الارتداء.',
                    'ورود عاجية بارزة موزعة بعناية.',
                    'حواف مزينة بشراشيب ناعمة.',
                    'لون محايد يناسب الإطلالات اليومية والمناسبات.',
                ],
                'image' => 'tyaniel/fashion/ivory-flower-crochet-shawl.jpeg',
                'gallery_image' => null,
                'slug' => 'ivory-flower-crochet-shawl',
                'tags' => 'أزياء,شال نسائي,شال كروشيه,عاجي,ورود,شراشيب,يدوي',
            ],
            [
                'title' => 'شال كروشيه موف بنقشة هندسية',
                'summary' => 'شال نسائي كروشيه بدرجة موف ترابية، بنقشة هندسية مفرغة وشراشيب ناعمة لإطلالة أنثوية مميزة.',
                'description' => 'شال كروشيه مثلث بلون موف ترابي جذاب، صمم بنقشة هندسية متكررة وتفاصيل مفرغة تنتهي بشراشيب ناعمة تمنحه حركة وأناقة.',
                'features' => [
                    'حياكة يدوية بنقشة هندسية دقيقة.',
                    'تصميم مثلث ينسدل بشكل أنيق على الكتفين.',
                    'درجة موف ترابية سهلة التنسيق.',
                    'شراشيب ناعمة تحيط بالحواف.',
                    'مناسب للعبايات والفساتين والإطلالات اليومية.',
                ],
                'image' => 'tyaniel/fashion/dusty-mauve-geometric-crochet-shawl-main.jpeg',
                'gallery_image' => 'tyaniel/fashion/dusty-mauve-geometric-crochet-shawl-alternate.jpeg',
                'slug' => 'dusty-mauve-geometric-crochet-shawl',
                'tags' => 'أزياء,شال نسائي,شال كروشيه,موف,نقشة هندسية,شراشيب,يدوي',
            ],
            [
                'title' => 'شال كروشيه أسود بنقشة هندسية',
                'summary' => 'شال نسائي كروشيه باللون الأسود، بنقشة هندسية مفرغة وشراشيب كثيفة لإطلالة كلاسيكية فاخرة.',
                'description' => 'شال كروشيه مثلث باللون الأسود الأنيق، يتميز بوحدات هندسية مفرغة وحواف مزينة بشراشيب تمنحه طابعاً كلاسيكياً لافتاً.',
                'features' => [
                    'صناعة يدوية بخيوط عالية الجودة.',
                    'نقشة هندسية مفرغة بتفاصيل واضحة.',
                    'لون أسود كلاسيكي يناسب مختلف الإطلالات.',
                    'شراشيب كثيفة وناعمة على الحواف.',
                    'مناسب للاستخدام اليومي والمناسبات.',
                ],
                'image' => 'tyaniel/fashion/black-geometric-crochet-shawl.jpeg',
                'gallery_image' => null,
                'slug' => 'black-geometric-crochet-shawl',
                'tags' => 'أزياء,شال نسائي,شال كروشيه,أسود,نقشة هندسية,شراشيب,يدوي',
            ],
            [
                'title' => 'شال كروشيه زيتي بنقشة هندسية',
                'summary' => 'شال نسائي كروشيه بلون زيتي دافئ، بتفاصيل هندسية مفرغة وشراشيب ناعمة تمنح الإطلالة لمسة طبيعية أنيقة.',
                'description' => 'شال كروشيه مثلث بدرجة زيتية غنية، صمم بوحدات هندسية متناسقة وحياكة مفرغة مع شراشيب ناعمة لإطلالة دافئة ومميزة.',
                'features' => [
                    'حياكة كروشيه يدوية بجودة عالية.',
                    'تصميم هندسي مفرغ ومتناسق.',
                    'لون زيتي دافئ وسهل التنسيق.',
                    'شراشيب ناعمة موزعة على الحواف.',
                    'يناسب الإطلالات اليومية والموسمية.',
                ],
                'image' => 'tyaniel/fashion/olive-geometric-crochet-shawl.jpeg',
                'gallery_image' => null,
                'slug' => 'olive-geometric-crochet-shawl',
                'tags' => 'أزياء,شال نسائي,شال كروشيه,زيتي,نقشة هندسية,شراشيب,يدوي',
            ],
            [
                'title' => 'شال كروشيه عاجي بزهور حمراء',
                'summary' => 'شال نسائي عاجي مزين بزهور حمراء وعاجية بارزة، مع شراشيب ناعمة لإطلالة حيوية ومميزة.',
                'description' => 'شال كروشيه مثلث بلون عاجي هادئ، تتوزع عليه زهور حمراء وعاجية بارزة بتباين لافت، وتكتمل تفاصيله بشراشيب ناعمة حول الحواف.',
                'features' => [
                    'حياكة كروشيه يدوية متقنة.',
                    'زهور حمراء وعاجية بارزة وموزعة بعناية.',
                    'تصميم مثلث مريح وسهل التنسيق.',
                    'حواف محاطة بشراشيب ناعمة.',
                    'قطعة مميزة للمناسبات والهدايا والإطلالات اليومية.',
                ],
                'image' => 'tyaniel/fashion/ivory-red-flower-crochet-shawl-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/ivory-red-flower-crochet-shawl-model.jpeg',
                'slug' => 'ivory-red-flower-crochet-shawl',
                'tags' => 'أزياء,شال نسائي,شال كروشيه,عاجي,أحمر,زهور,شراشيب,يدوي',
            ],
            [
                'title' => 'طقم قبعة وشال كروشيه عاجي بكرز أحمر',
                'summary' => 'طقم نسائي من قبعة وشال كروشيه باللون العاجي، مزين بتفاصيل كرز حمراء وشراشيب ناعمة لإطلالة دافئة ومميزة.',
                'description' => 'طقم كروشيه نسائي متناسق يجمع قبعة بحواف متموجة وشالاً طويلاً بشراشيب ناعمة، مزينين بحبات كرز حمراء وأوراق خضراء بارزة.',
                'features' => [
                    'طقم متكامل مكون من قبعة وشال متناسقين.',
                    'حياكة كروشيه يدوية بلون عاجي هادئ.',
                    'تفاصيل كرز حمراء وأوراق خضراء بارزة.',
                    'شال طويل بحواف مزينة بشراشيب ناعمة.',
                    'مناسب للإطلالات الشتوية والهدايا.',
                ],
                'image' => 'tyaniel/fashion/ivory-cherry-crochet-hat-scarf-set.jpeg',
                'gallery_image' => null,
                'slug' => 'ivory-cherry-crochet-hat-scarf-set',
                'tags' => 'أزياء,طقم نسائي,قبعة كروشيه,شال كروشيه,عاجي,كرز,شتوي,يدوي',
            ],
        ];
    }

    private function productBody(array $product): string
    {
        $features = '';

        foreach ($product['features'] as $feature) {
            $features .= '<li>' . e($feature) . '</li>';
        }

        return '<p>' . e($product['description']) . '</p>'
            . '<h4>مواصفات المنتج</h4><ul>' . $features . '</ul>'
            . '<h4>العناية بالمنتج</h4>'
            . '<p>يغسل يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة للحفاظ على الحياكة والتفاصيل.</p>';
    }

    private function attachGalleryImage(Service $service, string $galleryImage): void
    {
        $fileName = basename($galleryImage);

        $exists = $service->media()
            ->where('collection_name', 'multi_service_images')
            ->where('file_name', $fileName)
            ->exists();

        if ($exists) {
            return;
        }

        $path = storage_path('app/public/' . $galleryImage);

        if (! is_file($path)) {
            return;
        }

        $service
            ->addMedia($path)
            ->preservingOriginal()
            ->toMediaCollection('multi_service_images');
    }

    private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $candidate = $baseSlug;
        $counter = 2;

        while ($this->slugExists($candidate, $ignoreId)) {
            $candidate = $baseSlug . '-' . $counter++;
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
