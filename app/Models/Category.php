<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'category';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function Customer()
    {
        return $this->hasMany(Customer::class, 'category_id', 'id');
    }
}