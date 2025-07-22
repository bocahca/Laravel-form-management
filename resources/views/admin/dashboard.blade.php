{{-- filepath: d:\Tugas\KP\project\form-management\resources\views\admin\dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- Statistik --}}
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500 font-medium">Total Forms</div>
            <div class="mt-2 text-3xl font-semibold text-primary">{{ $formsCount }}</div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500 font-medium">Pending Submissions</div>
            <div class="mt-2 text-3xl font-semibold text-secondary">{{ $pendingCount }}</div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500 font-medium">Total Submissions</div>
            <div class="mt-2 text-3xl font-semibold text-accent">{{ $totalSubmissions }}</div>
        </div>
    </div>

    {{-- TODO: Daftar Form (statis dulu, besok kita dinamis tambahkan pagination) --}}
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-lg font-medium text-gray-700 mb-4">Daftar Form</h2>
        {{-- nanti loop $forms --}}
        <p class="text-gray-500">Belum ada form untuk ditampilkan.</p>
    </div>
@endsection
