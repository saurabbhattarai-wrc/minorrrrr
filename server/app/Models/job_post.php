<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'company_id',
    ];
    protected $primaryKey = 'job_id';
}
