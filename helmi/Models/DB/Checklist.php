<?php

namespace Helmi\Models\DB;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    public function created_by_user(){
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updated_by_user(){
        return $this->hasOne('App\User', 'id', 'last_update_by');
    }

    public function items(){
        return $this->hasMany('Helmi\Models\DB\ChecklistItem','checklist_id','id');
    }

    protected $fillable =[
        'object_domain','object_id','description','due','urgency','created_by','last_update_by'
    ];
}
