<?php

namespace App\Listeners;

use App\Events\CricketGameStatsSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketGameStatsSavedListener
{
    public function handle(CricketGameStatsSavedEvent $cricketGameStatsSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Game Stat: {$cricketGameStatsSavedEvent->cricketGameStats->gameSchedule->game_date}, Info added!</info>");
    }
}
