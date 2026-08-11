<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TyanielFashionHatsSeeder extends Seeder
{
    private const STORE_NAME = 'تيانيل';

    public function run(): void
    {
        $now = now();
        $purchaseSms = DB::table('definitions')->where('slug', 'purchase_sms')->value('id');
        $purchaseEmail = DB::table('definitions')->where('slug', 'purchase_email')->value('id');

        DB::transaction(function () use ($now, $purchaseSms, $purchaseEmail) {
            foreach ($this->products() as $product) {
                $existingId = DB::table('services')->where('image', $product['image'])->value('id');

                DB::table('services')->updateOrInsert(
                    ['image' => $product['image']],
                    [
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
                        'purchase_message' => $purchaseSms,
                        'purchase_email' => $purchaseEmail,
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
                        'slug' => $this->uniqueSlug($this->baseSlug($product['title']), $existingId),
                        'meta_title' => Str::limit($product['title'] . ' | ' . self::STORE_NAME, 70, ''),
                        'meta_description' => Str::limit($this->plainText($product['summary']), 155, ''),
                        'quantity' => 6,
                        'updated_at' => $now,
                        'created_at' => $now,
                    ]
                );

                $service = Service::where('image', $product['image'])->first();

                if ($service) {
                    $this->attachGalleryImage($service, $product['gallery_image']);
                }
            }
        });
    }

    private function products(): array
    {
        return [
            [
                'title' => 'قبعة كروشيه بنفسجية مزينة بالفراشات',
                'summary' => 'قبعة كروشيه نسائية بتدرجات بنفسجية وليمونية ووردية مع فراشات بارزة، قطعة مرحة تضيف لمسة أنثوية ناعمة للإطلالات اليومية.',
                'description' => 'تصميم محاك بعناية يجمع الألوان المشرقة مع حواف متموجة وفراشات كروشيه بارزة، مناسب للرحلات والطلعات النهارية والتنسيقات الصيفية.',
                'features' => ['خيوط كروشيه متماسكة بملمس مريح.', 'زخارف فراشات بارزة بدرجات وردية وبيضاء وصفراء.', 'حافة واسعة متموجة تمنح تغطية أنيقة.', 'قطعة خفيفة وسهلة التنسيق مع الإطلالات الناعمة.'],
                'image' => 'tyaniel/fashion/hat-purple-butterfly-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/hat-purple-butterfly-model.jpeg',
                'tags' => 'أزياء,قبعات كروشيه,قبعة,بنفسجي,فراشات,يدوي',
            ],
            [
                'title' => 'قبعة كروشيه كحلية بزهور ناعمة',
                'summary' => 'قبعة كروشيه كحلية بتفاصيل زهور وردية وبيضاء، تصميم راق يمنح الإطلالة لمسة هادئة وفاخرة.',
                'description' => 'لون كحلي عميق مع زهور كروشيه ناعمة على المقدمة، صممت لتناسب الإطلالات اليومية والفساتين الهادئة مع حضور أنيق غير مبالغ.',
                'features' => ['لون كحلي فاخر وسهل التنسيق.', 'ثلاث زهور كروشيه أمامية بتدرجات وردية وبيضاء.', 'حواف محاكة مرنة تضيف انسيابية للشكل.', 'مناسبة للهدايا والطلعات النهارية.'],
                'image' => 'tyaniel/fashion/hat-navy-floral-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/hat-navy-floral-model.jpeg',
                'tags' => 'أزياء,قبعات كروشيه,قبعة,كحلي,زهور,أناقة',
            ],
            [
                'title' => 'قبعة كروشيه وردية بفيونكة كبيرة',
                'summary' => 'قبعة كروشيه وردية بتفاصيل فيونكة كبيرة وحواف ملونة، قطعة أنثوية مبهجة تناسب الإطلالات المرحة والناعمة.',
                'description' => 'تصميم وردي لافت مزين بفيونكة أمامية وحواف كروشيه متعددة الألوان، يمنح الإطلالة شخصية لطيفة ومميزة.',
                'features' => ['لون وردي مشرق مع لمسات بنفسجية وليمونية.', 'فيونكة كروشيه كبيرة وبارزة.', 'حافة مزخرفة بتدرجات متعددة.', 'تصميم خفيف ومريح للاستخدام اليومي.'],
                'image' => 'tyaniel/fashion/hat-pink-bow-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/hat-pink-bow-model.jpeg',
                'tags' => 'أزياء,قبعات كروشيه,قبعة,وردي,فيونكة,ناعم',
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
            . '<p>يشحن المنتج داخل المملكة العربية السعودية وفق سياسة الشحن المعتمدة في متجر تيانيل. للحفاظ على جمال القطعة، تحفظ في مكان جاف وتنظف بلطف بقطعة قماش ناعمة بعيداً عن الرطوبة والعطور المباشرة.</p>';
    }

    private function attachGalleryImage(Service $service, string $image): void
    {
        $fileName = basename($image);

        $exists = $service->media()
            ->where('collection_name', 'multi_service_images')
            ->where('file_name', $fileName)
            ->exists();

        if ($exists) {
            return;
        }

        $path = storage_path('app/public/' . $image);

        if (! is_file($path)) {
            return;
        }

        $service
            ->addMedia($path)
            ->preservingOriginal()
            ->toMediaCollection('multi_service_images');
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
