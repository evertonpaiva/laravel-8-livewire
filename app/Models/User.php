<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use QueryCacheable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'email',
        'containstitucional',
        'cpf',
        'idpessoa',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The list of user roles
     *
     * @return string[]
     */
    public static function userRoleList()
    {
        return [
            'Admin' => [
                'color' => 'red'
            ],
            'Usuário' => [
                'color' => 'green'
            ],
            'Perfil 3' => [
                'color' => 'blue'
            ],
            'Perfil 4' => [
                'color' => 'purple'
            ],
            'Perfil 5'  => [
                'color' => 'pink'
            ],
        ];
    }

    /**
     * Retorno a cor do perfil através de seu nome
     *
     * @param $roleName nome do perfil
     * @return string cor do perfil
     */
    public static function getColorByRoleName($roleName)
    {
        return User::userRoleList()[$roleName]['color'];
    }

    /**
     * Gera a url para imagem de perfil do usuário, através do serviço Gravatar
     *
     * @return string url da imagem no serviço gravatar
     */
    public function avatarUrl()
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($this->email)));
    }
}
