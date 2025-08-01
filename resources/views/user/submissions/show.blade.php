@extends('layouts.app')

@section('title', 'Review Jawaban: ' . $form->title)

@section('content')
    <div class="p-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-6 sm:p-8 rounded-lg shadow-sm">
                {{-- HEADER FORM --}}
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-x-3 mb-2">
                            <h1 class="text-3xl font-bold text-gray-800">{{ $form->title }}</h1>
                        </div>
                        <p class="text-gray-600 mb-4">{{ $form->description }}</p>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm">
                            <span class="text-gray-500">Dibuat: {{ $form->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-y-3 flex-shrink-0 ml-6">
                        <a href="{{ url()->previous() }}"
                            class="px-4 py-2 inline-flex items-center text-gray-700 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                {{-- REVIEW ANSWERS --}}
                <div class="mt-8 pt-8 border-t border-gray-400">
                    <div class="space-y-6">
                        @foreach ($form->sections as $section)
                            <div class="rounded-lg">
                                <div class="bg-primary p-4 rounded-t-lg flex justify-between items-start gap-4">
                                    <div>
                                        <div class="flex items-center gap-x-2">
                                            <h2 class="text-l font-bold text-neutral-50">{{ $section->title }}</h2>
                                        </div>
                                        <p class="text-neutral-200 mt-1 text-sm">{{ $section->description }}</p>
                                    </div>
                                </div>
                                <div class="bg-white px-6 py-4 rounded-b-lg border-x border-b border-gray-200">
                                    <div class="space-y-6">
                                        @foreach ($section->questions()->orderBy('position')->get() as $question)
                                            @php
                                                $answer = $submission->answers
                                                    ->where('question_id', $question->id)
                                                    ->first();
                                                // Cek untuk multi option
                                                $selectedOptions =
                                                    $answer && $answer->options
                                                        ? $answer->options->pluck('id')->all()
                                                        : [];
                                            @endphp
                                            <div class="flex items-start gap-x-4 py-2">
                                                <div class="flex-1">
                                                    <div class="flex items-center mb-3">
                                                        <span
                                                            class="font-semibold text-gray-800 mr-2">{{ $loop->iteration }}.</span>
                                                        <label class="font-semibold text-gray-800">
                                                            {{ $question->question_text }}
                                                        </label>
                                                    </div>
                                                    <div class="ml-6 text-sm">
                                                        @if ($question->type === 'text' || $question->type === 'textarea')
                                                            <input type="text" readonly
                                                                value="{{ $answer?->answer_text ?? '-' }}"
                                                                class="w-full max-w-sm border-gray-300 rounded-md bg-gray-50 text-sm shadow-sm text-gray-700" />
                                                        @elseif ($question->type === 'dropdown' || $question->type === 'radio')
                                                            <div class="flex items-center gap-x-4">
                                                                @foreach ($question->options as $opt)
                                                                    <label class="inline-flex items-center text-gray-700">
                                                                        <input
                                                                            type="{{ $question->type === 'dropdown' ? 'radio' : 'radio' }}"
                                                                            disabled
                                                                            {{ $answer && $answer->answer_text == $opt->option_text ? 'checked' : '' }}>
                                                                        <span class="ml-2">{{ $opt->option_text }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        @elseif ($question->type === 'checkbox')
                                                            <div class="flex items-center gap-x-4">
                                                                @foreach ($question->options as $opt)
                                                                    <label class="inline-flex items-center text-gray-700">
                                                                        <input type="checkbox" disabled
                                                                            {{ in_array($opt->id, $selectedOptions) ? 'checked' : '' }}>
                                                                        <span class="ml-2">{{ $opt->option_text }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
