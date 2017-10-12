@extends('layouts.layout')

@section('content')

<br /><br /><br />
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

<form action="routeeingeben" method="post">
             <input type="hidden" name= "_token" value="{{ csrf_token() }}">
             <center>
             
             <div class="col-md-6 col-md-offset-3">
                 <input type="text" class="w3-input w3-border" name="start" placeholder="Meine Adresse">
                 <br />
             </div>

             <div class="col-md-6 col-md-offset-3">
                 <input type="text" class="w3-input w3-border" name="ziel" placeholder="Meine Zieladresse">
                 <br />
             </div>

             <div class="col-md-2 col-md-offset-5">
                <button type="submit" class="w3-button w3-green w3-block">Nach Auftrag suchen</button>
            </div>

            </center>
</form>

@endsection