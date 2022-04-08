<?php

namespace App\Listeners;

use App\Events\CricketGameLogSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketGameLogSavedListener
{
    public function handle(CricketGameLogSavedEvent $cricketGameLogSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Game Log: {$cricketGameLogSavedEvent->cricketGameLog->actionPoint->title}, Info added!</info>");
    }
}
