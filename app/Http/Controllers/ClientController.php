<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Client;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Blog;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;


class ClientController extends Controller
{
    public function postAddClient(Request $request)
    {
        return redirect()->route('users');
    }

    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        if (Auth::check()) {

            include(app_path() . '/Classes/phpgrid/jqgrid_dist.php');

            // Database config file to be passed in phpgrid constructor
//            $db_conf = array(
//                "type" => 'mysqli',
//                "server" => 'localhost',
//                "user" => 'admin',
//                "password" => 'admin',
//                "database" => 'laravel'
//            );
            include ('connect.php');

            $g = new \jqgrid($db_conf);

            $opt["caption"] = "Kliensek";
            $opt["height"] = "300";
            $opt["width"] = "1000";
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


            $col = array();
            $col["title"] = "Id";
            $col["name"] = "id";
            $col["hidden"] = true;
            $cols[] = $col;

            $col = array();
            $col["title"] = "Action";
            $col["name"] = "act";
            $col["width"] = "70";
            $cols[] = $col;

            $col = array();
            $col["title"] = "Név";
            $col["name"] = "client_name";
            $col["editable"] = true;
            $col["editrules"] = array("required"=>true);
            $cols[] = $col;

            $col = array();
            $col["title"] = "Cég név";
            $col["name"] = "company_name";
            $col["editable"] = true;
            $cols[] = $col;

            $col = array();
            $col["title"] = "Típus";
            $col["name"] = "type";
            $col["editable"] = true;
            $col["editrules"] = array("required"=>true);
            $col["edittype"] = "select";
            $col["editoptions"] = array("value"=>"beszállító:beszállító;vevő:vevő;restaurátor:restaurátor;bizományos:bizományos");
            $cols[] = $col;

            $col = array();
            $col["title"] = "Érdeklődési kör";
            $col["name"] = "interest";
            $col["editable"] = true;
            $col["editoptions"] = array("size"=>20); // with default display of textbox with size 20
            $col["editoptions"]["dataInit"] = 'function(el){ setTimeout(function(){          
                                                                                // remove nbsp from start 
                                                                                if (jQuery(".FormGrid:visible").length) $(el)[0].parentNode.firstChild.remove(); 
                                                                                         
                                                                                $("input[name=interest]").tagit({ 
                                                                                            availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"] 
                                                                                        }); },200); }';
            $cols[] = $col;

            $col = array();
            $col["title"] = "Telefon";
            $col["name"] = "phone_nr";
            $col["editable"] = true;
            $cols[] = $col;

            $col = array();
            $col["title"] = "Fax";
            $col["name"] = "fax_nr";
            $col["editable"] = true;
            $cols[] = $col;

            $col = array();
            $col["title"] = "Email";
            $col["name"] = "email";
            $col["editable"] = true;
            $cols[] = $col;

            $col = array();
            $col["title"] = "Irányítószám";
            $col["name"] = "postal_code";
            $col["editable"] = true;
            $col["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false, "bulkedit"=>false);
            $cols[] = $col;

            $col = array();
            $col["title"] = "Város";
            $col["name"] = "city";
            $col["editable"] = true;
            $col["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false, "bulkedit"=>false);
            $cols[] = $col;

            $col = array();
            $col["title"] = "Cím";
            $col["name"] = "address";
            $col["editable"] = true;
            $col["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false, "bulkedit"=>false);
            $cols[] = $col;

            $col = array();
            $col["title"] = "Cím";
            $col["name"] = "calcaddress";
            $col["editable"] = false;
            $col["show"] = array("list"=>true, "add"=>false, "edit"=>false, "view"=>true, "bulkedit"=>false);
            $cols[] = $col;

            $e["on_data_display"] = array(function($data){
                foreach($data["params"] as &$d)
                {
                    $d["calcaddress"] = $d["postal_code"] . " {$d["city"]}". " {$d["address"]}";
                }
            }, null, true);
            $g->set_events($e);


            $g->table = "clients";

            $g->set_columns($cols);

            $g->set_actions(array(
                    "delete"=>true, // allow/disallow delete
                    "rowactions"=>true, // show/hide row wise edit/del/save option
                    "export"=>true, // show/hide export to excel option
                    "autofilter" => true, // show/hide autofilter for search
                    "search" => "advance", // show single/multi field search condition (e.g. simple or advance)
                )
            );



            $out = $g->render("list1");
            $i = "grid.locale-hu.js";

            return view('clients', array('phpgrid_output' => $out, 'json_output' => $g->options["edit_options"]));
        }
        return redirect()->route('home');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $clients = Client::orderBy('id', 'asc')->get();
        return Datatables::of($clients)
            ->addColumn('action', function ($client) {
                return '<a href="#edit-'.$client->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }
    public function getAddEditRemoveColumn()
    {
        return view('datatables.eloquent.add-edit-remove-column');
    }

    /*innen kezdődnek a CRUD verzióhoz szükséges dolgok*/

    public function index(){
/*        // we need to show all data from "blog" table
        $clients = Client::all();
        // show data to our view
        return view('clients2',['clients' => $clients]);*/

        $search = \Request::get('search');
        $clients = Client::where('client_name','like', '%'.$search.'%')->orderBy('id')->paginate('3');
        return view('clients2',['clients' => $clients]);
    }

    // edit data function
    public function editItem(Request $req) {
        $client = Client::find ($req->id);
        $client->client_name = $req->client_name;
        $client->company_name = $req->company_name;
        $client->save();
        return response()->json($client);
    }

    // add data into database
    public function addItem(Request $req) {
        $rules = array(
            'client_name' => 'required'
        );
        // for Validator
        $validator = Validator::make ( Input::all (), $rules );
        if ($validator->fails())
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));

        else {
            $client = new Client();
            $client->client_name = $req->client_name;
            $client->company_name = $req->company_name;
            $client->save();
            return response()->json($client);
        }
    }
    // delete item
    public function deleteItem(Request $req) {
        Client::find($req->id)->delete();
        return response()->json();
    }


    public function searchClient(Request $request){
        if($request->ajax())
        {
            $output="";
            $clients=Client::where('client_name','LIKE','%'.$request->search2.'%')
                ->orWhere('company_name','LIKE','%'.$request->search2.'%')->get();

            if($clients){
                foreach ($clients as $key =>$client){
                    $output.='<tr>'.
                        '<td>'.$client->id.'</td>'.
                        '<td>'.$client->client_name.'</td>'.
                        '<td>'.$client->company_name.'</td>'.
                        '</tr>';
                }
                return Response($output);
            }
        }
    }

}