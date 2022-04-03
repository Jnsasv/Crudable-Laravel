<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_status'
    ];

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
    ];

    public $model_name ='user';

    public $model_display_name ='Usuarios';

    public $actions = [
        'create' =>true,
        'update' =>true,
        'delete' =>true,
    ];

    public $display_names = [
        'name'=>'Nombre',
        'status.name' =>'Estátus'
    ];

    public $editable_fields = [
        'name'=>'Nombre',
        'email'=>'Email',
        'password'=>'Contraseña',
        'status.name' =>'Estátus'
    ];

    public $creatable_fields =[
        'name'=>'Nombre',
        'email'=>'Email',
        'status.name' =>'Estátus'
    ];

    public $withs = ['status'];

    public $viewBag = ['status'];

    public $field_types = [
        'name'=>'text',
        'email'=>'text',
        'password'=>'text',
        'status.name'=> 'select'
    ];

    public $update_rules =[
        'name' => 'required|min:3|max:50',
        'email'  => 'required|min:3|max:50|email:rfc',
        'status'  => 'required'
    ];

    public $store_rules =[
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required','string', 'min:8', 'max:8'],
        'status'  => 'required'
    ];


    public function beforeStore (){
        $this->password = Hash::make($this->password);
        $this->email_verified_at = now();
    }

    public function afterStore()
    {
        $role = Role::find(1);
        $this->role()->attach($role);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class,'users_roles','id_user','id_role');
    }
}
