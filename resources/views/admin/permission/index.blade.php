@extends('admin.layouts.master')
@section('title', __('Create Permission'))
@section('bread-header', 'Permission')
@section('bread-subheader', 'Home - User Management - Create permission')
@section('admin-content')

<div class="row">
    <div class="col-lg-6">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="card-title align-items-start flex-column">
                    <div class="d-flex align-items-center position-relative my-1">
                        {{__('Create Single Permission')}}
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <div class="row bg-light p-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="">{{__('Home')}}</a></li>
                                  <li class="breadcrumb-item active" aria-current="page">{{__('Create Permission')}}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{route('create.permission')}}" method="POST" id="singlePermission">
            @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Permission Name')}}</label>
                        <input type="text" autocomplete="off" name="name" class="form-control" placeholder="{{__('Permission name')}}">
                        <div class="fs-7 fw-bold text-muted fst-italic">{{__("Note: Enter module name.permission name ")}} (<b>{{__('eg: user.view')}} </b>)</div>
                    </div>
                    @error('name')
                        <span class="fv-plugins-message-container invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="card-footer">
                    <input type="submit" name="single_btn" class="btn btn-primary btn-md" value="{{__('Create')}}">
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="card-title align-items-start flex-column">
                    <div class="d-flex align-items-center position-relative my-1">
                        {{__('Create Bulk Permission')}}
                    </div>
                </div>
                
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <div class="row me-3 bg-light p-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="">{{__('Home')}}</a></li>
                                  <li class="breadcrumb-item active" aria-current="page">{{__('Create Permission')}}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{route('bulkPermission')}}" method="POST" id="bulkPermission">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="d-flex required align-items-center fs-6 fw-bold mb-2">
                            {{__('Bulk Permission Name')}}
                        </label>
                        <input type="text" name="bulk_name" autocomplete="off" class="form-control" placeholder="{{__('Permission name')}}">
                        <div class="fs-7 fw-bold text-muted fst-italic">{{__("Note: Enter module name")}} (<b>{{__('eg: user')}} </b>) {{__("It will add ")}} <b>{{__('create, edit, list and delete')}}</b> {{__('permissions')}}</div>
                    </div>
                    @error('bulk_name')
                    <span class="fv-plugins-message-container invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="card-footer">
                    <input type="submit" name="bulk_btn" class="btn btn-md btn-primary" value="{{__('Create')}}">
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="card">
        <div class="card-header">
            <div class="card-title align-items-start flex-column">
                <h3>{{__('Permissions List')}}</h3>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table id="permissiontable" aria-label="" class="table table-striped  permission_datatable">
                <thead class="fw-bolder text-muted bg-light">
                  <tr class="table-heading-row">
                    <th>{{__('#')}}</th>
                    <th>{{__('Permission')}}</th>
                    <th>{{__('Action')}}</th>
                  </tr>
                </thead>
               
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('custom-script')
<script src="{{url('/admin/js/permission.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
<script>
    var permissionList = @json(route('permission'));
</script>
@endsection