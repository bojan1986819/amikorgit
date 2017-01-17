<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Procurement;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Blog;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ProductController extends Controller
{

    public function newProduct(){

        include(app_path() . '/Classes/phpgrid/jqgrid_dist.php');

        // Database config file to be passed in phpgrid constructor
        include ('connect.php');

        $g = new \jqgrid($db_conf);
        $opt["toolbar"] = "top";
        $opt["caption"] = "Válassz Klienst";
        $opt["height"] = "50";
        $opt["shrinkToFit"] = true;
        $opt["resizable"] = true;
        $opt["detail_grid_id"] = "list3";
        $opt["edit_options"]["afterSubmit"] = "function(){ jQuery('#list3').trigger('reloadGrid', [{current:true}]); return [true,'']; jQuery('#list1').setSelection(jQuery('#list1').jqGrid('getGridParam','selrow')); }";
        $opt["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list1').setSelection(r.id); }";
        $opt["subgridparams"] = "client_id";
        $opt["multiselect"] = false;
        $opt["export"] = array("filename"=>"my-file", "sheetname"=>"test", "format"=>"pdf");
        $opt["export"]["range"] = "filtered";
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
        $opt["add_options"]["success_msg"] = "Kliens sikeresen létrehozva!";
        $opt["edit_options"]["success_msg"] = "Kliens sikeresen módosítva!";
        $opt["delete_options"]["success_msg"] = "Kliens sikeresen törölve!";
        $g->set_options($opt);
        $g->table = "clients";

        $coe = array();
        $coe["title"] = "Kliens<br>kód";
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




//      BIZOMÁNYOSI SZERZŐDÉS VAGY VÉTELI JEGY LÉTREHOZÁSA

        $grid = new \jqgrid($db_conf);
        $opt = array();
        $opt["datatype"] = "local"; // stop loading detail grid at start
        $opt["caption"] = "Bizományosi szerződések / Vételi jegyek";
        $opt["height"] = "";
        $opt["reloadedit"] = true; // reload after inline edit
        $opt["add_options"]["heading"] = "Dokumentum létrehozása";
        $opt["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'400');
        $opt["add_options"]["topinfo"] = "Kérem adja meg a szükséges adatokat új Dokumentum létrehozásához<br />&nbsp;";
        $opt["add_options"]["success_msg"] = "Új dokumentum létrehozva!";
        $opt["add_options"]["afterShowForm"] = 'function (form)  
                {                     
                    // insert new form section before specified field 
                    insert_form_section(form, "doc_no", "Dokumentum adatai");          
                }';
        $opt["edit_options"]["caption"] = "Dokumentum módosítása";
        $opt["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'400');
        $opt["edit_options"]["topinfo"] = "Kérem adja meg a szükséges adatokat a Dokumentum módosításához<br />&nbsp;";
        $opt["edit_options"]["success_msg"] = "Dokumentum sikeresen módosítva!";
        $opt["edit_options"]["afterShowForm"] = 'function (form)  
                {                     
                    // insert new form section before specified field 
                    insert_form_section(form, "doc_no", "Dokumentum adatai");          
                }';
        $opt["detail_grid_id"] = "list2";
        $opt["subgridparams"] = "client_id,type";
        $opt["delete_options"]["success_msg"] = "Dokumentum sikeresen törölve!";

        $grid->set_options($opt);
        $id = intval($_GET["rowid"]);

        $grid->select_command = "SELECT procurements.*, clients.client_name, clients.city, Sum(products.beszerzesi_ar) as 'sumprice' FROM (products RIGHT JOIN procurements ON products.procurement_id = procurements.id) INNER JOIN clients ON procurements.client_id = clients.id WHERE procurements.client_id = $id GROUP BY procurements.id";
        $grid->table = "procurements";

        $cod = array();
        $cod["title"] = "Id";
        $cod["name"] = "id";
        $cod["hidden"] = true;
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Action";
        $cod["name"] = "act";
        $cod["width"] = "70";
        $cod["hidden"] = true;
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Dokumentum<br>szám";
        $cod["name"] = "doc_no";
        $cod["editable"] = true;
        $cod["editrules"] = array("required"=>true, "edithidden"=>true);
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Dokumentum<br>típusa";
        $cod["name"] = "type";
        $cod["editable"] = true;
        $cod["show"]["add"] = true;
        $cod["show"]["edit"] = false;
        $cod["editrules"] = array("required"=>true, "edithidden"=>true);
        $cod["edittype"] = "select";
        $cod["editoptions"] = array("value"=>"VJ:Vételi jegy;BSZ:Bizományosi szerződés;BSZ2:Bizományosi szerződés2");
        $cod["formatter"] = "select";
        $cod["formatoptions"] = array("value"=>"VJ:Vételi jegy;BSZ:Bizományosi szerződés;BSZ2:Bizományosi szerződés2");
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Kliens";
        $cod["name"] = "client_name";
        $cod["editable"] = false;
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Cím";
        $cod["name"] = "city";
        $cod["editable"] = false;
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Dokumentum<br>kiállítás";
        $cod["name"] = "creation_date";
        $cod["editable"] = true;
        $cod["editrules"] = array("required"=>true, "edithidden"=>true);
        $cod["formatter"] = "date";
        $cod["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'Y-m-d', "opts" => array("changeYear" => true, "dateFormat"=>'yy-mm-dd', "minDate"=>"15-07-08"));
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Esedékesség";
        $cod["name"] = "due_date";
        $cod["editable"] = true;
        $cod["editrules"] = array("required"=>true, "edithidden"=>true);
        $cod["formatter"] = "date";
        $cod["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'Y-m-d', "opts" => array("changeYear" => true, "dateFormat"=>'yy-mm-dd', "minDate"=>"15-07-08"));
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Összeg";
        $cod["name"] = "sumprice";
        $cod["editable"] = false;
        $cods[] = $cod;

        $cod = array();
        $cod["title"] = "Termékek<br>felvétele";
        $cod["name"] = "detail";
        $cod["default"] = "<a class='fancybox' onclick='jQuery(\"#list3\").setSelection({id});' href='#box_detail_grid'>Termékek</a>";
        $cod["width"] = "120";
        $cod["align"] = "center";
        $cod["editable"] = false;
        $cod["search"] = false;
        $cod["export"] = false;
        $cods[] = $cod;

//        $cod = array();
//        $cod["title"] = "Számla<br>Nyomtatása";
//        $cod["name"] = "print";
//        $buttons_html = "<a target='_blank' href='invoice/{id}' >Nyomtatás</a>";
//        $cod["width"] = "140";
//        $cod["align"] = "center";
//        $cod["editable"] = false;
//        $cod["search"] = false;
//        $cod["export"] = false;
//        $cod["default"] = $buttons_html;
//        $cods[] = $cod;


        $grid->set_columns($cods);

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
            $data["params"]["updated_at"] = $nowdate;
        }, null, true);
        $e["on_update"] = array(function($data){
            $nowdate = date('y/m/d');
            $data["params"]["updated_at"] = $nowdate;
        }, null, true);
        $grid->set_events($e);

        $out_invoices = $grid->render("list3");



//      TÁRGYAK FELVÉTELE





        $grid = new \jqgrid($db_conf);
        //ezt mindenképpen hozzá kell adni, mert különben folyton újratölt
        $opt = array();
        $opt["datatype"] = "local"; // stop loading detail grid at start
        $opt["caption"] = "Termék felvétel";
        $opt["height"] = "";
        $opt["reloadedit"] = true; // reload after inline edit
//        $opt["onAfterSave"] = "function(){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); setTimeout( function(){jQuery('#list1').setSelection(selr,true);},500 ); }";
//pop up form changes
        $opt["add_options"]["caption"] = "Termék hozzáadása";
        $opt["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'700');
        $opt["add_options"]["topinfo"] = "Kérem adja meg a szükséges adatokat új Termék felvételéhez<br />&nbsp;";
        $opt["add_options"]["afterShowForm"] = 'function (form)  
                {                     
                    // insert new form section before specified field 
                    insert_form_section(form, "product_name", "Termék adatok"); 
                    insert_form_section(form, "beszerzesi_ar", "Árak");
                     insert_form_section(form, "images", "Kép"); 
                }';
        $opt["add_options"]["success_msg"] = "Új termék hozzáadva!";
        $opt["edit_options"]["caption"] = "Termék módosítása";
        $opt["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'700');
        $opt["edit_options"]["topinfo"] = "Kérem adja meg a szükséges adatokat Termék módoításához<br />&nbsp;";
        $opt["edit_options"]["afterShowForm"] = 'function (form)  
                {                     
                    // insert new form section before specified field 
                    insert_form_section(form, "product_name", "Termék adatok"); 
                    insert_form_section(form, "beszerzesi_ar", "Árak");
                     insert_form_section(form, "images", "Kép"); 
                }';
        $opt["edit_options"]["success_msg"] = "Termék sikeresen módosítva!";
        $opt["height"] = "100";
        $opt["delete_options"]["success_msg"] = "Termék törölve!";
        $grid->set_options($opt);

// receive id, selected row of parent grid
        $id = intval($_GET["rowid"]);
        $type = $_GET["type"];

        $grid->select_command = "SELECT *, '$type' as 'tipus' FROM products WHERE procurement_id = $id";
        $grid->table = "products";

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
        $col["title"] = "Termék";
        $col["name"] = "product_name";
        $col["editrules"] = array("required"=>true);
        $col["editable"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Típus";
        $col["name"] = "product_type";
        $col["editable"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Beszerzési<br>státusz";
        $col["name"] = "tipus";
        $col["editable"] = false;
        $col["edittype"] = "select";
        $col["editoptions"] = array("value"=>"VJ:Vételi jegy;BSZ:Bizományosi szerződés;BSZ2:Bizományosi szerződés2");
        $col["formatter"] = "select";
        $col["formatoptions"] = array("value"=>"VJ:Vételi jegy;BSZ:Bizományosi szerződés;BSZ2:Bizományosi szerződés2");
        $cols[] = $col;

        $col = array();
        $col["title"] = "Állapot";
        $col["name"] = "allapot";
        $col["editable"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Méret";
        $col["name"] = "meret";
        $col["editable"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Kor";
        $col["name"] = "kor";
        $col["editable"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Művész";
        $col["name"] = "muvesz";
        $col["editable"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Technika";
        $col["name"] = "technika";
        $col["editable"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Beszerzési<br>ár";
        $col["name"] = "beszerzesi_ar";
        $col["editable"] = true;
        $cols[] = $col;

        $col = array();
        $col["title"] = "Ajánlott<br>ár";
        $col["name"] = "ajanlott_ar";
        $col["editable"] = true;
        $cols[] = $col;

        // file upload column
        $col = array();
        $col["title"] = "Kép";
        $col["name"] = "images";
        $col["width"] = "50";
        $col["editable"] = true;
        $col["edittype"] = "file"; // render as file
        $col["upload_dir"] = "temp"; // upload here
//        $col["editoptions"]["multiple"] = "multiple";
        $col["editrules"] = array("ifexist"=>"rename");
        $col["show"] = array("list"=>false,"edit"=>true,"add"=>true); // only show in add/edit dialog
        $cols[] = $col;

        // show pictures column
        $col = array();
        $col["title"] = "Képek";
        $col["name"] = "image";
        $col["height"] = "15";
        $col["editable"] = true;
        $col["default"] = "<a href='{images}' target='_blank'><img height=30 src='{images}'></a>";
        $col["show"] = array("list"=>true,"edit"=>false,"add"=>false); // only show in listing
        $cols[] = $col;

        $col = array();
        $col["title"] = "Termék<br>adatai";
        $col["name"] = "logo";
        $col["width"] = "200";
        $col["align"] = "left";
        $col["search"] = false;
        $col["sortable"] = false;
        $col["export"] = true;
        $buttons_html = "<a target='_blank' href='products/{id}' class='btn btn-primary'>Adatok</a>";
        $col["default"] = $buttons_html;
        $cols[] = $col;

        $grid->set_columns($cols);

        $grid->set_actions(array(
                "add"=>true, // allow/disallow add
                "edit"=>true, // allow/disallow edit
                "delete"=>true, // allow/disallow delete
                "clone"=>true, // allow/disallow clone
                "rowactions"=> false, // show/hide row wise edit/del/save option
                "autofilter" => false, // show/hide autofilter for search
                "search" => "advance" // show single/multi field search condition (e.g. simple or advance)
            )
        );

        $e["on_insert"] = array(function($data){
            $id = intval($_GET["rowid"]);
            $nowdate = date('y/m/d');
            $query = Procurement::where('id','=',$id)->first();
            $obj = json_decode($query);
            $cid = $obj->{'client_id'};
            $data["params"]["client_id"] = $cid;
            $data["params"]["procurement_id"] = $id;
            $data["params"]["client_id"] = $cid;
            $data["params"]["created_at"] = $nowdate;
            $tipus = $obj->{'type'};
            if($tipus=="VJ"){
                $data["params"]["paid"]=1;
            }
        }, null, true);
        $e["on_update"] = array(function($data){
            $nowdate = date('y/m/d');
            $data["params"]["updated_at"] = $nowdate;
        }, null, true);
        $e["on_delete"] = array(function($data){
            $rowid = $data["id"];
            $query = Product::select('images')->where('id','=',$rowid)->first();
            $obj = json_decode($query);
            $images = $obj->{'images'};
            File::delete($images);
        }, null, true);
        $grid->set_events($e);

        $out_products = $grid->render("list2");

        return view('new_product', array('out_clients' => $out_clients, 'out_products' => $out_products, 'out_invoices' => $out_invoices));
    }

    public function productIndex(){
        return view('products');
    }

    public function getProduct($id){
        $product = Product::find($id);

        return view('product', ['product'=>$product]);
    }

    public function allProductList(){
        include(app_path() . '/Classes/phpgrid/jqgrid_dist.php');

        include ('connect.php');

        $g = new \jqgrid($db_conf);
        $opt["toolbar"] = "top";
        $opt["caption"] = "Összes termék";
        $opt["shrinkToFit"] = true;
        $opt["resizable"] = true;
        $opt["height"] = "";
        $opt["multiselect"] = false;
        $opt["export"] = array("filename"=>"my-file", "sheetname"=>"test", "format"=>"pdf");
        $opt["export"]["range"] = "filtered";

        $g->set_options($opt);
        $g->select_command = "SELECT p.*, pr.type as 'tipus' FROM products p LEFT JOIN procurements pr ON p.procurement_id = pr.id";
        $g->table = "products";

        $coe = array();
        $coe["title"] = "Termék kód";
        $coe["name"] = "id";
        $coe["hidden"] = false;
        $coe["editable"] = false;
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Action";
        $coe["name"] = "act";
        $coe["width"] = "70";
        $coe["hidden"] = true;
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Termék név";
        $coe["name"] = "product_name";
        $coe["editrules"] = array("required"=>true);
        $coe["editable"] = true;
        $coe["formatter"] = "autocomplete"; // autocomplete
        $coe["formatoptions"] = array(    "sql"=>"SELECT DISTINCT product_name as v FROM products",
            "search_on"=>"concat(product_name,'-')",
            "callback"=>"fill_form");
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Termék típus";
        $coe["name"] = "product_type";
        $coe["editable"] = true;
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Beszerzési<br>státusz";
        $coe["name"] = "tipus";
        $coe["editable"] = false;
        $coe["edittype"] = "select";
        $coe["editoptions"] = array("value"=>"VJ:Vételi jegy;BSZ:Bizományosi szerződés;BSZ2:Bizományosi szerződés2");
        $coe["formatter"] = "select";
        $coe["formatoptions"] = array("value"=>"VJ:Vételi jegy;BSZ:Bizományosi szerződés;BSZ2:Bizományosi szerződés2");
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Beszerzési ár";
        $coe["name"] = "beszerzesi_ar";
        $coe["editable"] = true;
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Ajánlott ár";
        $coe["name"] = "ajanlott_ar";
        $coe["editable"] = true;
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Kifizetve";
        $coe["name"] = "paid";
        $coe["stype"] = "select";
        $coe["searchoptions"] = array("value"=>"1:fizetve;0:nincs kifizetve");
        $coe["formatter"] = "checkbox";
        $coe["formatoptions"] = array("value"=>"1:0");
        $coe["editable"] = true;
        $coe["edittype"] = "checkbox";
        $coe["editoptions"] = array("value"=>"1:0");
        $coes[] = $coe;

        $coe = array();
        $coe["title"] = "Termék<br>adatai";
        $coe["name"] = "logo";
        $coe["width"] = "100";
        $coe["align"] = "left";
        $coe["search"] = false;
        $coe["sortable"] = false;
        $coe["export"] = true;
        $buttons_html = "<a target='_blank' href='products/{id}' class='btn btn-primary'>Adatok</a>";
        $coe["default"] = $buttons_html;
        $coes[] = $coe;

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

        $out = $g->render("list1");
        return view('all_products', array('all_products_output' => $out));
    }

    public function nameAutocomplete(){
        $term = Input::get('term');

        $results = array();

        $queries = DB::table('clients')
            ->where('first_name', 'LIKE', '%'.$term.'%')
            ->orWhere('last_name', 'LIKE', '%'.$term.'%')
            ->take(5)->get();

        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->last_name.' '.$query->first_name.' '.$query->city.' '.$query->address ];
        }
        return Response::json($results);
    }
}