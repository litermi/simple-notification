<?php

namespace Litermi\SimpleNotification\Services;

/**
 *
 */
class SendSimpleNotificationService
{

    /**
     * @var
     */
    public $notification_email = false;

    /**
     * @var
     */
    public $notification_slack = false;

    /**
     * @var null
     */
    public $channel_slack = null;

    /**
     * @var null
     */
    public $to_email = null;

    public function __construct()
    {
    }

    /**
     * @return $this
     */
    public function email(): self
    {
        $this->notification_email = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function toEmail($email): self
    {
        $this->to_email = $email;
        return $this;
    }

    /**
     * @return $this
     */
    public function slack(): self
    {
        $this->notification_slack = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function channelSlack($channelSlack): self
    {
        $this->channel_slack = $channelSlack;
        return $this;
    }

    /**
     * @param $message
     * @return void
     */
    public function notification($subject, $message, $extraValues = []): void
    {
        if ($this->notification_email === true) {
            SendEmailNotificationService::execute($this->to_email, $subject, $message, $extraValues);
        }
        if ($this->notification_slack === true) {
            SendSlackNotificationService::execute($message, $this->channel_slack, $extraValues);
        }
    }
}
