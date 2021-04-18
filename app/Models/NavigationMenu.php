<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'slug',
        'sequence',
        'type',
        'icon'
    ];

    public static function getSidebarMenuItens()
    {
        return static::select('label', 'slug', 'icon')
            ->where('type', 'like', 'SidebarNav')
            ->orderBy('sequence')
            ->get();
    }
}
