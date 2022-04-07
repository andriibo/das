<?php

namespace App\Listeners;

use App\Events\CricketUnitStatsSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketUnitStatsSavedListener
{
    public function handle(CricketUnitStatsSavedEvent $cricketUnitStatsSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Unit Stat: {$cricketUnitStatsSavedEvent->cricketUnitStats->player->first_name}, Info added!</info>");
    }
}
