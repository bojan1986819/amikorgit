@extends('layouts.master')

@section('title')
    Eladott, fizetetlen bizományos tételek
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Eladott, fizetetlen bizományos tételek</h1>
    </div>
</div>
<hr>
<fieldset style="font-family:tahoma; font-size:12px">
    <legend>Időszak kiválasztása</legend>
    <form>
        Időszak kezdete: <input class="datepicker" type="text" id="datefrom"/>
        Időszak vége: <input class="datepicker" type="text" id="dateto"/>
        <input type="submit" id="search_date" value="Filter">
    </form>
</fieldset>
<br>

{!! $biznotpaid_output !!}

<script>
    jQuery(window).load(function() {

        // formats: http://api.jqueryui.com/datepicker/#option-dateFormat
        jQuery(".datepicker").datepicker(
            {
                "disabled":false,
                "dateFormat":"yy-mm-dd",
                "changeMonth": true,
                "changeYear": true,
                "firstDay": 1,
                "showOn":'both'
            }
        ).next('button').button({
            icons: {
                primary: 'ui-icon-calendar'
            }, text:false
        }).css({'font-size':'80%', 'margin-left':'2px', 'margin-top':'-5px'});

    });


    jQuery("#search_date").click(function() {
        grid = jQuery("#list1");

        // open initially hidden grid
        // $('.ui-jqgrid-titlebar-close').click();

        if (jQuery("#datefrom").val() == '' & jQuery("#dateto").val() == '')
            return false;

        var f = {groupOp:"AND",rules:[]};
        if (jQuery("#datefrom").val())
            f.rules.push({field:"invoice_products.created_at",op:"ge",data:jQuery("#datefrom").val()});

        if (jQuery("#dateto").val())
            f.rules.push({field:"invoice_products.created_at",op:"le",data:jQuery("#dateto").val()});

        var s = {groupOp:"OR",rules:[],groups:[f]};
        s.rules.push({field:"invoice_products.created_at",op:"nu",data:''});

        grid[0].p.search = true;
        jQuery.extend(grid[0].p.postData,{filters:JSON.stringify(s)});

        grid.trigger("reloadGrid",[{jqgrid_page:1,current:true}]);
        return false;
    });

</script>


@endsection
