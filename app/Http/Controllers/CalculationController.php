<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculationController extends Controller
{
    public function balance()
    {
        include(app_path() . '/Classes/phpgrid/jqgrid_dist.php');

        include ('connect.php');

        $g = new \jqgrid($db_conf);
        $opt["toolbar"] = "top";
        $opt["caption"] = "Bevétel-Kiadás";
        $opt["shrinkToFit"] = true;
        $opt["resizable"] = true;
        $opt["height"] = "300";
        $opt["multiselect"] = false;
        $opt["export"] = array("filename" => "my-file", "sheetname" => "test", "format" => "pdf");
        $opt["export"]["range"] = "filtered";

        $g->set_options($opt);
        $g->select_command = "SELECT clients.id, clients.client_name, Sum(products.beszerzesi_ar) AS 'sumspends', Sum(invoice_products.price) AS 'sumincome', invoice_products.created_at as 'createdat' FROM ((invoice_products INNER JOIN invoices ON invoice_products.invoice_id = invoices.id) RIGHT JOIN clients ON invoices.client_id = clients.id) LEFT JOIN products ON clients.id = products.client_id GROUP BY clients.id HAVING sumspends > 1 or sumincome > 1";
        $g->table = "clients";

        $col = array();
        $col["title"] = "Kliens kód";
        $col["name"] = "id";
        $col["dbname"] = "clients.id";
        $col["hidden"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Kliens neve";
        $col["name"] = "client_name";
        $col["dbname"] = "clients.client_name";
        $col["hidden"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Összes kiadás";
        $col["name"] = "sumspends";
        $col["hidden"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Összes bevétel";
        $col["name"] = "sumincome";
        $col["hidden"] = false;
        $cols[] = $col;

        $g->set_columns($cols);

        $g->set_actions(array(
                "add" => false, // allow/disallow add
                "edit" => false, // allow/disallow edit
                "delete" => false, // allow/disallow delete
                "rowactions" => false, // show/hide row wise edit/del/save option
                "export" => true, // show/hide export to excel option
                "autofilter" => true, // show/hide autofilter for search
                "search" => "simple" // show single/multi field search condition (e.g. simple or advance)
            )
        );

        $out = $g->render("list1");
        return view('balance', array('all_products_output' => $out));
    }

    public function allIncome()
    {
        include(app_path() . '/Classes/phpgrid/jqgrid_dist.php');

        include ('connect.php');

        $g = new \jqgrid($db_conf);
        $opt["toolbar"] = "top";
        $opt["caption"] = "Bevétel";
        $opt["shrinkToFit"] = true;
        $opt["resizable"] = true;
        $opt["height"] = "";
        $opt["multiselect"] = false;
        $opt["export"] = array("filename" => "my-file", "sheetname" => "test", "format" => "pdf");
        $opt["export"]["range"] = "filtered";
        $opt["grouping"] = true; //
        $opt["groupingView"] = array();
        $opt["groupingView"]["groupField"] = array("month"); // specify column name to
        // group listing
        $opt["groupingView"]["groupColumnShow"] = array(true); // either show grouped column in list or not (default:
        // true)
        $opt["groupingView"]["groupText"] = array("<b>{0} - {1} tétel</b>"); // {0} is grouped value, {1} is count in
        // group
        $opt["groupingView"]["groupOrder"] = array("asc"); // show group in asc or desc order
        $opt["groupingView"]["groupDataSorted"] = array(true); // show sorted data within group
        $opt["groupingView"]["groupSummary"] = array(true); // work with summaryType, summaryTpl, see column:
        // $col["name"] = "total";
        $opt["groupingView"]["groupCollapse"] = true; // Turn true to show group collapse (default: false)
        $opt["groupingView"]["showSummaryOnHide"] = true; // show summary row even if group collapsed (hide)

        $g->set_options($opt);
        $g->select_command = "SELECT concat(year(invoice_products.created_at),' ',month(invoice_products.created_at)) as 'month', date(invoice_products.created_at) as 'date', products
.id as 
'code', products.beszerzesi_ar as 'getprice',
invoice_products.price as 'price', clients.client_name as 'client_name' FROM (invoice_products LEFT JOIN products ON 
invoice_products.product_id = products.id) LEFT JOIN (invoices LEFT JOIN clients ON invoices.client_id = clients.id) 
ON invoice_products.invoice_id = invoices.id";
        $g->table = "invoice_products";

        $col = array();
        $col["title"] = "Hónap";
        $col["name"] = "month";
        $col["width"] = "80px";
        $col["align"] = "center";
        $col["hidden"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Dátum";
        $col["name"] = "date";
        $col["width"] = "80px";
        $col["align"] = "center";
        $col["hidden"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Termék<br>kód";
        $col["name"] = "code";
        $col["width"] = "50px";
        $col["align"] = "center";
        $col["hidden"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Beszerzési<br>ár";
        $col["name"] = "getprice";
        $col["width"] = "100px";
        $col["align"] = "center";
        $col["summaryType"] = "sum";
        $col["summaryTpl"] = '<b>Total: {0}HUF</b>';
        $col["hidden"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Eladási<br>ár";
        $col["name"] = "price";
        $col["width"] = "100px";
        $col["align"] = "center";
        $col["summaryType"] = "sum";
        $col["summaryTpl"] = '<b>Total: {0}HUF</b>';
        $col["hidden"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Bevétel";
        $col["name"] = "sum";
        $col["width"] = "100px";
        $col["align"] = "center";
        $col["summaryType"] = "sum";
        $col["summaryTpl"] = '<b>Total: {0}HUF</b>';
        $col["hidden"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Vevő";
        $col["name"] = "client_name";
        $col["hidden"] = false;
        $cols[] = $col;

        $g->set_columns($cols);

        $e["on_data_display"] = array(function($data){
            foreach($data["params"] as &$d)
            {
                $d["sum"] = $d["price"] - $d["getprice"];
            }
        }, null, true);
        $g->set_events($e);


        $g->set_actions(array(
                "add" => false, // allow/disallow add
                "edit" => false, // allow/disallow edit
                "delete" => false, // allow/disallow delete
                "rowactions" => false, // show/hide row wise edit/del/save option
                "export" => true, // show/hide export to excel option
                "autofilter" => true, // show/hide autofilter for search
                "search" => "simple" // show single/multi field search condition (e.g. simple or advance)
            )
        );

        $out = $g->render("list1");
        return view('income', array('income_output' => $out));
    }

    public function bizSoldNotPayed()
    {
        include(app_path() . '/Classes/phpgrid/jqgrid_dist.php');

        include ('connect.php');

        $g = new \jqgrid($db_conf);
        $opt["toolbar"] = "top";
        $opt["caption"] = "Eladott, fizetetlen bizományos tételek";
        $opt["shrinkToFit"] = true;
        $opt["resizable"] = true;
        $opt["height"] = "";
        $opt["multiselect"] = false;
        $opt["export"] = array("filename" => "my-file", "sheetname" => "test", "format" => "pdf");
        $opt["export"]["range"] = "filtered";
//        $opt["grouping"] = true; //
//        $opt["groupingView"] = array();
//        $opt["groupingView"]["groupField"] = array("month"); // specify column name to
//        // group listing
//        $opt["groupingView"]["groupColumnShow"] = array(true); // either show grouped column in list or not (default:
//        // true)
//        $opt["groupingView"]["groupText"] = array("<b>{0} - {1} tétel</b>"); // {0} is grouped value, {1} is count in
//        // group
//        $opt["groupingView"]["groupOrder"] = array("asc"); // show group in asc or desc order
//        $opt["groupingView"]["groupDataSorted"] = array(true); // show sorted data within group
//        $opt["groupingView"]["groupSummary"] = array(true); // work with summaryType, summaryTpl, see column:
//        // $col["name"] = "total";
//        $opt["groupingView"]["groupCollapse"] = true; // Turn true to show group collapse (default: false)
//        $opt["groupingView"]["showSummaryOnHide"] = true; // show summary row even if group collapsed (hide)

        $g->set_options($opt);
        $g->select_command = "SELECT concat(year(invoice_products.created_at),' ',month(invoice_products.created_at)) as 'month', date(invoice_products.created_at) as 'date', products
                        .id as 'code', products.beszerzesi_ar as 'getprice', products.product_name as 'product_name',
                        products.paid as 'paid', products.id as 'id',
                        invoice_products.price as 'price', clients.client_name as 'client_name', procurements.type as 'tipus' FROM (
                        (invoice_products LEFT JOIN products ON invoice_products.product_id = products.id) LEFT JOIN 
                        (invoices LEFT JOIN clients ON invoices.client_id = clients.id) ON
                        invoice_products.invoice_id = invoices.id) LEFT JOIN procurements ON products.procurement_id = procurements.id
                        WHERE procurements.type like 'BSZ' and products.paid = 0 and invoice_products.eladas_date is 
                        not null";
        $g->table = "products";

        $col = array();
        $col["title"] = "ID";
        $col["name"] = "id";
        $col["width"] = "80px";
        $col["align"] = "center";
        $col["hidden"] = true;
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Hónap";
        $col["name"] = "month";
        $col["width"] = "80px";
        $col["align"] = "center";
        $col["hidden"] = true;
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Dátum";
        $col["name"] = "date";
        $col["width"] = "80px";
        $col["align"] = "center";
        $col["hidden"] = false;
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Termék<br>kód";
        $col["name"] = "code";
        $col["width"] = "50px";
        $col["align"] = "center";
        $col["hidden"] = false;
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Termék<br>név";
        $col["name"] = "product_name";
        $col["width"] = "80px";
        $col["align"] = "center";
        $col["hidden"] = false;
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Beszerzési<br>ár";
        $col["name"] = "getprice";
        $col["width"] = "100px";
        $col["align"] = "center";
        $col["summaryType"] = "sum";
        $col["summaryTpl"] = '<b>Total: {0}HUF</b>';
        $col["hidden"] = false;
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Eladási<br>ár";
        $col["name"] = "price";
        $col["width"] = "100px";
        $col["align"] = "center";
        $col["summaryType"] = "sum";
        $col["summaryTpl"] = '<b>Total: {0}HUF</b>';
        $col["hidden"] = false;
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Bevétel";
        $col["name"] = "sum";
        $col["width"] = "100px";
        $col["align"] = "center";
        $col["summaryType"] = "sum";
        $col["summaryTpl"] = '<b>Total: {0}HUF</b>';
        $col["hidden"] = false;
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Vevő";
        $col["name"] = "client_name";
        $col["editable"] = false;
        $col["hidden"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Kifizetve";
        $col["name"] = "paid";
        $col["width"] = "100";
        $col["align"] = "center";
        $col["stype"] = "select";
        $col["searchoptions"] = array("value"=>"1:fizetve;0:nincs kifizetve");
        $col["formatter"] = "checkbox";
        $col["formatoptions"] = array("value"=>"1:0");
        $col["editable"] = true;
        $col["edittype"] = "checkbox";
        $col["editoptions"] = array("value"=>"1:0");
        $cols[] = $col;

        $col = array();
        $col["title"] = "Szerkesztés";
        $col["name"] = "act";
        $col["width"] = "100";
        $col["hidden"] = false;
        $cols[] = $col;

        $g->set_columns($cols);

        $e["on_data_display"] = array(function($data){
            foreach($data["params"] as &$d)
            {
                $d["sum"] = $d["price"] - $d["getprice"];
            }
        }, null, true);
        $g->set_events($e);


        $g->set_actions(array(
                "add" => false, // allow/disallow add
                "edit" => true, // allow/disallow edit
                "delete" => false, // allow/disallow delete
                "rowactions" => true, // show/hide row wise edit/del/save option
                "export" => true, // show/hide export to excel option
                "autofilter" => true, // show/hide autofilter for search
                "search" => "simple" // show single/multi field search condition (e.g. simple or advance)
            )
        );

        $out = $g->render("list1");
        return view('biznotpaid', array('biznotpaid_output' => $out));
    } //ez még nincs meg

}
