<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
  use LogsActivity;
  public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults()->logAll();
  }

  public function page_policy(){
    return $this->belongsTo(Post::class);
  }
  public function page_bank_accounts(){
    return $this->belongsTo(Post::class);
  }
}
