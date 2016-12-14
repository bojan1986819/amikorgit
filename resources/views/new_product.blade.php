@extends('layouts.master')

@section('title')
    Termék felvétel
@endsection

@section('content')
    <style>
        .ui-jqgrid tr.jqgrow td
        {
            vertical-align: top;
            white-space: normal !important;
            padding:2px 5px;
        }
    </style>

    <header><h3>Termék felvétel</h3></header>
    {{--<label>Válassz klienst</label>--}}
    {{--{{ Form::open(['action' => ['ProductController@index'], 'method' => 'GET']) }}--}}
    {{--{{ Form::text('q', '', ['id' =>  'q', 'placeholder' =>  'Kliens neve', 'class' => 'form-control'])}}--}}
    {{--{{ Form::hidden('invisible', 'Search', array('class' => 'button expand')) }}--}}
    {{--{{ Form::close() }}--}}
    {{--<br>--}}
    {{--<div class="interaction">--}}
        {{--<a href="#" class="btn btn-primary">Új kliens felvétele</a>--}}
    {{--</div>--}}
    <div style="margin:10px">
        {{--<fieldset style="font-family:tahoma; font-size:12px">--}}
            {{--<form>--}}
                {{--Kliens Keresés: <input type="text" id="filter" placeholder="Írj be egy nevet" class="form-control"/>--}}
                {{--<input type="submit" id="search_text" value="Filter">--}}
            {{--</form>--}}
        {{--</fieldset>--}}
        <hr>

        <script>
            function insert_form_section(form,beforeField,label)
            {
                jQuery('<tr class="FormData"><td style="padding:5px 0;" colspan="99">' +
                        '<div style="padding:3px" class="ui-widget-header ui-corner-all">' +
                        '<b>'+label+'</b></div></td></tr>')
                        .insertBefore(jQuery('#tr_'+beforeField, form));
            }
        </script>
        {!! $phpgrid_output_master !!}
    <br>
    {!! $phpgrid_output_detail !!}

<script>
    jQuery("#search_text").click(function() {
        grid = jQuery("#list1");

        // open initially hidden grid
        // $('.ui-jqgrid-titlebar-close').click();

        var searchFiler = jQuery("#filter").val(), f;

        if (searchFiler.length === 0) {
            grid[0].p.search = false;
            jQuery.extend(grid[0].p.postData,{filters:""});
        }
        f = {groupOp:"OR",rules:[]};

        // initialize search, 'name' field equal to (eq) 'Client 1'
        // operators: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc']

        f.rules.push({field:"last_name",op:"bw",data:searchFiler});
        f.rules.push({field:"first_name",op:"bw",data:searchFiler});

        grid[0].p.search = true;
        jQuery.extend(grid[0].p.postData,{filters:JSON.stringify(f)});

        grid.trigger("reloadGrid",[{jqgrid_page:1,current:true}]);

        return false;
    });
</script>
    <script>
        $(function()
        {
            $( "#filter" ).autocomplete({
                source: "new_product/nameautocomplete",
                minLength: 2,
                select: function(event, ui) {
                    $('#filter').val(ui.item.value);
                }
            });
        });
    </script>

@endsection
