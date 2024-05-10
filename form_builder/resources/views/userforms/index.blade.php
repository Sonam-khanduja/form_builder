@extends('admin.layouts.master')
@section('title', __('User Submit Form List'))
@section('admin-content')

<div class="row">
    <div class="card">
        <div class="card-header">
            <div class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                    {{__('User Submit Form List')}}
                    
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                    <div class="row me-3 bg-light p-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{__('User Submit Form List')}}</li>
                            </ol>
                        </nav>
                    </div>                    
                   
                </div>
            </div>
        
        </div>
        <div class="card-body table-responsive">
            <table id="userform_datatable" class="table table-striped userform_datatable" aria-label="">
                <thead class="fw-bolder text-muted bg-light">
                  <tr class="table-heading-row">
                    <th>{{__('#')}}</th>
                    <th>{{__('Name')}}</th>                    
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
<script src="{{url('js/custom/user_submitform.js')}}"></script>
<script>   
    var formlisting = @json(route('usersubmitform.index'));
</script>
@endsection