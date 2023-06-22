<?php

namespace App\Service;

use App\Models\Competition;
use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\Uuid;

class FixtureService
{
    private const KEY_FIXTURE = 'fixtures';
    private const KEY_TEAMS = 'teams';

    public function generateFixtures(&$teams): array
    {
        $fixtures = Cache::get(self::KEY_FIXTURE);
        if ($fixtures) {
            return $fixtures;
        }

        shuffle($teams);
        $reverseTeams = array_reverse($teams);

        $firstHalfFixture = $this->getHalfSeasonFixture($teams);
        $secondHalfFixture = $this->getHalfSeasonFixture($reverseTeams, true);

        $fixtures = array_merge($firstHalfFixture, $secondHalfFixture);

        Cache::put(self::KEY_FIXTURE, $fixtures);

        return $fixtures;
    }

    private function getHalfSeasonFixture(&$teams, $secondHalf = false): array
    {
        $fixtures = [];
        $teamCount = count($teams);

        $totalRounds = $teamCount - 1;
        $matchesPerRound = $teamCount / 2;

        for ($round = 1; $round <= $totalRounds; $round++) {

            $weekNumber = $round;
            if ($secondHalf) {
                $weekNumber = $round + $totalRounds;
            }

            $fixture = new Fixture();
            $fixture->setId($weekNumber);
            $fixture->setWeek(sprintf('Week %d', $weekNumber));

            $matches = [];

            for ($match = 0; $match < $matchesPerRound; $match++) {
                $team1 = $match;
                $team2 = $totalRounds - $match;

                /** @var Team $homeTeam */
                /** @var Team $awayTeam */

                if ($match % 2 == 0) {
                    $homeTeam = $teams[$team1];
                    $awayTeam = $teams[$team2];
                } else {
                    $homeTeam = $teams[$team2];
                    $awayTeam = $teams[$team1];
                }

                $competition = new Competition();
                $competition->setId((string)Uuid::uuid4());
                $competition->setHomeTeam($homeTeam);
                $competition->setAwayTeam($awayTeam);

                $matches[] = $competition;
            }

            $fixture->setMatches($matches);

            $fixtures[] = $fixture;

            $this->switchTeams($teams);
        }

        return $fixtures;
    }

    private function switchTeams(&$teams): void
    {
        $teamCount = count($teams);
        $firstItem = $teams[0];
        $lastItem = $teams[$teamCount - 1];
        unset($teams[0], $teams[$teamCount - 1]);

        $teams[] = $firstItem;
        $teams[] = $lastItem;
        $teams = array_values(array_filter($teams));
    }

    public function getTournamentTeams(): array
    {
        if (Cache::has(self::KEY_TEAMS)) {
            return Cache::get(self::KEY_TEAMS);
        }

        $teams = [
            $this->generateTeam('Liverpool', 65),
            $this->generateTeam('Manchester City', 80),
            $this->generateTeam('Chelsea', 55),
            $this->generateTeam('Arsenal', 70),
        ];

        Cache::put(self::KEY_TEAMS, $teams);

        return $teams;
    }

    private function generateTeam($name, $power): Team
    {
        $team = new Team();
        $team
            ->setId((string)Uuid::uuid4())
            ->setName($name)
            ->setPower($power);

        return $team;
    }

    public function getFixture($fixtureId): ?Fixture
    {
        $fixtures = Cache::get(self::KEY_FIXTURE);
        if ($fixtures) {
            foreach ($fixtures as $fixture) {
                if ($fixture->getId() == $fixtureId) {
                    return $fixture;
                }
            }
        }

        return null;
    }

    public function resetFixture($fixtures, $week = null): void
    {
        /** @var Fixture $fixture */
        foreach ($fixtures as $key => $fixture) {
            /** @var Competition $match */
            if ($week !== null && $week != $fixture->getId()) {
                continue;
            }
            $matches = $this->clearMatches($fixture->getMatches());

            $fixture->setMatches($matches);
            $fixture->setCompleted(false);
            $fixtures[$key] = $fixture;
        }

        Cache::delete(self::KEY_FIXTURE);
        Cache::put(self::KEY_FIXTURE, $fixtures);
    }

    public function simulateFixture($fixtures, $week = null): array
    {
        /** @var Fixture $fixture */
        foreach ($fixtures as $key => $fixture) {

            if ($fixture->isCompleted()) {
                continue;
            }

            /** @var Competition $match */
            if ($week !== null && $week != $fixture->getId()) {
                continue;
            }
            $matches = $this->simulateMatches($fixture->getMatches());

            $fixture->setMatches($matches);
            $fixture->setCompleted(true);
            $fixtures[$key] = $fixture;
        }

        Cache::delete(self::KEY_FIXTURE);
        Cache::put(self::KEY_FIXTURE, $fixtures);

        return $fixtures;
    }

    public function simulateMatches($matches): array
    {
        foreach ($matches as $key => $match) {
            if ($match->getHomeTeam()->getPower() >= $match->getAwayTeam()->getPower()) {
                $homeTeamGoal = rand(0, 10);
                $awayTeamGoal = rand(0, 6);
            } else {
                $homeTeamGoal = rand(0, 5);
                $awayTeamGoal = rand(0, 10);
            }
            $match->setHomeTeamGoal($homeTeamGoal);
            $match->setAwayTeamGoal($awayTeamGoal);
            $match->setPlayed(true);
            $matches[$key] = $match;
        }

        return $matches;
    }

    public function clearMatches($matches): array
    {
        /** @var Competition $match */
        foreach ($matches as $key => $match) {
            $match->setHomeTeamGoal(null);
            $match->setAwayTeamGoal(null);
            $match->setPlayed(false);
            $matches[$key] = $match;
        }

        return $matches;
    }
}
