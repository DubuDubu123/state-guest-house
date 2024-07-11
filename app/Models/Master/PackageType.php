<?php

namespace App\Models\Master;

use App\Models\Traits\HasActive;
use App\Models\Traits\HasActiveCompanyKey;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class PackageType extends Model
{
    //
     use HasActive,HasActiveCompanyKey;

      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'package_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','active','description','short_description','created_by', 'updated_by'];

   
    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
   
}
