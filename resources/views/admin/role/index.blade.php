<x-app-layout>
   
</x-app-layout>
@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
   
@stop

@section('content')
    @livewire('roles.show-roles') 
@stop
