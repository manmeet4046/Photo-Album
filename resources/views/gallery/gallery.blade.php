@extends('master')
@section('content')
<div class="row">	

	<div class="col-md-12">
		<h1>My Galleries</h1>
	</div>
</div>
@if (Session::has('success'))
          <div class="alert alert-info">
        {!! Session::get('success') !!}     
       </div>
       @endif	
<div class="row">
	<div class="col-md-8"> 
			@if($galleries->count() >0)
			<table class="table table-striped table-bordered">
				<thead >
     			 <tr class="bg-info" >
						<th colspan ="3">Name of the gallery</th>
						
					</tr>
				</thead>
					<tbody>
						@foreach($galleries as $gallery)
						<tr>
			
							<td><a href="{{ route('gallery.slideshow',$gallery->id) }}">{{ucfirst($gallery->name)}}</a></td>
							<td><img src="{{$gallery->image_path}}" class="mb-2" width="100" height="100"></td>
							<td class="text-right"><form action="{{ route('gallery.destroy',$gallery->id) }}" method="POST" onsubmit="return confirm('Do you really want to delete?');">
   							 <a class="btn btn-info btn-xs" href="{{ route('gallery.show',$gallery->id) }}">Show</a>
    
                    <a class="btn btn-primary btn-xs" href="{{ route('gallery.edit',$gallery->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger btn-xs" id="delete">Delete</button>
                </form></td>

						</tr>

						@endforeach
					</tbody>

				</thead>
			</table>

			{{ $galleries->links() }}
			@endif
	</div>
	<div class="col-md-4">

		<form class="form" method="POST" action="{{ route('gallery.store')}}" enctype="multipart/form-data">
			@csrf

		<div class="form-group">
			<input type="text" name="name" id="name" placeholder="Name of the gallery" class="form-control" value="{{old('name')}}">
		@error('name')
    <span class="badge text-danger">Error ! {{ $message }}</span>
@enderror
		<input type="file" name="image_path">
		@error('image_path')
    <span class="badge text-danger">Error ! {{ $message }}</span>
@enderror
	</div>
		<button type="input" class="btn btn-primary btn-xs">Add new Gallery</button>
		</form>

	</div>
</div>

@endsection