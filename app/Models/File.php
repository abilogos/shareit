<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\RoutesWithFakeIds;

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
    use RoutesWithFakeIds;

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

    /**
     * this accessor method will return file_path related to storage root
     *
     * @return string file path
     */
    public function getStoragePathAttribute() : string
    {
        return 'app/shares/'.($this->id);
    }

    /**
     * this method will increase The download_count 1
     *
     * @return void
     */
    public function hitDownload() : void
    {
        $this->download_count++;
        $this->save();
    }

    /**
     * this accessor generate file link for download page
     * @return [type] [description]
     */
    public function getLinkAttribute()
    {
        return route('file.show', ['file'=>$this]);
    }
}
