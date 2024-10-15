<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use DB;
class Admin extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles;
    protected $guard = "admin";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name','username','email','password','photo','address','phone','status'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function scopeSearch($query, $keyword){
       return $query->where('id', '!=', 1)
                     ->where(function($q) use ($keyword) {
                         $q->where('name', 'LIKE', '%' . $keyword . '%')
                           ->orWhere('username', 'LIKE', '%' . $keyword . '%')
                           ->orWhere('email', 'LIKE', '%' . $keyword . '%');
                     });
    }
    public function getPhotoAttribute($value){
   
        if($value){
          
            return asset('/storage/uploads/admins/'.$value);
        }else{
            return asset('/storage/uploads/admins/default-avatar.webp');
        }
    }
    public static function getPermissionGroups(){
        return DB::table('permissions')
        ->select('group_name')
        ->groupBy('group_name')
        ->get();
    }
    public static function getPermissionByGroupName($group_name){
        return DB::table('permissions')
        ->select('name','id')
        ->where('group_name',$group_name)
        ->get();
    }
    public static function roleHasPermissions($role,$permissions){

        $hasPermission = true;
        foreach($permissions as $permission){
            if(!$role->hasPermissionTo($permission->name)){
                $hasPermission = false;
            }
        }
        return $hasPermission;

    }
}
