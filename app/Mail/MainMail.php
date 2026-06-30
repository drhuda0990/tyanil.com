<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MainMail extends Mailable
{
  use Queueable, SerializesModels;
  public $request;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->request = $data;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    if (!empty($this->request['bcc'])) {
      $this->bcc($this->request['bcc']);
    }

    return $this->view('emails.main')
      ->from(config('mail.from.address'), config('mail.from.name'))
      ->subject(config('app.name', 'تيانيل') . ' | ' . $this->request['title'])
      ->with('request', $this->request);


    //
  }
}
