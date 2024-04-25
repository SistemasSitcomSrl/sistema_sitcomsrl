<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Crear Movimiento')

@section('content_header')
   
@stop

@section('content')
    @livewire('movimientos.create-movements') 
@stop
