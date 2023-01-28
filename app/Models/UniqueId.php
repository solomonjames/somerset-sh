<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property Carbon $created_at
 */
class UniqueId extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;
}
