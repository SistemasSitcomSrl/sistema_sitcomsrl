<x-app-layout>

</x-app-layout>
@extends('adminlte::page')

@section('title', 'Recibo Asignar')

@section('content_header')

@stop

@section('content')
    @livewire('asignar.create-asset')
@stop

