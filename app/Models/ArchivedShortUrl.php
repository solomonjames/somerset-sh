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
 * @property Carbon $original_created_at
 * @property Carbon $original_updated_at
 * @property Carbon $created_at
 */
class ArchivedShortUrl extends Model
{
    use HasFactory;

    /**
     * This has been disabled since this is an archive table.
     * There should be no instance where we are updating an archived record.
     */
    public const UPDATED_AT = null;

    protected $fillable = [
        'short_code',
        'long_url',
        'unique_hits',
        'total_hits',
        'original_created_at',
        'original_updated_at'
    ];
}
