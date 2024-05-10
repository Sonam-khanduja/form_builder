@extends('admin.layouts.master')
@section('title',__('Edit role ').$role->name)
@section('admin-content')
<div class="row">
    <div class="card">
        <div class="card-header">
            <div class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                    <a href="{{route('roles.index')}}" data-toggle="tooltip" data-original-title="{{__('GoBack')}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>                       
                    </a>
                    {{__('Edit Role')}}
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                    <div class="row bg-light p-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{__('Edit Role')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <form action="{{ route('roles.update',$role->id) }}" method="POST" class="needs-validation" novalidate id="roles">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group fv-row mb-10 fv-plugins-icon-container">
                    <label for="name" class="d-flex required align-items-center fs-6 fw-bold mb-2">Role name</label>
                    <input type="hidden" name="guard" value="web">
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror mb-3 mb-lg-0" id="name" placeholder="Enter role name" value="{{ $role->name }}" required autofocus>

                    @error('name')
                        <span class="fv-plugins-message-container invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group fv-row mb-10 fv-plugins-icon-container permissionTable">

                    <p  class="d-flex align-items-center fs-6 fw-bold mb-2">{{ __('Permissions') }} &nbsp;
                        <label class="form-check form-check-custom form-check-solid me-9">
                            <input type="checkbox" class="grand_selectall form-check-input filled-in" name="section[1]">
                        </label>
                    </p>
                    <div class="row bg-light mt-1 pt-3 pb-2">
                        @if(isset($customPermission))
                           @foreach($customPermission as $key => $group)
                            <div class="col-md-6 mb-2 ">
                                <div class="card child-checkbox">
                                    <div class="card-header">
                                        <div class="card-title">{{ ucfirst($key) }}</div>
                                        <div class="card-toolbar">
                                            <div class="d-flex">
                                                <label class="form-check form-check-custom form-check-solid me-9">
                                                    <input type="checkbox" class="selectall form-check-input filled-in" name="section[1]">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @forelse($group as $permission)
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-check form-check-custom form-check-solid me-9 d-inline">
                                                        <input name="permissions[]" class="permissioncheckbox form-check-input filled-in" type="checkbox" value="{{ $permission->id }}" {{ $role->permissions->contains('id',$permission->id) ? "checked" : "" }}>
                                                       
                                                        <span class="form-check-label" for="kt_roles_select_all">{{ucfirst(explode('.', $permission->name)[1])}}</span>
                                                        
                                                    </label>
                                                </div>
                                            @empty
                                                {{ __("No permission in this group !") }}
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    
                </div>

            </div>
            <div class="card-footer">
                <a class="btn btn-bg-light btn-active-color-primary btn-md" href="{{route('roles.index')}}">{{__('Back')}}</a>
             
                <button type="submit" class="btn btn-primary"> {{__('Update')}}</button>
                   <!-- @can('role.edit') -->
                <!-- @endcan -->
            </div>
        </form>
        
    </div>
</div>

@endsection
@section('custom-script')
    <script src="{{ url('admin/js/checkbox.js') }}"></script>
    <script src="{{ url('admin/js/roles.js') }}"></script>
    <script>
    var roleList = @json(route('roles.index'));
</script>
@endsection