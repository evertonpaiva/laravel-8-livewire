<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            {{ __('Create') }}
        </x-jet-button>
    </div>

    {{-- The data table --}}
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">{{__('Role')}}</th>
                    <th class="px-4 py-3">{{__('Route Name')}}</th>
                    <th class="px-4 py-3">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @if ($data->count())
                    @foreach ($data as $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ $item->role }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->route_name }}
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
                        <td class="px-4 py-3 text-sm" colspan="4">
                            {{ __('No Results Found') }}
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
    {{ $data->links() }}
    </div>

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Save User Permission') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="role" value="{{ __('Role') }}" />
                <select wire:model="role" id="" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="">-- {{ __('Select a Role') }} --</option>
                    @foreach(\App\Models\User::userRoleList() as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('role') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="routeName" value="{{ __('Route Name') }}" />
                <select wire:model="routeName" id="" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="">-- {{ __('Select a Route') }} --</option>
                    @foreach(\App\Models\UserPermission::routeNameList() as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
                @error('routeName') <span class="error">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if ($modelId)
                <x-jet-button wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-button>
            @else
                <x-jet-button wire:click="create" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Delete Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Permission') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this item?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete Item') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
