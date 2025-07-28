<div>
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" type="button"
            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-colors focus:outline-none"
            :class="{
                'bg-green-100 text-green-800': @js($form->is_active),
                'bg-red-100 text-red-800': !@js($form->is_active)
            }">
            <span>{{ $form->is_active ? 'Aktif' : 'Nonaktif' }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1 transition-transform duration-200"
                :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.354a.75.75 0
                111.14.976l-4 4.7a.75.75 0 01-1.14 0l-4-4.7a.75.75 0
                01.02-1.06z" clip-rule="evenodd" />
            </svg>
        </button>
        <div x-show="open" @click.away="open = false" x-transition
            class="absolute right-0 mt-2 w-36 bg-white border rounded-lg shadow-lg z-20 overflow-hidden">
            <button wire:click="setStatus(1)" type="button"
                class="w-full text-left px-4 py-2 text-xs font-medium hover:bg-gray-100
                {{ $form->is_active ? 'bg-green-50 text-green-800' : '' }}">
                Aktif
            </button>
            <button wire:click="setStatus(0)" type="button"
                class="w-full text-left px-4 py-2 text-xs font-medium hover:bg-gray-100
                {{ !$form->is_active ? 'bg-red-50 text-red-800' : '' }}">
                Nonaktif
            </button>
        </div>
    </div>

</div>
