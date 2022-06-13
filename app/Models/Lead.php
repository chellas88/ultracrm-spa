<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    public function contact(){
        $contact = Contact::find($this['contact_id']);
        return $contact;
    }

    public function manager(){
        return User::find($this->responsible_id);
    }
}
