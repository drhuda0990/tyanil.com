<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class ActionEvent extends Model
{ use LogsActivity;
    protected $table = 'action_events';
    protected $guarded = [];
    public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults()->logAll();
  }
}
