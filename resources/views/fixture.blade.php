@extends('layout')

@section('title', 'Fixture')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Generated Fixture</h1>
            <div class="row">
            @foreach ($fixtures as $fixture)
                <div class="col-3">
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
                            <td> - </td>
                            <td>{{ $match->getAwayTeam()->getName() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            @endforeach
                <div class="col-3"></div>
                <div class="col-3"></div>
            </div>

            <a class="btn btn-primary" href="/simulation?week=1">Start Simulation</a>
        </div>
@endsection
