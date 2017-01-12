<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculationController extends Controller
{
    public function allIncome()
    {
        include(app_path() . '/Classes/phpgrid/jqgrid_dist.php');

        // Database config file to be passed in phpgrid constructor
//        $db_conf = array(
//            "type" => 'mysqli',
//            "server" => 'localhost',
//            "user" => 'admin',
//            "password" => 'admin',
//            "database" => 'laravel'
//        );
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
}
