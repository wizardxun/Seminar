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
    /*
    Dem Nutzer alle Aufträge anzeigen, die er angelegt oder angenommen hat.
    Ruft die Daten aus Datenbank auf.
    */
    public function anzeigen()
    {
     $userid=Auth::user()->userid;
     //Die Aufträge die der Nutzer erstellt hat.
     $auftraege = auftrag::where('ag',$userid)->orderBy('ab', 'asc')->get();

     //Die Aufträge die der Nutzer angenommen hat. Die abgeschlossenen Aufträge stehen immer ganz unten.
     $lieferauftraege = auftrag::where('ag', '!=' , $userid)->where('an' , $userid)->orderBy('ab', 'asc')->get();

     //Zwei Arten von Aufträge zurück zum View liefern.
     return  View::make('auftragverwalten', compact('auftraege','lieferauftraege'));
    }




    /*
    Funktion für Auftrag anlegen. Absender gibt Lieferinformationen ein
    wie z.B. Adresse, Emfänger und zu vergebene Punkte, um einen Auftrag
    anzulegen.
    */
	public function anlegen(Request $request)
    {
     $req =$request-> all();	
     $userid=Auth::user()->userid;

     //Eingegebene Auftraginformationen in Datenbank speichern
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
     //Die Punkte von dem Nutzer abziehen
     $userpunkte=Auth::user()->punkte;
     $punkteabzug=$userpunkte-$req['punkte'];
     $user->punkte=$punkteabzug;
     $user->update();

     //Rückmeldung zum View bei der erfolgreichen Erstellung des Auftrags
    return back() ->with('message','Sie haben den Auftrag erfolgreich angelegt');

    }




    /*
    Je nach den eingegebenen Adressen des Zustellers, werden ihm nur die 
    sinnvollen Aufträge zurückgeliefert.
    Die Funktion nimmt die Adressen als Eingabe an und liefert mit Hilfe
    von einer anderen Funktion getDist() die sinnvollen Aufträge zurück.
    */
    public function liefererzeigen(Request $request)
    {

     $userid=Auth::user()->userid;

     //Holt alle Aufträge aus Datenbank, die weder angenommen noch von dem Nutzer selbst sind.
     $auftraege = auftrag::where('ag', '!=' , $userid)->whereNull('an')->get();

     //Ein Array für die Speicherung der sinnvollen Aufträge.
     $sinnvolleAuftr = array();

     //Eingabewerte in zwei Variablen speichern, um die Entfernung zu berechnen.
     $start = $request->input('start');
     $ziel = $request->input('ziel');
     $distance =  $this->getDist($start, $ziel);

     //Vergleiche alle Aufträge mit $distance, die ausgewählten Aufträge werden in $sinnvolleAuftr gespeichert.
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
     
     //Liefert die ausgewählten Aufträge zum View zurück.
     return View::make('auftragannehmen', compact('sinnvolleAuftr'));
    }




    /*
    Die Funktion berechnet mit Hilfe von Distance Matrix Dienst in Google
    Maps API die Entfernung von zwei Adressen.
    */
    public function getDist($addr, $addr2)
    {
        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=' . urlencode ( $addr ) . '&destinations=' . urlencode ( $addr2 ) . '&key=';
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = json_decode(curl_exec($ch), true);

            //Falls Google OK zurückliefert, greift die Entfernung zu.
            if($response['status'] == "OK"){
                $dist = $response['rows'][0]['elements'][0]['distance']['value'];
            }

        //Entfernung in Kilometer umrechnen und zurückliefern.
        return $dist/1000;
    }




    /*
    Der Zusteller nimmt die angezeigten Aufträge an. Zu jedem angenommenen
    Auftrag wird ein Prüfcode erstellt und in Datenbank gespeichert. Der 
    Zusteller soll eine bestimmte Zeit eingeben, wann er das Paket abholt.
    Dies wird per E-Mail dem Absender zugeschickt. 
    */
    public function annehmen(Request $request)
    {   
        $userid=Auth::user()->userid;
        $username=Auth::user()->name;
        $auftragid = $request->input('auftragid');

        //Zeiteingabe wird in $zeitfenster gepeichert.
        $zeitfenster = $request->input('zeitfenster');

        //Die NutzerID von Zusteller wird zu dem angenommenen Auftrag zugeordnet und in Datenbank gespeichert.
        $auftrag = auftrag::where('auftragID', $auftragid)->first();
        $auftrag->an = $userid;
        $auftrag->anName = $username;

        //Ein sich nicht wiederholender Prüfcode wird nach Zufallsprinzip erstellt
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

        //Speicherung in Datenbank
        $auftrag->save();

        //eine E-Mail zu dem Auftraggeber schicken
        $emailEmpfID = $auftrag->ag;
        $emailEmpf = User::where('userid', $emailEmpfID)->first();
        $to = $emailEmpf->email;
        $name = $emailEmpf->name;
        $inhalt ="Hallo " .$name.  ", \r\n\r\nDer Status Ihres Auftrags hat sich wie folgt geändert: \r\n" .$username. 
                 " hat Ihren Auftrag (AuftragID: ".$auftragid. 
                 ") angenommen. Er kommt um ".$zeitfenster." Uhr. \r\n\r\nMit freundlichen Grüßen \r\n\r\nIhr Leafpacket-Team";

        Mail::raw("$inhalt", function($message)use($to)
        {
            $message->to($to)->subject('Auftragstatus geändert');
        });

        return \Redirect::route('routeeingeben')->with('message', 'Sie haben den Auftrag erfolgreich angenommen');

    }




    /*
    In Datenbank wird bei lb(Liefererbestätigen) initial 0 gespeichert. Die Funktion 
    ändert 0 zu 1, aufgrund von dieser Zahl wird bei dem View den Auftragstatus angezeigt.
    Der Empfäger wird per Mail informiert, dass er auch bestätigen soll, dabei wird die
    Prüfcode zugeschickt.
    */
    public function liefererbestaetigen(Request $request)
    {
        $liefererName=Auth::user()->name;
        $auftragid = $request->input('auftragid');
        $auftrag = auftrag::where('auftragID', $auftragid)->first();
        $anName = $auftrag->anName;
        $code = $auftrag->code;
        $to = $auftrag->empfEmail;
        $name = $auftrag->empfName;

        //eine E-Mail für die Bestätigung dem Empfänger schicken.
        $inhalt ="Hallo " .$name.  ", \r\n\r\nSie haben vor Kurzem ein Paket von " .$anName. 
                 " bekommen. Der Lieferer ".$liefererName. " hat die Zustellung bestätigt. Bitte bestätigen Sie diese auch bei http://localhost:8000/bestaetigen mit dem Bestätigungscode: "
                 .$code. 
                 ".\r\n\r\nMit freundlichen Grüßen \r\n\r\nIhr Leafpacket-Team";
        Mail::raw("$inhalt", function($message)use($to)
        {
            $message->to($to)->subject('Bestätigen Sie die Zustellung');
        });

        //Zusteller hat bestätigt
        $auftrag->lb = '1';
        $auftrag->save();

        return back() ->with('message','Sie haben den Auftrag erfolgreich bestätigt, die Punkte werden Ihnen gutschreiben sobald der Absender aucht bestätigt hat.');
    }




    /*
    Die Funktion prüft ob der von dem Empfänger eingegebene Prüfcode mit dem in Datenbank
    gespeicherten Prüfcode übereinstimmt. 
    Eine E-Mail wird auch dem Absender zugeschickt.
    */
    public function empfbestaetigen(Request $request)
    {   
        //Eingabe des Prüfodes.
        $code = $request->input('code');

        //Suche ob der Code in Datenbank vorhanden ist.
        $auftrag = auftrag::where('code', $code)->first();

        //Prüfcode gefunden -> Empfänger bestätigt.
        if(count($auftrag)>0){
            $auftrag->eb = 1;
            $auftrag->save();
           
            //Eine E-Mail zu Absender schicken.
            $agid = $auftrag->ag;
            $auftragid = $auftrag->auftragID;
            $ag = User::where('userid', $agid)->first();
            $to = $ag->email;
            $name = $ag->name;
            $inhalt ="Hallo " .$name.  ", \r\n\r\nDer Erhalt des Pakets wird von dem Empfänger bestätigt. Bitte bestätigen Sie den Auftrag (AuftragID: " .$auftragid.
                ").\r\n\r\nMit freundlichen Grüßen \r\n\r\nIhr Leafpacket-Team";
            Mail::raw("$inhalt", function($message)use($to)
            {
                $message->to($to)->subject('Bestätigen Sie bitte den Auftrag');
            });
            return back() ->with('richtig','Danke für die Bestätigung!');
        }else{
            //Prüfcode nicht gefunden -> Dem Nutzer melden.
            return back() ->with('falsch','Der eingegebene Code ist nicht vergeben');
        }
    }




    /*
    Die Funktion ändert den Auftragstatus, schreibt dem Zusteller die Punkte gut und informiert
    den Zusteller.
    */
    public function abbestaetigen(Request $request)
    {
        $auftragid = $request->input('auftragid');
        $auftrag = auftrag::where('auftragID', $auftragid)->first();
        $auftrag->ab ='1';
        $auftrag->save();
        $punkte = $auftrag->punkte;
        $anid = $auftrag->an;

        //Dem Zusteller gutschreiben.
        $an = User::where('userid', $anid)->first();
        $punktestand = $an->punkte;
        $an->punkte = $punktestand + $punkte;
        $an->save();

        //Eine E-Mail zu Zusteller schicken.
        $to = $an->email;
        $name = $an->name;
        $inhalt ="Hallo " .$name.  ", \r\n\r\nDer Auftrag (AuftragID: " .$auftragid.
                 ") wird von dem Auftraggeber bestätigt. Sie erhalten " .$punkte. 
                 " Punkte.\r\n\r\nMit freundlichen Grüßen \r\n\r\nIhr Leafpacket-Team";

        Mail::raw("$inhalt", function($message)use($to)
        {
            $message->to($to)->subject('Auftrag abgeschlossen');
        });

        return back() ->with('message','Sie haben den Auftrag erfolgreich bestätigt.');
    }
}











































