<?php

namespace Helmi\Models\DB;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    public $table = 'checklistitems';

    protected $fillable =[
        'name','user_id'
    ];
}
