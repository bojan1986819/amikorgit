@extends('layouts.main')

@section('title')
    {{ $product->product_name }} adatai
@endsection

@section('content')
    <div class="ContentMain" align="center">
        <section class="row new-post">
            <div class="col-md-6 col-md-offset-3">
                <form  enctype="multipart/form-data">
                    <table style="width: 500px; margin-left: auto; margin-right: auto; background-color: rgba(0, 0, 0, 0.5)" cellpadding="10px">
                        <header><h3 align="center">{{ $product->product_name }} adatai</h3></header>
                        <tbody>
                                <tr>
                                    <td width="150px">
                                        <h2 for="product_name">Termék neve</h2>
                                    </td>
                                    <td align="left">
                                        <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}" id="product_name" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="150px">
                                        <h2 for="first_name">Technika</h2>
                                    </td>
                                    <td align="left">
                                        <input type="text" name="product_name" class="form-control" value="{{ $product->technika }}" id="product_name" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="150px">
                                        <h2 for="first_name">Méret</h2>
                                    </td>
                                    <td align="left">
                                        <input type="text" name="product_name" class="form-control" value="{{ $product->meret }}" id="product_name" readonly>
                                    </td>
                                </tr>
                                @if(Auth::user())
                                <tr>
                                    <td width="150px">
                                        <h2 for="first_name">Ajánlott ár</h2>
                                    </td>
                                    <td align="left">
                                        <input type="text" name="product_name" class="form-control" value="{{ $product->ajanlott_ar }}" id="product_name" readonly>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td width="150px">
                                        <h2 for="first_name">Kép</h2>
                                    </td>
                                    <td align="left" height="50px">
                                        <img src="{{ URL::to($product->images) }}" height="100px">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100px">
                                        @if(Auth::user())
                                            <div id="printableArea" align="center">
                                                {!! QrCode::size(100)->generate(URL::to("project/{$product->id}"));  !!}
                                            </div>
                                    </td>
                                    <td align="left">
                                            <input type="button" onclick="printDiv('printableArea')" value="QRkód nyomtatása" class="btn btn-primary"/>
                                            <script>
                                                $(function() {
                                                    $("#printableArea").hide();
                                                });

                                                function printDiv(divName) {
                                                    var printContents = document.getElementById(divName).innerHTML;
                                                    var originalContents = document.body.innerHTML;

                                                    document.body.innerHTML = printContents;

                                                    window.print();

                                                    document.body.innerHTML = originalContents;
                                                }
                                            </script>
                                        @endif
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </form>

            </div>
        </section>
    </div>
@endsection