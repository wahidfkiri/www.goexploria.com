<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaAttr extends Model
{
  protected $table = 'media_attrs';
  protected $fillable = array('attr', 'value');
  public function media() {
    return $this->belongsTo("App\Models\Media", "media_id");
  }

}
