<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_no',
        'student_name',
        'issue_date',
        'expire_date',
        'qualification',
        'accredited_by',
    ];
}
