<x-action-section>
    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-900 dark:text-gray-300">
            {{ __('Uma vez apagado, todos os seus dados serão permanentemente apagados. Antes de apagá-lo, por favor, baixe todos os seus dados ou informações que deseja reter.') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Apagar conta') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Você tem certeza que deseja apagar seu cadastro? Uma vez apagado, todos os seus dados serão permanentemente apagados. Digite sua senha para apagar seu cadastro.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="block w-3/4 mt-1" placeholder="Senha da conta institucional" x-ref="password" wire:model.defer="password" wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
