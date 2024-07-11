<?php

namespace App\Models\Access;

use App\Models\User;
use App\Models\Access\Traits\RoleTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasActive;
use Nicolaslopezj\Searchable\SearchableTrait;

class Role extends Model
{
    use RoleTrait,HasActive,SearchableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    protected $searchable = [
        'columns' => [
            'roles.name' => 20, 
        ], 
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'name', 'description', 'all','created_by','updated_by'
    ];

    /**
     * The attributes that can be used for sorting with query string filtering.
     *
     * @var array
     */
    public $sortable = [
        'name', 'all', 'locked', 'created_at', 'updated_at'
    ];

    /**
     * The relationships that can be loaded with query string filtering includes.
     *
     * @var array
     */
    public $includes = [
        'users', 'permissions'
    ];

    /**
     * The users associated with the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }  

    /**
     * The permissions associated with the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }
}
