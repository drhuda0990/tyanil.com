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
    /*
      return $this->view('emails.'.$this->request->e_page)
                  //->from($this->request->e_from)
                  //->from(' HPCC ')
                  ->from(Config('setting.MAIN_EMAIL_ADMIN'))
                  ->subject('HPCC | '.$this->request->e_title);
      */



    if (!empty($this->request['bcc'])) {
      $this->bcc($this->request['bcc']);
    }

    return $this->markdown('emails.main')
      //->from('store@example.test')
      ->subject(env("APP_NAME") . '|' . $this->request['title'])
      ->with('request', $this->request);


    //
  }
}
