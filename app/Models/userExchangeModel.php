<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userExchangeModel extends Model
{
    use HasFactory;

    protected $table = "user_exchange";

    public $timestamps = false;
}
