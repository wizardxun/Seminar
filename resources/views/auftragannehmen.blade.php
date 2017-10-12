@extends('layouts.layout')

@section('content')



  	 
     @if(count($sinnvolleAuftr)>0)
      <table class="w3-table-all w3-hoverable">
        <tr >
          <td>AuftragID &nbsp</td>
          <td>Punkte &nbsp</td>
          <td>Absender &nbsp</td>
          <td>Adresse des Absenders &nbsp</td>
          <td>PLZ des Absenders &nbsp</td>
          <td>Empfänger &nbsp</td>
          <td>Adresse des Empfängers &nbsp</td>
          <td>PLZ des Empfängers &nbsp</td>
          <td>Datum</td>
          <td></td>
        </tr>
        @foreach($sinnvolleAuftr as $auftrag)
        <tr>
          <td>{{$auftrag->auftragID}} &nbsp</td>
          <td>{{$auftrag->punkte}} &nbsp</td>
          <td>{{$auftrag->absName}} &nbsp</td>
          <td>{{$auftrag->absAdr}} &nbsp</td>
          <td>{{$auftrag->absPLZ}} &nbsp</td>
          <td>{{$auftrag->empfName}} &nbsp</td>
          <td>{{$auftrag->empfAdr}} &nbsp</td>
          <td>{{$auftrag->empfPLZ}} &nbsp</td>
          <td>{{$auftrag->created_at}} &nbsp</td>
          <td>
              <form action="annehmen" method="post">
                <input type="hidden" name= "_token" value="{{ csrf_token() }}">
                <input type="hidden" name= "auftragid" value="{{ $auftrag->auftragID }}">
                <input type="text" name= "zeitfenster" placeholder="Ich komme um">
                <button type = "submit">annehmen</button>
              </form>
          </td>
        </tr>
        @endforeach
      </table>

      @else
      <br />
      <center><h4>Zur Zeit gibt es keinen Lieferauftrag</h4></center>
      @endif
@endsection