<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\User;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
  public $table = "posts";
   protected $guarded = [];
  protected $casts = [
      'publish_at' => 'datetime',
  ];

  public function user(){
    return $this->belongsTo(User::class);
  }

  public function tags(){
    return $this->belongsToMany(Tag::class);
  }
  public function tag_name(){
    return $this->belongsTo(Tag::class,'tags');
  }

  public function pictures(){
    return $this->belongsToMany(Picture::class);
  }

}
