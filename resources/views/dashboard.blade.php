@extends('layouts.layout')

@section('content')
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
    <li data-target="#myCarousel" data-slide-to="4"></li>
    <li data-target="#myCarousel" data-slide-to="5"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="http://localhost/seminar/step1.png" alt="step1">
      <div class="carousel-caption">
        <h3>Schritt 1: Paket gut einpacken</h3>
      </div>
    </div>

    <div class="item">
      <img src="http://localhost/seminar/step2.png" alt="step2">
      <div class="carousel-caption">
        <h3>Schritt 2: Bei Leafpacket Lieferauftrag anlegen</h3>
      </div>
    </div>

    <div class="item">
      <img src="http://localhost/seminar/step3.png" alt="step3">
      <div class="carousel-caption">
        <h3>Schritt 3: Das Paket dem Zulieferer übergeben</h3>
      </div>
    </div>

    <div class="item">
      <img src="http://localhost/seminar/step4.png" alt="step4">
      <div class="carousel-caption">
        <h3>Schritt 4: Der Zulieferer liefert das Paket zu</h3>
      </div>
    </div>

    <div class="item">
      <img src="http://localhost/seminar/step5.png" alt="step5">
      <div class="carousel-caption">
        <h3>Schritt 5: Das Paket wird dem Empfänger zugestellt</h3>
      </div>
    </div>

    <div class="item">
      <img src="http://localhost/seminar/step6.png" alt="step6">
      <div class="carousel-caption">
        <h3>Schritt 6: Den Auftrag wird von beiden bestätigt</h3>
      </div>
    </div>


  </div>

<!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


@endsection



