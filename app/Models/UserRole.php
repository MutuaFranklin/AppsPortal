<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_role';

    public function user()
    {
        $this->belongsTo(User::class);
    }
    public function role()
    {
        $this->belongsTo(Role::class);
    }
}
