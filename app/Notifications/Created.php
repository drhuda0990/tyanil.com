<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Created extends Notification
{
    use Queueable;

    private $user;
private $title;
private $content;
private $routeMame;
private $rid;
    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct($title,$content,$routeMame=null,$rid=null)
    {
        // $this->user = $user;
        $this->title = $title;
        $this->content = $content;
        $this->routeMame = $routeMame;
        $this->rid = $rid;
         
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
         return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return \Mirovit\NovaNotifications\Notification::make()
            ->info($this->title)
            ->subtitle($this->content)
            // ->routeDetail($this->routeMame, $this->rid)
             ->icon('fas fa-info')
            ->toArray();

    }
}
