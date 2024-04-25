<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Crear Herramientas')

@section('content_header')
   
@stop

@section('content')
    @livewire('solicitudCrear.create-inventory') 
@stop
