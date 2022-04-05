<?php

namespace App\Listeners;

use App\Events\CricketGameStatSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketGameStatSavedListener
{
    public function handle(CricketGameStatSavedEvent $cricketGameStatSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Game Stat: {$cricketGameStatSavedEvent->cricketGameStat->cricketGameSchedule->game_date}, Info added!</info>");
    }
}
