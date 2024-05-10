@extends('admin.layouts.master')
@section('title', __('Roles List'))
@section('admin-content')

<div class="row">
    <div class="card">
        <div class="card-header">
            <div class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                   <h3>{{__('Roles List')}}</h3>
            </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                    <div class="row me-3 bg-light p-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{__('Roles List')}}</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('roles.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> {{__(' Create role')}}</a>
                   <!-- @can('role.create') -->
                    <!-- @endcan -->
                   
                </div>
               
            </div>
        </div>
        <div class="card-body table-responsive">
            <table id="roletable" class="table table-striped  role_datatable" aria-label="">
                <thead class="fw-bolder text-muted bg-light">
                  <tr class="table-heading-row">
                    <th>{{__('#')}}</th>
                    <th>{{__('Role Name')}}</th>
                    <th class="d-none">{{__('Role count')}}</th>
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
<script src="{{url('/admin/js/roles.js')}}"></script>
<script>
    var roleList = @json(route('roles.index'));
   
</script>
 
@endsection