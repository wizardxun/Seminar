@extends('layouts.layout')

@section('content')
 <br />
 @if(Session::has('message'))
    <div class="row">
       <div class="col-md-6 col-md-offset-3">
         <div class="alert alert-success alert-dismissable">
           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
           {{ Session::get('message') }}
       </div>
      </div>
    </div>
@endif

    <center><h4>Meine Aufträge als Absender</h4></center>
  	@if(count($auftraege)>0)
  	<table class="w3-table-all w3-hoverable">
      <tr>
        <td>ID &nbsp</td>
        <td>Empfänger &nbsp</td>
        <td>Adresse &nbsp</td>
        <td>E-Mail des Empfängers &nbsp</td>
        <td>Punkte &nbsp</td>
        <td>Datum &nbsp</td>
        <td>Auftragstatus &nbsp</td>
        <td></td>
      </tr>
  		@foreach($auftraege as $auftrag)
  		<tr>
  			<td>{{$auftrag->auftragID}} &nbsp</td>
  			<td>{{$auftrag->empfName}} &nbsp</td>
        <td>{{$auftrag->empfAdr}} &nbsp</td>
        <td>{{$auftrag->empfEmail}} &nbsp</td>
  			<td>{{$auftrag->punkte}} &nbsp</td>
        <td>{{$auftrag->created_at}} &nbsp</td>
  			@if(count($auftrag->an)>0)
           @if($auftrag->lb===0 && $auftrag->ab===0 && $auftrag->eb===0)
  			   <td>von {{$auftrag->anName}} angenommen</td>
           <td></td>
           @elseif($auftrag->lb===1 && $auftrag->ab===0 && $auftrag->eb===0)
           <td>Zustellung von {{$auftrag->anName}} (Lieferer) bestätigt </td>
           <td></td>
           @elseif($auftrag->lb===1 && $auftrag->ab===0 && $auftrag->eb===1)
           <td>Zustellung von {{$auftrag->empfName}} (Empfänger) bestätigt </td>
           <td>
             <form action="abbestaetigen" method="post">
               <input type="hidden" name= "_token" value="{{ csrf_token() }}">
               <input type="hidden" name= "auftragid" value="{{ $auftrag->auftragID }}">
               <button type = "submit">bestätigen</button>
             </form>
           </td>
           @elseif($auftrag->lb===1 && $auftrag->ab===1 && $auftrag->eb===1)
           <td>Abgeschlossen</td>
           <td></td>
           @endif
  			@else
  			<td>Auftrag noch nicht angenommen</td>
        <td></td>
  			@endif
  		</tr>
  		@endforeach
  	</table>
  	@else
    <table class="w3-table-all w3-hoverable"><td>Sie haben keinen Auftrag</td></table>
  	
  	@endif
    <br />
    <center><h4>Meine Aufträge als Lieferer</h4></center>
       @if(count($lieferauftraege)>0)
        <table class="w3-table-all w3-hoverable">
          <tr>
            <td>ID &nbsp</td>
            <td>Punkte &nbsp</td>
            <td>Absender &nbsp</td>
            <td>Abholadresse &nbsp</td>
            <td>AbholPLZ &nbsp</td>
            <td>Empfänger &nbsp</td>
            <td>Zustelladresse &nbsp</td>
            <td>ZustellPLZ &nbsp</td>
            <td>Datum</td>
            <td>Status</td>
            <td></td>
          </tr>
          @foreach($lieferauftraege as $lieferauftrag)
          <tr>
            <td>{{$lieferauftrag->auftragID}} &nbsp</td>
            <td>{{$lieferauftrag->punkte}} &nbsp</td>
            <td>{{$lieferauftrag->absName}} &nbsp</td>
            <td>{{$lieferauftrag->absAdr}} &nbsp</td>
            <td>{{$lieferauftrag->absPLZ}} &nbsp</td>
            <td>{{$lieferauftrag->empfName}} &nbsp</td>
            <td>{{$lieferauftrag->empfAdr}} &nbsp</td>
            <td>{{$lieferauftrag->empfPLZ}} &nbsp</td>
            <td>{{$lieferauftrag->created_at}} &nbsp</td>
            @if($lieferauftrag->lb===0)
            <td>laufend</td>
            <td>
              <form action="liefererbestaetigen" method="post">
                <input type="hidden" name= "_token" value="{{ csrf_token() }}">
                <input type="hidden" name= "auftragid" value="{{ $lieferauftrag->auftragID }}">
                <button type = "submit">bestätigen</button>
              </form>
            </td>
            @else
              @if($lieferauftrag->ab===0)
              <td>bestätigt</td>
              <td></td>
              @else
              <td>abgeschlossen</td>
              <td></td>
              @endif
            @endif
          </tr>
          @endforeach
        </table>
        @else
        <table class="w3-table-all w3-hoverable"><td>Zur Zeit gibt es keinen Lieferauftrag</td></table>

        @endif
@endsection