@extends('master')
@section('content')
<div class="row">	

	<div class="col-md-12">
		<h1>My Galleries</h1>
	</div>
</div>	
<div class="row">
	<div class="col-md-8"> 
			@if($galleries->count() >0)
			<table class="table table-striped table-bordered">
				<thead >
     			 <tr class="bg-info" >
						<th colspan ="2">Name of the gallery</th>
						
					</tr>
				</thead>
					<tbody>
						@foreach($galleries as $gallery)
						<tr>
							<td>{{$gallery->name}}</td>
							<td class="text-right">View / Edit / Delete</td>

						</tr>
						@endforeach
					</tbody>

				</thead>
			</table>
			@endif
	</div>
	<div class="col-md-4">

		<form class="form" method="POST" action="{{url('gallery/save')}}">
			@csrf
		<div class="form-group">
			<input type="text" name="gallery_name" id="gallery_name" placeholder="Name of the gallery" class="form-control">
		</div>
		<button class="btn btn-primary">Save</button>
		</form>

	</div>
</div>
@endsection