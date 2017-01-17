@extends('layouts.master')

@section('title')
    Termék felvétel
@endsection

@section('content')
    <script>
        function insert_form_section(form,beforeField,label)
        {
            jQuery('<tr class="FormData"><td style="padding:5px 0;" colspan="99">' +
                '<div style="padding:3px" class="ui-widget-header ui-corner-all">' +
                '<b>'+label+'</b></div></td></tr>')
                .insertBefore(jQuery('#tr_'+beforeField, form));
        }
    </script>

    <div class="row">
        <link type="text/css" rel="stylesheet" href="//cdn.jsdelivr.net/fancybox/2.1.4/jquery.fancybox.css" />
        <script type="text/javascript" src="//cdn.jsdelivr.net/fancybox/2.1.4/jquery.fancybox.js"></script>



        <header><h3>Termék felvétel</h3></header>
            <hr>

            <style>
                .ui-jqgrid tr.jqgrow td
                {
                    vertical-align: top;
                    white-space: normal !important;
                    padding:2px 5px;
                }

                /* required for add/edit dialog overlapping */
                .fancybox-overlay {
                    z-index:940;
                }
            </style>
        <div style="margin:10px">
            {!! $out_clients !!}
            <br>
            {!! $out_invoices !!}
            <br>
            {!! $out_products !!}

        </div>

            <div id='box_detail_grid' style='display:none'>
            </div>

    </div>

    <script>
        $(document).ready(function() {
            $('.fancybox').fancybox({
                afterClose : function() { $('#list3').trigger("reloadGrid");}
            });

        });
    </script>

@endsection
