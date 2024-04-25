<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Transf. Recibidas')

@section('content_header')
   
@stop

@section('content')
    @livewire('transferenciaRecibidas.show-transfer') 
@stop

