<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $short_code
 * @property string $long_url
 * @property int    $unique_hits
 * @property int    $total_hits
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ShortUrl extends Model
{
    use HasFactory;
}
