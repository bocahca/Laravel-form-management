{{-- filepath: d:\Tugas\KP\project\form-management\resources\views\admin\dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-bold mb-4">Selamat datang, {{ Auth::user()->name }}!</h3>
        <p>Ini adalah dashboard utama admin. Silakan pilih menu di sidebar.</p>
    </div>
@endsection
