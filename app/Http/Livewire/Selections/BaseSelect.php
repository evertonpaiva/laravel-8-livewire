<?php

namespace App\Http\Livewire\Selections;

use Asantibanez\LivewireSelect\LivewireSelect;

abstract class BaseSelect extends LivewireSelect
{
    public function styles()
    {
        return [
            'default' => 'p-2 rounded border w-full appearance-none',

            'searchSelectedOption' => 'p-2 rounded border w-full bg-white flex items-center',
            'searchSelectedOptionTitle' => 'w-full text-gray-900 text-left',
            'searchSelectedOptionReset' => 'h-4 w-4 text-gray-500',

            'search' => 'relative',
            'searchInput' => 'block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400'.
                'focus:outline-none focus:shadow-outline-purple'.
                'dark:text-gray-300 dark:focus:shadow-outline-gray form-input',
            'searchOptionsContainer' => 'absolute top-0 left-0 mt-12 w-full z-10',

            'searchOptionItem' => 'p-2 hover:bg-purple-700 hover:text-white cursor-pointer text-sm',
            'searchOptionItemActive' => 'bg-purple-600 text-white font-medium',
            'searchOptionItemInactive' => 'bg-purple-200 text-gray-600',

            'searchNoResults' => 'p-8 w-full bg-white border text-center text-xs text-gray-600',
        ];
    }
}
