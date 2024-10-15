<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;
class Permissions extends SpatiePermission
{
    use HasFactory;
    public function scopeSearch($query, $keyword){
        return $query->where('name','LIKE','%'.$keyword.'%')
                    ->orWhere('group_name','LIKE','%'.$keyword.'%');
    }
}
