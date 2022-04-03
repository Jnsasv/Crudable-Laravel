<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AdminUserScope implements Scope{

    public function apply(Builder $builder, Model $model){
      return  $builder->whereHas('role',function($q){
            $q->where('id',1);
      });
    }

}
