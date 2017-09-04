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

    <h3>Mein Auftrag als Absender</h3>
  	@if(count($auftraege)>0)
  	<table>
      <tr>
        <td>ID &nbsp</td>
        <td>Empfänger &nbsp</td>
        <td>Adresse &nbsp</td>
        <td>E-Mail des Empfängers &nbsp</td>
        <td>Punkte &nbsp</td>
        <td>Datum &nbsp</td>
        <td>Auftragstatus &nbsp</td>
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
           @elseif($auftrag->lb===1 && $auftrag->ab===0 && $auftrag->eb===0)
           <td>Zustellung von {{$auftrag->anName}} (Lieferer) bestätigt </td>
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
           @endif
  			@else
  			<td>auftrag noch nicht angenommen</td>
  			@endif
  		</tr>
  		@endforeach
  	</table>
  	@else
  	Sie haben keinen Auftrag
  	@endif

    <h3>Mein Auftrag als Lieferer</h3>
       @if(count($lieferauftraege)>0)
        <table>
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
              @else
              <td>abgeschlossen</td>
              @endif
            @endif
          </tr>
          @endforeach
        </table>
        @else
        Zur Zeit gibt es keinen Liefer-Auftrag.
        @endif
@endsection