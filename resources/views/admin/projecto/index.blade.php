<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Proyectos')

@section('content_header')
   
@stop

@section('content')
    @livewire('proyectos.show-projects') 
@stop
