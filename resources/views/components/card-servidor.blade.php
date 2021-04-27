<!-- Card -->
<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
        <i class="far fa-id-card"></i>
    </div>
    <div>
        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
        {{ $cargo }}
        </p>
        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ $idvinculo }}
        </p>
        <x-rounded color="{{ $cor }}" >
            {{ $situacao }}
        </x-rounded>
    </div>
</div>
