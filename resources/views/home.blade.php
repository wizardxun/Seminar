<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    body {
  
  background: ;
}

.container {
  max-width: 500px;
  width: 100%;
  margin: 0 auto;
  position: relative;
}

#logout_form input[type="text"],
#logout_form input[type="email"],
#logout_form input[type="tel"],
#logout_form input[type="url"],
#logout_form input[type="password"],
#logout_form textarea,
#logout_form button[type="submit"] {
  ;
}

#logout_form {
  background: #F9F9F9;
  padding: 25px;
  margin: 45px;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}

#logout_form h3 {
  display: block;
  font-size: 30px;
  font-weight: 30;
  margin: 2px 0;
  margin-bottom: 10px;
  color:green;
}

#logout_form h4 {
  margin: 5px 0 15px;
  display: block;
  font-size: 13px;
  font-weight: 400;
}

fieldset {
  border: medium none !important;
  margin: 0 0 12px;
  min-width: 100%;
  padding: 0;
  width: 100%;
}

#logout_form input[type="text"],
#logout_form input[type="email"],
#logout_form input[type="tel"],
#logout_form input[type="url"],
#logout_form input[type="password"],
#logout_form textarea {
  width: 100%;
  border: 1px solid #ccc;
  background: #FFF;
  margin: 0 0 5px;
  padding: 10px;
}

#logout_form input[type="text"]:hover,
#logout_form input[type="email"]:hover,
#logout_form input[type="tel"]:hover,
#logout_form input[type="url"]:hover,
#logout_form input[type="password"],
#logout_form textarea:hover {
  -webkit-transition: border-color 0.3s ease-in-out;
  -moz-transition: border-color 0.3s ease-in-out;
  transition: border-color 0.3s ease-in-out;
  border: 1px solid #aaa;
}

#logout_form textarea {
  height: 100px;
  max-width: 100%;
  resize: none;
}

#logout_form button[type="submit"] {
  cursor: pointer;
  width: 100%;
  border: none;
  background: #4CAF50;
  color: #FFF;
  margin: 0 0 5px;
  padding: 10px;
  font-size: 15px;
}

#logout_form button[type="submit"]:hover {
  background: #43A047;
  -webkit-transition: background 0.3s ease-in-out;
  -moz-transition: background 0.3s ease-in-out;
  transition: background-color 0.3s ease-in-out;
}

#logout_form button[type="submit"]:active {
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
}

.copyright {
  text-align: center;
}

#logout_form input:focus,
#logout_form textarea:focus {
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

.half {
  float: left;
  width: 48%;
  margin-bottom: 1em;
}

.rright { width: 50%; }

.lleft {
     margin-right: 2%; 
}


@media (max-width: 480px) {
  .half {
     width: 100%; 
     float: none;
     margin-bottom: 0; 
  }
}


/* Clearfix */
.cf:before,
.cf:after {
    content: " "; /* 1 */
    display: table; /* 2 */
}

.cf:after {
    clear: both;
}
  </style>
</head>
<body>

<div class="container">
    <div class="row">

                <div class="panel-body">

                    <br />
                    <form action="/logout" method="post" id="logout_form">
                        {{ csrf_field() }}
                     <h5>Hallo {{ Auth::user()->name }}!</h5>
                     <h5>Danke für die Anmeldung!</h5>
                    <a href="#" onclick="document.getElementById('logout_form').submit()"><h5>Los geht's zum Login</h5></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>