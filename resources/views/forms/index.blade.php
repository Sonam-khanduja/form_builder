@extends('admin.layouts.master')
@section('title', __('Forms List'))
@section('admin-content')

<div class="row ">
    <div class="card ">
        <div class="card-header">
            <div class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                    {{__('Forms List')}}                    
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                    <div class="row me-3 bg-light p-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{__('Forms List')}}</li>
                            </ol>
                        </nav>
                    </div>
                    
                
                    <a href="{{ route('forms.create')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> {{__('Create New Form')}}</a>
                 
                </div>
            </div>
        
        </div>
        <div class="card-body table-responsive">
            <table id="formdatatable" class="table table-striped form_datatable" aria-label="">
                <thead class="fw-bolder text-muted bg-light">
                  <tr class="table-heading-row">
                    <th>{{__('#')}}</th>
                    <th>{{__('Form Name')}}</th>
                    <th>{{__('Layout')}}</th>
                    <th>{{__('Description')}}</th>   
                    <th>{{__('Actions')}}</th> 
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
<script src="{{url('js/custom/form.js')}}"></script>
<script>
    
    var formList = @json(route('forms.index'));

</script>
@endsection