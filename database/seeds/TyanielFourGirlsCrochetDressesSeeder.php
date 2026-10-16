<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TyanielFourGirlsCrochetDressesSeeder extends Seeder
{
    public function run(): void
    {
        $purchaseMessageId = DB::table('definitions')->where('slug', 'purchase_sms')->value('id');
        $purchaseEmailId = DB::table('definitions')->where('slug', 'purchase_email')->value('id');

        foreach ($this->products() as $product) {
            $this->upsertProduct($product, $purchaseMessageId, $purchaseEmailId);
        }
    }

    private function products(): array
    {
        return [
            [
                'title' => 'طقم فستان وقبعة كروشيه أزرق ملكي وأبيض للبنات',
                'summary' => 'طقم كروشيه يدوي للبنات يضم فستاناً أزرق ملكياً وأبيض مع قبعة متناسقة مزينة بفيونكة.',
                'description' => 'طقم كروشيه يدوي أنيق للبنات يجمع فستاناً بقصة واسعة وقبعة متناسقة بدرجات الأزرق الملكي والأبيض، مع حواف متموجة وفيونكة بارزة.',
                'features' => [
                    'طقم مكون من فستان وقبعة كروشيه متناسقين.',
                    'ألوان أزرق ملكي وأبيض بتباين أنيق.',
                    'قبعة مزينة بفيونكة كروشيه بارزة.',
                    'قصة واسعة وحواف متموجة ناعمة.',
                    'مناسب للمناسبات والهدايا والتصوير.',
                ],
                'slug' => 'girls-royal-blue-white-crochet-dress-hat-set',
                'main_image' => 'tyaniel/fashion/girls-royal-blue-white-crochet-dress-hat-set-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-royal-blue-white-crochet-dress-hat-set-details.jpeg',
                'tags' => 'أزياء,فساتين أطفال,طقم أطفال,فستان كروشيه,قبعة كروشيه,بنات,أزرق ملكي,أبيض,فيونكة,يدوي',
                'care' => 'يرجى تأكيد المقاس المناسب عند الطلب. يغسل الطقم يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة.',
            ],
            [
                'title' => 'فستان كروشيه موف وأبيض للبنات بنقشة الزهور',
                'summary' => 'فستان كروشيه يدوي للبنات باللون الموف والأبيض، مزين بصفوف زهور ورباط خصر بكرات كروشيه.',
                'description' => 'فستان كروشيه يدوي للبنات يجمع اللون الموف مع الأبيض في وحدات زهرية متناسقة، ويكتمل برباط خصر مزين بكرات كروشيه وحواف متموجة.',
                'features' => [
                    'حياكة كروشيه يدوية بوحدات زهرية دقيقة.',
                    'ألوان موف وأبيض بتوزيع متناسق.',
                    'رباط خصر مزين بكرات كروشيه.',
                    'أزرار لؤلؤية وحواف متموجة.',
                    'مناسب للمناسبات والزيارات والتصوير.',
                ],
                'slug' => 'girls-mauve-white-daisy-crochet-dress',
                'main_image' => 'tyaniel/fashion/girls-mauve-white-daisy-crochet-dress-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-mauve-white-daisy-crochet-dress-details.jpeg',
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,موف,أبيض,زهور,لؤلؤ,يدوي',
                'care' => 'يرجى تأكيد المقاس المناسب عند الطلب. يغسل الفستان يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة.',
            ],
            [
                'title' => 'فستان كروشيه أحمر وأبيض للبنات بفيونكة',
                'summary' => 'فستان كروشيه يدوي للبنات باللون الأحمر والأبيض، مزين بفيونكة كبيرة وطبقات متموجة أنيقة.',
                'description' => 'فستان كروشيه يدوي للبنات بتصميم أحمر وأبيض لافت، يتميز بفيونكة أمامية كبيرة وأكمام قصيرة وطبقات سفلية متموجة.',
                'features' => [
                    'حياكة كروشيه يدوية متقنة بملمس ناعم.',
                    'ألوان أحمر وأبيض بتصميم واضح وأنيق.',
                    'فيونكة كروشيه كبيرة تزين الواجهة.',
                    'طبقات متموجة وحواف مزخرفة.',
                    'مناسب للمناسبات والاحتفالات والتصوير.',
                ],
                'slug' => 'girls-red-white-bow-crochet-dress',
                'main_image' => 'tyaniel/fashion/girls-red-white-bow-crochet-dress-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-red-white-bow-crochet-dress-details.jpeg',
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,أحمر,أبيض,فيونكة,يدوي',
                'care' => 'يرجى تأكيد المقاس المناسب عند الطلب. يغسل الفستان يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة.',
            ],
            [
                'title' => 'فستان كروشيه أزرق سماوي للبنات بزهور الباستيل',
                'summary' => 'فستان كروشيه يدوي للبنات بالأزرق السماوي، مزين بزهور وأطراف بدرجات الوردي والأصفر والأبيض.',
                'description' => 'فستان كروشيه يدوي للبنات بلون أزرق سماوي هادئ، تزينه زهور بارزة عند الخصر وطبقات باستيل وردية وصفراء وبيضاء عند الياقة والحافة.',
                'features' => [
                    'حياكة كروشيه يدوية بتفاصيل دقيقة.',
                    'لون أزرق سماوي مع درجات باستيل متناسقة.',
                    'زهور بارزة ملونة عند الخصر.',
                    'قصة واسعة بطبقات وحواف متموجة.',
                    'مناسب للمناسبات والهدايا والتصوير.',
                ],
                'slug' => 'girls-sky-blue-pastel-floral-crochet-dress',
                'main_image' => 'tyaniel/fashion/girls-sky-blue-pastel-floral-crochet-dress-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-sky-blue-pastel-floral-crochet-dress-details.jpeg',
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,أزرق سماوي,باستيل,وردي,أصفر,أبيض,زهور,يدوي',
                'care' => 'يرجى تأكيد المقاس المناسب عند الطلب. يغسل الفستان يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة.',
            ],
        ];
    }

    private function upsertProduct(array $product, ?int $purchaseMessageId, ?int $purchaseEmailId): void
    {
        $existingId = DB::table('services')
            ->where('slug', $product['slug'])
            ->orWhere('image', $product['main_image'])
            ->value('id');

        DB::transaction(function () use ($product, $existingId, $purchaseMessageId, $purchaseEmailId) {
            $now = now();
            $attributes = [
                'title' => $product['title'],
                'summry' => '<p>' . e($product['summary']) . '</p>',
                'price_1' => '100',
                'price_2' => null,
                'body' => $this->productBody($product),
                'tags' => $product['tags'],
                'image' => $product['main_image'],
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

            if ($existingId) {
                DB::table('services')->where('id', $existingId)->update($attributes);
                $serviceId = $existingId;
            } else {
                $attributes['created_at'] = $now;
                $serviceId = DB::table('services')->insertGetId($attributes);
            }

            $service = Service::find($serviceId);

            if ($service) {
                $this->attachGalleryImage($service, $product['gallery_image']);
            }
        });
    }

    private function productBody(array $product): string
    {
        $features = '';

        foreach ($product['features'] as $feature) {
            $features .= '<li>' . e($feature) . '</li>';
        }

        return '<p>' . e($product['description']) . '</p>'
            . '<h4>مواصفات المنتج</h4><ul>' . $features . '</ul>'
            . '<h4>المقاس والعناية</h4><p>' . e($product['care']) . '</p>';
    }

    private function attachGalleryImage(Service $service, string $galleryImage): void
    {
        $path = storage_path('app/public/' . $galleryImage);

        if (! is_file($path)) {
            return;
        }

        $fileName = basename($galleryImage);
        $existingMedia = $service->media()
            ->where('collection_name', 'multi_service_images')
            ->where('file_name', $fileName)
            ->first();

        if ($existingMedia) {
            $existingPath = $existingMedia->getPath();

            if (is_file($existingPath) && hash_file('sha256', $existingPath) === hash_file('sha256', $path)) {
                return;
            }

            $existingMedia->delete();
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
