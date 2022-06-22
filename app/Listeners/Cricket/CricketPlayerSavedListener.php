<?php

namespace App\Listeners\Cricket;

use App\Events\Cricket\CricketPlayerSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketPlayerSavedListener
{
    public function handle(CricketPlayerSavedEvent $cricketPlayerSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Player: {$cricketPlayerSavedEvent->cricketPlayer->first_name}, Info added!</info>");
    }
}
