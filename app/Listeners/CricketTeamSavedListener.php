<?php

namespace App\Listeners;

use App\Events\CricketTeamSavedEvent;
use Symfony\Component\Console\Output\ConsoleOutput;

class CricketTeamSavedListener
{
    public function handle(CricketTeamSavedEvent $cricketTeamSavedEvent)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln("<info>Team: {$cricketTeamSavedEvent->cricketTeam->name}, Info added!</info>");
    }
}
