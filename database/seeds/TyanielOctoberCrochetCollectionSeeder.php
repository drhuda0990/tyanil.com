<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TyanielOctoberCrochetCollectionSeeder extends Seeder
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
                'title' => 'فستان بنات كروشيه مرجاني بالزهور',
                'summary' => 'فستان كروشيه يدوي للبنات باللون المرجاني مع تفاصيل بيضاء، مزين بزهور بارزة ورباط خصر رقيق.',
                'description' => 'فستان كروشيه يدوي للبنات بلون مرجاني مبهج، مزين بصف من الزهور البارزة وتفاصيل بيضاء ناعمة عند الياقة والحافة.',
                'features' => [
                    'حياكة كروشيه يدوية متقنة بملمس ناعم.',
                    'لون مرجاني مع تفاصيل وحواف بيضاء.',
                    'زهور بارزة وأوراق خضراء تزين الصدر.',
                    'رباط خصر وأزرار خلفية لسهولة الارتداء.',
                    'مناسب للمناسبات والزيارات والتصوير.',
                ],
                'slug' => 'girls-coral-white-floral-crochet-dress',
                'main_image' => 'tyaniel/fashion/girls-coral-white-floral-crochet-dress-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-coral-white-floral-crochet-dress-details.jpeg',
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,مرجاني,أبيض,زهور,يدوي',
                'care' => 'يرجى تأكيد المقاس المناسب عند الطلب. يغسل الفستان يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة.',
            ],
            [
                'title' => 'فستان بنات كروشيه بألوان الباستيل والزهور',
                'summary' => 'فستان كروشيه يدوي للبنات بألوان وردية وبنفسجية وصفراء وعاجية، مزين بزهور بارزة وتصميم واسع أنيق.',
                'description' => 'فستان كروشيه يدوي للبنات يجمع ألوان الباستيل في طبقات متموجة متناغمة، مع زهور بارزة عند الخصر وتفاصيل ناعمة حول الياقة.',
                'features' => [
                    'حياكة كروشيه يدوية بجودة عالية.',
                    'درجات باستيل وردية وبنفسجية وصفراء وعاجية.',
                    'زهور بارزة ملونة عند الخصر.',
                    'قصة واسعة بطبقات وحواف متموجة.',
                    'مناسب للمناسبات والهدايا والتصوير.',
                ],
                'slug' => 'girls-pastel-rainbow-floral-crochet-dress',
                'main_image' => 'tyaniel/fashion/girls-pastel-rainbow-floral-crochet-dress-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-pastel-rainbow-floral-crochet-dress-details.jpeg',
                'tags' => 'أزياء,فساتين أطفال,فستان كروشيه,بنات,باستيل,وردي,بنفسجي,زهور,يدوي',
                'care' => 'يرجى تأكيد المقاس المناسب عند الطلب. يغسل الفستان يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة.',
            ],
            [
                'title' => 'طقم فستان وقبعة كروشيه وردي للبنات',
                'summary' => 'طقم كروشيه يدوي للبنات مكون من فستان وردي وقبعة متناسقة، مزين بزهور بارزة وتفاصيل بيضاء ناعمة.',
                'description' => 'طقم كروشيه يدوي متناسق للبنات يجمع فستاناً وردياً بقصة واسعة وقبعة أنيقة، وتزين القطعتين زهور بارزة وتفاصيل بيضاء رقيقة.',
                'features' => [
                    'طقم مكون من فستان وقبعة كروشيه متناسقين.',
                    'لون وردي ناعم مع تفاصيل وحواف بيضاء.',
                    'زهور بارزة وأوراق خضراء بتوزيع أنيق.',
                    'قصة مريحة ومناسبة للمناسبات والتصوير.',
                    'صناعة يدوية بتفاصيل دقيقة.',
                ],
                'slug' => 'girls-pink-white-floral-crochet-dress-hat-set',
                'main_image' => 'tyaniel/fashion/girls-pink-white-floral-crochet-dress-hat-set-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/girls-pink-white-floral-crochet-dress-hat-set-details.jpeg',
                'tags' => 'أزياء,فساتين أطفال,طقم أطفال,فستان كروشيه,قبعة كروشيه,بنات,وردي,أبيض,زهور,يدوي',
                'care' => 'يرجى تأكيد المقاس المناسب عند الطلب. يغسل الطقم يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة.',
            ],
            [
                'title' => 'شال كروشيه أحمر مزين بالورود',
                'summary' => 'شال نسائي مثلث باللون الأحمر، مزين بورود كروشيه بارزة وشراشيب ناعمة لإطلالة دافئة ولافتة.',
                'description' => 'شال كروشيه نسائي باللون الأحمر الغني، يجمع الحياكة المفرغة مع ورود بارزة موزعة بعناية وحواف محاطة بشراشيب ناعمة.',
                'features' => [
                    'حياكة كروشيه يدوية متقنة.',
                    'تصميم مثلث مرن وسهل التنسيق.',
                    'ورود بارزة موزعة على كامل الشال.',
                    'شراشيب ناعمة تحيط بالحواف.',
                    'مناسب للإطلالات اليومية والمناسبات.',
                ],
                'slug' => 'red-crochet-floral-shawl',
                'main_image' => 'tyaniel/fashion/red-crochet-floral-shawl-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/red-crochet-floral-shawl-model.jpeg',
                'tags' => 'أزياء,شال نسائي,شال كروشيه,أحمر,ورود,شراشيب,يدوي',
                'care' => 'يغسل الشال يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة للحفاظ على الحياكة والشراشيب.',
            ],
            [
                'title' => 'شال كروشيه عاجي بنقشة هندسية',
                'summary' => 'شال نسائي كروشيه باللون العاجي، بنقشة هندسية مفرغة وحواف مزينة بشراشيب ناعمة.',
                'description' => 'شال كروشيه نسائي مثلث بلون عاجي هادئ، يتميز بوحدات هندسية مفرغة متناسقة وشراشيب ناعمة تمنحه إطلالة راقية وسهلة التنسيق.',
                'features' => [
                    'حياكة كروشيه يدوية بتفاصيل دقيقة.',
                    'نقشة هندسية مفرغة ومتناسقة.',
                    'لون عاجي محايد يناسب مختلف الإطلالات.',
                    'شراشيب ناعمة موزعة حول الحواف.',
                    'مناسب للعبايات والفساتين والهدايا.',
                ],
                'slug' => 'ivory-diamond-lace-crochet-shawl',
                'main_image' => 'tyaniel/fashion/ivory-diamond-lace-crochet-shawl-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/ivory-diamond-lace-crochet-shawl-details.jpeg',
                'tags' => 'أزياء,شال نسائي,شال كروشيه,عاجي,نقشة هندسية,شراشيب,يدوي',
                'care' => 'يغسل الشال يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة للحفاظ على الحياكة والشراشيب.',
            ],
            [
                'title' => 'شال كروشيه عاجي بزخارف بارزة',
                'summary' => 'شال نسائي كروشيه باللون العاجي، مزين بوحدات بارزة ونقشة مفرغة مع شراشيب ناعمة.',
                'description' => 'شال كروشيه نسائي مثلث بلون عاجي أنيق، تتوزع عليه زخارف بارزة فوق حياكة مفرغة دقيقة، وتكتمل تفاصيله بشراشيب ناعمة.',
                'features' => [
                    'حياكة كروشيه يدوية بجودة عالية.',
                    'زخارف بارزة موزعة بنمط متناسق.',
                    'قاعدة مفرغة خفيفة وأنيقة.',
                    'شراشيب ناعمة تحيط بالحواف.',
                    'لون عاجي سهل التنسيق ومناسب للهدايا.',
                ],
                'slug' => 'ivory-raised-motif-crochet-shawl',
                'main_image' => 'tyaniel/fashion/ivory-raised-motif-crochet-shawl-product.jpeg',
                'gallery_image' => 'tyaniel/fashion/ivory-raised-motif-crochet-shawl-details.jpeg',
                'tags' => 'أزياء,شال نسائي,شال كروشيه,عاجي,زخارف بارزة,شراشيب,يدوي',
                'care' => 'يغسل الشال يدوياً بماء بارد ومنظف لطيف، ويجفف بشكل مسطح بعيداً عن الحرارة المباشرة للحفاظ على الحياكة والشراشيب.',
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
            . '<h4>المقاس والعناية</h4>'
            . '<p>' . e($product['care']) . '</p>';
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
