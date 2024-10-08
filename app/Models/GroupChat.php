<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type_id',
        'create_by',
    ];


    public function service()
    {
        return $this->belongsTo(Service::class, 'type_id', 'id');
    }

}