<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Contact extends Model implements HasMedia
{

  use HasFactory, LogsActivity, InteractsWithMedia;
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logAll();
  }
  protected $guarded = [];
  public function typeName()
  {
    return $this->belongsTo(Definition::class, 'type')->where('type_id', '=', 5);
  }
  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('contact_image')
      ->acceptsFile(function ($file) {
        return in_array($file->mimeType, ['image/jpeg', 'image/png']);
      });
    $this->addMediaCollection('main')->singleFile();
  }
}
