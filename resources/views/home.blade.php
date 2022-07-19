@extends('layouts.app')


@section('content')
    <x-nav></x-nav>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome,{{ Str::upper(Auth::user()->name) }}</div>
            </div>
        </div>
    </div>
@endsection
