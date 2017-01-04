@extends('layouts.main')

@section('title')
    {{ $invoice->invoice_id }} számla adatai
@endsection

@section('content')
    <div class="ContentMain" align="center">
        <section class="row new-post">
            <div class="col-md-6 col-md-offset-3">
                <form  enctype="multipart/form-data">
                    <table style="width: 500px; margin-left: auto; margin-right: auto; background-color: rgba(0, 0, 0, 0.5)" cellpadding="10px">
                        <header><h3 align="center">{{ $invoice->invoice_id }} számla adatai</h3></header>
                        <tbody>
                        <tr>
                            <th>ID</th>

                        </tr>
                        {{ csrf_field() }}


                        @foreach($invoiceProducts as $invoiceProduct)
                            <tr class="item{{$invoiceProduct->id}}">
                                <td>{{$invoiceProduct->id}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>

            </div>
        </section>
    </div>
@endsection