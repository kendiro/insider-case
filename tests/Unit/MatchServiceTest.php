<?php

namespace Tests\Unit;

use App\Service\FixtureService;
use App\Service\MatchService;
use PHPUnit\Framework\TestCase;

class MatchServiceTest extends TestCase
{
    public function test_fixture_generate(): void
    {
        $fixtureService = new FixtureService();
        $matchService = new MatchService();

        $teams = $fixtureService->getTournamentTeams();
        $fixtures = $fixtureService->generateFixtures($teams);
        $pointTables = $matchService->getPointTable($fixtures, $teams);

        $this->assertEquals(count($pointTables), count($teams));
    }
}
