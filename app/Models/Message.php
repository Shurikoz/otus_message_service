<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'channel_id',
    ];

    protected $casts = [
        'user_id'    => 'integer',
        'channel_id' => 'integer',
        'text'       => 'string',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function channel(): HasOne
    {
        return $this->hasOne(Channel::class);
    }
}
