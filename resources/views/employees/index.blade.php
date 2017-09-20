@include('layouts.app')

@if($employees && $employees->count())
	{{ 'Hola' }}
@else
	{{ 'Bye' }}
@endif