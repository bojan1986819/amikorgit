@extends('layouts.master')

@section('title')
    Kliensek kezelése
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

    {!! $phpgrid_output !!}


    <script>
        var opts = {
            'ondblClickRow': function (id) {
                jQuery(this).jqGrid('editGridRow', id, {!!  $json_output !!});
            }
        };
    </script>

@endsection
