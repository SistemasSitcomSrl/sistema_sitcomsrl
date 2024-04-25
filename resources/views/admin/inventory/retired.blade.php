<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Solicitud Retiro')

@section('content_header')
   
@stop

@section('content')
@livewire('solicitudRetiro.show-inventory-retired') 
@stop

