<?php

namespace App\Listeners;

use App\Events\CricketUnitStatSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketUnitStatSavedListener
{
    public function handle(CricketUnitStatSavedEvent $cricketUnitStatSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Unit Stat: {$cricketUnitStatSavedEvent->cricketUnitStat->player->first_name}, Info added!</info>");
    }
}
