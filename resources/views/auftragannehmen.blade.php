@extends('layouts.layout')

@section('content')
     <br />
     @if(Session::has('message'))
        <div class="row">
           <div class="col-md-4 col-md-offset-3">
             <div class="alert alert-success alert-dismissable">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               {{ Session::get('message') }}
           </div>
          </div>
        </div>
    @endif
  	 
     @if(count($auftraege)>0)
      <table>
        <tr>
          <td>AuftragID &nbsp</td>
          <td>Punktevergabe &nbsp</td>
          <td>Absender &nbsp</td>
          <td>Adresse des Absenders &nbsp</td>
          <td>PLZ des Absenders &nbsp</td>
          <td>Empfänger &nbsp</td>
          <td>Adresse des Empfängers &nbsp</td>
          <td>PLZ des Empfängers &nbsp</td>
          <td>Datum</td>
        </tr>
        @foreach($auftraege as $auftrag)
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
                <button type = "submit">annehmen</button>
              </form>
          </td>
        </tr>
        @endforeach
      </table>

      @else
      Zur Zeit gibt es keinen Liefer-Auftrag.
      @endif
@endsection