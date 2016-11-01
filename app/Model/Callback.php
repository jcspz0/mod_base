<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Callback extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mu_callback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['alternativeIdentifier', 'activity_history_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];

}
