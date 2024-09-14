<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupUser extends Model
{

    //use SoftDeletes;

    protected $table = 'group_user'; // Explicitly defining the table name

    protected $fillable = ['group_id', 'user_id', 'role']; // Allow mass assignment for these fields

    public $timestamps = true; // Handle timestamps if your pivot table does so

    // Define relationships if needed, for example:
    public function group()
    {
        return $this->belongsTo(GroupChat::class, 'group_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Additional methods specific to the pivot, like role-based checks, can be added here
}