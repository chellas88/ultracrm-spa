<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crm extends Model
{
    use HasFactory;

    public function managers(){
        return User::where('domain', $this->domain)->get();
    }

    public function pipelines(){
        return $this->hasMany(Pipeline::class);
    }
}
