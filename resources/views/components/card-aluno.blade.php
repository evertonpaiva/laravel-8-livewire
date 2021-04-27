<!-- Card -->
<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
        <i class="fas fa-user-graduate"></i>
    </div>
    <div>
        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
        {{ $curso }} - {{ $nomecurso }}
        </p>
        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ $matricula }}
        </p>
        <x-rounded color="{{ $cor }}" >
            {{ $situacao }}
        </x-rounded>
    </div>
</div>
