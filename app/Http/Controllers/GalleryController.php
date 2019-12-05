<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function viewGalleryList(){
    	return view('gallery.gallery');

    }
    public function saveGallery(Request $request){

    }
    public function viewGalleryPics(){

    }
    public function imageUpload(Request $request){

    } 
}
