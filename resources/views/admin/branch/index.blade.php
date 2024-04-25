<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Sucursales')

@section('content_header')
   
@stop

@section('content')
    @livewire('sucursales.show-branches') 
@stop
