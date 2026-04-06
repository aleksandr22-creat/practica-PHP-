<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;


class User extends Model implements IdentityInterface
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'login',
        'password'
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
        });
    }

    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function attemptIdentity(array $credentials)
    {
        return self::where(['login' => $credentials['login'],
            'password' => md5($credentials['password'])])->first();
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function isScienceOfficer()
    {
        return $this->role && $this->role->name === 'science_officer';
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login'); // перенаправляем на логин, а не на /hello
    }

    public function aspirant()
    {
        return $this->hasOne(Aspirant::class);
    }
}