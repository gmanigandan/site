<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = ['name','phone','email','password', 'address','phone','status'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function scopeSearch($query, $keyword){
        return $query->where('name','LIKE','%'.$keyword.'%')
                    ->orWhere('phone','LIKE','%'.$keyword.'%')
                     ->orWhere('email','LIKE','%'.$keyword.'%');
    }
}
