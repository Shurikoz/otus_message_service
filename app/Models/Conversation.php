<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'channel_id',
    ];

    protected $casts = [
        'user_id'    => 'integer',
        'channel_id' => 'integer',
    ];

    public function channels(): HasOne
    {
        return $this->hasOne(Channel::class, 'id', 'channel_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
