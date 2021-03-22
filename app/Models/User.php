<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatarPath() {
        $fileObj = new File();
        $file = $fileObj->find(Auth::user()->image);

        $path = '/images/default.png';
        if ( $file ) {
          $path = '/'.$file->namefilefull;
        }

        return $path;
    }
    public function listUser($id) {
      $list = DB::table('users');
      $list->leftjoin('files', 'files.id', '=', 'users.image');
      $list->where('users.id', $id);

      $listAll = $list->addSelect('users.id as id',
                                  'users.ativo as ativo',
                                  'users.name as name',
                                  'users.funcao as funcao',
                                  'users.email as email',
                                  'users.image as image',
                                  'users.type as type',
                                  'users.hide as hide',

                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull')->get();
       return $listAll->first();
    }

    public function listUsers() {
      $list = DB::table('users');
      $list->leftjoin('files', 'files.id', '=', 'users.image');
      $list->where('users.id', '<>', Auth::user()->id);

      $listAll = $list->addSelect('users.id as id',
                                  'users.ativo as ativo',
                                  'users.name as name',
                                  'users.funcao as funcao',
                                  'users.email as email',
                                  'users.image as image',
                                  'users.type as type',
                                  'users.hide as hide',

                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull')->get();
       return $listAll;
    }
}
