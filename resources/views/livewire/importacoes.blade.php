<div class="p-6 dark:bg-gray-800">

    <x-form-title>
        Importações
    </x-form-title>

    @include('layouts.flash-messages')

    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        @can('importacao.create')
            <x-jet-button wire:click="createShowModal">
                {{ __('Nova') }}
            </x-jet-button>
        @endcan
    </div>

    <x-loading />

    {{-- The data table --}}
    <div class="w-full overflow-hidden rounded-lg shadow-xs" wire:init="readyToLoadData">
        <div class="w-full overflow-x-auto" wire:poll.5000ms="render">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Tipo de Importação</th>
                    <th class="px-4 py-3">Processamento<br />Iniciado</th>
                    <th class="px-4 py-3">Requisições</th>
                    <th class="px-4 py-3">Registros<br />Processados</th>
                    <th class="px-4 py-3">Registros<br />Importados</th>
                    <th class="px-4 py-3">Registros<br />Ignorados</th>
                    <th class="px-4 py-3">Finalizada<br />com sucesso</th>
                    <th class="px-4 py-3">Duração<br />(em minutos)</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($data as $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ $item->id }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->model_type }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <x-rounded color="{{ $item->started ? 'green' : 'red' }}">
                                    {{ $item->started ? 'Sim' : 'Não' }}
                                </x-rounded>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->requisicoes }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->processados }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->importados }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->ignorados }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if(!is_null($item->success))
                                    <x-rounded color="{{ $item->success ? 'green' : 'red' }}">
                                        {{ $item->success ? 'Sim' : 'Não' }}
                                    </x-rounded>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->duracao }}
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
        @if( is_object($data))
            {{ $data->links() }}
        @endif
    </div>

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Nova importação') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="type" value="{{ __('Tipo de Importação') }}" />
                <select wire:model="type" class="block appearance-none w-full bg-gray-100 border border-gray-200
                text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="">-- Selecione --</option>
                    <option value="modalidade">Modalidades de Curso</option>
                    <option value="tipocurso">Tipos de Curso</option>
                    <option value="disciplina">Disciplinas</option>
                    <option value="departamento">Departamentos</option>
                </select>
                <x-jet-input-error for="type" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if ($modelId)
                @can('importacao.edit')
                    <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                        {{ __('Adicionar') }}
                    </x-jet-button>
                @endcan
            @else
                @can('importacao.create')
                    <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                        {{ __('Adicionar') }}
                    </x-jet-button>
                @endcan
            @endif

        </x-slot>
    </x-jet-dialog-modal>
</div>
