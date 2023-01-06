<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Model implements AuthenticatableContract,JWTSubject
{
    use Authenticatable;
    public $timestamps = false;
    // define table
    protected $table = 'tb_member';
    // define primary key
    protected $primaryKey = 'member_id';
    // define field
    protected $fillable = ['member_email','member_nama','member_alamat','member_nohp','member_group','point','member_foto','member_aktif','member_hapus','member_status'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
