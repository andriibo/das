<?php

namespace App\Listeners;

use App\Events\CricketPlayerSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketPlayerSavedListener
{
    public function handle(CricketPlayerSavedEvent $cricketPlayerSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Player: {$cricketPlayerSavedEvent->cricketPlayer->first_name}, Info added!</info>");
    }
}
