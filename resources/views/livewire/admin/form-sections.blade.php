<div>
    <div class="space-y-6">
        @forelse ($form->sections()->orderBy('position')->get() as $section)
            <div class="rounded-lg">
                {{-- Header Section --}}
                <div class="bg-primary p-4 rounded-t-lg flex justify-between items-start gap-4">
                    <div>
                        <div class="flex items-center gap-x-2">
                            <h2 class="text-l font-bold text-neutral-50">{{ $section->title }}</h2>
                            <div class="flex items-center gap-x-1.5">
                                {{-- Tombol Naik Posisi --}}
                                @if (!$loop->first)
                                    <button wire:click="moveUpSection({{ $section->id }})" title="Naikkan Posisi"
                                        class="p-1.5 bg-gray-100 text-gray-600 rounded-full hover:bg-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                        </svg>
                                    </button>
                                @endif

                                {{-- Tombol Turun Posisi --}}
                                @if (!$loop->last)
                                    <button wire:click="moveDownSection({{ $section->id }})" title="Turunkan Posisi"
                                        class="p-1.5 bg-gray-100 text-gray-600 rounded-full hover:bg-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                @endif

                                {{-- Spacer --}}
                                @if (!$loop->first || !$loop->last)
                                    <div class="w-px h-5 bg-primary-dark"></div>
                                @endif
                                {{-- Edit Section --}}
                                <button onclick="Livewire.dispatch('editSection', { sectionId: {{ $section->id }} })"
                                    class="p-1.5 bg-yellow-100 text-yellow-600 rounded-full hover:bg-yellow-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                                {{-- Delete Section --}}
                                <button wire:click="deleteSection({{ $section->id }})"
                                    wire:confirm="Yakin ingin menghapus section ini?"
                                    class="p-1.5 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p class="text-neutral-200 mt-1 text-sm">{{ $section->description }}</p>
                    </div>
                    {{-- Tambah Pertanyaan --}}
                    <button type="button"
                        wire:click="$dispatch('openCreateQuestionModal', { sectionId: {{ $section->id }} })"
                        class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm font-semibold rounded-md hover:bg-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-4 h-4 mr-1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Pertanyaan
                    </button>
                </div>

                {{-- Daftar Pertanyaan --}}
                <div class="bg-white px-6 py-4 rounded-b-lg border-x border-b border-gray-200">
                    <div class="space-y-6">
                        @forelse ($section->questions()->orderBy('position')->get() as $question)
                            <div class="flex items-start justify-between gap-x-4 py-2">

                                {{-- Nomor, Teks Pertanyaan, dan Preview Input --}}
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <span class="font-semibold text-gray-800 mr-2">{{ $loop->iteration }}.</span>
                                        <p class="font-semibold text-gray-800">
                                            {{ $question->question_text }}</p>
                                    </div>

                                    {{-- Tipe input preview --}}
                                    <div class="ml-6 text-sm">
                                        @php
                                            $commonClasses =
                                                'w-full max-w-sm border-gray-300 rounded-md bg-gray-50 text-sm shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50';
                                            $optionClasses =
                                                'form-radio text-primary border-gray-400 bg-gray-100 focus:ring-primary/50';
                                            $checkboxClasses =
                                                'form-checkbox text-primary border-gray-400 bg-gray-100 rounded focus:ring-primary/50';
                                        @endphp

                                        @if ($question->type === 'text')
                                            <input type="text" class="{{ $commonClasses }}">
                                        @elseif ($question->type === 'textarea')
                                            <textarea rows="3" class="{{ $commonClasses }}"></textarea>
                                        @elseif ($question->type === 'dropdown')
                                            <select class="{{ $commonClasses }}">
                                                <option>Pilih salah satu...</option>
                                                @foreach ($question->options ?? [] as $opt)
                                                    <option>{{ $opt->option_text }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($question->type === 'radio')
                                            <div class="flex flex-wrap gap-4">
                                                @foreach ($question->options ?? [] as $opt)
                                                    <label class="inline-flex items-center text-gray-700">
                                                        <input type="radio" name="radio-preview-{{ $question->id }}"
                                                            class="{{ $optionClasses }}">
                                                        <span class="ml-2">{{ $opt->option_text }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @elseif($question->type === 'checkbox')
                                            <div class="flex flex-wrap gap-4">
                                                @foreach ($question->options ?? [] as $opt)
                                                    <label class="inline-flex items-center text-gray-700">
                                                        <input type="checkbox" class="{{ $checkboxClasses }}">
                                                        <span class="ml-2">{{ $opt->option_text }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Kanan: Tombol Aksi Pertanyaan (Urutan, Edit, Hapus) --}}
                                <div class="flex items-center space-x-2 flex-shrink-0">
                                    {{-- Tombol Naik Posisi --}}
                                    @if (!$loop->first)
                                        <button wire:click="moveUpQuestion({{ $question->id }})"title="Naikkan Posisi"
                                            class="p-1.5 bg-gray-100 text-gray-500 rounded-full hover:bg-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 15l7-7 7 7" />
                                            </svg>
                                        </button>
                                    @endif
                                    {{-- Tombol Turun Posisi --}}
                                    @if (!$loop->last)
                                        <button wire:click="moveDownQuestion({{ $question->id }})"
                                            title="Turunkan Posisi"
                                            class="p-1.5 bg-gray-100 text-gray-500 rounded-full hover:bg-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    @endif
                                    {{-- Tombol Edit Pertanyaan --}}
                                    <button
                                        onclick="Livewire.dispatch('openEditQuestionModal', { questionId: {{ $question->id }} })"
                                        class="p-1.5 bg-yellow-100 text-yellow-600 rounded-full hover:bg-yellow-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    {{-- Tombol Hapus Pertanyaan --}}
                                    <button wire:click="deleteQuestion({{ $question->id }})"
                                        wire:confirm="Yakin ingin menghapus pertanyaan ini?"
                                        class="p-1.5 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 italic py-4">Belum ada pertanyaan di
                                section ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <p class="text-gray-500 italic">Belum ada section yang dibuat untuk form ini.</p>
            </div>
        @endforelse
    </div>

    @if ($showSectionModal)
        {{-- Modal Tambah/Edit Section --}}
        <div class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center">
            <div class="bg-white rounded-lg w-full max-w-md p-6 z-50 shadow-lg">
                <h3 class="text-lg font-semibold mb-4">
                    {{ $isEditSection ? 'Edit Section' : 'Tambah Section' }}
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Judul Section</label>
                        <input type="text" wire:model.defer="sectionTitle"
                            class="w-full border rounded p-2 focus:outline-none focus:ring" />
                        @error('sectionTitle')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Deskripsi</label>
                        <textarea wire:model.defer="sectionDescription" class="w-full border rounded p-2 focus:outline-none focus:ring"></textarea>
                        @error('sectionDescription')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6 gap-2">
                    <button wire:click="$set('showSectionModal', false)"
                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Batal</button>
                    <button wire:click="saveSection"
                        class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    @endif
    @if ($showQuestionModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-xl rounded-lg p-6 shadow-xl">
                <h2 class="text-xl font-bold mb-4">
                    @if ($isEditQuestion)
                        Edit Pertanyaan
                    @else
                        Tambah Pertanyaan
                    @endif
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="questionText">Pertanyaan</label>
                        <input type="text" wire:model.defer="questionText" id="questionText"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                        @error('questionText')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="questionType">Tipe
                            Pertanyaan</label>
                        <select wire:model.live="questionType" id="questionType"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="radio">Radio Button</option>
                            <option value="dropdown">Dropdown</option>
                        </select>
                        @error('questionType')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (in_array($questionType, ['checkbox', 'radio', 'dropdown']))
                        <div>
                            <label class="block font-medium text-sm text-gray-700" for="questionOptions">
                                Pilihan Opsi (pisahkan dengan koma. Contoh: Opsi 1, Opsi 2)
                            </label>
                            <textarea wire:model.defer="questionOptions" id="questionOptions" rows="3"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm"></textarea>
                            @error('questionOptions')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                <div class="flex justify-end mt-6 space-x-2">
                    <button wire:click="$set('showQuestionModal', false)"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-sm">Batal</button>
                    <button wire:click="saveQuestion"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">Simpan</button>
                </div>
            </div>
        </div>
    @endif


</div>
