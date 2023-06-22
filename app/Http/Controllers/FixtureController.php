<?php

namespace App\Http\Controllers;

use App\Service\FixtureService;
use App\Service\MatchService;
use Illuminate\Http\Request;

class FixtureController extends Controller
{

    public function __construct(protected FixtureService $fixtureService,
                                protected MatchService $matchService
    ){}

    public function index()
    {
        $teams = $this->fixtureService->getTournamentTeams();

        return view('fixture', ['fixtures' => $this->fixtureService->generateFixtures($teams)]);
    }

    public function team()
    {
        return view('team', ['teams' => $this->fixtureService->getTournamentTeams()]);
    }

    public function simulation(Request $request)
    {
        $teams = $this->fixtureService->getTournamentTeams();
        $fixtures = $this->fixtureService->generateFixtures($teams);

        $week = $request->get('week');
        $reset = $request->get('reset', false);
        if ($reset) {
            $this->fixtureService->resetFixture($fixtures, $week);
            return redirect('/simulation?week=' . $week ?? 1);
        }

        $pointTables = $this->matchService->getPointTable($fixtures, $teams);

        return view('simulation', [
            'pointTables' => $pointTables,
            'totalFixture' => count($fixtures),
            'fixture' => $this->fixtureService->getFixture($week ?? 1),
            'predictions' => $this->matchService->getPredictions($pointTables, $fixtures, $teams)
        ]);
    }

    public function simulate(Request $request)
    {
        $week = $request->get('week');

        $teams = $this->fixtureService->getTournamentTeams();
        $fixtures = $this->fixtureService->generateFixtures($teams);

        $this->fixtureService->simulateFixture($fixtures, $week ?? null);

        return redirect('/simulation?week=' . $week ?? 1);
    }
}
