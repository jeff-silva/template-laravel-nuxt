<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\ModelTrait;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class AppUser extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, ModelTrait;

    protected $table = 'app_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function schemaFields()
    {
        return [
            'id' => fn($table) => $table->id(),
            'name' => fn($table, $field) => $table->string($field, 255)->nullable(),
            'email' => fn($table, $field) => $table->string($field, 255)->nullable(),
            'password' => fn($table, $field) => $table->string($field, 255)->nullable(),
            'email_verified_at' => fn($table, $field) => $table->dateTime($field)->nullable(),
            'created_at' => fn($table, $field) => $table->dateTime($field)->nullable(),
            'updated_at' => fn($table, $field) => $table->dateTime($field)->nullable(),
            'deleted_at' => fn($table, $field) => $table->dateTime($field)->nullable(),
        ];
    }

    public function schemaSeed()
    {
        $user = self::firstOrNew([ 'id' => 1 ]);
        $user->name = 'Main User';
        $user->email = 'main@grr.la';
        $user->password = Hash::make('main@grr.la');
        $user->save();
    }
}
