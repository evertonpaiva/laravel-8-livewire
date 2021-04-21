<div class="p-6 dark:bg-gray-800">

    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Usuários
    </h4>

    {{-- Search --}}
    <div class="flex flex-row mt-5 mb-5">
        <div class="block text-sm">
            <x-jet-label for="searchTerm" value="{{ __('Busca') }}" />
            <x-jet-input id="searchTerm" wire:model="searchTerm" type="text" wire:model="searchTerm" placeholder="Nome, email ou conta institucional" autofocus />
            <x-jet-input-error for="searchTerm" class="mt-2" />
        </div>
    </div>

    <x-loading />

    {{-- The data table --}}
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Conta Institucional</th>
                    <th class="px-4 py-3">Perfil</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($data as $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ $item->nome }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->email }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->containstitucional }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <div class="flex items-center space-x-2">
                                    @foreach($item->getRoleNames() as $role)
                                        @php($cor = \App\Models\User::getColorByRoleName($role))
                                        <x-rounded color="{{ $cor }}" >
                                            {{ $role }}
                                        </x-rounded>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    @can('user.edit')
                                    <x-edit-icon-button wire:click="updateShowModal({{ $item->id }})" />
                                    @endcan

                                    @can('user.delete')
                                    <x-delete-icon-button wire:click="deleteShowModal({{ $item->id }})" />
                                    @endcan
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
        @if( is_object($data))
            {{ $data->links() }}
        @endif
    </div>

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Atualizar dados') }}
        </x-slot>

        <x-slot name="content">
            <div class="block text-sm">
                <x-jet-label for="nome" value="{{ __('Name') }}" />
                <x-jet-input wire:model="nome" id="" type="text" readonly disabled class="disabled:opacity-50" />
                <x-jet-input-error for="nome" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="role" value="{{ __('Role') }}" />
                <select wire:model="roleNameAdd" id="" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="">-- Selecione um perfil --</option>
                    @foreach($remainingRoles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="role" class="mt-2" />
            </div>

            <!-- Tabela de perfis do usuario -->
            <div class="mt-4">
                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Perfis do usuário - {{ $modelId }}</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @if (count($roles) > 0)
                                @foreach($roles as $role)
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex items-center space-x-2 text-sm">
                                                <x-delete-icon-button wire:click="deleteRoleShowModal({{ $modelId }}, '{{ $role }}')" />
                                                <x-rounded color="{{ \App\Models\User::getColorByRoleName($role) }}">
                                                    {{ $role }}
                                                </x-rounded>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm" colspan="5">
                                        {{ __('No Results Found') }}
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if ($modelId)
                @can('user.edit')
                <x-jet-button wire:click="update" wire:loading.attr="disabled">
                    {{ __('Adicionar') }}
                </x-jet-button>
                @endcan
            @else
                @can('user.create')
                <x-jet-button wire:click="create" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-jet-button>
                @endcan
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Delete Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Apagar usuário') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this item?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @can('user.delete')
            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Apagar usuário') }}
            </x-jet-danger-button>
            @endcan
        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Delete Role Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmRoleDeleteVisible">
        <x-slot name="title">
            Remover perfil <b>{{ $roleNameDelete }}</b> do usuário
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this item?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmRoleDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @can('user.edit')
            <x-jet-danger-button class="ml-2" wire:click="deleteRole" wire:loading.attr="disabled">
                {{ __('Remover perfil') }}
            </x-jet-danger-button>
            @endcan
        </x-slot>
    </x-jet-dialog-modal>
</div>
