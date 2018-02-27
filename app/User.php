<?php

namespace App;

use App\UserFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gd_tokens'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'gd_tokens' => 'array'
    ];

    public function files()
    {
        return $this->hasMany(UserFile::class);
    }

    public function updateFiles($files)
    {
        UserFile::truncate();
        UserFile::insert($files);

        Cache::flush();
    }
}
