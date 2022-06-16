@extends('admin.layouts.main')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item"><a href="{{route('admin_Competition')}}">Competition-List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Competition-Add</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Competition Add</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-5 mb-4 ml-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-12 col-sm-12">
                                <!-- Form -->
                                @if(Session::has('success'))
                                    <div class="alert alert-success mb-4" id="success-alert">
                                        <center><span class="text-white">{{Session::get('success')}}</span></center>
                                    </div>
                                @endif
                                <form action="{{route('admin_Competition_add_edit')}}" method="POST" enctype="multipart/form-data">@csrf
                                    <div class="mb-4">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control"  name="title" placeholder="Enter your title...">
                                    </div>
                                    <sqan style="color: crimson">@error('title'){{$message}}@enderror</sqan>
                                    <div class="my-4">
                                        <label for="textarea">Competition Date</label>
                                        <input type="date" class="form-control"  name="comp_date" placeholder="Enter Competition Date...">
                                    </div>
                                    <sqan style="color: crimson">@error('comp_date'){{$message}}@enderror</sqan>
                                    <div class="my-4">
                                        <label for="textarea">Competition Amount</label>
                                        <input type="number" class="form-control"  name="comp_amount" placeholder="Enter Amount...">
                                    </div>
                                    <sqan style="color: crimson">@error('comp_amount'){{$message}}@enderror</sqan>
{{--                                    <div class="my-4">--}}
{{--                                        <label for="textarea">Video</label>--}}
{{--                                        <input type="text" class="form-control" name="url" placeholder="Enter your Video url...">--}}
{{--                                    </div>--}}
                                    <div class="my-4">
                                        <label for="textarea">Iframe Data</label>
                                        <textarea class="form-control" name="iframe" rows="4" cols="50" placeholder="Enter your Iframe data.."></textarea>
                                    </div>

                                    <fieldset class="my-4">
                                        <legend class="h6">Status</legend>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1" checked="">
                                            <label class="form-check-label" for="exampleRadios1">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0">
                                            <label class="form-check-label" for="exampleRadios2">
                                                Inactive
                                            </label>
                                        </div>
                                    </fieldset>
                                    <div class="my-4">
                                        <button class="btn btn-pill btn-outline-success" type="submit">Submit</button>
                                    </div>

                                </form>
                                <!-- End of Form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
