<?php

namespace Litermi\SimpleNotification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Litermi\SimpleNotification\Services\GetIconByLevelNotificationService;

/**
 *
 */
class SimpleSlackNotification extends Notification
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     *
     * @param array $data
     */
    public function __construct(private $subject, private $level, $data = [])
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $data         = $this->data;
        $message      = '';
        $environment  = array_key_exists('environment', $data) ? $data[ 'environment' ] : env('APP_ENV');
        $subject = "/ Notification in: ".env('APP_NAME')." ";
        $subject = "ENV:$environment ".GetIconByLevelNotificationService::execute($this->level)." "
            .$this->subject ." " .$subject;
        return (new SlackMessage)
            ->success()
            ->content($subject)
            ->attachment(function ($attachment) use ($message, $data) {
                $attachment->title($message, $data)->fields($data);
            });
    }
}
