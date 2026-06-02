<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class JitsiMeeting extends Model
{
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
      }
      public function service(){
        return $this->belongsTo(Service::class,'service_id');
      }
      public function serviceInvoiceItem(){
        return $this->belongsTo(ServiceInvoiceItem::class,'service_invoice_items_id');
      }

}
