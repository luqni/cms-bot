@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="h2">Admin Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
@endsection
