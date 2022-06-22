<?php

namespace App\Listeners\Cricket;

use App\Events\Cricket\CricketUnitStatsSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketUnitStatsSavedListener
{
    public function handle(CricketUnitStatsSavedEvent $cricketUnitStatsSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Unit Stats ID: {$cricketUnitStatsSavedEvent->cricketUnitStats->id}, Info added!</info>");
    }
}
