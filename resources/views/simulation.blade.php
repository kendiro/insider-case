@extends('layout')

@section('title', 'Simulation')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Simulation</h1>
            <div class="row">
                <div class="col-4">
                    <table class="table">
                        <thead>
                        <tr>
                            <td class="table-title">Team Name</td>
                            <td class="table-title">P</td>
                            <td class="table-title">W</td>
                            <td class="table-title">D</td>
                            <td class="table-title">L</td>
                            <td class="table-title">GD</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pointTables as $row)
                            <tr>
                                <td>{{ $row->getTeam()->getName() }}</td>
                                <td>{{ $row->getPoint() }}</td>
                                <td>{{ $row->getWin() }}</td>
                                <td>{{ $row->getDraw() }}</td>
                                <td>{{ $row->getLose() }}</td>
                                <td>{{ $row->getGoalFor() - $row->getGoalAgainst() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    @if($fixture)
                    <table class="table">
                        <thead>
                        <tr>
                            <td colspan="3" class="table-title">{{ $fixture->getWeek() }}</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($fixture->getMatches() as $match)
                            <tr>
                                <td>{{ $match->getHomeTeam()->getName() }}</td>
                                <td>{{ $match->getHomeTeamGoal() }} - {{ $match->getAwayTeamGoal() }}</td>
                                <td>{{ $match->getAwayTeam()->getName() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="col-4">
                    @if($predictions)
                        <table class="table">
                            <thead>
                            <tr>
                                <td class="table-title">Prediction</td>
                                <td class="table-title">%</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($predictions as $prediction)
                                <tr>
                                    <td>{{ $prediction['teamName'] }}</td>
                                    <td>{{ $prediction['prediction'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col text-center"><a class="btn btn-primary" href="/simulate">Play All Weeks</a></div>
                @if ($fixture->getId() > 1)
                    <div class="col text-center"><a class="btn btn-primary" href="/simulate?week={{ $fixture->getId()-1 }}"> << Previous Week</a></div>
                @endif
                @if (!$fixture->isCompleted())
                    <div class="col text-center"><a class="btn btn-primary" href="/simulate?week={{ $fixture->getId() }}">Play</a></div>
                @endif
                @if ($fixture->getId() < $totalFixture)
                    <div class="col text-center"><a class="btn btn-primary" href="/simulate?week={{ $fixture->getId()+1 }}">Next Week >> </a></div>
                @endif
                <div class="col text-center"><a class="btn btn-danger" href="/simulation?week={{ $fixture->getId() }}&reset=true">Reset</a></div>
            </div>
        </div>
@endsection
