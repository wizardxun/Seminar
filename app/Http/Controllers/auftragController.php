<?php

namespace App\Http\Controllers;
use App\auftrag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Mail;
use App\User;
class auftragController extends Controller
{
	public function anlegen(Request $request)
    {
     $req =$request-> all();	
     $userid=Auth::user()->userid;
     auftrag::create([
        'ag' => $userid,
        'empfEmail' => $req['empfEmail'],
        'absName' => $req['absName'],
        'punkte' => $req['punkte'],
        'absPLZ' => $req['absPLZ'],
        'absAdr' => $req['absAdr'],
        'empfName' => $req['empfName'],
        'empfPLZ' => $req['empfPLZ'],
        'empfAdr' => $req['empfAdr']
    ]);
     $user = Auth::user();
     $userpunkte=Auth::user()->punkte;
     $punkteabzug=$userpunkte-$req['punkte'];
     $user->punkte=$punkteabzug;
     $user->update();
    return back() ->with('message','Sie haben den Auftrag erfolgreich angelegt');

    }

    public function anzeigen()
    {
     $userid=Auth::user()->userid;
     $auftraege = auftrag::where('ag',$userid)->orderBy('ab', 'asc')->get();
     $lieferauftraege = auftrag::where('ag', '!=' , $userid)->where('an' , $userid)->orderBy('ab', 'asc')->get();
     return  View::make('auftragverwalten', compact('auftraege','lieferauftraege'));
    }

    public function liefererzeigen(Request $request)
    {
    // sinnvolle Auftraege anzeigen
     $userid=Auth::user()->userid;   
     $auftraege = auftrag::where('ag', '!=' , $userid)->whereNull('an')->get();
     $sinnvolleAuftr = array();
     $start = $request->input('start');
     $ziel = $request->input('ziel');

     $distance =  $this->getDist($start, $ziel);

     foreach ($auftraege as $auftrag) {
        $zz1 = $auftrag -> absAdr;
        $zz2 = $auftrag -> empfAdr;
        $umweg = $this->getDist($start, $zz1) + $this->getDist($zz1, $zz2) + $this->getDist($zz2, $ziel);
        if($distance < 10 && $umweg < 1.5 * $distance) {
            array_push($sinnvolleAuftr, $auftrag);
        } elseif ($distance < 100 && $distance >10 && $umweg < 1.3 * $distance) {
            array_push($sinnvolleAuftr, $auftrag);
        }elseif ($distance >= 100 && $umweg < 1.1 * $distance) {
            array_push($sinnvolleAuftr, $auftrag);
        }
     }
     
     return View::make('auftragannehmen', compact('sinnvolleAuftr'));
    }

    public function annehmen(Request $request)
    {   
        $userid=Auth::user()->userid;
        $username=Auth::user()->name;
        $auftragid = $request->input('auftragid');
        $zeitfenster = $request->input('zeitfenster');
        $auftrag = auftrag::where('auftragID', $auftragid)->first();
        $auftrag->an = $userid;
        $auftrag->anName = $username;
        $oldcodes = auftrag::all()->pluck('code')->toArray();
        $code = rand(100000,999999);
        a:
        foreach ($oldcodes as $oldcode) {
            if($code == $oldcode) {
                $code = rand(100000,999999);
                goto a;
            }
        }
        $auftrag->code = $code;
        $auftrag->save();

        //ein E-Mail zu dem Auftraggeber schicken
        $emailEmpfID = $auftrag->ag;
        $emailEmpf = User::where('userid', $emailEmpfID)->first();
        $to = $emailEmpf->email;
        $name = $emailEmpf->name;
        $inhalt ="Hallo " .$name.  ", \r\n\r\nIhr Auftragstatus hat die folgende Änderung: \r\n" .$username. 
                 " hat Ihren Auftrag (AuftragID: ".$auftragid. 
                 ") angenommen. Er kommt um ".$zeitfenster." Uhr. \r\n\r\nMit freundlichen Grüßen \r\n\r\nIhr Leafpacket-Team";

        Mail::raw("$inhalt", function($message)use($to)
        {
            $message->to($to)->subject('Auftragstatus geändert');
        });

        return \Redirect::route('routeeingeben')->with('message', 'Sie haben den Auftrag erfolgreich angenommen');

    }


    public function liefererbestaetigen(Request $request)
    {
        $liefererName=Auth::user()->name;
        $auftragid = $request->input('auftragid');
        $auftrag = auftrag::where('auftragID', $auftragid)->first();
        $anName = $auftrag->anName;
        $code = $auftrag->code;
        $to = $auftrag->empfEmail;
        $name = $auftrag->empfName;
        $inhalt ="Hallo " .$name.  ", \r\n\r\nSie haben vor Kurzem ein Paket von " .$anName. 
                 " bekommen. Der Lieferer ".$liefererName. " hat die Zustellung bestätigt. Bitte bestätigen Sie diese auch bei http://localhost:8000/bestaetigen mit dem Bestätigungscode: "
                 .$code. 
                 ".\r\n\r\nMit freundlichen Grüßen \r\n\r\nIhr Leafpacket-Team";

        //ein E-Mail für die Bestätigung dem Empfänger schicken 
        Mail::raw("$inhalt", function($message)use($to)
        {
            $message->to($to)->subject('Bestätigen Sie die Zustellung');
        });

        $auftrag->lb = '1';
        $auftrag->save();

        return back() ->with('message','Sie haben den Auftrag erfolgreich bestätigt, die Punkte werden Ihnen gutschreiben sobald der Absender aucht bestätigt hat.');
    }


    public function abbestaetigen(Request $request)
    {
        $auftragid = $request->input('auftragid');
        $auftrag = auftrag::where('auftragID', $auftragid)->first();
        $auftrag->ab ='1';
        $auftrag->save();
        $punkte = $auftrag->punkte;
        $anid = $auftrag->an;
        $an = User::where('userid', $anid)->first();
        $punktestand = $an->punkte;
        $an->punkte = $punktestand + $punkte;
        $an->save();

        //ein E-Mail zu Lieferer schicken
        $to = $an->email;
        $name = $an->name;
        $inhalt ="Hallo " .$name.  ", \r\n\r\nDer Auftrag (AuftragID: " .$auftragid.
                 ") wird von dem Auftraggeber bestätigt. Sie erhalten " .$punkte. 
                 "Punkte.\r\n\r\nMit freundlichen Grüßen \r\n\r\nIhr Leafpacket-Team";

        Mail::raw("$inhalt", function($message)use($to)
        {
            $message->to($to)->subject('Auftrag abgeschlossen');
        });

        return back() ->with('message','Sie haben den Auftrag erfolgreich bestätigt.');
    }

    public function empfbestaetigen(Request $request)
    {
        $code = $request->input('code');
        $auftrag = auftrag::where('code', $code)->first();
        if(count($auftrag)>0){
            $auftrag->eb = 1;
            $auftrag->save();
           
            //ein E-Mail zu Absender schicken
            $agid = $auftrag->ag;
            $auftragid = $auftrag->auftragID;
            $ag = User::where('userid', $agid)->first();
            $to = $ag->email;
            $name = $ag->name;
            $inhalt ="Hallo " .$name.  ", \r\n\r\nDen Erhalt des Pakets wird von dem Empfänger bestätigt. Bitte bestätigen Sie den Auftrag (AuftragID: " .$auftragid.
                ")\r\n\r\nMit freundlichen Grüßen \r\n\r\nIhr Leafpacket-Team";
            Mail::raw("$inhalt", function($message)use($to)
            {
                $message->to($to)->subject('Bestätigen Sie bitte den Auftrag');
            });
            return back() ->with('richtig','Danke für die Bestätigung!');
        }else{
            return back() ->with('falsch','Der eingegebene Code ist nicht vergeben');
        }
    }


    public function getDist($addr, $addr2)
    {
        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=' . urlencode ( $addr ) . '&destinations=' . urlencode ( $addr2 ) . '&key=';
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = json_decode(curl_exec($ch), true);
            //If google responds with a status of OK
            //Extract the distance text:
            if($response['status'] == "OK"){
                $dist = $response['rows'][0]['elements'][0]['distance']['value'];
            }
        return $dist/1000;
    }
}











































