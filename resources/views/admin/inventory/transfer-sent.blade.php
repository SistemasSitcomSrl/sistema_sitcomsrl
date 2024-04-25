<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Transf. Enviadas')

@section('content_header')
   
@stop

@section('content')
    @livewire('transferenciaEnviadas.show-transfer-sent') 
@stop