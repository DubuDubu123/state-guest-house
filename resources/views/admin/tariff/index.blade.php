@extends('admin.layouts.app')
@section('title', 'Main page')

@section('content')
<style>
    .nav-tabs .nav-link.active, .nav-tabs .nav-link.active:focus, .nav-tabs .nav-link.active:hover, .nav-tabs .nav-item.open .nav-link, .nav-tabs .nav-item.open .nav-link:focus, .nav-tabs .nav-item.open .nav-link:hover{
        color: #fff;
        border-color: transparent;
        border-bottom-color: #86BEBD !important;
        background-color: #86BEBD !important;
    }
    .tab-content.p-10 {
        margin-top: 20px;
    }
       /* Chrome, Safari, Edge, Opera */
       input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
    <!-- Start Page content -->
    <section class="content" style="margin-left:25px">
        {{-- <div class="container-fluid"> --}}


        <div class="row" style="margin-top:30px;margin-left: 30px;text-align: left;margin-right: 30px;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
        <h3 style="
    padding-left: 15px;
    margin-bottom: 10px;
    margin-top: 20px;
">Tariff Card</h3>   
            <div class="col-12"> 
            <div class="box">

                    <ul class="nav nav-tabs" style="padding: 1rem">

                                                <li class="nav-item">
                            <a href="#membership" data-toggle="tab" aria-expanded="false" class="nav-link active"> Membership
                            </a>
                        </li>
                                                <li class="nav-item">
                            <a href="#room" data-toggle="tab" aria-expanded="false" class="nav-link "> Room Tariff
                            </a>
                        </li>
                                                <li class="nav-item">
                            <a href="#party" data-toggle="tab" aria-expanded="false" class="nav-link "> Party Hall / Lawn Tariff
                            </a>
                        </li>
                                                <li class="nav-item">
                            <a href="#sports" data-toggle="tab" aria-expanded="false" class="nav-link "> Sports Tariff
                            </a>
                        </li> 
                    </ul>

                    <form action="{{url('/')}}/tariff/save-tariff" method="post" enctype="multipart/form-data">
                         @csrf
                    <div class="tab-content p-10">

                        
                        <div class="tab-pane show active" id="membership">

                        <div class="row">

                                
                                
    @foreach($membership_tariff as $key=>$value)
    <div class="col-md-6">
    <div class="form-group" style="
    /* text-align: center; */
    margin-top: 6px;
">
    @if($value->name == "Life Time Members")
    <label for="title">Life Time Membership (₹)</label> 
<input name="membership[{{$value->id}}][life_time]" type="number" value="{{$value->price}}" class="form-control" id="title" @if(!auth()->user()->hasRole('super-user')) disabled @endif >
    @else
    <label for="title">Associate Membership (₹)</label> 
<input name="membership[{{$value->id}}][associate]" type="number" value="{{$value->price}}" class="form-control" id="title" @if(!auth()->user()->hasRole("super-user")) disabled @endif>
    @endif 
    </div>
</div>   
    @endforeach            
</div>
@if(auth()->user()->hasRole('super-user'))
<div class="col-md-12">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-custom waves-effect waves-light" type="submit">
                                        Submit
                                    </button>
                                </div>
                                </div>
@endif
                        </div> 
                        <div class="tab-pane show" id="room">
                        

                        <div class="row"> 
                             <div class="col-md-3"> 
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title">Officers and their family(₹)</label> 
                            </div>
                        </div>
                        
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                 <label for="title">Others (₹)</label> 
                            </div>
                        </div>                   
                        </div> 
                        @foreach($tariff as $key=>$value)
                        <div class="row">             
                        <div class="col-md-3">
                            <div class="form-group" style="text-align: center;margin-top: 6px;">
                                <label for="title">Day {{$value->day}}</label> 
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                 <input name="tariff[{{$value->id}}][rent_for_officers_family]" type="number" value="{{$value->rent_for_officers_family}}" class="form-control" id="title" @if(!auth()->user()->hasRole(('super-user'))) disabled @endif> 
                            </div>
                        </div> 
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                 <input name="tariff[{{$value->id}}][rent_for_others]" type="number" value="{{$value->rent_for_others}}" class="form-control" id="title" @if(!auth()->user()->hasRole(('super-user'))) disabled @endif> 
                            </div>
                        </div>                        
                        </div> 
                        @endforeach
                        <div class="row">             
                        <div class="col-md-3">
                            <div class="form-group" style="text-align: center;margin-top: 6px;">
                                <label for="title"><strong>Total rooms</strong></label> 
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                 <input name="total_rooms" type="number" value="{{$tariff[0]->total_rooms}}" class="form-control" id="title" @if(!auth()->user()->hasRole(('super-user'))) disabled @endif> 
                            </div>
                        </div>        
                        </div>
                        @if(auth()->user()->hasRole('super-user'))
                     <div class="col-md-12">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-custom waves-effect waves-light" type="submit">
                                        Submit
                                    </button>
                                </div>
                                </div>
                        @endif
                                </div>
                                                <div class="tab-pane show" id="party">
                        
                                                <div class="row"> 
                                                @foreach($party_tariff as $key=>$value)
<div class="col-md-4">
    <div class="form-group" style="
    /* text-align: center; */
    margin-top: 6px;
">
        <label for="title">Booking No : {{$value->day}}</label>

<input name="party_tariff[{{$value->id}}]" type="number" value="{{$value->price}}" class="form-control" id="title" @if(!auth()->user()->hasRole(('super-user'))) disabled @endif>

                                                
        
    </div>
</div>  
@endforeach
                                    
</div>
@if(auth()->user()->hasRole('super-user'))
<div class="col-md-12">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-custom waves-effect waves-light" type="submit">
                                        Submit
                                    </button>
                                </div>
                                </div>
                                @endif
                                                </div> 

                                                <div class="tab-pane" id="sports">
                        

                        <div class="row">               
                        <div class="col-md-3">
                            <div class="form-group">
                         Name        
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group"> 
                              <label for="title">Daily</label> 
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title">Monthly</label> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                 <label for="title">Yearly</label> 
                            </div>
                        </div>                
                        </div>
                        @foreach($sports_tariff as $key=>$value)
                        <div class="row">         
                        <div class="col-md-3">
                            <div class="form-group" style=" 
                            margin-top: 6px;">
                        <label for="title">{{$value->name}}</label> 
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <input name="sports_tariff[{{$value->id}}][daily_tariff]" type="number" value="{{$value->daily_tariff}}" class="form-control" id="title" @if(!auth()->user()->hasRole(('super-user'))) disabled @endif> 
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <input name="sports_tariff[{{$value->id}}][mothly_tariff]" type="number" value="{{$value->mothly_tariff}}" class="form-control" id="title" @if(!auth()->user()->hasRole(('super-user'))) disabled @endif> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input name="sports_tariff[{{$value->id}}][yearly_tariff]" type="number" value="{{$value->yearly_tariff}}" class="form-control" id="title" @if(!auth()->user()->hasRole(('super-user'))) disabled @endif>  
                            </div>
                        </div>                       
                        </div>
                        @endforeach
                        @if(auth()->user()->hasRole('super-user'))
                        <div class="col-md-12">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-custom waves-effect waves-light" type="submit">
                                        Submit
                                    </button>
                                </div>
                                </div>
                        @endif
                    </div>
                 </div>
                    </form>

                </div>
                                <!-- </a> -->
                                </div>
                                 
                                </div>
    
                            </div>
<!-- on boarding  -->
 

<!-- end -->
            </div> 
            </div>
        </div>

        {{-- </div> --}}
        <!-- container -->


        <script src="{{ asset('assets/js/fetchdata.min.js') }}"></script>
        <script>
            var search_keyword = '';
            
            $(function() {
                $('body').on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    $.get(url, $('#search').serialize(), function(data) {
                        $('#js-types-partial-target').html(data);
                    });
                });

                $('#search').on('click', function(e) {
                    e.preventDefault();
                    search_keyword = $('#search_keyword').val();

                    fetch('types/fetch?search=' + search_keyword)
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('#js-types-partial-target').innerHTML = html
                        });
                });


            });

            $(document).on('click', '.sweet-delete', function(e) {
                e.preventDefault();

                let url = $(this).attr('data-url');

                swal({
                    title: "Are you sure to delete ?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Delete",
                    cancelButtonText: "No! Keep it",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        swal.close();

                        $.ajax({
                            url: url,
                            cache: false,
                            success: function(res) {

                                fetch('types/fetch?search=' + search_keyword)
                                    .then(response => response.text())
                                    .then(html => {
                                        document.querySelector('#js-types-partial-target')
                                            .innerHTML = html
                                    });

                                $.toast({
                                    heading: '',
                                    text: res,
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 5000,
                                    stack: 1
                                });
                            }
                        });
                    }
                });
            });

        </script>


    @endsection
