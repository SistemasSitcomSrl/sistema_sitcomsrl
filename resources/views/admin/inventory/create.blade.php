<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Recibo Transferir')

@section('content_header')
   
@stop

@section('content')
    @livewire('transferenciaEnviadas.create-transfers') 
@stop
