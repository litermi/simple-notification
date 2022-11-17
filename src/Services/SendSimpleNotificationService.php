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
    private $notification_email = false;

    /**
     * @var
     */
    private $notification_slack = false;

    /**
     * @var null
     */
    private $channel_slack = null;

    /**
     * @var null
     */
    private $to_email = null;

    /**
     * @var null
     */
    private $level = null;

    public function __construct()
    {
    }

    /**
     * @return $this
     */
    public function email(): self
    {
        $this->level = null;
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
    public function warning(): self
    {
        $this->level = 1;
        return $this;
    }

    /**
     * @return $this
     */
    public function error(): self
    {
        $this->level = 2;
        return $this;
    }

    /**
     * @return $this
     */
    public function slack(): self
    {
        $this->channel_slack = null;
        $this->notification_slack = true;
        $this->level = null;
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
     * @param $subject
     * @param string $message
     * @param array $extraValues
     * @return void
     */
    public function notification($subject, string $message = '', $extraValues = []): void
    {
        if ($this->notification_slack === true) {
            SendSlackNotificationService::execute(
                $this->channel_slack,
                $subject,
                $this->level,
                $message,
                $extraValues
            );
        }
        if ($this->notification_email === true) {
            SendEmailNotificationService::execute(
                $this->to_email,
                $subject,
                $this->level,
                $message,
                $extraValues
            );
        }
    }
}
