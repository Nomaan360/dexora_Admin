<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class winnerModel extends Model
{
    use HasFactory;

    protected $table = "winner";

    public $timestamps = false;
}
