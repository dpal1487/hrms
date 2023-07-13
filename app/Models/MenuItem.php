<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $fillable=['menu_id','title','url','target','icon_class','color','parent_id','order_by','route','parameters'];
    
    public function menu(){
        return $this->hasOne(Menu::class,'id','menu_id');
    }
    
    public function parent(){
        return $this->hasOne(MenuItem::class,'id','parent_id');
    }
}
