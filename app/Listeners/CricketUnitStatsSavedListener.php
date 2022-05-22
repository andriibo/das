<?php

namespace App\Listeners;

use App\Events\CricketUnitStatsSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketUnitStatsSavedListener
{
    public function handle(CricketUnitStatsSavedEvent $cricketUnitStatsSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Unit Stats ID: {$cricketUnitStatsSavedEvent->cricketUnitStats->id}, Info added!</info>");
    }
}
