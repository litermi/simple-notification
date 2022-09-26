<?php

namespace Litermi\SimpleNotification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

/**
 *
 */
class SimpleSlackNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     *
     * @param array $data
     */
    public function __construct(private $subject, $data = [])
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
        $subject = "ENV:$environment 💡 / Notification in: ".env('APP_NAME')." ";
        $subject = $this->subject." ".$subject;
        return (new SlackMessage)
            ->success()
            ->content($subject)
            ->attachment(function ($attachment) use ($message, $data) {
                $attachment->title($message, $data)->fields($data);
            });
    }
}
