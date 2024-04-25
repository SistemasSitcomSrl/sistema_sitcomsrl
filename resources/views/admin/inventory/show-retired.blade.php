<x-app-layout>

</x-app-layout>
@extends('adminlte::page')

@section('title', 'Recibo de Anulados')

@section('content_header')

@stop

@section('content')
    @livewire('solicitudRetiro.create-inventory-retired')
@stop
