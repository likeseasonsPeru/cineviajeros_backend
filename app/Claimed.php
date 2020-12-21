<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claimed extends Model
{
    //
    protected $fillable = ['names','surnames','type_document', 'n_document', 'home', 'district', 'telephone', 'email', 'type_claim', 'date', 'n_ticket', 'monto', 'description'];
}
