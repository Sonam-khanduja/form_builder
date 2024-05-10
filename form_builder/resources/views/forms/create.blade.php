@extends('admin.layouts.master')
@section('title',__('Create Form'))
@section('admin-content')

<link rel="stylesheet"  href="{{url('css/custom/custom_form.css')}}">
<div class="row ">   
<div class="card">
        <div class="card-header">
            <div class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" href="{{route('forms.index')}}" data-toggle="tooltip" data-original-title="{{__('Go Back')}}">
                       <i class="fa fa-arrow-left" aria-hidden="true"></i>                       
                    </a>
                    {{__('Create a new Form')}}
                </div>
            </div>           
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                <div class="row me-3 bg-light p-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{__('Create Form')}}</li>
                            </ol>
                        </nav>
                    </div>
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#custom_fields">    
                            <i class="fa fa-plus" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Add Custom Fields')}}"></i>
                            Add Custom Fields
                        </a>

                        <!-- style="pointer-events: none; color:#7b7b7b" -->
                   
                    <a class="btn" id="createAdditionalLogic"  data-bs-toggle="modal" data-bs-target="#additionalLogic">    
                      <i class="fa fa-plus" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Additional Logic')}}"></i>
                        Additional Logic
                    </a>
                </div>
            </div>
        </div>
        <form action="{{ route('forms.store') }}" method="POST" class="needs-validation" novalidate id="formsId">
        @csrf
             <input type="hidden" name="customfield_options" value="" id="customfield_options">
             <input type="hidden" name="addOptions" value="" id="addOptions">
            <div class="card-body">
                <div class="row">
                <div class="col-4">
                    <div>
                        <div class="form-group fv-row mb-10 fv-plugins-icon-container">
                            <label for="name" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Name')}}</label>
                            <input name="name" type="text" autocomplete="off" class="form-control @error('name') is-invalid @enderror mb-3 mb-lg-0" id="name" placeholder="{{__('Enter User Name')}}" value="" required autofocus>
                            @error('name')
                                <span class="fv-plugins-message-container invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                   
                    <div >
                        <div class="form-group fv-row mb-10 fv-plugins-icon-container">
                            <label for="layout" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Layout')}}</label>
                              <select name="layout" id="layout" class="form-select form-control" value="">
                                        <option value="">{{__('Please select one')}}</option>                                       
                                            <option value="1">Portrait</option>
                                            <option value="0">Lanscape</option>                                       
                                </select>
                            @error('email')
                                <span class="fv-plugins-message-container invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>              

                    <div >
                        <div class="form-group fv-row mb-10 fv-plugins-icon-container">
                            <label for="layout" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Description')}}</label>
                            <textarea class="form-control"  name="description"  rows="3" placeholder="Enter ..."></textarea>                          
                        </div>
                    </div> 

                </div>                    
                    <div class="col-8"> 
                          <div  id="createNewForm"></div>
                    </div>
                 
                </div>
            </div>
            <div class="card-footer">
                <button type="reset" class="btn btn-danger">{{__('Reset')}}</button>
                <button id="createbtn" type="submit" class="btn btn-primary"> {{__('Create')}}</button>
            </div>
        </form>
    </div>




    
<!-- Modal -->
<div id="custom_fields" class="custom_fields modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">{{__('Add Custom Fields')}} </h5>
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <div class="modal-body">
             @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- {{ route('forms.customfields') }} -->
<!-- onkeyup="checkDuplicateLabel(e) -->
             <!-- onsubmit="onSubmitForm(event, this)"  -->
        <form method="POST" action="{ route('forms.customfields') }} " class="pull-right custom_fieldsForm" id="custom_fieldsForm" >
        @csrf          
                <!-- onkeyup="checkDuplicateLabel(this)" -->
            <div class="form-group custom_elements" id="main_label">
                <label for="fieldLabel" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Field label')}}</label>            
                <input type="text" required class ="form-control @error('label_name') is-invalid @enderror mb-3 mb-lg-0" id="label_name" name="label_name" >
                <span class="text-danger error-text label_error fv-plugins-message-container " role="alert"></span>
            </div>
              <div class="form-group custom_elements" id="main_fieldType">
                <label for="fieldType" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Field Type')}}</label>
                <select name="fieldType" id="fieldType"  class="form-select form-control " value="" required>
                        <option value="">{{__('Please select one')}}</option>                                       
                        <option value="input">Input Field</option>
                        <option value="checkbox">Check Box</option>   
                        <option value="textarea">Text Area</option>  
                        <option value="radio">Radio</option>   
                        <option value="date">Date</option>  
                        <option value="select">Select</option>                                                                                     
                </select>              
                <span class="text-danger error-text fieldType_error fv-plugins-message-container" role="alert"></span>                
             </div>
            
             <div class="form-group custom_elements" id="main_checkboxOptions">          
                <div id="checkboxOptions" style="display:none">
                   <div >                                
                     <div id="custom_checkboxOption"></div>
                        <button id="rowAdder" type="button" class="btn btn-dark">
                         <i class="fa fa-plus" aria-hidden="true"></i> 
                        </button>             
                        <span id="checkbox_error" class="text-danger error-text checkbox_error fv-plugins-message-container " role="alert"></span>
                    </span>
                 </div>   
                </div>
             </div>
  
                  <!--Select options -->
               <div id="selectOptions" style="display:none">
                <div>
                <div id="custom_selectOption"></div>
                        <button id="selectOptions_rowAdder" type="button" class="btn btn-dark">
                         <i class="fa fa-plus" aria-hidden="true"></i> 
                        </button> 
                        <span id="selectOptions_error" class="text-danger error-text selectOptions_error fv-plugins-message-container " role="alert"></span>
                    </span>
                </div>
               </div> 

               <div id="radioOptions" style="display:none">
               <div>
                <div id="custom_radioOption"></div>
                        <button id="radioOptions_rowAdder" type="button" class="btn btn-dark">
                         <i class="fa fa-plus" aria-hidden="true"></i> 
                        </button>   
                        <span id="radioOptions_error" class="text-danger error-text radioOptions_error fv-plugins-message-container " role="alert"></span>

                    </span>
               </div>
               </div> 

                <!-- Add placeHolder -->
                <div class="form-group custom_elements" id="main_required_field">
                <label for="required_field" class="d-flex  align-items-center fs-6 fw-bold mb-2">{{__('Field Required')}}</label>            
                <input type="checkbox"  id="required_field" name="required_field" >   
                </div> 
<!--   
                <label for="field_id" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Field Id Name')}}</label>            
                <input type="text" class ="form-control" id="field_id" name="field_id">  -->
                <div class="form-group custom_elements" id="main_field_id">
                <label for="field_id" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Field Id Name')}}</label>            
                <input type="text" class ="form-control" id="field_id" name="field_id"> 
                <span class="text-danger error-text fieldId_error fv-plugins-message-container " role="alert"></span>
                
                </div>

                <div class="form-group custom_elements" id="main_field_classname">
                <label for="field_classname" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Field Class Name')}}</label>            
                <input type="text" class ="form-control" id="field_classname" name="field_classname">
                </div>
                

                <!-- add before and after -->
                <div class="form-group custom_elements" id="main_afterbefore">          
                <div id="afterbefore" style="display:none">
                   <div class="col-4">                                
                    <select name="afterbeforeOption" id="afterbeforeOption" name ="afterbeforeOption" class="form-select form-control" value="">
                            <option value="none">{{__('Please select one')}}</option>                                       
                                <option value="before">Before</option>
                                <option value="after">After</option>     
                    </select>
                    </span>
                 </div>   
                </div>
              </div>

              <div class="form-group custom_elements" id="main_selectFieldOption">   
                <div id="selectFieldOption" style="display:none">
                   <div class="col-4">                                
                   <label for="field_selectionOption" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Next')}}</label>   
                    <select id="afterbeforeOption" name="afterbeforeOption" class="form-select form-control" value="">
                            <option value="none">{{__('Please select one')}}</option>                                       
                                <option value="before">Before</option>
                                <option value="after">After</option>     
                    </select>
                    </span>
                 </div>   
                </div>
              </div>

              <div class="form-group custom_elements" id="main_checkLabel">          
                <div id="checkLabelForNextField" style="display:none">
                <label for="field_selectionOption" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Pervious Fields ')}}</label> 
                        <div id="custom_labelForNextOptions">
                            <select  id="nextField" name="nextField" class="form-select form-control" value="">
                            <option value="none">{{__('Please select one')}}</option>      
                            </select>                    
                        </div> 
                </div>
              </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="customSubmitBtn"  class="btn btn-danger customSubmitBtn">{{__('Submit')}}</button>

                </div>

                </form>              
            </div>

        </div>
    </div>
</div>  

@include('forms.customfield')
<!-- end POPUP -->
@endsection
@section('custom-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
<script src="{{ url('js/custom/form.js') }}"></script>  
<script src="{{ url('js/custom/add_custom_form.js')}}"></script>
    <script>
    let $usersInf = [];
    var formList = @json(route('forms.index'));
    var customField = @json( route('forms.customfields'));
    var getadditionallogic = @json( route('forms.getadditionallogic'));    
    var additionalLogicForm = @json( route('forms.additionallogic'));
    var getadditionalLogicOption = @json( route('forms.getadditionalLogicOption'));
    var updateAdditionalLogic = @json( route('forms.updateAdditionalLogic'));
    var deleteFormElement =@json( route('forms.deleteFormElement')); 
</script>
@endsection