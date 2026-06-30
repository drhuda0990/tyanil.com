<?php

namespace App\Mail;

use App\Support\EmailCompliance;
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
    $this->request['title'] = EmailCompliance::cleanSubject($this->request['title'] ?? null);
    $this->request['body'] = $this->request['body'] ?? '';
    $this->request['plain_body'] = $this->request['plain_body'] ?? EmailCompliance::plainText($this->request['body']);

    if (!empty($this->request['bcc'])) {
      $this->bcc($this->request['bcc']);
    }

    $mail = $this->view('emails.main')
      ->text('emails.main-text')
      ->from(config('mail.from.address'), config('mail.from.name'))
      ->replyTo(config('mail.from.address'), config('mail.from.name'))
      ->subject(config('app.name', 'تيانيل') . ' | ' . $this->request['title'])
      ->with('request', $this->request);

    $mail->withSymfonyMessage(function ($message) {
      $headers = $message->getHeaders();
      $headers->addTextHeader('Auto-Submitted', 'auto-generated');
      $headers->addTextHeader('X-Auto-Response-Suppress', 'All');
      $headers->addTextHeader('X-Entity-Ref-ID', sha1(config('app.url') . '|' . ($this->request['title'] ?? '') . '|' . microtime(true)));

      if (($this->request['mail_category'] ?? null) === 'marketing' && !empty($this->request['unsubscribe_url'])) {
        $headers->addTextHeader('List-ID', EmailCompliance::listId());
        $headers->addTextHeader('List-Unsubscribe', '<' . $this->request['unsubscribe_url'] . '>, <mailto:' . config('mail.from.address') . '?subject=unsubscribe>');
        $headers->addTextHeader('List-Unsubscribe-Post', 'List-Unsubscribe=One-Click');
        $headers->addTextHeader('Precedence', 'bulk');
      }
    });

    return $mail;
  }
}
