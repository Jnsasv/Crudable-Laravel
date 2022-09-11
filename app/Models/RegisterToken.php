<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Env;

class   RegisterToken extends Model
{
    use HasFactory;

    public $model_display_name ='register_token';
    public $table ='register_token';

    protected $fillable = [
        'code',
        'id_user',
        'due_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,"id_user","id");
    }

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $code = rand(0,9999);
            $query->code = $code<10?"000".$code:($code<100?"00".$code:($code<1000?"0".$code:$code));
            $query->due_date = now()->addMinutes(Env("REGISTER_TOKEN_DUE_TIME",10));

        });
    }
}
