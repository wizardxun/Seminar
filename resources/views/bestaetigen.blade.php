<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="
    sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    body {
  
  background: ;
}

.container {
  max-width: 350px;
  width: 100%;
  margin: 200 auto;
  position: relative;
}

#bestaetigen_form input[type="text"],
#bestaetigen_form input[type="email"],
#bestaetigen_form input[type="tel"],
#bestaetigen_form input[type="url"],
#bestaetigen_form input[type="password"],
#bestaetigen_form textarea,
#bestaetigen_form button[type="submit"] {
  ;
}

#bestaetigen_form {
  background: #F9F9F9;
  padding: 20px;
  margin: 45px;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}

#bestaetigen_form h3 {
  display: block;
  font-size: 30px;
  font-weight: 30;
  margin: 2px 0;
  margin-bottom: 10px;
  color:green;
}

#bestaetigen_form h4 {
  margin: 5px 0 15px;
  display: block;
  font-size: 13px;
  font-weight: 400;
}

fieldset {
  border: medium none !important;
  margin: 0 0 6px;
  min-width: 100%;
  padding: 0;
  width: 100%;
}

#bestaetigen_form input[type="text"],
#bestaetigen_form input[type="email"],
#bestaetigen_form input[type="tel"],
#bestaetigen_form input[type="url"],
#bestaetigen_form input[type="password"],
#bestaetigen_form textarea {
  width: 100%;
  border: 1px solid #ccc;
  background: #FFF;
  margin: 0 0 5px;
  padding: 10px;
}

#bestaetigen_form input[type="text"]:hover,
#bestaetigen_form input[type="email"]:hover,
#bestaetigen_form input[type="tel"]:hover,
#bestaetigen_form input[type="url"]:hover,
#bestaetigen_form input[type="password"],
#bestaetigen_form textarea:hover {
  -webkit-transition: border-color 0.3s ease-in-out;
  -moz-transition: border-color 0.3s ease-in-out;
  transition: border-color 0.3s ease-in-out;
  border: 1px solid #aaa;
}

#bestaetigen_form textarea {
  height: 100px;
  max-width: 100%;
  resize: none;
}

#bestaetigen_form button[type="submit"] {
  cursor: pointer;
  width: 100%;
  border: none;
  background: #4CAF50;
  color: #FFF;
  margin: 0 0 5px;
  padding: 10px;
  font-size: 15px;
}

#bestaetigen_form button[type="submit"]:hover {
  background: #43A047;
  -webkit-transition: background 0.3s ease-in-out;
  -moz-transition: background 0.3s ease-in-out;
  transition: background-color 0.3s ease-in-out;
}

#bestaetigen_form button[type="submit"]:active {
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
}

.copyright {
  text-align: center;
}

#bestaetigen_form input:focus,
#bestaetigen_form textarea:focus {
  outline: 0;
  border: 1px solid #aaa;
}

::-webkit-input-placeholder {
  color: #888;
}

:-moz-placeholder {
  color: #888;
}

::-moz-placeholder {
  color: #888;
}

:-ms-input-placeholder {
  color: #888;
}
}
  </style>
</head>
<body>
   
    <div class="container">
        @if(Session::has('richtig'))
        <center>
            <div class="col-10">
                <div class="alert alert-success" role="alert"> <font size="2px" > {{ Session::get('richtig') }} </font> </div>
            </div> 
        </center>
        @endif
        @if(Session::has('falsch'))
        <center>
            <div class="col-10">
                <div class="alert alert-danger" role="alert"> <font size="2px" > {{ Session::get('falsch') }} </font> </div>
            </div> 
        </center>
        @endif
        <form id="bestaetigen_form" action="/bestaetigt" method="post">
            <input type="hidden" name= "_token" value="{{ csrf_token() }}">
            <input name="code" placeholder=" Code eingeben" type="text">
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Bestätigen</button>

        </form>
        <center><a href="http://localhost:8000">Zum Loginseite</a></center>
    </div>
     

</body>
</html>