<div class="p-6 dark:bg-gray-800">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        @can('navigation-menu.create')
        <x-jet-button wire:click="createShowModal">
            {{ __('Create') }}
        </x-jet-button>
        @endcan
    </div>

    <x-loading />

    {{-- The data table --}}
    <div class="w-full overflow-hidden rounded-lg shadow-xs" wire:init="readyToLoadData">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">{{ __('Type') }}</th>
                    <th class="px-4 py-3">{{ __('Sequence') }}</th>
                    <th class="px-4 py-3">{{ __('Label') }}</th>
                    <th class="px-4 py-3">{{ __('Url') }}</th>
                    <th class="px-4 py-3">{{ __('Ícone') }}</th>
                    <th class="px-4 py-3">{{ __('Permissão') }}</th>
                    <th class="px-4 py-3">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($data as $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ $item->type }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->sequence }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->label }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <a class="text-indigo-600 hover:text-indigo-900"
                                   target="_blank"
                                   href="{{ url( $item->slug ) }}">
                                    {{ $item->slug }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <i class="{{ $item->icon }}"></i>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->permission }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    @can('navigation-menu.edit')
                                    <x-edit-icon-button wire:click="updateShowModal({{ $item->id }})" />
                                    @endcan

                                    @can('navigation-menu.delete')
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

    @if( is_object($data))
        {{ $data->links() }}
    @endif

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Navigation Menu Item') }} {{ $modelId }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="label" value="{{ __('Label') }}" />
                <x-jet-input wire:model="label" id="label" class="block mt-1 w-full" type="text" />
                <x-jet-input-error for="label" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="slug" value="{{ __('Slug') }}" />
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        http://localhost:8090/
                    </span>
                    <x-jet-input wire:model="slug" placeholder="endereço-url" />
                </div>
                <x-jet-input-error for="slug" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="sequence" value="{{ __('Sequence') }}" />
                <x-jet-input wire:model="sequence" id="sequence" type="text" />
                <x-jet-input-error for="sequence" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="type" value="{{ __('Type') }}" />
                <select wire:model="type" class="block appearance-none w-full bg-gray-100 border border-gray-200
                text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="SidebarNav">SidebarNav</option>
                    <option value="TopNav">TopNav</option>
                </select>
            </div>
            <div class="mt-4">
                <x-jet-label for="icon" value="{{ __('Ícone') }}" />
                <x-jet-input wire:model="icon" id="icon" type="text" />
                <x-jet-input-error for="icon" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="icon-preview" value="{{ __('Pré-visualização') }}" />
                <div class="ml-4 mb-2">
                    <i class="fas {{ $icon }}"></i>
                    <span class="ml-4">{{ $label }}</span>
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="permission" value="{{ __('Permissão') }}" />
                <x-jet-input wire:model="permission" id="permission" type="text" />
                <x-jet-input-error for="permission" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if ($modelId)
                @can('navigation-menu.create')
                <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-button>
                @endcan
            @else
                @can('navigation-menu.edit')
                <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-jet-button>
                @endcan
            @endif

        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Delete Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Apagar item de navegação') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza que deseja apagar esse item de navegação?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Apagar item de navegação') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>
