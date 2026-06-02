<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\CourseTrainee;
use App\General;
use App\TamaraNotifications;
use App\Cart;
use App\Services\PaymentService;
use App\Definition;
use App\PaymentRequest;
use App\PaymentResponse;
use App\TabbyResponse;
use Auth;
use Carbon\Carbon;

class CheckPayments implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $payments = PaymentRequest::where('created_at', '>=', now()->subMinutes(30))
      ->where(function ($q) {
        $q->whereNull('check_num')
          ->orWhere('check_num', '<>', 2);
      })->get();
    // dd($payments);
    if ($payments) {
      foreach ($payments as $payment) {
        $existResponse = PaymentResponse::where([['payment_id', $payment->order_id], ['payment_type', $payment->payment_type]])->first();
        // dd($existResponse, $payment, $paymentRequest);
        if (!$existResponse) {
          $trainee = $payment->trainee;
          $service = new PaymentService();
          $payment->check_num = ($payment->check_num == null) ? 1 : ($payment->check_num + 1);
          $payment->save();
          if ($payment->payment_type == 'tap') {
            $service->handleTapCheck($payment->payment_id, $trainee);
          }
        
        }
      }
    }
  }
}