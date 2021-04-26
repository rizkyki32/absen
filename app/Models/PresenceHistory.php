<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceHistory extends Model
{
    use HasFactory;
    protected $table = 'presence_history_user';
}
