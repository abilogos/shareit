<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * File Model is a DataModel for Storing File Relaed data into database.
 *
 * The Actual File will be save in /storage/app/{$file_id} and a refrence for file metadata
 * will be save in database. the metadata included creation time/ real full file name (+extention)/
 */
class File extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     *  mass assignment attriutes
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'download_count' => 0,
    ];

    /**
     * This function will return The User who is files owner
     *
     * @return BelongsTo related user
     */
    public function user() :BelongsTo
    {
        return $this->belogsTo(\App\Models\User::class);
    }
}
