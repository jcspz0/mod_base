<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mu_client';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'razon_social', 'latitud', 'longitud'];

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

    public function category(){
        return $this->belongsTo('\base\Model\Category','category_id', 'id');
    }

    public function __toString(){
        return '[ID='.$this->id.', NOMBRE='.$this->nombre.', RAZON SOCIAL='.$this->razon_social.', LATITUD='.$this->latitud.', LONGITUD='.$this->longiud.']';
    }

}
