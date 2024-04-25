<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Herramientas')

@section('content_header')
   
@stop

@section('content')
    @livewire('herramientas.show-posts') 
@stop

