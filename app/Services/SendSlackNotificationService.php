<?php

namespace App\Services;

use Spatie\SlackAlerts\Facades\SlackAlert;

class SendSlackNotificationService
{
    public function handle(string $message, string $location): void
    {
        $notification = $this->getServiceName() . ': ' . $location . '. ' . $message;
        SlackAlert::message($notification);
    }

    private function getServiceName(): string
    {
        return config('app.name');
    }
}
