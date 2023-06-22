<?php

namespace App\Service;

use App\Models\Competition;
use App\Models\Fixture;
use App\Models\PointTable;

class MatchService
{
    private const POINT_WIN = 3;
    private const POINT_LOSE = 0;
    private const POINT_DRAW = 1;

    public function getPointTable($fixtures, $teams): array
    {
        $pointTables = [];

        foreach ($teams as $team) {

            $pointTable = new PointTable();
            $pointTable->setTeam($team);

            $playedMatch = 0;
            $totalPoint = 0;
            $totalWin = 0;
            $totalLose = 0;
            $totalDraw = 0;
            $totalGoalFor = 0;
            $totalGoalAgainst = 0;

            /** @var Fixture $fixture */
            foreach ($fixtures as $fixture) {

                /** @var Competition $match */
                foreach ($fixture->getMatches() as $match) {

                    $matchPoint = self::POINT_LOSE;

                    if ($match->isPlayed()) {

                        $playedMatch++;

                        if ($match->getAwayTeam()->getId() === $pointTable->getTeam()->getId()) {

                            if ($match->getAwayTeamGoal() > $match->getHomeTeamGoal()) {
                                $matchPoint = self::POINT_WIN;
                                $totalWin++;
                            } elseif ($match->getAwayTeamGoal() < $match->getHomeTeamGoal()) {
                                $totalLose++;
                            } else {
                                $matchPoint = self::POINT_DRAW;
                                $totalDraw++;
                            }

                            $totalGoalFor = $totalGoalFor + $match->getAwayTeamGoal();
                            $totalGoalAgainst = $totalGoalAgainst + $match->getHomeTeamGoal();

                        } elseif ($match->getHomeTeamGoal() === $team) {

                            if ($match->getHomeTeamGoal() > $match->getAwayTeamGoal()) {
                                $matchPoint = self::POINT_WIN;
                                $totalWin++;
                            } elseif ($match->getHomeTeamGoal() < $match->getAwayTeamGoal()) {
                                $totalLose++;
                            } else {
                                $matchPoint = self::POINT_DRAW;
                                $totalDraw++;
                            }

                            $totalGoalFor = $totalGoalFor + $match->getHomeTeamGoal();
                            $totalGoalAgainst = $totalGoalAgainst + $match->getAwayTeamGoal();
                        }

                        $totalPoint += $matchPoint;
                    }

                }

            }

            $pointTable->setDraw($totalDraw);
            $pointTable->setWin($totalWin);
            $pointTable->setLose($totalLose);
            $pointTable->setGoalFor($totalGoalFor);
            $pointTable->setGoalAgainst($totalGoalAgainst);
            $pointTable->setPoint($totalPoint);

            $pointTables[] = $pointTable;
        }

        usort($pointTables, [$this, 'sortPoints']);

        return $pointTables;
    }

    private function sortPoints(PointTable $team1, PointTable $team2): int
    {
        if ($team1->getPoint() == $team2->getPoint()) {
            if ($team1->getGoalFor() - $team1->getGoalAgainst() >= $team2->getGoalFor() - $team2->getGoalAgainst()) {
                return -1;
            } else {
                return 1;
            }
        }

        return $team1->getPoint() > $team2->getPoint() ? -1 : 1;
    }

    public function getPredictions($pointTables, $fixtures, $teams): array
    {
        $predictions = [];

        $completedFixtureCount = 0;
        foreach ($fixtures as $fixture) {
            if ($fixture->isCompleted()) {
                $completedFixtureCount++;
            }
        }

        $totalMatch = count($fixtures);
        $teamPoints = $teamRankings = [];
        /** @var PointTable $pointTable */
        $ranking = 1;
        foreach ($pointTables as $pointTable) {
            $teamPoints[$pointTable->getTeam()->getId()] = $pointTable->getPoint();
            $teamRankings[$pointTable->getTeam()->getId()] = $ranking;
            $ranking++;
        }

        foreach ($teams as $team) {
            $predictions[$team->getId()] = [
                'teamName' => $team->getName(),
                'prediction' => 0,
                'teamPoint' => $teamPoints[$team->getId()],
                'teamRanking' => $teamRankings[$team->getId()],
                'remainingMatches' => $totalMatch - $completedFixtureCount,
            ];

            if ($predictions[$team->getId()]['remainingMatches'] <= 2) {
                if ($predictions[$team->getId()]['teamRanking'] == 1) {
                    $predictions[$team->getId()]['prediction'] = 100;
                }
                if (in_array($teamRankings[$team->getId()], [1, 2]) && $pointTables[0]->getPoint() == $pointTables[1]->getPoint()) {
                    $predictions[$team->getId()]['prediction'] = 50;
                }
            }

        }

        return $predictions;
    }

}
