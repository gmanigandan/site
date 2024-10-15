<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    public function scopeSearch($query, $keyword){
        return $query->where('name','!=','Super Admin')->where('name','LIKE','%'.$keyword.'%');
    }
}
