<?php

namespace App\Services;

use Spatie\SlackAlerts\Facades\SlackAlert;

class SendSlackNotificationService
{
    public function handle(string $message, string $location): void
    {
        SlackAlert::message($location . '. ' . $message);
    }
}
