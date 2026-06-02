<?php

namespace App\Nova;

use App\Nova\Rating;
use Laravel\Nova\Fields\Image;
use Illuminate\Http\Request;
use Outl1ne\MultiselectField\Multiselect;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;

class Service extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Service::class;
    public static $group = 'المنتجات والمتجر';
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static function label()
    {
        return ('المنتجات');
    }

    public static function singularLabel()
    {
        return ('منتج');
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'serviceCategory.title'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('العنوان', 'title')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('رابط SEO', 'slug')
                ->nullable()
                ->hideFromIndex()
                ->help('يتم توليده تلقائياً من اسم المنتج ويمكن تعديله عند الحاجة.')
                ->rules('nullable', 'max:191'),
            Text::make('عنوان SEO', 'meta_title')
                ->nullable()
                ->hideFromIndex()
                ->help('يتم توليده تلقائياً مع اسم المتجر.')
                ->rules('nullable', 'max:191'),
            Textarea::make('وصف SEO', 'meta_description')
                ->nullable()
                ->hideFromIndex()
                ->help('يفضل أن يكون بين 150 و160 حرفاً. يتم توليده تلقائياً من وصف المنتج.')
                ->rules('nullable', 'max:170'),
            Image::make('الصورة', 'image')
                ->disk('public')
                ->rules('nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'),
            Files::make('الصور المتعددة', 'multi_service_images')->nullable(),
            Files::make('الملفات المتعددة التي يتم تزويد العميل بها عند شراء الخدمة', 'multi_attachment_file')
                ->rules('nullable') // فقط هنا لحقل المجموعة نفسه
                ->hideFromIndex(),
            Files::make('الملفات الكبيره', 'largeFileUploads')
                ->help(' يتم رفعها عن طريق صفحة منفصله من خلال الضغط على ايقونة ... بجانب اسم الخدمة ويتم تزويد العميل بها عند شراء الخدمة')
                ->rules('nullable') // فقط هنا لحقل المجموعة نفسه
                ->hideWhenCreating()
                ->hideFromIndex(),
            // File::make('المرفق', 'attachment')->help('الملف الذي يتم تزويد العميل فيه عند شراء هذه الخدمة')->disk('books'),
            Trix::make('النبذة', 'summry')
                ->hideFromIndex(),
            Trix::make('التفاصيل', 'body')
                ->hideFromIndex(),
            Text::make('السعر ', 'price_1')
                ->rules('required'),
            // Text::make('السعر بعد', 'price_2'),
            Select::make('التقسيمة التابعه لها', 'service_category_id')
                ->options(\App\ServiceCategory::where('activate', 1)
                    ->orderBy('order_num')
                    ->pluck('title', 'id'))
                ->searchable()
                ->displayUsingLabels(),
            Select::make('رسالة نصية ترسل بعد شراء الخدمة', 'purchase_message')
                ->options(\App\Definition::where('type_id', '=', 1)
                    ->pluck('name', 'id'))
                ->searchable()
                ->nullable()
                ->displayUsingLabels()
                ->hideFromIndex(),
            Select::make('رسالة إيميل ترسل بعد شراء الخدمة', 'purchase_email')
                ->options(\App\Definition::where('type_id', '=', 1)
                    ->pluck('name', 'id'))
                ->searchable()
                ->nullable()
                ->displayUsingLabels()
                ->hideFromIndex(),
            Multiselect::make('المشرفين', 'service_admins')
                ->options($this->getServiceAdmins())
                ->hideFromIndex(),
            Boolean::make('خدمة تحتاج لشحن', 'required_shipment'),
            Boolean::make('تفعيل خيار يبداء السعر من', 'price_start_from'),
            Boolean::make('غير متاح التسجيل حالياً', 'not_available'),
            Boolean::make('تفعيل', 'activate'),
            Heading::make('حقول خاصة بالخدمة التسويقيه'),
            Boolean::make('الخدمة تسويق خارجية', 'advertizment_service'),
            Text::make('الرابط الذي يتم توجية العميل له عند الضغط على هذة الخدمة ', 'redirect_url')
                ->hideFromIndex(),
            HasMany::make('المميزات الإضافية للخدمة', 'additionalFeatures', AdditionalFeatures::class),
            HasMany::make('طلبات الخدمة', 'serviceInvoiceItems', ServiceInvoiceItem::class),
            HasMany::make('التقييمات', 'ratings', Rating::class),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }
    public static function rules(Request $request)
    {
        return [
            'multi_service_images.*' => 'file|mimetypes:image/jpeg,image/png,image/webp|max:4096',
            'multi_attachment_file.*' => 'file|mimetypes:image/jpeg,image/png,image/webp,application/pdf,video/mp4|max:51200',
            'largeFileUploads.*' => 'file|mimetypes:image/jpeg,image/png,image/webp,application/pdf,video/mp4|max:512000',
        ];
    }
    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new Actions\LargeFileUpload($request))
                ->onlyOnTableRow()
                ->confirmText('هل أنت متأكد من الانتقال إلى الصفحة المحددة')
                ->confirmButtonText('انتقال')
                ->cancelButtonText("إلغاء الأمر"),
        ];
    }
    public function getServiceAdmins()
    {
        $items =  \App\ServiceAdmind::where('activate', 1)->get();
        $data = null;
        foreach ($items as $item) {
            $data[$item->id] = $item->name;
        }

        return $data;
    }
}
