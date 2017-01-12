@extends('layouts.invoicemain')

@section('title')
    {{ $invoices->id }} számla adatai
@endsection

@section('content')
    <div align="center">
        <input type="button" onclick="printDiv('printableArea')" value="Nyomtatás" class="btn btn-primary"/>
    </div>
    <div class="ContentMain" align="center" id="printableArea">
    <style>
        @page { size: auto;  margin: 0mm; }

        .invoice-box{
            background-color: white;
            max-width:800px;
            margin:auto;
            padding:30px;
            border:1px solid #eee;
            box-shadow:0 0 10px rgba(0, 0, 0, .15);
            font-size:16px;
            line-height:24px;
            font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color:#555;
        }

        .invoice-box table{
            width:100%;
            line-height:inherit;
            text-align:left;
        }

        .invoice-box table td{
            padding:5px;
            vertical-align:top;
        }

        .invoice-box table tr td:nth-child(2){
            text-align:right;
        }

        .invoice-box table tr.top table td{
            padding-bottom:20px;
        }

        .invoice-box table tr.top table td.title{
            font-size:45px;
            line-height:45px;
            color:#333;
        }

        .invoice-box table tr.information table td{
            padding-bottom:40px;
            border:1px solid #ddd;
        }

        .invoice-box table tr.heading td{
            background:#eee;
            border-bottom:1px solid #ddd;
            font-weight:bold;
        }

        .invoice-box table tr.details td{
            padding-bottom:20px;
        }

        .invoice-box table tr.item td{
            border-bottom:1px solid #eee;
        }

        .invoice-box table tr.item.last td{
            border-bottom:none;
        }

        .invoice-box table tr.total td:nth-child(2){
            border-top:2px solid #eee;
            font-weight:bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td{
                width:100%;
                display:block;
                text-align:center;
            }

            .invoice-box table tr.information table td{
                width:100%;
                display:block;
                text-align:center;
            }
        }
    </style>

        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="{{ URL::to('assets/logo.png')}}" style="width:100%; max-width:300px;">
                                </td>

                                <td>
                                    Számlaszám: {{ $invoices->invoice_no }}<br>
                                    Kiállítva: {{ $invoices->invoice_date }}<br>
                                    Esedékes: {{ $invoices->due_date }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    Amikor Kft<br>
                                    1063 Budapest<br>
                                    Pozsonyi út 11.
                                </td>

                                <td>
                                    {{ $invoices->company_name }}<br>
                                    {{ $invoices->client_name }}<br>
                                    {{ $invoices->email }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="heading">
                    {{--<td>--}}
                        {{--Sor--}}
                    {{--</td>--}}
                    <td>
                        Termék
                    </td>

                    <td>
                        ár
                    </td>
                </tr>

                @foreach($invoiceProducts as $key=>$invoiceProduct)
                    <tr class="item">
{{--                        <td>{{ ++$key }}</td>--}}
                        <td>{{$invoiceProduct->product_name}}</td>
                        <td>{{$invoiceProduct->price}}</td>

                    </tr>
                @endforeach


                <tr class="total">
                    <td></td>

                    <td>
                        Összeg: {{$ipsums->price or '0'}}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection