<?php

namespace App\Services;

use Spatie\SlackAlerts\Facades\SlackAlert;

class SendSlackNotificationService
{
    public function handle(string $message, string $method, array $params): void
    {
        $located = 'Called at ' . $method . ' with params - ' . http_build_query($params, '', ', ');
        SlackAlert::message($located . '. ' . $message);
    }
}
