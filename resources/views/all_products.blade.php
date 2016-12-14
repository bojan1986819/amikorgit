@extends('layouts.master')

@section('title')
    Termékek kezelése
@endsection

@section('content')
    <ul class="nav nav-tabs tabs-up" id="friends">
        <li class="active"><a href="{{ route('all_products') }}" data-target="#contacts" class="media_node active span" id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Összes termék </a></li>
        <li><a href="{{ route('neworder') }}" data-target="#friends_list" class="media_node span" id="friends_list_tab" data-toggle="tabajax" rel="tooltip"> Termék eladása</a></li>
    </ul>

<div class="row">
    <div class="col-md-12">
        <h1>Termékek kezelése</h1>
    </div>
</div>
<hr>

{!! $all_products_output !!}
    <hr>
@endsection