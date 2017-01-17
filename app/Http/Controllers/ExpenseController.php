<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function allExpenses()
    {
        include(app_path() . '/Classes/phpgrid/jqgrid_dist.php');

        include ('connect.php');

        $g = new \jqgrid($db_conf);
        $opt["toolbar"] = "top";
        $opt["caption"] = "Kiadások";
        $opt["shrinkToFit"] = true;
        $opt["resizable"] = true;
        $opt["height"] = "300";
        $opt["multiselect"] = false;
        $opt["export"] = array("filename" => "kiadas", "sheetname" => "kiadas", "format" => "xls");
        $opt["export"]["range"] = "filtered";

        $g->set_options($opt);
        $g->table = "expenses";

        $col = array();
        $col["title"] = "ID";
        $col["name"] = "id";
        $col["width"] = "80px";
        $col["align"] = "center";
        $col["hidden"] = true;
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Dátum";
        $col["name"] = "created_at";
        $col["width"] = "100";
        $col["align"] = "center";
        $col["formatter"] = "date";
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Kiadási tétel";
        $col["name"] = "description";
        $col["editable"] = true;
        $col["hidden"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Költség";
        $col["name"] = "price";
        $col["editable"] = true;
        $col["hidden"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Megjegyzés";
        $col["name"] = "other";
        $col["editable"] = true;
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
        $col["title"] = "KP / KÁRTYA /<br>SZÁMLA";
        $col["name"] = "type";
        $col["width"] = "100";
        $col["align"] = "center";
        $col["stype"] = "select";
        $col["searchoptions"] = array("value"=>"kp:készpénz;kartya:kártya;szamla:számla");
        $col["formatter"] = "select";
        $col["formatoptions"] = array("value"=>"kp:készpénz;kartya:kártya;szamla:számla");
        $col["editable"] = true;
        $col["edittype"] = "select";
        $col["editoptions"] = array("value"=>"kp:készpénz;kartya:kártya;szamla:számla");
        $cols[] = $col;

        $g->set_columns($cols);

        $g->set_actions(array(
                "add" => true, // allow/disallow add
                "edit" => true, // allow/disallow edit
                "delete" => true, // allow/disallow delete
                "rowactions" => false, // show/hide row wise edit/del/save option
                "export" => true, // show/hide export to excel option
                "autofilter" => true, // show/hide autofilter for search
                "search" => "simple" // show single/multi field search condition (e.g. simple or advance)
            )
        );

        $e["on_insert"] = array(function($data){
            $nowdate = date('y/m/d');
            $data["params"]["created_at"] = $nowdate;
            $data["params"]["updated_at"] = $nowdate;
        }, null, true);
        $e["on_update"] = array(function($data){
            $nowdate = date('y/m/d');
            $data["params"]["updated_at"] = $nowdate;
        }, null, true);
        $g->set_events($e);

        $out = $g->render("list1");
        return view('expense', array('expense_output' => $out));
    }

}
