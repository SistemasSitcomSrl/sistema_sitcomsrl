<x-app-layout>

</x-app-layout>
@extends('adminlte::page')

@section('title', 'Solicitud Asignar')

@section('content_header')

@stop

@section('content')
    @livewire('asignar.show-asset') 
@stop
