@extends('layout')

@section('title', 'Teams')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Tournament Teams</h1>

            <table class="table">
                <thead>
                <tr>
                    <td class="table-title">Team Name</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td>{{ $team->getName() }}</td>
                    </tr>
                @endforeach

                </tbody>

            </table>

            <a class="btn btn-primary" href="/fixtures">Generate Fixtures</a>
        </div>
@endsection
