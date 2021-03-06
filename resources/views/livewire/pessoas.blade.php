<div class="p-6 dark:bg-gray-800">

    <x-form-title>
        Pessoas
    </x-form-title>

    @include('layouts.flash-messages')

    {{-- Search --}}
    <div class="flex flex-row mt-5 mb-5">
        <div class="block text-sm">
            <x-jet-label for="searchTerm" value="{{ __('Busca') }}" />
            <x-jet-input id="searchTerm" wire:model.debounce.500ms="searchTerm" wire:loading.class.delay="opacity-50" type="text" placeholder="Nome" autofocus />
            <x-jet-input-error for="searchTerm" class="mt-2" />
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
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">CPF</th>
                    <th class="px-4 py-3">Conta Institucional</th>
                    <th class="px-4 py-3">Aluno</th>
                    <th class="px-4 py-3">Servidor</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($data as $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ $item->node->nome }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->node->cpf }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->node->containstitucional }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center space-x-2">
                                    @foreach($item->node->alunos->edges as $aluno)
                                        @php($cor = 'orange')
                                        <x-rounded color="{{ $cor }}" >
                                            {{ $aluno->node->matricula }}
                                        </x-rounded>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center space-x-2">
                                    @foreach($item->node->servidores->edges as $servidor)
                                        @php($cor = 'blue')
                                        <x-rounded color="{{ $cor }}" >
                                            {{ $servidor->node->idvinculo }}
                                        </x-rounded>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <x-detail-icon-button wire:click="updateShowModal({{ $item->node->idpessoa }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm" colspan="5">
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
            {{ __('Próxima') }}
        </x-button>
        @else
        <x-disabled-button class="ml-2" wire:click="nextPage">
            {{ __('Próxima') }}
        </x-disabled-button>
        @endif
    </div>

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Dados pessoais') }}
        </x-slot>

        <x-slot name="content">
            <div class="block text-sm">
                <x-jet-label for="nome" value="{{ __('Name') }}" />
                <x-jet-input wire:model="nome" id="" type="text" readonly disabled class="disabled:opacity-50" />
            </div>
            <div class="block text-sm">
                <x-jet-label for="cpf" value="{{ __('CPF') }}" />
                <x-jet-input wire:model="cpf" id="" type="text" readonly disabled class="disabled:opacity-50" />
            </div>
            <div class="block text-sm">
                <x-jet-label for="containstitucional" value="{{ __('Conta Institucional') }}" />
                <x-jet-input wire:model="containstitucional" id="" type="text" readonly disabled class="disabled:opacity-50" />
            </div>

            <!-- component -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2">
                <!-- Alunos -->
                @foreach($alunos as $aluno)
                    <x-card-aluno
                        curso="{{ $aluno->node->objPrograma->curso }}"
                        nomecurso="{{ $aluno->node->objPrograma->nomecurso }}"
                        matricula="{{ $aluno->node->matricula }}"
                        situacao="{{ $aluno->node->objSituacao->situacao }}"
                        cor="{{ $aluno->node->objSituacao->cor }}"
                    />
                @endforeach

                <!-- Servidores -->
                @foreach($servidores as $servidor)
                    <x-card-servidor
                        idvinculo="{{ $servidor->node->idvinculo }}"
                        cargo="{{ $servidor->node->cargo }}"
                        situacao="{{ $servidor->node->situacao }}"
                        cor="{{ $servidor->node->cor }}"
                    />
                @endforeach
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeUpdateModal" wire:loading.attr="disabled">
                {{ __('Fechar') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>
