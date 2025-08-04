@extends('layouts.app')

@section('title', 'Review Submissions')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
       <livewire:user.submissions-list />
    </div>
@endsection
