<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserPermission
 *
 * @property int $id
 * @property string|null $role
 * @property string|null $route_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserPermissionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role', 'route_name'
    ];

    /**
     * The list of routes when authenticated
     *
     * @return string[]
     */
    public static function routeNameList()
    {
        return [
            'navigation-menus',
            'dashboard',
            'users',
            'user-permissions',
        ];
    }

    /**
     * Checks if the current user role has access
     *
     * @param $userRole
     * @param $routeName
     * @return bool
     */
    public static function isRoleHasRightToAccess($userRole, $routeName)
    {
        try {
            $model = static::where('role', $userRole)
                ->where('route_name', $routeName)
                ->first();
            return (bool) $model;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
