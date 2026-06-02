<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Mailing_list extends Model
{
  use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
    public $table = "mailing_lists";
    //protected $fillable = ['name','email','mobile']; 

    public function mailing(){
      return $this->belongsTo(Mailing::class );
    }

}
