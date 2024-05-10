@extends('admin.layouts.master')
@section('title', __('Users List'))
@section('admin-content')

<div class="row">
    <div class="card">
        <div class="card-header">
            <div class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                    {{__('Users List')}}
                    
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                    <div class="row me-3 bg-light p-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{__('Users List')}}</li>
                            </ol>
                        </nav>
                    </div>
                    
                    {{-- @can('role.create') --}}
                    <a href="{{ route('users.create')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> {{__('Create New User')}}</a>
                    {{-- @endcan --}}
                </div>
            </div>
        
        </div>
        <div class="card-body table-responsive">
            <table id="usertable" class="table table-striped user_datatable" aria-label="">
                <thead class="fw-bolder text-muted bg-light">
                  <tr class="table-heading-row">
                    <th>{{__('#')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Created At')}}</th>            
                    <th>{{__('Status')}}</th>
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
@section('styles')

@endsection
@section('custom-script')
<script src="{{url('/admin/js/users.js')}}"></script>
<script>
    let $usersInf = [];
    var userList = @json(route('users.index'));

</script>
@endsection