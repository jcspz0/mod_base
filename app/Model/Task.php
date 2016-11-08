<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mu_task';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['agent_id', 'activity_id', 'client_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];

    public function scopeFecha($query, $date)
    {
        if(trim($date) != ''){
            $query->where('created_at', 'like', '%' . $date . '%');
        }
    }

    public function agent(){
        return $this->belongsTo('\base\Model\Agent','agent_id', 'id');
    }

    public function activity(){
        return $this->belongsTo('\base\Model\Activity','activity_id', 'id');
    }

    public function client(){
        return $this->belongsTo('\base\Model\Client','client_id', 'id');
    }

    public function getDateAttribute(){
        $date = new \DateTime($this->attributes['created_at']);
        return $date->format('Y-m-d');
    }

    public function getHourAttribute(){
        $date = new \DateTime($this->attributes['created_at']);
        return $date->format('H:i');
    }
    
    public function __toString(){
        return '[ID='.$this->id.']';
    }
}
