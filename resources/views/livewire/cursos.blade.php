<div class="p-6 dark:bg-gray-800">

    <x-form-title>
        Cursos
    </x-form-title>

    @include('layouts.flash-messages')

    {{-- Search --}}
    <div class="flex flex-row mt-5 mb-5">
        <div class="block text-sm">
            <div class="mb-4">
                <x-jet-label for="searchTerm" value="{{ __('Busca') }}" />
                <x-jet-input id="searchTerm" wire:model.debounce.500ms="searchTerm" wire:loading.class.delay="opacity-50" type="text" placeholder="Nome do curso" autofocus />
                <x-jet-input-error for="searchTerm" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-jet-label for="idmodalidade" value="{{ __('Modalidade') }}" />
                <select wire:model="idmodalidade" wire:loading.class.delay="opacity-50" class="block appearance-none w-full bg-gray-100 border border-gray-200
                text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="">-- Todas --</option>
                    @foreach($modalidades as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="idmodalidade" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-jet-label for="idtipocurso" value="{{ __('Tipo de Curso') }}" />
                <select wire:model="idtipocurso" wire:loading.class.delay="opacity-50" class="block appearance-none w-full bg-gray-100 border border-gray-200
                text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="">-- Todos --</option>
                    @foreach($tiposCurso as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="idtipocurso" class="mt-2" />
            </div>
        </div>
    </div>

    <x-loading />

    {{-- The data table --}}
    <div class="w-full overflow-hidden rounded-lg shadow-xs" wire:init="readyToLoadData">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Curso</th>
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">Modalidade</th>
                    <th class="px-4 py-3">Tipo de curso</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($data as $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ $item->node->curso }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->node->nome }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->node->objModalidade->modalidade }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->node->objTipoCurso->tipocurso }}
                            </td>
                        </tr>
                    @empty
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm" colspan="2">
                                {{ __('No results found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-row mt-5">
        @if($navHasPreviousPage)
        <x-button class="ml-2" wire:click="previousPage">
            {{ __('Anterior') }}
        </x-button>
        @else
        <x-disabled-button class="ml-2" wire:click="previousPage">
            {{ __('Anterior') }}
        </x-disabled-button>
        @endif

        @if($navHasNextPage)
        <x-button class="ml-2" wire:click="nextPage">
            {{ __('Pr??xima') }}
        </x-button>
        @else
        <x-disabled-button class="ml-2" wire:click="nextPage">
            {{ __('Pr??xima') }}
        </x-disabled-button>
        @endif
    </div>

</div>
