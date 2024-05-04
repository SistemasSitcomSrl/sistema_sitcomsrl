<x-app-layout>
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

@stop

@section('content')
    @livewire('trabajadores.show-workers')
@stop
