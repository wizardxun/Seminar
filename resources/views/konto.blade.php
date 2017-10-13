@extends('layouts.layout')

@section('content')

<table class="w3-table-all w3-hoverable">
	<tr>
		<td>Name &nbsp</td>
		<td>{{ Auth::user()->name }}</td>
	</tr>

	<tr>
		<td>E-Mail &nbsp</td>
		<td>{{ Auth::user()->email }}</td>
	</tr>

	<tr>
		<td>Punkte &nbsp</td>
		<td>{{ Auth::user()->punkte }}</td>
	</tr>

	<tr>
		<td>Registrierungsdatum &nbsp</td>
		<td>{{ Auth::user()->created_at }}</td>
	</tr>

</table>


@endsection