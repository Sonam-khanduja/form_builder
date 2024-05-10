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
        <form method="POST" action="{{ route('forms.customfields') }} " class="pull-right custom_fieldsForm" id="custom_fieldsForm" >
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
                            <option value="button">Button</option>     
                            <option value="submit">Submit</option>                                                           
                </select>
                <span class="text-danger error-text fieldType_error fv-plugins-message-container" role="alert"></span>
             </div>            
             <div class="form-group custom_elements" id="main_checkboxOptions">          
                <div id="checkboxOptions" style="display:none">
                   <div>                                
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
<!-- end POPUP -->





<!--Custom Additional Logic -->
<div id="additionalLogic" class="additionalLogic modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">{{__('Additional Logic')}}</h5>        
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

    <form method="POST" action="{{ route('forms.additionallogic') }}" class="pull-right custom_fieldsForm" id="additionallogic_Form">      
            @csrf                  
            <input type="hidden" name="form_id" id="additionallogic_form_id" value="">  
            <div class="form-group custom_elements" id="additionallogic_main">
                <div class="form-group custom_elements" id="additionallogic_options">                
                            
                       <label for="fieldType" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Select Field Type')}}</label>            
                        <select name="select_fieldTypeFrom" id="select_fieldTypeFrom"  class="form-select form-control " value="" required>   
                        <option value="">{{__('Please select one')}}</option>   
                            @if(!empty($getCustomFields))        
                                @foreach($getCustomFields as $val)                          
                                    <option value="{{$val->id}}">{{ucfirst($val->label_name);}}</option>
                                @endforeach
                            @endif
                                
                        </select>       
                        <input type="hidden" id="conditionalField"  name="conditionalField" value="">

                        <div class="form-group"><div id="elementsOptionVal"></div></div>
                        
                        <div class="form-group custom_elements" id="main_visibility_option">   
                        <div id="visibility_option"  class="visibility_option" style="display:none">                                      
                        <label for="field_selectionOption" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Visiblity')}}</label>   
                            <select id="select_visibility_option" name="select_visibility_option" class="form-select form-control" value="">
                                    <option value="">{{__('Please select one')}}</option>                                       
                                        <option value="hide">Hide</option>
                                        <option value="show">Show</option>     
                            </select>
                            </span>                     
                        </div>
                        <span class="text-danger error-text visibility_error fv-plugins-message-container " role="alert"></span>
                    </div>


                    <div class="form-group custom_elements" id="main_visibility_option">   
                        <div id="visibility_option" class="visibility_option" style="display:none"> 
                       <label for="fieldType" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Choose Field Type')}}</label>            
                        <select name="select_fieldType_to" id="select_fieldType_to"  class="form-select form-control select_fieldType_to " value="" required>
                        @if(!empty($getCustomFields))           
                            @foreach($getCustomFields as $val)                          
                                <option value="{{$val->id}}">{{ucfirst($val->label_name);}}</option>
                            @endforeach
                        @endif
                        </select>
                   </div>
                  
                </div>

                    <!-- <div class="form-group custom_elements" id="main_positions">   
                        <div id="visibility_option" style="display:none">                                      
                        <label for="field_selectionOption" class="d-flex required align-items-center fs-6 fw-bold mb-2">{{__('Visiblity')}}</label>   
                            <select id="select_position" name="select_position" class="form-select form-control" value="">
                                    <option value="">{{__('Please select one')}}</option>                                       
                                        <option value="after">After</option>
                                        <option value="before">Before</option>     
                            </select>
                            </span>                     
                        </div>
                    </div> -->
                  

                   
                </div>             
             </div>   

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="additionalLogicSubmitBtn"  class="btn btn-danger additionalLogicSubmitBtn">{{__('Submit')}}</button>
                </div>
            </div>
        </form>              
    </div>
  </div>
</div>
</div>
<!-- end POPUP -->

<!--Custom Additional Logic  -->



<!-- Delete Form Element -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{__('Delete Field Elements')}}</h4>
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
            {{__('Do you want to Delete this Element?')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" id="deleteYes" class="btn btn-primary">Yes</button>
            </div>
        </div>
    </div>
</div>