<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'single_name',
        'description',
        'short_description',
        'link',
        'display_image',
        'internal',
        'external',
        'internal_users_no',
        'external_users_no',
        'lead_dev',
        'release_date',
        'status_id',
        'published_by',
        'registered_by',
        'updated_by',
        'deleted_by',
    ];

    public function leadDeveloper()
    {
        return $this->belongsTo(User::class, 'lead_dev');
    }
    

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    

    public function developers()
    {
        return $this->belongsToMany(User::class, 'application_dev',
            'application_id', 'user_id');
    }
}
