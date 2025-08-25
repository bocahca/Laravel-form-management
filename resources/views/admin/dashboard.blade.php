{{-- filepath: d:\Tugas\KP\project\form-management\resources\views\admin\dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Halo, {{ Auth::user()->name }}!</h1>
    </div>

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

    {{-- Pending Submissions --}}
    <livewire:admin.pending-submissions />
    <livewire:admin.submission-review-modal />

@endsection
