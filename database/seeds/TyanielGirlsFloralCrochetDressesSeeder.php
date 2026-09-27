<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TyanielGirlsFloralCrochetDressesSeeder extends Seeder
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
                'title' => 'فستان كروشيه موف وعاجي للبنات بزهور لؤلؤية',
                'summary' => 'فستان كروشيه للبنات بدرجات الموف والعاجي، مزين بزهور بارزة وحبات لؤلؤ لتفاصيل طفولية أنيقة.',
                'description' => 'فستان كروشيه يدوي للبنات يجمع اللون الموف مع تفاصيل عاجية ناعمة، وتزينه زهور كروشيه بارزة بحبات لؤلؤ وحواف متموجة تمنحه إطلالة مبهجة.',
                'features' => [
                    'حياكة كروشيه يدوية متقنة.',
                    'ألوان موف وعاجية متناسقة.',
                    'زهور بارزة مزينة بحبات لؤلؤ.',
                    'أكمام قصيرة وحافة سفلية مزخرفة.',
                    'مناسب للمناسبات والزيارات والتصوير.',
                ],
                'image' => 'tyaniel/fashion/girls-mauve-ivory-floral-crochet-dress.jpeg',
                'gallery_image' => null,
                'slug' => 'girls-mauve-ivory-floral-crochet-dress',
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,موف,عاجي,زهور,لؤلؤ,يدوي',
            ],
            [
                'title' => 'فستان كروشيه وردي وأبيض للبنات بزهور لؤلؤية',
                'summary' => 'فستان كروشيه للبنات باللون الوردي مع تفاصيل بيضاء، مزين بزهور وحبات لؤلؤ لإطلالة ناعمة ومميزة.',
                'description' => 'فستان كروشيه يدوي للبنات بلون وردي ناعم تتخلله زخارف بيضاء، مع زهور بارزة مرصعة بحبات لؤلؤ وحواف متموجة تناسب الإطلالات المرحة.',
                'features' => [
                    'حياكة كروشيه يدوية بملمس ناعم.',
                    'تصميم وردي وأبيض سهل التنسيق.',
                    'زهور بارزة بتفاصيل لؤلؤية.',
                    'أكمام قصيرة مزخرفة وحواف متموجة.',
                    'مناسب للمناسبات والهدايا والتصوير.',
                ],
                'image' => 'tyaniel/fashion/girls-pink-white-floral-crochet-dress-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-pink-white-floral-crochet-dress-detail.jpeg',
                'slug' => 'girls-pink-white-floral-crochet-dress',
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,وردي,أبيض,زهور,لؤلؤ,يدوي',
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
            . '<h4>المقاس والعناية</h4>'
            . '<p>يرجى تأكيد المقاس المناسب عند الطلب. يغسل الفستان يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة للحفاظ على الحياكة والزخارف.</p>';
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
