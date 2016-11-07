<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use base\Model\Category;

class Item extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mu_item';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'precio', 'stock', 'category_id'];

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

    public function getCategoryIdAttribute(){
        //dd($this->attributes['category_id']);
        return $this->attributes['category_id'];
    }

    public function __toString(){
        return '[ID='.$this->id.', NOMBRE='.$this->nombre.', PRECIO='.$this->precio.', STOCK='.$this->stock.', ID DE CATEGORIA='.$this->category_id.']';
    }

}
