@extends('admin.layouts.master') 
@section('title', __('Dashboard'))
@section('bread-header', 'Dashboard')
@section('bread-subheader', 'Home')
@section('admin-content')



<div class="row ">
    <div class="card ">
        <div class="card-header">
            <div class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                <h1>{{__('Welcome')}} {{auth()->user()->name}} !</h1></h1>     
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                    <div class="row me-3 bg-light p-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Dashboard')}}</a></li>                            
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    
  @endsection