<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
class GalleryController extends Controller
{
    public function viewGalleryList(){
    	$galleries = Gallery::all();

    	return view('gallery.gallery',compact('galleries'));

    }
    public function saveGallery(Request $request){

    	$gallery = new Gallery;

    	$gallery->name = $request->gallery_name;
    	$gallery->created_by = 1;
    	$gallery->published= 1;
    	$gallery->save();

    	return redirect()->back();

    }
    public function viewGalleryPics(){

    }
    public function imageUpload(Request $request){

    } 
}
