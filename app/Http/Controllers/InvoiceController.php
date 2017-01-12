<?php
namespace App\Http\Controllers;

use Dompdf\FrameDecorator\Table;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Invoice;
use App\InvoiceProduct;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function newOrder()
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
        $opt["caption"] = "Válassz Klienst";
        $opt["height"] = "50";
        $opt["shrinkToFit"] = true;
        $opt["resizable"] = true;
        $opt["detail_grid_id"] = "list2";
// refresh detail grid on master edit
        $opt["edit_options"]["afterSubmit"] = "function(){ jQuery('#list2').trigger('reloadGrid', [{current:true}]); return [true,'']; jQuery('#list1').setSelection(jQuery('#list1').jqGrid('getGridParam','selrow')); }";

// select after add
        $opt["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list1').setSelection(r.id); }";

// extra params passed to detail grid, column name comma separated
        $opt["subgridparams"] = utf8_encode("client_name");
        $opt["multiselect"] = false;
        $opt["export"] = array("filename"=>"my-file", "sheetname"=>"test", "format"=>"pdf");
        $opt["export"]["range"] = "filtered";
//pop up form changes
        $opt["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'480');
        $opt["add_options"]["topinfo"] = "Kérem adja meg a szükséges adatokat új Kliens felvételéhez<br />&nbsp;";
        $opt["add_options"]["afterShowForm"] = 'function (form)  
                {                     
                    // insert new form section before specified field 
                    insert_form_section(form, "client_name", "Adatok"); 
                    insert_form_section(form, "phone_nr", "Elérhetőség");
                     insert_form_section(form, "postal_code", "Cím"); 
         
                }';
        $opt["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'480');
        $opt["edit_options"]["topinfo"] = "Kliens adatainak módosítása<br />&nbsp;";
        $opt["edit_options"]["afterShowForm"] = 'function (form)  
                {                     
                    // insert new form section before specified field 
                    insert_form_section(form, "client_name", "Adatok"); 
                    insert_form_section(form, "phone_nr", "Elérhetőség");
                     insert_form_section(form, "postal_code", "Cím"); 
         
                }';

        $g->set_options($opt);
        $g->select_command = "SELECT * FROM clients WHERE type like '%vevő%'";
        $g->table = "clients";

        $coe = array();
        $coe["title"] = "Kliens kód";
        $coe["name"] = "id";
        $coe["width"] = 30;
        $coe["hidden"] = false;
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Action";
        $coe["name"] = "act";
        $coe["width"] = "70";
        $coe["hidden"] = true;
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Név";
        $coe["name"] = "client_name";
        $coe["editable"] = true;
        $coe["editrules"] = array("required"=>true);
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Cég név";
        $coe["name"] = "company_name";
        $coe["editable"] = true;
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Típus";
        $coe["name"] = "type";
        $coe["editable"] = true;
        $coe["editrules"] = array("required"=>true);
        $coe["edittype"] = "select";
        $coe["editoptions"] = array("value"=>"beszállító:beszállító;vevő:vevő;restaurátor:restaurátor;bizományos:bizományos");
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Érdeklődési kör";
        $coe["name"] = "interest";
        $coe["editable"] = true;
        $coe["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false, "bulkedit"=>false);
        $coe["editoptions"] = array("size"=>20); // with default display of textbox with size 20
        $coe["editoptions"]["dataInit"] = 'function(el){ setTimeout(function(){          
                                                                                // remove nbsp from start 
                                                                                if (jQuery(".FormGrid:visible").length) $(el)[0].parentNode.firstChild.remove(); 
                                                                                         
                                                                                $("input[name=interest]").tagit({ 
                                                                                            availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"] 
                                                                                        }); },200); }';
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Telefon";
        $coe["name"] = "phone_nr";
        $coe["editable"] = true;
        $coe["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false, "bulkedit"=>false);
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Fax";
        $coe["name"] = "fax_nr";
        $coe["editable"] = true;
        $coe["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false, "bulkedit"=>false);
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Email";
        $coe["name"] = "email";
        $coe["editable"] = true;
        $coe["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false, "bulkedit"=>false);
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Irányítószám";
        $coe["name"] = "postal_code";
        $coe["editable"] = true;
        $coe["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false, "bulkedit"=>false);
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Város";
        $coe["name"] = "city";
        $coe["editable"] = true;
        $coe["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false, "bulkedit"=>false);
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Cím";
        $coe["name"] = "address";
        $coe["editable"] = true;
        $coe["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false, "bulkedit"=>false);
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Cím";
        $coe["name"] = "calcaddress";
        $coe["editable"] = false;
        $coe["show"] = array("list"=>true, "add"=>false, "edit"=>false, "view"=>true, "bulkedit"=>false);
        $coes[] = $coe;

//        $coe = array();
//        $coe["title"] = "Számlák<br>megtekintése";
//        $coe["name"] = "invoices";
//        $coe["default"] = "<a class='fancybox' onclick='jQuery(\"#list1\").setSelection({id});' href='#box_detail_grid'>Számlák</a>";
//        $coe["width"] = "120";
//        $coe["align"] = "center";
//        $coe["editable"] = false;
//        $coe["search"] = false;
//        $coe["export"] = false;
//        $coes[] = $coe;

        $e["on_data_display"] = array(function($data){
            foreach($data["params"] as &$d)
            {
                $d["calcaddress"] = $d["postal_code"] . " {$d["city"]}". " {$d["address"]}";
            }
        }, null, true);
        $g->set_events($e);

        $g->set_columns($coes);


        $g->set_actions(array(
                "add"=>true, // allow/disallow add
                "edit"=>true, // allow/disallow edit
                "delete"=>false, // allow/disallow delete
                "rowactions"=>false, // show/hide row wise edit/del/save option
                "export"=>false, // show/hide export to excel option
                "autofilter" => true, // show/hide autofilter for search
                "search" => "simple" // show single/multi field search condition (e.g. simple or advance)
            )
        );

        $out_clients = $g->render("list1");


        //        detail grid

        $grid = new \jqgrid($db_conf);
        //ezt mindenképpen hozzá kell adni, mert különben folyton újratölt
        $opt = array();
        $opt["datatype"] = "local"; // stop loading detail grid at start
        $opt["caption"] = "Számlák";
        $opt["height"] = "";
        $opt["reloadedit"] = true; // reload after inline edit
//        $opt["onAfterSave"] = "function(){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); setTimeout( function(){jQuery('#list1').setSelection(selr,true);},500 ); }";
//pop up form changes
        $opt["add_options"]["heading"] = "Számla létrehozása";
        $opt["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'400');
        $opt["add_options"]["topinfo"] = "Kérem adja meg a szükséges adatokat új Számla létrehozásához<br />&nbsp;";
        $opt["add_options"]["success_msg"] = "Új számla létrehozva!";
        $opt["add_options"]["afterShowForm"] = 'function (form)  
                {                     
                    // insert new form section before specified field 
                    insert_form_section(form, "invoice_no", "Számla adatai");          
                }';
        $opt["edit_options"]["caption"] = "Számla módosítása";
        $opt["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'400');
        $opt["edit_options"]["topinfo"] = "Kérem adja meg a szükséges adatokat a Számla módosításához<br />&nbsp;";
        $opt["edit_options"]["success_msg"] = "Számla sikeresen módosítva!";
        $opt["edit_options"]["afterShowForm"] = 'function (form)  
                {                     
                    // insert new form section before specified field 
                    insert_form_section(form, "invoice_no", "Számla adatai");          
                }';
        $opt["detail_grid_id"] = "list3";

        $grid->set_options($opt);
// receive id, selected row of parent grid
        $id = intval($_GET["rowid"]);
        $city = utf8_decode($_GET["client_name"]);
        $last_name = utf8_decode($_GET["client_name"]);
        $first_name = utf8_decode($_GET["client_name"]);

//        $grid->select_command = "SELECT *,'$id' as 'cid', '$city' as 'city', '$last_name' as 'last_name', '$first_name' as 'first_name'  FROM invoices WHERE client_id = $id";
        $grid->select_command = "SELECT invoices.*, clients.client_name, clients.city, Sum(invoice_products.price) as 'sumprice' FROM (invoice_products RIGHT JOIN invoices ON invoice_products.invoice_id = invoices.id) INNER JOIN clients ON invoices.client_id = clients.id WHERE invoices.client_id = $id GROUP BY invoices.id";
        $grid->table = "invoices";

        $col = array();
        $col["title"] = "Id";
        $col["name"] = "id";
        $col["hidden"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Action";
        $col["name"] = "act";
        $col["width"] = "70";
        $col["hidden"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Számla szám";
        $col["name"] = "invoice_no";
        $col["editable"] = true;
        $col["editrules"] = array("required"=>true, "edithidden"=>true);
        $cols[] = $col;

        $col = array();
        $col["title"] = "Kliens";
        $col["name"] = "client_name";
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Cím";
        $col["name"] = "city";
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Számla kiállítás";
        $col["name"] = "invoice_date";
        $col["editable"] = true;
        $col["editrules"] = array("required"=>true, "edithidden"=>true);
        $col["formatter"] = "date";
        $col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'Y-m-d', "opts" => array("changeYear" => true, "dateFormat"=>'yy-mm-dd', "minDate"=>"15-07-08"));
        $cols[] = $col;

        $col = array();
        $col["title"] = "Esedékesség";
        $col["name"] = "due_date";
        $col["editable"] = true;
        $col["editrules"] = array("required"=>true, "edithidden"=>true);
        $col["formatter"] = "date";
        $col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'Y-m-d', "opts" => array("changeYear" => true, "dateFormat"=>'yy-mm-dd', "minDate"=>"15-07-08"));
        $cols[] = $col;

        $col = array();
        $col["title"] = "Összeg";
        $col["name"] = "sumprice";
        $col["editable"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Sorok<br>megtekintése";
        $col["name"] = "detail";
        $col["default"] = "<a class='fancybox' onclick='jQuery(\"#list2\").setSelection({id});' href='#box_detail_grid2'>Sorok</a>";
        $col["width"] = "120";
        $col["align"] = "center";
        $col["editable"] = false;
        $col["search"] = false;
        $col["export"] = false;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Számla<br>Nyomtatása";
        $col["name"] = "print";
        $buttons_html = "<a target='_blank' href='invoice/{id}' >Nyomtatás</a>";
        $col["width"] = "140";
        $col["align"] = "center";
        $col["editable"] = false;
        $col["search"] = false;
        $col["export"] = false;
        $col["default"] = $buttons_html;
        $cols[] = $col;


        $grid->set_columns($cols);

        $grid->set_actions(array(
                "add"=>true, // allow/disallow add
                "edit"=>true, // allow/disallow edit
                "delete"=>true, // allow/disallow delete
                "rowactions"=> false, // show/hide row wise edit/del/save option
                "autofilter" => false, // show/hide autofilter for search
                "search" => "advance" // show single/multi field search condition (e.g. simple or advance)
            )
        );

        $e["on_insert"] = array(function($data){
            $id = intval($_GET["rowid"]);
            $nowdate = date('y/m/d');
            $data["params"]["client_id"] = $id;
            $data["params"]["created_at"] = $nowdate;
        }, null, true);
        $e["on_update"] = array(function($data){
            $nowdate = date('y/m/d');
            $data["params"]["updated_at"] = $nowdate;
        }, null, true);
        $grid->set_events($e);

        $out_detail = $grid->render("list2");


        //// INVOICE ROWS GRID


        $grid2 = new \jqgrid($db_conf);
        //ezt mindenképpen hozzá kell adni, mert különben folyton újratölt
        $opt = array();
        $opt["datatype"] = "local"; // stop loading detail grid at start
        $opt["caption"] = "Számla adatai";
        $opt["height"] = "";
        $opt["add_options"]["caption"] = "Új sor hozzáadása";
        $opt["multiselect"] = true;
        $opt["add_options"]["heading"] = "Sor hozzáadása";
        $opt["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'400');
        $opt["add_options"]["topinfo"] = "Kérem adja meg a szükséges adatokat új Számla sor hozzáadásához!<br />A típusnak megfelelően töltse ki a dátumokat!<br />&nbsp;";
        $opt["add_options"]["success_msg"] = "Sor hozzáadva!";
        $opt["add_options"]["afterShowForm"] = 'function (form)  
                {                     
                    // insert new form section before specified field 
                    insert_form_section(form, "product_id", "Termék név és tétel típúsa");
                    insert_form_section(form, "berbeadas_start", "Bérbeadási dátumok");
                    insert_form_section(form, "eladas_date", "Értékesítés dátuma");
                    insert_form_section(form, "price", "Termék ára");
                }';
        $opt["edit_options"]["caption"] = "Sor módosítása";
        $opt["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'400');
        $opt["edit_options"]["topinfo"] = "Kérem adja meg a szükséges adatokat a Számla sor módosításához!<br />A típusnak megfelelően töltse ki a dátumokat!<br />&nbsp;";
        $opt["edit_options"]["success_msg"] = "Sor módosítva!";
        $opt["edit_options"]["afterShowForm"] = 'function (form)  
                {                     
                    // insert new form section before specified field 
                    insert_form_section(form, "product_id", "Termék név és tétel típúsa");
                    insert_form_section(form, "berbeadas_start", "Bérbeadási dátumok");
                    insert_form_section(form, "eladas_date", "Értékesítés dátuma");
                    insert_form_section(form, "price", "Termék ára");          
                }';

        $grid2->set_options($opt);
// receive id, selected row of parent grid
        $id = intval($_GET["rowid"]);

        $grid2->select_command = "SELECT i.*, p.product_name as 'pname', p.ajanlott_ar as 'ajanlottar', p.beszerzesi_ar as 'beszer' FROM invoice_products i LEFT JOIN products p ON i.product_id=p.id GROUP BY i.id HAVING i.invoice_id=$id";
        $grid2->table = "invoice_products";

        $cod = array();
        $cod["title"] = "Id";
        $cod["name"] = "id";
        $cod["hidden"] = true;
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Termék kód";
        $cod["name"] = "product_id";
        $cod["editable"] = true;
        $cod["editrules"] = array("required"=>true);
        $cod["edittype"] = "select"; // render as select
        $str = $g->get_dropdown_values("select distinct id as k, product_name as v from products where eladas_status != 'restaurálás' or eladas_status is null");
        $cod["editoptions"] = array("value"=>":;".$str);
        $cod["editoptions"]["dataInit"] = "function(){ setTimeout(function(){ link_select2('{$cod["name"]}'); },200); }";
        $cod["stype"] = "select"; // render as select
        $cod["searchoptions"] = array("value"=>$str);
        $cod["searchoptions"]["dataInit"] = "function(){ setTimeout(function(){ link_select2('gs_{$cod["name"]}'); },200); }";
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Termék név";
        $cod["editable"] = false;
        $cod["name"] = "pname";
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Típus";
        $cod["name"] = "type";
        $cod["editable"] = true;
        $cod["editrules"] = array("required"=>true);
        $cod["edittype"] = "select";
        $cod["editoptions"] = array("value"=>"eladas:eladas;bérbe adás:bérbe adás");
        $cod["editoptions"]["onchange"] = "function(){ show_hide_fields(); }";
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Bérbeadás kezdete";
        $cod["name"] = "berbeadas_start";
        $cod["editable"] = true;
        $cod["formatter"] = "date";
        $cod["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'Y-m-d', "opts" => array("changeYear" => true, "dateFormat"=>'yy-mm-dd', "minDate"=>"15-07-08"));
        $cod["editoptions"]["dataInit"] = "function(){ setTimeout( function(){show_hide_fields();},200 ) }";
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Bérbeadás vége";
        $cod["name"] = "berbeadas_end";
        $cod["editable"] = true;
        $cod["formatter"] = "date";
        $cod["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'Y-m-d', "opts" => array("changeYear" => true, "dateFormat"=>'yy-mm-dd', "minDate"=>"15-07-08"));
        $cod["editoptions"]["dataInit"] = "function(){ setTimeout( function(){show_hide_fields();},200 ) }";
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Eladás dátuma";
        $cod["name"] = "eladas_date";
        $cod["editable"] = true;
        $cod["formatter"] = "date";
        $cod["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'Y-m-d', "opts" => array("changeYear" => true, "dateFormat"=>'yy-mm-dd', "minDate"=>"15-07-08"));
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Beszerzési Ár";
        $cod["name"] = "beszer";
        $cod["editable"] = false;
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Ár";
        $cod["name"] = "price";
        $cod["editable"] = true;
        $cod["editrules"] = array("required"=>true);
        $cods[] = $cod;


        $grid2->set_columns($cods);


        $grid2->set_actions(array(
                "add"=>true, // allow/disallow add
                "edit"=>true, // allow/disallow edit
                "delete"=>true, // allow/disallow delete
                "bulkedit"=>false,
                "rowactions"=> false, // show/hide row wise edit/del/save option
                "autofilter" => true, // show/hide autofilter for search
                "search" => "advance" // show single/multi field search condition (e.g. simple or advance)
            )
        );

        $e["on_insert"] = array(function($data){
            $id = intval($_GET["rowid"]);
            $nowdate = date('y/m/d');

            $berbend = InvoiceProduct::where('product_id',$data["params"]["product_id"])->max('berbeadas_end');
            $berbstart = InvoiceProduct::where('product_id',$data["params"]["product_id"])->min('berbeadas_start');
            $eladasdat = InvoiceProduct::where('product_id',$data["params"]["product_id"])->min('eladas_date');

            if($data["params"]["type"]!='eladas') {
                if ($berbend > $data["params"]["berbeadas_start"] && $berbstart < $data["params"]["berbeadas_start"])
                    phpgrid_error("Ez alatt az idő alatt már bérbe van adva");
                elseif ($berbend > $data["params"]["berbeadas_end"] && $berbstart < $data["params"]["berbeadas_end"])
                    phpgrid_error("Ez alatt az idő alatt már bérbe van adva");
                elseif ($berbend > $data["params"]["berbeadas_start"] && $berbstart < $data["params"]["berbeadas_end"])
                    phpgrid_error("Ez alatt az idő alatt már bérbe van adva");
                elseif ($berbend > $data["params"]["berbeadas_end"] && $berbstart < $data["params"]["berbeadas_start"])
                    phpgrid_error("Ez alatt az idő alatt már bérbe van adva");
                elseif ($eladasdat < $data["params"]["berbeadas_end"] || $eladasdat < $data["params"]["berbeadas_start"])
                    phpgrid_error("Ez alatt az idő alatt már el van adva");
                $data["params"]["invoice_id"] = $id;
                $data["params"]["created_at"] = $nowdate;
                $data["params"]["eladas_date"]= 'NULL';
            } else {
                if ($berbend > $data["params"]["eladas_date"])
                    phpgrid_error("Ez alatt az idő alatt már bérbe van adva");
                elseif ($eladasdat != null)
                    phpgrid_error("Ez a termék már el van adva");
                $data["params"]["invoice_id"] = $id;
                $data["params"]["created_at"] = $nowdate;
                $data["params"]["berbeadas_end"] = 'NULL';
                $data["params"]["berbeadas_start"]= 'NULL';
            }
        }, null, true);
        $e["on_update"] = array(function($data){
            if($data["params"]["type"]!='eladas') {
                $data["params"]["eladas_date"]= 'NULL';
            } else {
                $data["params"]["berbeadas_end"] = 'NULL';
                $data["params"]["berbeadas_start"]= 'NULL';
            }

            $nowdate = date('y/m/d');
            $data["params"]["updated_at"] = $nowdate;

//            $invoice = Invoice::where('client_id',8)->first();
//            $invoice->invoice_no = 12345;
//            $invoice->update();

        }, null, true);
        $grid2->set_events($e);

        $out_detail2 = $grid2->render("list3");


        return view('new_order', array('clients_output' => $out_clients, 'invoices_output' => $out_detail, 'invoice_rows_output' => $out_detail2));
    }

    public function getInvoice($id){
//        $invoice = InvoiceProduct::where('invoice_id','=',$id)->first();
        $invoice = Invoice::
            leftJoin('clients', 'invoices.client_id', '=', 'clients.id')
            ->where('invoices.id','=',$id)
            ->select('invoices.*','client_name','company_name','address','postal_code','city','email')
            ->first();
        $invoiceProducts = InvoiceProduct::
            join('products','invoice_products.product_id', '=', 'products.id')
            ->where('invoice_products.invoice_id','=',$id)
            ->select('invoice_products.*','product_name')
            ->paginate(5);
        $ipsum = InvoiceProduct::
            groupBy('invoice_id')
            ->selectRaw('sum(price) as price, invoice_id')
            ->where('invoice_id','=',$id)
            ->first();

        return view('invoice', ['ipsums'=>$ipsum,'invoiceProducts'=>$invoiceProducts,'invoices'=>$invoice]);
    }

}