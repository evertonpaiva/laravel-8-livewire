<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NavigationMenu
 *
 * @property int $id
 * @property int $sequence
 * @property string $type
 * @property string $label
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\NavigationMenuFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationMenu whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationMenu whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationMenu whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationMenu whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationMenu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NavigationMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'slug',
        'sequence',
        'type'
    ];
}
