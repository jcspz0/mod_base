<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mu_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];

    public function scopeName($query, $name)
    {
        if(trim($name) != ''){
            $query->where('nombre', 'like', '%' . $name . '%');
        }
    }

    public function item(){
        return $this->hasMany('\base\Model\Item','category_id', 'id');
    }
}
