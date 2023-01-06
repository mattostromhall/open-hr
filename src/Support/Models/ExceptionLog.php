<?php

namespace Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Concerns\Unguarded;

class ExceptionLog extends Model
{
    use HasFactory;
    use Unguarded;
}
