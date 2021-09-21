<?php

declare(strict_types=1);

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use FromHome\Cloudimg\Models\Source;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

final class User extends Authenticatable
{
    use HasApiTokens;

    use HasFactory;

    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function providers(): HasMany
    {
        return $this->hasMany(Source::class)->withoutGlobalScopes();
    }
}
