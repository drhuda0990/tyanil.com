<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Support\StoreSettings;

class Service extends Model implements HasMedia
{
  use HasFactory, LogsActivity, InteractsWithMedia;


  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logAll();
  }
  protected $casts = [
    'times_from_date' => 'datetime',
    'times_to_date' => 'datetime',
  ];

  public function getSeoRouteKeyAttribute()
  {
    return $this->slug ?: $this->id;
  }

  public static function servicePrice($id)
  {
    $service = Service::find($id);
    $price = $service->price_1;
    if ($service->price_2 != null) {
      $price = $service->price_2;
    }
    return (float)$price;
  }
  public function customers()
  {
    return $this->hasMany(ServiceInvoice::class);
  }
  public function registerMediaConversions(?Media $media = null): void
  {
    $this->addMediaConversion('thumb')
      ->width(130)
      ->height(130);
  }

  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('largeFileUploads'); // or 'multi_attachment_file' if you named it like that
    $this->addMediaCollection('multi_attachment_file')
      //   ->useDisk('google2') // This sends the files to your Google Drive
      ->acceptsFile(function ($file) {
        return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/webp', 'application/pdf', 'video/mp4']);
      });
    // $this->addMediaCollection('main')->singleFile()->useDisk('google2');
    // $this->addMediaCollection('my_multi_collection')->useDisk('google2');
    $this->addMediaCollection('main')->singleFile();
    $this->addMediaCollection('my_multi_collection');
  }
  public function serviceCategory()
  {
    return $this->belongsTo(ServiceCategory::class);
  }
  public function additionalFeatures()
  {
    return $this->hasMany(AdditionalFeatures::class, 'service_id');
  }
  public function activateAdditionalFeatures()
  {
    return $this->hasMany(AdditionalFeatures::class, 'service_id')->where('activate', 1);
  }
  public function serviceInvoiceItems()
  {
    return $this->hasMany(ServiceInvoiceItem::class, 'service_id');
  }

  public function CustomerServices()
  {
    return $this->belongsToMany(Customer::class, 'service_invoice_items', 'service_id', 'customer_id')->withPivot('attend_course', 'certificate_request', 'certificate', 'course_program_type', 'registration_type', 'english_program_status', 'activate', 'time', 'certificate_enable', 'manual_installment_activate', 'individual_installment_amount', 'course_installment_num', 'paid_installment_amount', 'english_program_status')->wherePivot('activate', 1);
  }
  public function getImageUrlAttribute()
  {
    $gSetting = StoreSettings::get();
    // Check if the image field is empty or null
    if (empty($this->attributes['image'])) {
      return Storage::url($gSetting->default_service_image); // Path to your default image
    }

    // Otherwise, return the path to the uploaded image
    return Storage::url($this->attributes['image']);
  }
  public function meetings()
  {
    return $this->hasMany(JitsiMeeting::class, 'service_id');
  }
  public function ratings()
  {
    return $this->hasMany(Rating::class, 'service_id');
  }
  public function averageRating()
  {
    return $this->ratings()->avg('stars');
  }
  public function customerHasPurchased($customer_id)
  {
    return ServiceInvoiceItem::whereHas('serviceInvoice', function ($q) use ($customer_id) {
      $q->where('customer_id', $customer_id);
    })->where('service_id', $this->id)->exists();
  }
  public function customerHasRated($customer_id)
{
    return $this->ratings()
        ->where('customer_id', $customer_id)
        ->exists();
}

}
