<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'privilege_code', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function adminlte_image()
    {
        $name = str_replace(' ', '+', $this->name);
        return "https://ui-avatars.com/api/?name=$name";
    }

    public function adminlte_desc()
    {
        return $this->privilegeText() . ' <br> ' . $this->isActiveBadge();
    }

    public function adminlte_profile_url()
    {
        return route("profile.edit");
    }

    public function privilegeText()
    {
        $lookUp = LookUp::where('group_code', 'PRIV_CODE')
            ->where('key', $this->privilege_code)
            ->first();

        return $lookUp != null ? $lookUp->label : '-';
    }

    public function isActiveText()
    {
        return $this->is_active == true ? 'Aktif' : 'Non Aktif';
    }

    public function isActiveBadge()
    {
        return ($this->is_active == true) ? "<span class='badge badge-success'>" . $this->isActiveText() . "</span>" : "<span class='badge badge-danger'>" . $this->isActiveText() . "</span>";
    }
}
