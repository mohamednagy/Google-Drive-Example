<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    protected $fillable = ['file_id', 'title', 'size', 'mime_type', 'download_url', 'user_id'];
}
