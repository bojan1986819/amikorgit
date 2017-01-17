@extends('layouts.master')

@section('title')
    Termék eladása
@endsection

@section('content')
    <ul class="nav nav-tabs tabs-up" id="friends">
        <li><a href="{{ route('all_products') }}" data-target="#contacts" class="media_node active span" id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Összes termék </a></li>
        <li class="active"><a href="{{ route('neworder') }}" data-target="#friends_list" class="media_node span" id="friends_list_tab" data-toggle="tabajax" rel="tooltip"> Termék eladása</a></li>
    </ul>
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


    <header><h3>Új megrendelés</h3></header>
    <hr>



    <style>
        /* required for add/edit dialog overlapping */
        .fancybox-overlay {
            z-index:940;
        }
    </style>

    <div style="margin:10px">
        {!! $clients_output !!}
        <hr>
        {!! $invoices_output !!}
        <hr>


    </div>


    <div id='box_detail_grid2' style='display:none'>
        {!! $invoice_rows_output !!}

    </div>

    <script>
        function show_hide_fields()
        {
            var selector1 = 'input[name="type"].editable';
            var selector2 = 'input[name="type"].FormElement';

            if ($(selector1).val() == "eladas" || $(selector2).val() == "eladas")
            {
                $('input[name="berbeadas_start"]').prop("disabled",true);
                $('input[name="berbeadas_end"]').attr("disabled",true);
            }
            else
            {
                $('input[name="berbeadas_start"]').attr("disabled",false);
                $('input[name="berbeadas_end"]').attr("disabled",false);
            }
//            $('input[name="berbeadas_start"]').attr("disabled","disabled");
//            $('input[name="berbeadas_end"].FormElement').hide();
        }

        $(document).ready(function() {
            $('.fancybox').fancybox({
                afterClose : function() { $('#list2').trigger("reloadGrid");}
            });

        });

        function link_select2(id)
        {
            $('select[name='+id+'].editable, select[id='+id+']').select2({width:'95%', dropdownCssClass: 'ui-widget ui-jqdialog'});
            $(document).unbind('keypress').unbind('keydown');
        }
    </script>

</div>
@endsection


