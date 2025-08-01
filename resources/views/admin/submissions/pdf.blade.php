<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $form->title }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #1f2937;
            font-size: 12px;
        }

        .page-container {
            padding: 20px;
        }

        .stamp-image {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 120px;
            opacity: 0.9;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 4px;
        }

        h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        p {
            margin: 4px 0;
        }

        .section {
            margin-top: 25px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }

        .section-header {
            background-color: #1E40AF;
            color: white;
            padding: 12px 16px;
        }

        .section-description {
            font-size: 11px;
            margin-top: 4px;
            color: #dbeafe;
        }

        .section-content {
            padding: 16px;
            background-color: #ffffff;
        }

        .question-block {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .question-label {
            font-weight: bold;
            margin-bottom: 8px;
        }

        .answer {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            padding: 10px 14px;
            border-radius: 6px;
        }

        .option-list {}

        .option-list label {
            display: inline-block;
            padding: 5px 0;
        }

        .option-list input {
            vertical-align: middle;
            margin-right: 4px;
            margin-left: 4px;
        }

        .meta-info {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }
    </style>
</head>

<body>
    <div class="page-container" style="position: relative;">
        @if (!empty($stampPath))
            <img src="{{ $stampPath }}" alt="Approved Stamp" class="stamp-image">
        @endif
        {{-- HEADER FORM --}}
        <h1>{{ $form->title }}</h1>
        <p>{{ $form->description }}</p>
        <p class="meta-info">Tanggal Submit: {{ $submission->created_at->format('d/m/y') }}</p>
        <p class="meta-info">User: {{ $submission->user->name }}</p>

        @foreach ($form->sections as $section)
            <div class="section">
                <div class="section-header">
                    <h2>{{ $section->title }}</h2>
                    @if ($section->description)
                        <p class="section-description">{{ $section->description }}</p>
                    @endif
                </div>
                <div class="section-content">
                    @foreach ($section->questions()->orderBy('position')->get() as $question)
                        @php
                            $answer = $submission->answers->where('question_id', $question->id)->first();

                            $selectedOptionIds = $answer?->options?->pluck('id')->all() ?? [];
                        @endphp

                        <div class="question-block">
                            <div class="question-label">
                                {{ $loop->parent->iteration }}.{{ $loop->iteration }}. {{ $question->question_text }}
                            </div>

                            @if ($question->type === 'text' || $question->type === 'textarea')
                                <div class="answer">
                                    {{ $answer?->answer_text ?? '-' }}
                                </div>
                            @elseif ($question->type === 'dropdown')
                                <div class="answer">
                                    {{ $answer?->answer_text ?? '-' }}
                                </div>
                            @elseif ($question->type === 'radio' || $question->type === 'checkbox')
                                <div class="answer">
                                    <div class="option-list">
                                        @foreach ($question->options as $opt)
                                            <label>
                                                @if ($question->type === 'checkbox')
                                                    <input type="checkbox" disabled
                                                        {{ in_array($opt->id, $selectedOptionIds) ? 'checked' : '' }}>
                                                @else
                                                    <input type="radio" disabled
                                                        {{ $answer && $answer->answer_text == $opt->option_text ? 'checked' : '' }}>
                                                @endif
                                                {{ $opt->option_text }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
