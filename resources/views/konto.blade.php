@extends('layouts.layout')

@section('content')

<table>
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
		<td>Registierungsdatum &nbsp</td>
		<td>{{ Auth::user()->created_at }}</td>
	</tr>

</table>


@endsection