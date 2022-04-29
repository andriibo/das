<?php

namespace App\Listeners;

use App\Events\CricketUnitSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketUnitSavedListener
{
    public function handle(CricketUnitSavedEvent $cricketUnitSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Unit Id: {$cricketUnitSavedEvent->cricketUnit->id}, Info added!</info>");
    }
}
