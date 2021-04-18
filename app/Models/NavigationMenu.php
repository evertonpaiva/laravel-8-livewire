<?php

namespace App\Models;

use Rennokki\QueryCache\Traits\QueryCacheable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model
{
    use HasFactory;
    use QueryCacheable;

    /**
     * cache time, in seconds
     * @var int
     */
    public $cacheFor = 3600;

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'label',
        'slug',
        'sequence',
        'type',
        'icon',
        'permission'
    ];

    public static function getSidebarMenuItens()
    {
        return static::select('label', 'slug', 'icon', 'permission')
            ->where('type', 'like', 'SidebarNav')
            ->orderBy('sequence')
            ->get();
    }
}
