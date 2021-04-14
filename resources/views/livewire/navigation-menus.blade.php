<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            {{ __('Create') }}
        </x-jet-button>
    </div>

    {{-- The data table --}}
    {{-- The data table --}}
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">{{ __('Type') }}</th>
                    <th class="px-4 py-3">{{ __('Sequence') }}</th>
                    <th class="px-4 py-3">{{ __('Label') }}</th>
                    <th class="px-4 py-3">{{ __('Url') }}</th>
                    <th class="px-4 py-3">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @if ($data->count())
                    @foreach ($data as $item)
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
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <x-edit-icon-button wire:click="updateShowModal({{ $item->id }})" />
                                    <x-delete-icon-button wire:click="deleteShowModal({{ $item->id }})" />
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

    <br />
    {{ $data->links() }}

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Navigation Menu Item') }} {{ $modelId }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="label" value="{{ __('Label') }}" />
                <x-jet-input wire:model="label" id="label" class="block mt-1 w-full" type="text" />
                @error('label') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="slug" value="{{ __('Slug') }}" />
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        http://localhost:8090/
                    </span>
                    <x-jet-input wire:model="slug" placeholder="endereço-url" />
                </div>
                @error('slug') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="sequence" value="{{ __('Sequence') }}" />
                <x-jet-input wire:model="sequence" id="sequence" type="text" />
                @error('sequence') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="type" value="{{ __('Type') }}" />
                <select wire:model="type" class="block appearance-none w-full bg-gray-100 border border-gray-200
                text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="SidebarNav">SidebarNav</option>
                    <option value="TopNav">TopNav</option>
                </select>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if ($modelId)
                <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-button>
            @else
                <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-jet-button>
            @endif

        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Delete Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Page') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this navigation item?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete Navigation Item') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>


</div>
