<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Gallery;
class Image extends Model
{
   protected $fillable = ['gallery_id','file_name','file_size','file_mime','file_path','created_by','order_img'];

   public function gallery(){
   	return $this->belongsTo('App\Gallery');
   }
}
