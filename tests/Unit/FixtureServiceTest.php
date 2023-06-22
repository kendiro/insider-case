<?php

namespace Tests\Unit;

use App\Service\FixtureService;
//use Illuminate\Foundation\Testing\TestCase;

use PHPUnit\Framework\TestCase;

class FixtureServiceTest extends TestCase
{
    public function test_fixture_generate(): void
    {
        $fixtureService = new FixtureService();

        $teams = $fixtureService->getTournamentTeams();
        $totalRounds = (count($teams) - 1) * 2;
        $fixtures = $fixtureService->generateFixtures($teams);

        $this->assertEquals($totalRounds, count($fixtures));
    }

    public function test_fixture(): void
    {
        $fixtureService = new FixtureService();

        //$teams = $fixtureService->getTournamentTeams();
        //$fixtures = $fixtureService->generateFixtures($teams);


        $this->assertNotEmpty($fixtureService->getFixture(1));
    }
}
