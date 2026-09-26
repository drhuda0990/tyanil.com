<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TyanielBurgundyFashionProductsSeeder extends Seeder
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
                    'body' => $product['body'],
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
                'title' => 'شال كروشيه أحمر مزين بالورود',
                'summary' => 'شال نسائي مثلث من الكروشيه الأحمر، مزين بورود بارزة وشراشيب ناعمة تمنحه حضوراً أنيقاً ودافئاً.',
                'image' => 'tyaniel/fashion/red-crochet-floral-shawl-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/red-crochet-floral-shawl-model.jpeg',
                'slug' => 'red-crochet-floral-shawl',
                'tags' => 'أزياء,شال نسائي,شال كروشيه,أحمر,ورود,شراشيب,يدوي',
                'body' => '<p>شال كروشيه نسائي باللون الأحمر صُنع بعناية بتصميم مثلث وتفاصيل ورود بارزة، مع حواف من الشراشيب الناعمة لإطلالة أنيقة ومريحة.</p>'
                    . '<h4>مواصفات المنتج</h4><ul>'
                    . '<li>حياكة كروشيه يدوية متقنة.</li>'
                    . '<li>تصميم مثلث سهل الارتداء والتنسيق.</li>'
                    . '<li>ورود كروشيه بارزة موزعة بعناية.</li>'
                    . '<li>حواف مزينة بشراشيب ناعمة.</li>'
                    . '<li>مناسب للإطلالات اليومية والمناسبات.</li>'
                    . '</ul><h4>العناية بالمنتج</h4>'
                    . '<p>يغسل يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة للحفاظ على الحياكة والتفاصيل.</p>',
            ],
            [
                'title' => 'فستان كروشيه خمري بحواف عاجية',
                'summary' => 'فستان كروشيه نسائي باللون الخمري مع تفاصيل زهور وحواف عاجية، بتصميم أنيق ومريح يناسب الإطلالات المميزة.',
                'image' => 'tyaniel/fashion/burgundy-ivory-crochet-dress.jpeg',
                'gallery_image' => null,
                'slug' => 'burgundy-ivory-crochet-dress',
                'tags' => 'أزياء,فستان نسائي,فستان كروشيه,خمري,عاجي,زهور,يدوي',
                'body' => '<p>فستان كروشيه نسائي باللون الخمري الغني، تزينه تفاصيل عاجية على الحمالات والخصر والحافة السفلية، ليجمع بين أناقة الحياكة اليدوية والراحة.</p>'
                    . '<h4>مواصفات المنتج</h4><ul>'
                    . '<li>حياكة كروشيه يدوية بجودة عالية.</li>'
                    . '<li>تصميم طويل بقصة أنيقة ومريحة.</li>'
                    . '<li>حمالات مزينة بتفاصيل زهور عاجية.</li>'
                    . '<li>حزام وحافة سفلية بتشطيب زهري متناسق.</li>'
                    . '<li>مناسب للإطلالات اليومية والمناسبات الخاصة.</li>'
                    . '</ul><h4>المقاس والعناية</h4>'
                    . '<p>يرجى تأكيد المقاس المناسب عند الطلب. يغسل الفستان يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح للحفاظ على القصة والحياكة.</p>',
            ],
        ];
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
