<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cipherModel extends Model
{
    use HasFactory;

    protected $table = "cipher";

    public $timestamps = false;
}
