@extends('layouts.master')

@section('title')
    Kiadás-Bevétel
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1>Kiadás-Bevétel</h1>
    </div>
</div>
<hr>

{!! $all_products_output !!}


@endsection
