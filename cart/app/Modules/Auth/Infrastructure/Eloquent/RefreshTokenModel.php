<?php

namespace App\Modules\Auth\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

class RefreshTokenModel extends Model
{
    protected $table = 'refresh_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'jti',
        'user_id',
        'expires_at',
        'revoked_at',
    ];
}
