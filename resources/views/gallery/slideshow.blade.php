@extends('master')
  
@section('content')
<style>
  .carousel-item {
  height: 80vh;
  min-height: 250px;
  background: no-repeat center center scroll;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;

}
.carousel-item.active img{
margin-top: auto;
margin-right: auto;
}
.carousel-inner .carousel-item,
.carousel-inner .carousel-item.active,
.carousel-inner .carousel-item {
    margin: auto;
    padding: 0px;
}
</style>
<div class="container">

    <div class="col-lg-12">
      @if($gallery->count()>0)
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    
    <ol class="carousel-indicators">
      @php $i =-1;@endphp
      @foreach($gallery->images as $key=>$photoCount)
      @php $i++;@endphp
      <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" class="{{($i==0)?'active':''}}" style="cursor: pointer;"></li>
    <!--  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
      @endforeach
    </ol><div class="  mt-2 mb-2" style="font-size:20px;" ><u > Photos of Album :  <span class="maroon" > Name</span></u></div>
    <div class="carousel-inner " role="listbox">
    
@foreach($gallery->images as $key=>$photo)
      <!-- Slide One - Set the background image for this slide in the line below -->
     
      <div class="carousel-item {{($key==0)?'active':''}} " style="background-image: url({{$photo->file_path}})">
        <div class="carousel-caption d-none d-md-block">
          <h3 class="" ><span style="background-color: grey;padding: 5px;border-radius: 10px;">{{$photo->name}}</span></h3>
        
        </div>
      </div>
 @endforeach
   
    </div>
   <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: black;"></span>
          <span class="sr-only">Previous</span>
        </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: black;"></span>
          <span class="sr-only">Next</span>
        </a>
    
  </div>
  @else
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

<ol class="carousel-indicators">
      
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active" style="cursor: pointer;"></li>
    <!--  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
  
    </ol>
<div class="carousel-item active " style="background-image: url('/img/no_slider_image.png')">
        <div class="carousel-caption d-none d-md-block">
          <h3 class="" ><span style="background-color: grey;padding: 5px;border-radius: 10px;">No Image Uploaded for Slide Show</span></h3>
         <a href="{{url()->previous()}}" class="maroon" style="font-size: 18px;background-color: lightyellow;">{{__('Go Back')}}</a>
        </div>
      </div>
  @endif

</div>
</div></div>
@endsection

@section('scripts')
<script src="{{asset('/js/jquery.slim.min.js')}}"></script>
<script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
@endsection