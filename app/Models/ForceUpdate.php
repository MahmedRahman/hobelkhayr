<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForceUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'version_number',
        'platform',
        'is_force_update',
        'is_optional_update',
        'update_description'
    ];

    protected $casts = [
        'is_force_update' => 'boolean',
        'is_optional_update' => 'boolean'
    ];
}
