@extends('layouts.master')

@section('title')
    Termék kezelés
@endsection

@section('content')
    <ul class="nav nav-tabs tabs-up" id="friends">
        <li><a href="{{ route('all_products') }}" rel="tooltip"> Összes termék </a></li>
        <li><a href="{{ route('neworder') }}"rel="tooltip"> Termék eladása</a></li>
    </ul>

    <div class="tab-content">
            <h2>Válassz a menüből</h2>
    </div>

@endsection
