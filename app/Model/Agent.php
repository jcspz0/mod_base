<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mu_agent';

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

    public function task(){
        return $this->hasMany('\base\Model\Task','agent_id', 'id');
    }

    public function __toString(){
        return '[ID='.$this->id.', NOMBRE='.$this->nombre.']';
    }
}
