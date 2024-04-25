<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Solicitud Crear')

@section('content_header')
   
@stop

@section('content')
    @livewire('solicitudCrear.show-inventory-transfer') 
@stop

