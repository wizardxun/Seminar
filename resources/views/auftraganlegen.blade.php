
@extends('layouts.layout')

@section('content')

<br /> <br/>
@if(Session::has('message'))
<center>
	<div class="row">
	  	<div class="col-md-6 col-md-offset-3">
	  		<div class="alert alert-success alert-dismissable">
	  		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  		  {{ Session::get('message') }}
	  	</div>
	  </div>
	</div>
	
</center>
@endif

<div class="container">  
  <form id="auftrag_form" action="/gesendet" method="post">
  	<input type="hidden" name= "_token" value="{{ csrf_token() }}">
    <h3>Ihr Paketschein</h3>
    <div class="half lleft cf">
    	<h5>Absender</h5>
	      <input name="absName" placeholder="Ihr Name" type="text" tabindex="1">
	      <input name="absPLZ" placeholder="Ihre Postleitzahl" type="text" tabindex="2" required> 
	      <input name="absAdr" placeholder="Ihre Adresse" type="text" tabindex="3" required>
	      <input name="punkte" placeholder="Punktevergabe für diesen Auftrag" type="text" tabindex="4" >
	</div>
	<div class="half rright cf">
		<h5>Empfänger</h5>
	      <input name="empfName" placeholder="Name des Empfängers" type="text" tabindex="5" >
	      <input name="empfPLZ" placeholder="Postleitzahl des Empfängers" type="text" tabindex="6" >
	      <input name="empfAdr" placeholder="Adresse des Empfängers" type="text" tabindex="7" >
		  <input name="empfEmail" placeholder="E-Mail Adresse des Empfängers" type="email" tabindex="8" >
	</div>  
	<br />
    <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Auftrag anlegen!</button>  
  </form>
</div>



@endsection