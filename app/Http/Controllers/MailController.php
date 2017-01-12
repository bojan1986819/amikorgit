<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

use Mail;
use Session;

class MailController extends Controller
{

    public function getEmailForm() {
        return view('mail');
    }

    public function postEmail(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'min:3',
            'emailname' => 'min:3',
            'message' => 'min:1']);

        $clients = Client::where('email','<>','')->groupBy('email')->pluck('email');


        foreach ($clients as $client) {
            $data = array(
                'email' => $request->email,
                'emailname' => $request->emailname,
                'subject' => $request->subject,
                'bodyMessage' => $request->message,
                'clientemail' => $client
            );
            Mail::send(['html'=>'email.email'], $data, function ($message) use ($data, $client) {
                $message->from($data['email'], $data['emailname']);
                $message->to($client)
                    ->getSwiftMessage()
                    ->getHeaders()
                    ->addTextHeader('Content-type: text/html', 'true');
                $message->subject($data['subject']);
            });
        }
        Session::flash('success', 'Email sikeresen elküldve!');

        return redirect()->route('email');
    }


}