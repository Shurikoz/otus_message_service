<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $input)
 * @method static findOrFail($id)
 */
class Friend extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'friend_id',
    ];

    protected $casts = [
        'user_id'   => 'integer',
        'friend_id' => 'integer',
    ];
}
