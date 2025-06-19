<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $fillable = [
        'method', 'endpoint', 'payload', 'status_code', 'response',
    ];

    protected $casts = [
        'payload' => 'array',
        'response' => 'array',
    ];
}
