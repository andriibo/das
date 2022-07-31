<?php

namespace App\Listeners\Cricket;

use App\Events\Cricket\CricketTeamSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketTeamSavedListener
{
    public function handle(CricketTeamSavedEvent $cricketTeamSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Team: {$cricketTeamSavedEvent->cricketTeam->name}, Info added!</info>");
    }
}
