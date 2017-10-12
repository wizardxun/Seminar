<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="http://localhost/Seminar/formstyle.css"/>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="/maps/documentation/javascript/demos/demos.css">
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: gray;
      padding: 25px;
    }
    
  .carousel-inner img {
      width: 100%; /* Set width to 100% */
      margin: auto;
      min-height:200px;
  }

  /* Hide the carousel text when the screen is less than 600 pixels wide */
  @media (max-width: 600px) {
    .carousel-caption {
      display: none; 
    }
  }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse bg-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>

    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">

        <li><a href="http://localhost:8000/homepage">Home</a></li>
        <li><a href="http://localhost:8000/senden">Senden</a></li>
        <li><a href="http://localhost:8000/liefern">Liefern</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Mein Konto<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="http://localhost:8000/konto">Konto Verwalten</a></li>
                <li><a href="http://localhost:8000/auftraganzeigen">Auftrag Verwalten</a></li>
            </ul>
        </li>           
      </ul>
      <form action="/logout" method="post" id="logout_form">
      <ul class="nav navbar-nav navbar-right">
        {{ csrf_field() }}
        <li><a href="#" onclick="document.getElementById('logout_form').submit()"> <span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
      </ul>
      </form>
    </div>
  </div>
</nav>


 @yield('content')

</body>
</html>

