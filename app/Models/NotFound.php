<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotFound extends Model
{
    use HasFactory;

    protected $fillable = [
        'uri',
        'count',
    ];

    public function redirection()
    {
        return $this->hasOne(Redirection::class, 'from', 'uri');
    }
}
