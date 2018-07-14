@extends('layouts.base')
@section('title', 'Stat link')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-9 col-lg-8 col-xl-7 mx-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Redirected at</th>
                        <th scope="col">Refer</th>
                        <th scope="col">Ip</th>
                        <th scope="col">Browser</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stats as $stat)
                        <tr>
                            <td>{{ $stat['redirected_at'] }}</td>
                            <td>{{ $stat['refer'] }}</td>
                            <td>{{ $stat['ip'] }}</td>
                            <td>{{ $stat['browser'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center mt-5">
                    <a href="{{ route('home') }}" class="btn btn-light btn-sm">Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection