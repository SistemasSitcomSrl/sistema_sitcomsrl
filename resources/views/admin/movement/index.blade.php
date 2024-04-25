<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Lista Movimientos')

@section('content_header')
   
@stop

@section('content')
    @livewire('movimientos.show-movements') 
@stop
