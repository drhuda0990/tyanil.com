<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class cvTemplate extends Model
{
    use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
    protected $fillable = [
        'profile_content',
        'customer_id',
        'title',
        'name',
        'job',
        'contact',
        'location',
        'language',
    ];

    public function sections()
    {
        return $this->hasMany(cvSectionTemplate::class, 'cv_template_id');
    }
}
