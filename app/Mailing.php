<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
  use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
    public $table = "mailings";
    public function Mailing_list(){
      return $this->HasMany(Mailing_list::class, 'mailing_id');
    }
}
