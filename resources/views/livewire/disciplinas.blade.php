<div class="p-6 dark:bg-gray-800">

    <x-form-title>
        Disciplinas
    </x-form-title>

    @include('layouts.flash-messages')

    {{-- Search --}}
    <div class="flex flex-row mt-5 mb-5">
        <div class="block text-sm">
            <div class="mb-4">
                <x-jet-label for="searchTerm" value="{{ __('Busca') }}" />
                <x-jet-input id="searchTerm" wire:model.debounce.500ms="searchTerm" wire:loading.class.delay="opacity-50" type="text" placeholder="Nome da disciplina" autofocus />
                <x-jet-input-error for="searchTerm" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-jet-label for="iddepto" value="{{ __('Departamento') }}" />
                <select wire:model="iddepto" wire:loading.class.delay="opacity-50" class="block appearance-none w-full bg-gray-100 border border-gray-200
                text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="">-- Todos --</option>
                    @foreach($departamentos as $departamento)
                        <option value="{{ $departamento['iddepto'] }}">{{ $departamento['nome'] }} ({{ $departamento['depto'] }})</option>
                    @endforeach
                </select>
                <x-jet-input-error for="iddepto" class="mt-2" />
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
                    <th class="px-4 py-3">Disciplina</th>
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">Departamento</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($data as $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ $item->disciplina }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->nome }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->departamento->nome }}
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
        @if( is_object($data))
            {{ $data->links() }}
        @endif
    </div>

</div>
