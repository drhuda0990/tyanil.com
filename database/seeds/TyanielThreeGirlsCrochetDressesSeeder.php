<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TyanielThreeGirlsCrochetDressesSeeder extends Seeder
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
                'title' => 'فستان بنات كروشيه وردي بالزهور',
                'summary' => 'فستان كروشيه يدوي للبنات باللون الوردي مع تفاصيل بيضاء، مزين بزهور بارزة ورباط خصر أنيق.',
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,وردي,أبيض,زهور,يدوي',
                'slug' => 'girls-dusty-pink-floral-crochet-dress',
                'main_image' => 'tyaniel/fashion/girls-dusty-pink-floral-crochet-dress-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-dusty-pink-floral-crochet-dress-details.jpeg',
                'body' => '<p>فستان كروشيه يدوي للبنات باللون الوردي الهادئ مع إطار أبيض وحواف متموجة، مزين بباقة من الزهور البارزة ورباط خصر ناعم.</p>'
                    . '<h4>مواصفات المنتج</h4><ul>'
                    . '<li>حياكة كروشيه يدوية متقنة بملمس ناعم.</li>'
                    . '<li>تصميم وردي واسع مع تفاصيل وحواف بيضاء.</li>'
                    . '<li>زهور بارزة بدرجات الوردي والأبيض والأصفر.</li>'
                    . '<li>رباط خصر أمامي وأزرار خلفية لسهولة الارتداء.</li>'
                    . '<li>مناسب للمناسبات والزيارات والتصوير.</li>'
                    . '</ul>',
            ],
            [
                'title' => 'فستان بنات كروشيه سماوي بفيونكة',
                'summary' => 'فستان كروشيه يدوي للبنات باللون السماوي مع تفاصيل بيضاء، مزين بفيونكة كبيرة وحواف أنيقة.',
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,سماوي,أبيض,فيونكة,يدوي',
                'slug' => 'girls-sky-blue-white-bow-crochet-dress',
                'main_image' => 'tyaniel/fashion/girls-sky-blue-white-bow-crochet-dress-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-sky-blue-white-bow-crochet-dress-details.jpeg',
                'body' => '<p>فستان كروشيه يدوي للبنات باللون السماوي مع تفاصيل بيضاء، يتوسطه فيونكة كبيرة وتحيط بتنورته حواف مزخرفة ومتموجة.</p>'
                    . '<h4>مواصفات المنتج</h4><ul>'
                    . '<li>حياكة كروشيه يدوية متقنة بملمس ناعم.</li>'
                    . '<li>تصميم سماوي واسع مع خطوط وحواف بيضاء.</li>'
                    . '<li>فيونكة بيضاء كبيرة بتفاصيل متدلية.</li>'
                    . '<li>أزرار خلفية ورباط خصر لسهولة الارتداء.</li>'
                    . '<li>مناسب للمناسبات والزيارات والتصوير.</li>'
                    . '</ul>',
            ],
            [
                'title' => 'فستان بنات كروشيه أصفر بالزهور',
                'summary' => 'فستان كروشيه يدوي للبنات باللون الأصفر الفاتح مع حواف بيضاء، مزين بزهور ملونة وفيونكة خلفية.',
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,أصفر,أبيض,زهور,فيونكة,يدوي',
                'slug' => 'girls-yellow-floral-crochet-dress',
                'main_image' => 'tyaniel/fashion/girls-yellow-floral-crochet-dress-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-yellow-floral-crochet-dress-details.jpeg',
                'body' => '<p>فستان كروشيه يدوي للبنات باللون الأصفر الفاتح مع حواف بيضاء رقيقة، مزين بزهور وردية وبنفسجية وفيونكة خلفية كبيرة.</p>'
                    . '<h4>مواصفات المنتج</h4><ul>'
                    . '<li>حياكة كروشيه يدوية متقنة بملمس ناعم.</li>'
                    . '<li>تصميم أصفر فاتح واسع مع حواف بيضاء.</li>'
                    . '<li>زهور بارزة بدرجات الوردي والبنفسجي والأبيض.</li>'
                    . '<li>فيونكة خلفية كبيرة وأزرار لسهولة الارتداء.</li>'
                    . '<li>مناسب للمناسبات والزيارات والتصوير.</li>'
                    . '</ul>',
            ],
        ];
    }

    private function upsertProduct(array $product, ?int $purchaseMessageId, ?int $purchaseEmailId): void
    {
        $now = now();
        $existingId = DB::table('services')->where('image', $product['main_image'])->value('id');

        DB::transaction(function () use ($product, $now, $existingId, $purchaseMessageId, $purchaseEmailId) {
            $attributes = [
                'title' => $product['title'],
                'summry' => '<p>' . e($product['summary']) . '</p>',
                'price_1' => '100',
                'price_2' => null,
                'body' => $product['body'] . $this->careInstructions(),
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
                ['image' => $product['main_image']],
                $attributes
            );

            $service = Service::where('image', $product['main_image'])->first();

            if ($service) {
                $this->attachGalleryImage($service, $product['gallery_image']);
            }
        });
    }

    private function careInstructions(): string
    {
        return '<h4>المقاس والعناية</h4>'
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
