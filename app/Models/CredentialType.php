<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CredentialType extends Model
{
    use HasFactory;

    protected $table = "credentials_types";
    public $timestamps = false;
}
