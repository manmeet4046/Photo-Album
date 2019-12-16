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
       
            <div class="col-lg-6  pull-left">
                <h4> Add Images to  Gallery (<span style="color:maroon;" >{{ ucfirst($gallery->name) }}</span>) </h4>
            </div>
            <div class=" col-lg-6 pull-right text-right">
                <a class="btn btn-primary btn-xs" href="{{ route('gallery.index') }}"> Back</a>
            </div>
        
    </div>
    <div>Note: Click on Drop Zone to upload multiple files or Drag & Drop the file(s) to upload.</div>

  <hr>
    <div class="row justify-content-md-center">
        <div class="col-md-2"></div><div class="col-md-8 text-right">
         <form method="post" action="{{url('image/upload')}}" 
                  class="dropzone" id="dropzone" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div style="color:red;"> Drop Zone</div>
    <input type="hidden" name="gallery_id" value={{$gallery->id}}>
  
</form>   
        </div>
        <div class="col-md-2">
         @if (Session::has('success'))
          <div class="alert alert-info">
        {!! Session::get('success') !!}     
       </div>
        @endif
</div>
    </div>
    <hr>
<br/>
  <div class="row justify-content-md-center mb-3"> @error('order_img')
    <div class="badge text-danger">Error ! {{ $message }}</div>
@enderror</div>
  <div class="row justify-content-md-center">  
    
           @foreach($images as $image)
           <div class="form-group justify-content-md-left ">
             <form class="form-horizontal" action="{{ route('gallery.update', $image->id) }}" method="post" >
  @csrf
  @method('PUT')
    <img src="{{$image->file_path}}" class="mb-2" width="220" height="200">
    <div class="col-md-12 text-left mr-5 mb-5">
     <input type="" name="order_img" class="input-group-prepend input-sm" size="8" value="{{($image->order_img==0)?'':$image->order_img}}" style="display:inline-block;" >
      <input class="btn btn-xs btn-primary  " style="margin-left:10px" type="submit" name="" value="Change Order">

    </div>
 
 
</form> 
<form class="form-horizontal" style="margin-top: -40px;margin-left:70px" action="{{ route('deleteImage',$image->id) }}" onsubmit="return confirm('Do you really want to delete?');" method="post">
 @csrf
@method('DELETE') <input class="btn btn-xs btn-info  input-group-prepend" type="submit" name="" value="Remove"></form><hr> </div>
            @endforeach
    
       
     </div>  
     
<style>.dz-error{
color: blue;
}
</style>
    
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
                    addRemoveLinks: true,
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
                $(file.previewElement).addClass("dz-success").find('.dz-success-message').text(response  + ' Check allowed format and Size of the file ' );
               location.reload();
                console.log(response);
            },
            error: function(file, message)
            {

               $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(message.message  + ' Check allowed format and Size of the file ' );
               return false;
            }
};
</script>
@endsection