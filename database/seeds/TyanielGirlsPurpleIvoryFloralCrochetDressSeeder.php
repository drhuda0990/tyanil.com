<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TyanielGirlsPurpleIvoryFloralCrochetDressSeeder extends Seeder
{
    private const MAIN_IMAGE = 'tyaniel/fashion/girls-purple-ivory-floral-crochet-dress-product.jpeg';

    private const GALLERY_IMAGE = 'tyaniel/fashion/girls-purple-ivory-floral-crochet-dress-details.jpeg';

    public function run(): void
    {
        $now = now();
        $title = 'فستان بنات كروشيه بنفسجي بالورود';
        $summary = 'فستان كروشيه يدوي للبنات باللون البنفسجي وحواف بيضاء، مزين بورود بارزة ورباط خصر بكرات ناعمة.';
        $existingId = DB::table('services')->where('image', self::MAIN_IMAGE)->value('id');
        $purchaseMessageId = DB::table('definitions')->where('slug', 'purchase_sms')->value('id');
        $purchaseEmailId = DB::table('definitions')->where('slug', 'purchase_email')->value('id');

        DB::transaction(function () use (
            $now,
            $title,
            $summary,
            $existingId,
            $purchaseMessageId,
            $purchaseEmailId
        ) {
            $attributes = [
                'title' => $title,
                'summry' => '<p>' . e($summary) . '</p>',
                'price_1' => '100',
                'price_2' => null,
                'body' => $this->productBody(),
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,بنفسجي,أبيض,ورود,يدوي',
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
                'slug' => $this->uniqueSlug('girls-purple-ivory-floral-crochet-dress', $existingId),
                'meta_title' => Str::limit($title . ' | تيانيل', 70, ''),
                'meta_description' => Str::limit($summary, 155, ''),
                'quantity' => 6,
                'updated_at' => $now,
            ];

            if (! $existingId) {
                $attributes['created_at'] = $now;
            }

            DB::table('services')->updateOrInsert(
                ['image' => self::MAIN_IMAGE],
                $attributes
            );

            $service = Service::where('image', self::MAIN_IMAGE)->first();

            if ($service) {
                $this->attachGalleryImage($service);
            }
        });
    }

    private function productBody(): string
    {
        return '<p>فستان كروشيه يدوي للبنات باللون البنفسجي مع حواف بيضاء مزخرفة، مزين بورود بارزة ورباط خصر ينتهي بكرتين ناعمتين.</p>'
            . '<h4>مواصفات المنتج</h4><ul>'
            . '<li>حياكة كروشيه يدوية متقنة بملمس ناعم.</li>'
            . '<li>تصميم بنفسجي واسع مع حواف بيضاء متموجة.</li>'
            . '<li>ورود بارزة باللونين الأبيض والوردي مع أوراق خضراء.</li>'
            . '<li>رباط خصر أمامي مزين بكرتين ناعمتين.</li>'
            . '<li>أزرار خلفية على شكل قلب لسهولة الارتداء.</li>'
            . '</ul><h4>المقاس والعناية</h4>'
            . '<p>يرجى تأكيد المقاس المناسب عند الطلب. يغسل الفستان يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة للحفاظ على الحياكة والزخارف.</p>';
    }

    private function attachGalleryImage(Service $service): void
    {
        $fileName = basename(self::GALLERY_IMAGE);

        $exists = $service->media()
            ->where('collection_name', 'multi_service_images')
            ->where('file_name', $fileName)
            ->exists();

        if ($exists) {
            return;
        }

        $path = storage_path('app/public/' . self::GALLERY_IMAGE);

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
