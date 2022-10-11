<?php

namespace Litermi\SimpleNotification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Litermi\SimpleNotification\Services\GetIconByLevelNotificationService;

/**
 *
 */
class SimpleEmailNotification extends Notification
{

    use Queueable;

    private $data;

    private $via;

    private $subject;

    public function __construct($via, $subject, private $level, $data)
    {
        $this->subject = $subject;
        $this->data = $data;
        $this->via = $via;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ($this->via) ? $this->via : ['mail', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $data = $this->data['endpoint'];
        $environment  = array_key_exists('environment', $data) ? $data[ 'environment' ] : env('APP_ENV');
        $subject = "/ Notification in: ".env('APP_NAME')." ";
        $subject = "ENV:$environment ".GetIconByLevelNotificationService::execute($this->level)." "
            .$this->subject ." " .$subject;

        $view = config('simple-notification.view-simple-email');

        return (new MailMessage())
            ->subject($subject)
            ->markdown($view, $this->data);
    }

}

