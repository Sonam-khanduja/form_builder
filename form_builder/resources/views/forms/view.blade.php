@extends('admin.layouts.master')
@section('title',__('View Form'))
@section('admin-content')
<link rel="stylesheet"  href="{{url('css/custom/viewform.css')}}">



<div class="row">
    <div class="card">
        <div class="card-header">
            <div class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" href="{{route('forms.index')}}" data-toggle="tooltip" data-original-title="{{__('Go Back')}}">
                     <i class="fa fa-arrow-left" aria-hidden="true"></i>   
                    </a>
                
                    {{__('View Form')}}
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                    <div class="row bg-light p-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{__('View Form')}}</li>
                            </ol>
                        </nav>
                    </div>                    
                    <a  id="previrewbtn" class="btn btn-primary" data-bs-toggle="modal" >    
                        <i class="" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Preview')}}"></i>
                       PDF 
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route('forms.formSubmit') }}" method="POST" class="needs-validation" novalidate id="formubmit_{{$formDetails->id}}">
        @csrf
             <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
             <input type="hidden" name="form_id" id="form_id" value="{{$formDetails->id}}">
             <input type="hidden" name="customfield_options" value="" id="customfield_options">
             <input type="hidden" name="addOptions" value="" id="addOptions">

            <div class="card-body">
               <div class="row">
               <div class="col-8">
               <div class="form-group fv-row mb-10 fv-plugins-icon-container">
                    <label  class="d-flex required align-items-center fs-6 fw-bold mb-2">{{$formDetails->name}}</label>  
                    <label  class="d-flex required align-items-center fs-6 fw-bold mb-2">{{$formDetails->description}}</label>                    
               </div>

                  
                <div id="createNewForm"> 
                <?php $addClass = ""; 
                      $checkedVal = '';
                      $additionalLogicId = '';
                    ?>
                    @foreach($getCustomFields as $key => $val)                    
                        @foreach($getAdiitionalLogic as $key1 => $addlogic)                           
                            @if($addlogic->select_fieldType_to == $val->id   ) 
                            <?php                                 
                                $addClass =$addlogic->visibility; ?>
                            @endif                                                   
                        @endforeach      
                    
                    @switch($val)
                      @case($val->fieldType == "input")
                      <div class='form-group fv-row mb-10  fv-plugins-icon-container {{$val->label_name}}'  data-attr="{{$val->label_name}}">
                        <fieldset style="position:relative">
                       <label class='d-flex align-items-center fs-6 fw-bold mb-2'>{{$val->label_name}}</label>
                       <input type='text'  class='form-control {{$val->field_classname}} {{$addClass }}' data-id="{{$val->id}}"  name='{{$val->field_id}}'   id="{{$val->field_id}}" required="{{$val->required_field}}">
                        <button type="button"  class="closeBtn"  data-id="{{$val->id}}"  style="position: absolute;right:0px;top:1px;outline:1px solid #fff">
                        <span>&times;</span>
                        </button>
                     </fieldset>
                    </div> 
                      @break

                      @case($val->fieldType == "textarea")
                      <div class='form-group fv-row mb-10 fv-plugins-icon-container {{$val->label_name}}'  data-attr="{{$val->label_name}}">
                        <fieldset style="position:relative">
                       <label class='d-flex align-items-center fs-6 fw-bold mb-2'>{{$val->label_name}}</label>
                       <textarea  required="{{$val->required_field}}"  name='{{$val->field_id}}' data-id="{{$val->id}}"   class='form-control {{$val->field_classname}} {{$addClass }}'  id="{{$val->field_id}}"  rows='3' ></textarea>
                       
                     </fieldset>
                    </div> 
                    @break

                    @case($val->fieldType == "date")
                      <div class='form-group fv-row mb-10 fv-plugins-icon-container {{$val->label_name}}'  data-attr="{{$val->label_name}}">
                        <fieldset style="position:relative">
                       <label class='d-flex align-items-center fs-6 fw-bold mb-2'>{{$val->label_name}}</label>
                       <input type='date'  class='form-control {{$val->field_classname}} {{$addClass }}' data-id="{{$val->id}}"  name='{{$val->field_id}}'   id="{{$val->field_id}}" required="{{$val->required_field}}">
                    
                     </fieldset>
                    </div> 
                     @break


                       
                    @case($val->fieldType == "select")
                      <div class='form-group fv-row mb-10 fv-plugins-icon-container {{$val->label_name}}'  data-attr="{{$val->label_name}}">
                        <fieldset style="position:relative">
                       <label class='d-flex align-items-center fs-6 fw-bold mb-2'>{{$val->label_name}}</label>                       
                       <select name='{{$val->field_id}}'   id="{{$val->field_id}}" data-id="{{$val->id}}"  data-visibility="{{$addClass}}"  required="{{$val->required_field}}" class="form-select form-control  {{$val->field_classname}}  {{$addClass}}" value="">
                            <option value="">{{__('Please select one')}}</option>
                            @foreach($getotherFields as $elementsOptions)    
                            @if($elementsOptions->custom_field_id == $val->id)                                        
                               @if($elementsOptions->fieldType == "select" &&  ($elementsOptions->field_value !=null && ($elementsOptions->field_option !=null)))
                               <option value="{{$elementsOptions->field_value}}">{{$elementsOptions->field_option}}</option> 
                             @endif
                             @endif
                            @endforeach
                            </select>                     
                     </fieldset>
                    </div> 
                    @break

                    @case($val->fieldType == "checkbox")
                      <div class='form-group fv-row mb-10 fv-plugins-icon-container {{$val->label_name}}'  data-attr="{{$val->label_name}}">
                        <fieldset style="position:relative">
                       <label class='d-flex align-items-center fs-6 fw-bold mb-2'>{{$val->label_name}}</label>   
                     
                        @foreach($getotherFields as $elementsOptions)                     
                           @foreach($getAdiitionalLogic as $key1 => $addlogic)  
                            @if($addlogic->conditionalField == $elementsOptions->id   && $addlogic->selected_option !=0 ) 
                                    <?php                                 
                                        $checkedVal = "checked='checked'";
                                        // $additionalLogicId = $addlogic->id;
                                    ?>
                                    @endif                                                 
                                @endforeach     

                            @if($elementsOptions->custom_field_id == $val->id)

                            @if($elementsOptions->fieldType == "checkbox" &&  ($elementsOptions->field_value !=null && ($elementsOptions->field_option !=null)))
                            <input type='checkbox'  {{$checkedVal}}  class='{{$elementsOptions->field_classname}} custom_fieldsCheck {{$addClass}}'  value="{{$elementsOptions->field_option}}"  data-id="{{$val->id}}"  data-addition-logic="{{$elementsOptions->id}}"  data-visibility="{{$addClass}}"  name='{{$elementsOptions->field_id}}'   id="{{$elementsOptions->field_id}}" required="{{$elementsOptions->required_field}}">
                            <label>{{$elementsOptions->field_option}}</label>
                            @endif
                            @endif
                            @endforeach                   
                     </fieldset>
                    </div> 
                    @break

                    @case($val->fieldType == "radio")
                      <div class='form-group fv-row mb-10 fv-plugins-icon-container {{$val->label_name}}'  data-attr="{{$val->label_name}}">
                        <fieldset style="position:relative">
                       <label class='d-flex align-items-center fs-6 fw-bold mb-2'>{{$val->label_name}}</label>
                       @foreach($getotherFields as $elementsOptions)
                       @if($elementsOptions->custom_field_id == $val->id)
                        @if($elementsOptions->fieldType == "radio" &&  ($elementsOptions->field_value !=null && ($elementsOptions->field_option !=null)))
                        <input type='radio'  class='{{$elementsOptions->field_classname}} {{$addClass}}'data-id="{{$val->id}}"  value="{{$elementsOptions->field_option}}"  name='{{$elementsOptions->field_id}}'   id="{{$elementsOptions->field_id}}" required="{{$elementsOptions->required_field}}">
                        <label>{{$elementsOptions->field_option}}</label>
                        @endif
                        @endif
                        @endforeach
                     
                     </fieldset>
                    </div> 
                    @break

                    @endswitch
                    @endforeach
                </div>                
                </div>           

               </div>  
            </div>
            <div class="card-footer">     
            <!-- <button type="reset" class="btn btn-danger">{{__('Reset')}}</button>          -->
                <!-- <button type="submit" id="updateEditBtn" class="btn btn-primary"> {{__('Submit Form')}}</button> -->
            </div>
        </form>
    </div>
</div>



@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>

@section('custom-script')
   <script>
    let $usersInf = [];
    var formId= 'formubmit_'+'<?php echo $formDetails->id;?>';
    var formName= '<?php echo $formDetails->name;?>';
    $(document).ready(function()
    { 
        window.jsPDF = window.jspdf.jsPDF;
      $("#previrewbtn").on("click",  function () {
        alert(formId);
        var doc = new jsPDF();	
        // Source HTMLElement or a string containing HTML.
        var elementHTML = document.querySelector("#"+formId);

        doc.html(elementHTML, {
            callback: function(doc) {
                // Save the PDF
                doc.save(formName+'.pdf');
            },
            margin: [10, 10, 10, 10],
            autoPaging: 'text',
            x: 0,
            y: 0,
            width: 190, //target width in the PDF document
            windowWidth: 675 //window width in CSS pixels
        });
      }); 
});
</script>
@endsection

