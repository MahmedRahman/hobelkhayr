<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Notifaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_ids',
        'send_to_all',
        'data',
        'status',
        'sent_at'
    ];

    protected $casts = [
        'user_ids' => 'array',
        'data' => 'array',
        'send_to_all' => 'boolean',
        'sent_at' => 'datetime'
    ];

    public function users()
    {
        if ($this->send_to_all) {
            return User::where('role', 'user')->get();
        }
        return User::whereIn('id', $this->user_ids ?? [])->get();
    }
}