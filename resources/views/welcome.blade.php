@extends('layouts.main')

@section('title')
    Bejelentkezés AmikorCRM
@endsection
@section('content')
<div class="ContentLeft">
    <h2>Add meg az email címed és jelszavad</h2>
    <h6><br />
        <br />
        Kattints a belépés gombra
    </h6>
</div>
<div class="ContentRight">
    @include('includes.message-block')
    <div class="col-md-6">
        <div class="PageHeading">
            <h1>Belépés</h1>
        </div>
        <form action="{{ route('signin') }}" method="post">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <input class="TField" type="text" name="email" id="email" placeholder="Email cím" value="{{ Request::old('email') }}">
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <input class="TField" type="password" name="password" id="password" placeholder="Jelszó" value="{{ Request::old('password') }}">
            </div>
            <div class="FormElement">
                <input type="submit" class="button" value="Belépés" />
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </div>
        </form>
    </div>
</div>
@endsection
