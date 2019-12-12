<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Image;
use Illuminate\Support\Facades\Auth;
//use Intervention\Image\Facades\Image;
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {

        $galleries = Gallery::latest()->paginate(10);
       return view('gallery.gallery',compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|unique:galleries|min:5|max:100',
        ],[ 'name.required' => 'Name of the gallary is required','name.unique'=>'This name is already taken, choose a unique name']);

        Gallery::create($request->all());
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

        $images = Image::where('gallery_id',$gallery->id)->orderByRaw('order_img = 0, order_img ASC')->get();

        
       
        return view('gallery.show',compact('gallery','images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'order_img' => 'nullable|numeric',
        ],['order_img.numeric'=>'Input Numeric value only']);
        $image = Image::findOrFail($id);
       $image->update(['order_img'=>$request->order_img]);
       return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function imageUpload(Request $request){
        /*$file = $request->file;
       
        $filename = $request->file('file')->getClientOriginalName();
        $file->move(public_path('galleryImg/images'), 'gh'); 
        $gallery = Gallery::findOrFail($request->gallery_id);
        $image = $gallery->images()->create([
            'gallery_id'=>$request->gallery_id,
            'file_name'=>$request->file->getClientOriginalName(),
            'file_size'=>$file->getClientSize(),
            'file_mime'=>$file->getClientMimeType(),
            'file_path'=>'gallery/images' . $filename,
            'created_by'=>Auth::user()->id,
        ]);*/

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
        
        
    }

    public function destroy(Gallery $gallery)
    {
         $gallery->delete();
  
        return redirect()->route('gallery.index')
                        ->with('success','Product deleted successfully');
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