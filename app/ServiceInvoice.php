<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ServiceInvoice extends Model
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
  public function serviceItems()
  {
    return $this->hasMany(ServiceInvoiceItem::class, 'service_invoice_id');
  }

  public static function invoicePrice($id)
  {
    $total = 0;
    $shipment = 0;
    $invoice = ServiceInvoice::find($id);
    if ($invoice) {
      if ($invoice->shipment_price) {
        $total += $invoice->amount + $invoice->shipment_price;
      } else {
        $total = $invoice->amount;
      }
    }
    return ['total' => $total, 'shipment' => $shipment];
  }
  public function method_name(){
    return $this->belongsTo(Definition::class,'method')->where('type_id', '=', 4);
  }
  public function discount()
  {
    return $this->belongsTo(Discount::class, 'discount_id');
  }
}
