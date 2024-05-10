@extends('admin.layouts.master')
@section('title',__('Edit User'))
@section('admin-content')

<div class="row">
    <div class="card">
        <div class="card-header">
            <div class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" href="{{route('users.index')}}" data-toggle="tooltip" data-original-title="{{__('Go Back')}}">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>  
                    </a>
                  
                    {{__('Edit User')}}
                </div>
            </div>
           
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                    <div class="row bg-light p-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{__('Edit User')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('users.update', $userDetails->id) }}" method="POST" class="needs-validation" novalidate id="users">
        @csrf
        @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="form-group fv-row mb-10 fv-plugins-icon-container">
                            <label for="name" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Name')}}</label>
                            <input name="name" type="text" autocomplete="off" class="form-control @error('name') is-invalid @enderror mb-3 mb-lg-0" id="name" placeholder="{{__('Enter User Name')}}" value="{{ $userDetails->name }}" required autofocus>
                            @error('name')
                                <span class="fv-plugins-message-container invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group fv-row mb-10 fv-plugins-icon-container">
                            <label for="email" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Email')}}</label>
                            <input name="email" type="email" autocomplete="off" class="form-control @error('email') is-invalid @enderror mb-3 mb-lg-0" id="email" placeholder="{{__('Enter User Email Address')}}" value="{{ $userDetails->email  }}" required autofocus>
                            @error('email')
                                <span class="fv-plugins-message-container invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group fv-row mb-10 fv-plugins-icon-container">
                                    <label for="status" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Select Status')}}</label>
                                    <select name="status" id="status" class="form-select form-control" value="" required>
                                        <option value="none">{{__('Please select one')}}</option>                                              
                                    
                                            <option value="1" {{ (isset($userDetails->status)&& $userDetails->status=='1')?'selected':''}}>Active</option>
                                            <option value="0" {{ (isset($userDetails->status)&& $userDetails->status=='0')?'selected':''}}  >InActive</option>                                       
                                    </select>
                                    @error('role')
                                        <span class="fv-plugins-message-container invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                         </div>
                    </div>                
                </div>
            </div>
            <div class="card-footer">              
                <button type="submit" class="btn btn-primary"> {{__('Update')}}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('custom-script')
    <script src="{{ url('admin/js/user.js') }}"></script>
    <script> 
    var userList = @json(route('users.index'));

</script>
@endsection