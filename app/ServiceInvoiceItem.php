<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ServiceInvoiceItem extends Model
{
  use HasFactory, LogsActivity;
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logAll();
  }
  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }
  public function service()
  {
    return $this->belongsTo(Service::class, 'service_id');
  }

  public function serviceInvoice()
  {
    return $this->belongsTo(ServiceInvoice::class, 'service_invoice_id');
  }
  public function serInvoiceItemsFeatures()
  {
    return $this->hasMany(SerInvoiceItemsFeature::class, 'service_invoice_item_id');
  }
}