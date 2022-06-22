<?php

namespace App\Listeners\Cricket;

use App\Events\Cricket\CricketGameStatsSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketGameStatsSavedListener
{
    public function handle(CricketGameStatsSavedEvent $cricketGameStatsSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $gameSchedule = $cricketGameStatsSavedEvent->cricketGameStats->gameSchedule;
        $consoleOutput->writeln("<info>Game Stats ID: {$gameSchedule->id}, Info added!</info>");
    }
}
