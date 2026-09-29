<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TyanielGirlsYellowPurpleCrochetDressSeeder extends Seeder
{
    private const MAIN_IMAGE = 'tyaniel/fashion/girls-yellow-purple-bow-crochet-dress-product.jpeg';

    private const GALLERY_IMAGE = 'tyaniel/fashion/girls-yellow-purple-bow-crochet-dress-details.jpeg';

    public function run(): void
    {
        $now = now();
        $title = 'فستان كروشيه أصفر وبنفسجي للبنات بفيونكات';
        $summary = 'فستان كروشيه يدوي للبنات بدرجات الأصفر الفاتح والبنفسجي، مزين بفيونكات ورباط خصر وتفاصيل ناعمة.';
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
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,أصفر,بنفسجي,فيونكات,يدوي',
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
                'slug' => $this->uniqueSlug('girls-yellow-purple-bow-crochet-dress', $existingId),
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
        return '<p>فستان كروشيه يدوي للبنات يجمع الأصفر الفاتح والبنفسجي في تصميم واسع ومبهج، مع رباط خصر مزين بفيونكات وتفاصيل أمامية وخلفية أنيقة.</p>'
            . '<h4>مواصفات المنتج</h4><ul>'
            . '<li>حياكة كروشيه يدوية متقنة بملمس ناعم.</li>'
            . '<li>تصميم واسع بدرجات الأصفر الفاتح والبنفسجي.</li>'
            . '<li>رباط خصر أمامي مزين بفيونكات صغيرة.</li>'
            . '<li>فيونكة خلفية كبيرة مع أزرار على شكل قلب.</li>'
            . '<li>حواف متموجة تناسب المناسبات والزيارات والتصوير.</li>'
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
