<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Customer extends Authenticatable implements MustVerifyEmailContract
{

  use HasFactory, LogsActivity, MustVerifyEmail, Notifiable;
  public $table = "customers";
  protected $guard = 'customer';
  protected $fillable = [
    'name',
    'email',
    'phone',  // Add the phone field here
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logAll();
  }

  public function sendEmailVerificationNotification()
  {
    if (empty($this->email)) {
      return;
    }

    $this->notify(new \App\Notifications\CustomerVerifyEmail());
  }
  public function serviceInvoices()
  {
    return $this->hasMany(ServiceInvoice::class);
  }
  public function services()
  {
    return $this->hasMany(ServiceInvoiceItem::class)->where('activate', 1);
  }
  public function cvs()
  {
    return $this->hasMany(cvTemplate::class);
  }
  public function customerAddresses()
  {
    return $this->hasMany(CustomerAddress::class);
  }
  public function ratings()
  {
    return $this->hasMany(Rating::class);
  }
  public function carts()
  {
    return $this->hasMany(Cart::class)->whereHas('service', function ($q) {
      $q->where('activate', 1);
    });
  }
  public function allAddress()
  {
    return $this->hasMany(CustomerAddress::class, 'customer_id');
  }
  public function virtual_classrooms()
  {
    return $this->hasMany(JitsiMeeting::class, 'customer_id');
  }
}
