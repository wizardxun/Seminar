<!doctype html>
<html lang="en">
  <head>
    <title>leafpacket</title>
         
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="
    sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  </head>

  <body >
    <br /> <br /> <br /> <br />
    <center><img src="http://localhost/seminar/logo.png" width="500" height="200"/></center>
    <br />
    <center>
        <div class="col-4">
            @if(Session::has('message'))

            <div class="alert alert-danger" role="alert"> <font size="2px" > {{ Session::get('message') }} </font> </div>

            @endif
        </div> 
    </center>
        <form action="dashboard" method="post">
             <input type="hidden" name= "_token" value="{{ csrf_token() }}">
             <center>
             <div class="col-3">
                 <input type="text" class="w3-input w3-border" name="username" placeholder="E-Mail">
                 <br />
             </div>

             <div class="col-3">
                 <input type="password" class="w3-input w3-border" name="password" placeholder="Passwort">
             </div>

             <div class="col-3">
                <br />
                <button type="submit" class="w3-button w3-green w3-block">einloggen</button>
            </div>
            </center>
        </form>
        <center>
            <div class="col-3">
                <br />
                <form action="bestaetigen" method="get">
                <button type="submit" class="w3-button w3-blue w3-block">Zustellung bestätigen</button>
                </form>
            </div>
        </center>
          
 
        <br/><center><font size="2px"color="grey">Noch kein Konto? Jetzt <a href="http://localhost:8000/register">registrieren</a>!</font></center>
  </body>
</html>