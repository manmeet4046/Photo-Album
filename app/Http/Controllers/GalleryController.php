<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Image;
use Illuminate\Support\Facades\Auth;
use File;
use Validator;
//use Image;
//use Intervention\Image\Facades\Image;
class GalleryController extends Controller
{
    
    public function __construct(){ // for login auth
        $this->middleware('auth');
    }

    public function index()
    {

        $galleries = Gallery::latest()->paginate(10);
       return view('gallery.gallery',compact('galleries'));
    }

  

    public function create()
    {
        //
    }

public function slideshow(Gallery $gallery){
  // foreach($gallery->images as $gall){
  //   dd($gall->file_name);
  // }
  

   
  // $albumname = $gallery->name;
    return view('gallery.slideshow',compact('gallery'));
   }
    public function store(Request $request)
    {

       $validate= $request->validate(
            [
                'name' => 'required|unique:galleries|min:5|max:100',
                'image_path'=>'required|mimes:jpeg,png,jpg,gif|max:1028|dimensions:max_width=200,max_height=200',
            ],
            [   // for custom Validation Msg
                'name.required' => 'Name of the gallary is required',
                'name.unique'=>'This name is already taken, choose a unique name',
                'image_path.dimensions'=>'Image dimensions should be 200 X 200 '
            ]);

        $photos = $request->file('image_path');
        $save_name = 'gallery_img_'.$photos->getClientOriginalName();
        $photos->move(public_path('galleryCoverImgs/'.$request->name), $save_name);
        $path= '/galleryCoverImgs/'.$request->name.'/'.$save_name ;

        Gallery::create(array_merge($validate,['image_path'=>$path]));
        return redirect('/gallery?page=1');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //dd($gallery->id);

        $images = Image::where('gallery_id',$gallery->id)
            ->orderByRaw('order_img = 0, order_img ASC')->get();

        return view('gallery.show',compact('gallery','images'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
         $request->validate(
            [
            'order_img' => 'nullable|numeric',
            ],
            ['order_img.numeric'=>'Input Numeric value only']);

        $image = Image::findOrFail($id);
        $image->update(['order_img'=>$request->order_img]);
        return redirect()->back();
    }



    public function imageUpload(Request $request){

        $gallery = Gallery::findOrFail($request->gallery_id);
        $photos = $request->file('file');
        $save_name = $photos->getClientOriginalName();
       
        $photos->move(public_path('galleryImg/'.$gallery->name), $save_name);
        

         $image = $gallery->images()->create([
            'gallery_id'=>$request->gallery_id,
            'file_name'=> $save_name,
            'file_size'=>'343',
            'file_mime'=>$photos->getClientMimeType(),
            'file_path'=>'/galleryImg/' . $gallery->name .'/'. $save_name,
            'created_by'=>Auth()->user()->id,
        ]);

        return "uploaded";
        
        
    }

    public function destroy(Gallery $gallery)
    {
         
       

foreach($gallery->images as $image){

   $image_path = public_path().$image->file_path;

   if(file_exists($image_path)) {
    unlink($image_path);
    
    
     }
    
    }

    $galleryImgPath = public_path().$gallery->image_path;
    if(file_exists($galleryImgPath)) {
    unlink($galleryImgPath);
    
     }

    $gallery->images()->delete(); // Delete inside image table
    $rem = public_path('/galleryImg/'.$gallery->name);
    $remGalleryImg = public_path('/galleryCoverImgs/'.$gallery->name);
    $gallery->delete();
    if(is_dir($rem)) { // For exception handling Dir not found
     rmdir($rem);
    }
    if(is_dir($remGalleryImg)) { // For exception handling Dir not found
     rmdir( $remGalleryImg);
    }

    return  redirect()->back()->with('success', 'The Gallery Folder along with the associated images have been deleted Successfully! '); 
   
    }

    public function destroyImage(Image $image ,$id)
    {

        $image=Image::findOrFail($id);

        $image->delete($image->id);
       
        
        $path=public_path().$image->file_path;
        
        if (file_exists($path)) {
            unlink($path);
        }
        return redirect()->back()->with('success', 'The selected Image has been deleted  from db and  the local folder!'); 
    }
}
