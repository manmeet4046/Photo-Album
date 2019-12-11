@extends('master')
@section('content')
<style>.roww {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
}

/* Create two equal columns that sits next to each other */
.column {
  flex: 50%;
  padding: 0 4px;
}

.column img {
  margin-top: 8px;
  vertical-align: middle;
}
</style>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> View Gallery</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-xs" href="{{ route('gallery.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $gallery->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Details:</strong>
                {{ $gallery->published }}
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-8 text-right">
         <form method="post" action="{{url('image/upload')}}" 
                  class="dropzone" id="dropzone" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <input type="hidden" name="gallery_id" value={{$gallery->id}}>
   
</form>   
        </div>
    </div>

  <div class="row">   <div class="col-md-12">
            @foreach($images as $image)
            

              
               <form>    
 
           <img src="{{$image->file_path}}" class="" width="200">
          
          <br/>
           <input type="" name="" class="input-group-prepend" value="{{$image->order_img}}">
           <input class="btn btn-xs btn-primary  .input-group-prepend" type="submit" name="" value="Change Order">
</form>
            @endforeach
        </div> 
     </div>      
     

    
    <script type="text/javascript">
        Dropzone.options.dropzone =
         {
            maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            timeout: 5000,
            addRemoveLinks: true,
            removedfile: function(file) 
            {
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                    type: 'POST',
                    url: '{{ url("/deleteImage") }}',
                    data: {filename: name},
                    success: function (data){
                        console.log("File deleted successfully!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function(file, response) 
            {
                console.log(response);
            },
            error: function(file, response)
            {
               return false;
            }
};
</script>
@endsection