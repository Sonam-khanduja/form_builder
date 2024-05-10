
var arr = [];
var selectOption = '';
var flag = 0;
var otherElements = [];
$(document).ready(function()
{
    $(".label_error").text("");
    $(".fieldType_error").text("");
    $("#checkbox_error").text("");

    $(".custom_fields #customSubmitBtn").on('click',function(e)
    {
        e.preventDefault();
        var customFieldData = $('#custom_fieldsForm').serialize();
        var _token = $("input[name='_token']").val();
        var fieldType = $("#fieldType").val();
        var labelNameVal = $("#label_name").val();      
        var field_idVal = $("#field_id").val();      
        
        var customCheckBoxDiv =  $('#custom_checkboxOption').html(); 
      
        if(labelNameVal === "")
        {
        $(".label_error").text("This field is required");      
        return false;
        }  
        if(fieldType === "")
        {
        $(".fieldType_error").text("This field is required");  
        return false;     
        }

        if(field_idVal === "")
        {
        $(".fieldId_error").text("This field is required");  
        return false;     
        }        
        
        changeFieldType();         
        if(fieldType != ""  && labelNameVal !="" )
        {           
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },    
            cache: false,
            type: "POST",          
            async: true,
            url: customField,
            data: customFieldData,
            success: function (response) {         
                if(response.success == "success")
                {
                    var stringifyData = response.request;    
                    var optionsArr = response.optionArr;        
                    arr.push(stringifyData);       
                    var otherElements = appendOptionalElements(optionsArr);
                    $("#addOptions").val(JSON.stringify(otherElements));     
                    
                    $("#customfield_options").val(JSON.stringify(arr));     
                    $checkLength =  $("#createNewForm").find(".fv-plugins-icon-container").length;
                    if($checkLength != 0)
                    {
                        appendElement(response.html);    
                    }
                    else if(response.html != "")
                    {                    
                        $("#createNewForm").html(response.html);
                        $('#custom_fields').modal('toggle');
                        $('.modal-backdrop').hide();   
                        $("#custom_selectOption").html("");
                        $("#custom_checkboxOption").html("");
                        $("#custom_radioOption").html("");
                        resetVal();                      
                    }                  
                }

             if(response.status == 400)
             {
                $.each(response.errors, function (key, err_value )
                  {
                    if(key === 'label_name')
                    {
                        $(".label_error").text(err_value);
                    }
                    if(key === 'fieldType')
                    {
                        $(".fieldType_error").text(err_value);
                    }
                    console.log("ssas="+key+"val=="+err_value);
                  });
             }else{
                $(".fieldType_error").text("");
                $(".label_error").text("");
             } 
            }           
        
        }); // end        
    }    
    removeRequiredAttr();      

    checkElement();
});

// --------------------------------------------------------
removeRequiredAttr();
//Element Close button 
$(document).on('click','.closeBtn',function()
{    
    if($(document).find("#form_id").length != 0)
    {  
        var btnId =  $(this).attr('data-id');
        var form_id =  $("#form_id").val();
        if(btnId !="" && form_id !="")
        {
            $('#myModal').modal('show');
            $("#deleteYes").on("click",function()
            {
                $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },    
                        cache: false,
                        type: "POST",          
                        async: true,
                        url:deleteFormElement,
                        data: {id:btnId,form_id:form_id},
                        success: function (response) 
                        {
                            $(this).parent().remove();
                            location.reload();
                            $('#myModal').modal('hide');          
                        }
                    });          
            });        
        }
    }else{
    $(this).parent().remove();
    }
   
});

changeFieldType();
});





function appendOptionalElements(arr) 
{
    otherElements.push(arr);
    return otherElements;
}



function changeFieldType()
{
    // Modal value change
    $("#fieldType").on("change",function()
    {
        var checkVal = $(this).val();    
        var fieldType = $("#fieldType").val();  
        $("#custom_selectOption").html("");
        $("#custom_checkboxOption").html("");
        $("#custom_radioOption").html("");

        if(fieldType != "")
        {
         $(".fieldType_error").text("");  
        }
        
        if(checkVal == "checkbox")
        {  
            addCheckBoxOptions();
            checkAtLeastOne(checkVal);
            disabledSubmitButton();           
            $("#selectOptions").css('display','none');
            $("#radioOptions").css('display','none');
          
        }
        if(checkVal == "select")
        { 
           addSelectBoxOptions(); 
           checkAtLeastOne(checkVal);       
           $("#checkboxOptions").css('display','none');
           $("#radioOptions").css('display','none');
    
        }
        if(checkVal == "radio")
        { 
            addRadioOptions();
            checkAtLeastOne(checkVal);   
            $("#checkboxOptions").css('display','none');
            $("#selectOptions").css('display','none');
        }    
        if(checkVal == "input" || checkVal == "textarea" || checkVal == "date" || checkVal == "button" || checkVal == "submit" || checkVal == "")
        {
            displayNone();
        }

        enabledSubmitButton();
    });
    
    }


function checkDuplicateLabel(e)
{
    var labelNameVal = $("#label_name").val();   
    if(labelNameVal != "")
    {
     $(".label_error").text("");       
    }  
    var lablename = e.value;        

    for (let i = 0; i < arr.length ; i++) 
    {  
        if(arr.length > 1)
        {                                
           $("#selectFieldOption").css('display','block');
           $("#checkLabelForNextField").css('display','block');        
        }else{
           $("#selectFieldOption").css('display','none');
           $("#checkLabelForNextField").css('display','none');   
        }
        // Check for same label
        if (arr[i].label_name !== lablename) 
        {             
            // add error message on labale==  
            enabledSubmitButton();
        }
        else
        {
            disabledSubmitButton();
        }
    }

}


function checkElement()
{
    // $(document).find("#createAdditionalLogic").css("color","#7b7b7b");
    // $(document).find("#createAdditionalLogic").css("pointer-events","none");
    //  arr length
    for (let i = 0; i < arr.length ; i++) 
    {  

        $("#select_fieldTypeFrom").append("<option>"+arr[i].label_name+"</option>");
        if(arr.length > 1)
        {        

            // $("#createAdditionalLogic").css("pointer-events","block");
            // $("#createAdditionalLogic").css("color","#212529"); 
        }
    }
    
}

function checkAtLeastOne(field)
{
    if(field == "checkbox")
    {
       disabledSubmitButton();  
       $checkLength = $('input[name="custom_checkboxoptions[]"]').length;        
       $checkVal = $('input[name="custom_checkboxoptions[]"]').val();
        if($checkLength < 1)
        {
            $("#checkbox_error").text("Please select at least one option");
            disabledSubmitButton();        
            return  false;
        }        
    }


    if(field == "select")
    {
       disabledSubmitButton();  
       $checkLength = $('input[name="custom_options[]"]').length;        
       $checkVal = $('input[name="custom_options[]"]').val();
        if($checkLength < 1)
        {
            $("#selectOptions_error").text("Please select at least one option");
            disabledSubmitButton();        
            return  false;
        }        
    }

    if(field == "radio")
    {
        disabledSubmitButton();  
        $checkLength = $('input[name="radio_options[]"]').length;        
        $checkVal = $('input[name="radio_options[]"]').val();
        if($checkLength < 1)
        {
            $("#radioOptions_error").text("Please select at least one option");
            disabledSubmitButton();        
            return  false;
        }        
    }
}


function addCheckBoxOptions()
{
    $("#checkboxOptions").css('display','block');
    $("#rowAdder").on("click",function ()
    {
        $("#checkbox_error").text("");          
        newRowAdd =
            '<div class="checkbox_row"><div class="input-group m-3" >' +           
            '<input type="text" name="custom_checkboxoptions[]"   placeholder="Option" class="form-control m-input custom_checkBox">'+
            '<div class="input-group-prepend">' +
            '<button class="btn btn-danger deleteRow" id="deleteRow" type="button">' +
            '<i class="fas fa-minus" aria-hidden="true"></i></button> </div></div> </div>';
        $('#custom_checkboxOption').append(newRowAdd);
    });

      // Removing options
      $("body").on("click", ".deleteRow", function () {
        $(this).parents(".select_row").remove();
        enabledSubmitButton();
    }); 
   
}

function addSelectBoxOptions()
{       
    $("#selectOptions").css('display','block');
    $("#selectOptions_rowAdder").click(function () {     
        // $("#custom_selectOption").html("");        
        newRowAdd =
            '<div class="select_row"><div class="input-group m-3" >' +           
            '<input type="text" name="custom_options[]" placeholder="Option" class="form-control ">'+
            '<input type="text" name="custom_value[]" placeholder="Value"  class="form-control">'+            
            '<div class="input-group-prepend">' +
            '<button class="btn btn-danger deleteRow" id="deleteRow" type="button">' +
            '<i class="fas fa-minus" aria-hidden="true"></i></button> </div></div> </div>';
        $('#custom_selectOption').append(newRowAdd);
    });       
      // Removing options
      $("body").on("click", ".deleteRow", function () {
        $(this).parents(".select_row").remove();
        enabledSubmitButton();
    }); 
}


function addRadioOptions()
{       
    $("#radioOptions").css('display','block');
    $("#radioOptions_rowAdder").click(function () 
    {                 
        newRowAdd =
            '<div class="radio_row"><div class="input-group m-3">' +           
            '<input type="text" name="radio_options[]" placeholder="Option" class="form-control">'+          
            '<div class="input-group-prepend">' +
            '<button class="btn btn-danger deleteRow" id="deleteRow" type="button">' +
            '<i class="fas fa-minus" aria-hidden="true"></i></button> </div></div> </div>';
        $('#custom_radioOption').append(newRowAdd);
    });
    
      // Removing options
    $("body").on("click", ".deleteRow", function () {
        $(this).parents(".radio_row").remove();
        enabledSubmitButton();
    });     
}



function displayNone()
{
    $("#checkboxOptions").css('display','none');
    $("#selectOptions").css('display','none');
    $("#radioOptions").css('display','none');
}

function disabledSubmitButton()
{
    $('#customSubmitBtn').attr('disabled','disabled');
}
function enabledSubmitButton()
{
    $('#customSubmitBtn').removeAttr('disabled');
}

function resetVal()
{
    $("#custom_fields #label_name").val("");
    $("#custom_fields #fieldType").val("");
    $("#custom_fields #required_field").val("");
    $("#custom_fields #field_id").val("");
    $("#custom_fields #field_classname").val("");
    $("#custom_fields #field_classname").val("");  
    $('#custom_checkboxOption').html(""); 
    displayNone();
}

function appendElement(data)
{
 if(data !='')
 {   
    $('#createNewForm div.fv-plugins-icon-container:last').append(data);
    $('#custom_fields').modal('toggle');
    $('.modal-backdrop').hide();   
    resetVal();
 }
}

$('#createbtn').on('click',function(){
    removeRequiredAttr();
})

// for all appended html remove 
function removeRequiredAttr(){
    // $("#createNewForm").find(".form-control ").removeAttr("required");
    $("#createNewForm").find(".form-control ").removeClass("is-invalid");    
}


// On change Additional Logic..
var form_id ='';
$("#select_fieldTypeFrom").on("change",function()
{
    var val = $(this).val(); 
    form_id = $('#form_id').val();
    $("#additionallogic_form_id").val(form_id);

    if(val !="")
    {
        additionalLogic(val,form_id)


        // Disabled Iteams For Select Field To
        $('.select_fieldType_to option').each(function() 
        {   
            // when value is same
            if(val == $(this).attr('value') ) 
            {
                $(this).attr("disabled","disabled");
            }
            // when value is not same
            if(val != $(this).attr('value') ) 
            {
                $(this).removeAttr("disabled");
            }           
        });

        $("#elementsOptionVal").css('display',"block"); 
        // $(".visibility_option").css('display',"none");
    }else{      
        $(".visibility_option").css('display',"none"); 
        $("#elementsOptionVal").css('display',"none");  
    }  
    
});


// Additional Logic functionality in Edit Form
function additionalLogic(val,form_id)
{
    var html = '';
    var htmlOptions = '';
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },    
        cache: false,
        type: "POST",          
        async: true,
        url:getadditionallogic,
        data: {id:val,form_id:form_id},
        success: function (response) 
        {             
            if(response.success == "success")  
            {
            var select = '';
            var optionId= "";
            var optionName = "";
            var optionClass = "";
            var optionRequire = "";
            var optionCustomFieldId = "";
            var optionElementId ="";
            var flag = 0;
            for(var i=0; i< response.data.length; i++) 
            {   
                optionElementId = response.data[i]['id'];
                optionId= response.data[i]['field_id'];
                optionName = response.data[i]['field_id'];
                optionClass = response.data[i]['field_classname'];
                optionRequire =  response.data[i]['required_field'];
                optionCustomFieldId = response.data[i]['custom_field_id'];
                console.log("option=="+response.data[i]['fieldType']);
               
                if( (response.data[i]['fieldType'] === "radio")  ||  (response.data[i]['fieldType'] === "checkbox") ||  (response.data[i]['fieldType'] === "select") )
                {
                    flag = 1;
                
                    if(response.data[i].field_value !=null && (response.data[i].field_option !=null))
                    {
                        if(response.data[i]['fieldType'] == "select")
                        {
                            select = "select";                       
                            htmlOptions +='<option value="'+response.data[i].field_option+'">'+response.data[i].field_value+'</option>';                
                        }
                        if(response.data[i]['fieldType'] == "radio")
                        {                            
                            html +=  '<input type="hidden" data-id="'+optionCustomFieldId+'" class="elementId" >';
                            html +=  '<input type="radio" id="'+response.data[i]['field_id']+'" data-id="'+optionElementId+'" name="'+response.data[i]['field_id']+'" class="custom_element '+response.data[i]['field_classname']+'"  value="'+response.data[i]['field_option']+'">';
                            html +=  '<label>'+response.data[i]['field_option']+'</label>';
                            console.log("Html"+html);  
                        }
                        if(response.data[i]['fieldType'] == "checkbox")
                        {
                            html +=  '<input type="hidden" data-id="'+optionElementId+'" class="elementId" >';
                            html +=  '<input type="checkbox" id="'+response.data[i]['field_id']+'" name="'+response.data[i]['field_id']+'"  data-id="'+optionElementId+'" class="custom_element  '+response.data[i]['field_classname']+'" value="'+response.data[i]['field_option']+'">';
                            html +=  '<label>'+response.data[i]['field_option']+'</label>';                   
                        }         
                    }
                }else{
                    flag = 0;
                }

                }
            
               var selectOption = '';           
               if(flag !=0)   
               {
                if(select == "select" )
                {                  
                    selectOption +="<div class='form-group fv-row mb-10 fv-plugins-icon-container'>";
                    selectOption +="<label class='d-flex align-items-center fs-6 fw-bold mb-2'>Select Options</label>";
                    selectOption +=  '<select name="'+optionName+'" data-id="'+optionCustomFieldId+'"  id="'+optionId+'" class="form-select form-control  '+optionClass+'" value="" data-id="'+optionCustomFieldId+'">';
                    selectOption +=  htmlOptions;
                    selectOption += '</select></div>';
                    $("#elementsOptionVal").html(selectOption);
                }else {
                    selectOption +="<div class='form-group fv-row mb-10 fv-plugins-icon-container'>";
                    selectOption +="<label class='d-flex align-items-center fs-6 fw-bold mb-2'>Select Options</label>";
                    selectOption +=  html;
                    selectOption += '</div>';
                    $("#elementsOptionVal").html(selectOption); 
                }
               }else{
                $(".visibility_option").css('display',"block");     
                $("#elementsOptionVal").css('display',"none");   
               }

               $(".custom_element").on('click',function()
               {                
                   var checkBoxval = $(this).val();      
                   var elementId =        $(this).attr("data-id");     
                   if(checkBoxval != "" && elementId != '' )
                   {
                    $(".visibility_option").css('display',"block");     
                    $("#conditionalField").val(elementId);
                   }                  
               });

               
            //    location.reload();
            }
            
        }
    });
}
// ********************************************************************************************************************


    $("#additionalLogicSubmitBtn").on('click',function(e)
    {
        e.preventDefault();
        var additionallogic_Form = $('#additionallogic_Form').serialize();      
        var visibility = $("#select_visibility_option").val();
        if(visibility === "")
        {
            $(".visibility_error").text("This field is required");      
            return false;
        }                
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },    
            cache: false,
            type: "POST",          
            async: true,
            url:additionalLogicForm,
            data: additionallogic_Form,
            success: function (response) 
            {   
                $("#select_fieldTypeFrom").val('');
                $('#additionalLogic').modal('toggle');             
            }
        });

    });
    // Display none;

    $(".show").parent().css("display","block"); 
    // $(".hide").parent().css("display","none"); 


    var editFormId = $('.needs-validation').attr('id');    
    $('input[type="checkbox"]').on('click',function()
    {
        if($(this).is(':checked'))
        {
            var elementOptionId=  $(this).attr('data-id');
            var additionalLogicId=  $(this).attr('data-addition-logic'); 
            additionLogicOnElemnets(elementOptionId,"checked",additionalLogicId);
            // updateAdditionLogicOnElemnets(elementOptionId,"checked");
             
        }else{
            var elementOptionId=  $(this).attr('data-id');   
            var additionalLogicId=  $(this).attr('data-addition-logic'); 
            var visibility=  $(this).attr('data-visibility');  
             
            additionLogicOnElemnets(elementOptionId,"unchecked",additionalLogicId);
            // updateAdditionLogicOnElemnets(elementOptionId,"checked");

        }      
    });

    $('input[type="radio"]').on('click',function()
    {   
        if($(this).is(':checked'))
        {
            var elementOptionId=  $(this).attr('data-id');            
            var additionalLogicId=  $(this).attr('data-addition-logic'); 
            // alert(elementOptionId+"==="+additionalLogicId);
            additionLogicOnElemnets(elementOptionId,"checked",additionalLogicId);             
        }else{
            var elementOptionId=  $(this).attr('data-id');   
            var additionalLogicId=  $(this).attr('data-addition-logic'); 
            var visibility=  $(this).attr('data-visibility');               
            additionLogicOnElemnets(elementOptionId,"unchecked",additionalLogicId);
            // updateAdditionLogicOnElemnets(elementOptionId,"checked");

        }      
    });
    
// ==================CHANGE LOGIC ON EDIT======================================================

function additionLogicOnElemnets(elementOptionId,condition,additionalLogicId)
{    
    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },    
        cache: false,
        type: "POST",          
        async: true,
        url:getadditionalLogicOption,
        data: {id:elementOptionId,condition:condition,additionalLogicId:additionalLogicId},
        success: function (response) 
        {
            if(response.success =="success")
            {                            
                for (let i = 0; i < response.elementOptions.length; i++) 
                    { 
                        if($("#"+response.elementOptions[i]['field_id']).attr('data-id') ==  response.elementOptions[i]['select_fieldType_to'])   
                        {                           
                            // console.log("asa=="+$("#"+response.elementOptions[i]['field_id']).hasClass(response.elementOptions[i]['visibility']));
                            if($("#"+response.elementOptions[i]['field_id']).hasClass(response.elementOptions[i]['visibility']))
                            {   
                                if(condition == "checked")
                                {    // Remove Class
                                    if(response.elementOptions[i]['visibility'] == "show" )
                                    {
                                      $("#"+response.elementOptions[i]['field_id']).removeClass(response.elementOptions[i]['visibility']);
                                      $("#"+response.elementOptions[i]['field_id']).parent().css("display","block");
                                    }

                                    if(response.elementOptions[i]['visibility'] == "hide" && response.elementOptions[i]['change_event'] !=0)
                                    {
                                      $("#"+response.elementOptions[i]['field_id']).parent().css("display","none");
                                    }                                
                                 
                                }                           
                          }
                        }      
                        
                        if(condition == "unchecked")
                        {   
                            // console.log("asa=="+response.elementOptions[i]['field_id']+"visib=="+response.elementOptions[i]['visibility']);
                        
                            if(response.elementOptions[i]['visibility'] == "hide")
                                {
                                    $("#"+response.elementOptions[i]['field_id']).addClass("show"); 
                                    $(".show").parent().css("display","none");
                                }

                                // if(response.elementOptions[i]['visibility'] == "hide" && response.elementOptions[i]['change_event'] !=0)
                                // {
                                //   $("#"+response.elementOptions[i]['field_id']).parent().css("display","block");
                                // } 

                        }
                        



                    }
              
            }
        }
    });           

// **************************************************************************************************************************

// Update AdditionalLogic On edit
// function updateAdditionLogicOnElemnets(data,condition)
// { 
//     $.ajax({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },    
//         cache: false,
//         type: "POST",          
//         async: true,
//         url:updateAdditionalLogic,
//         data: {data:data,condition:condition},
//         success: function (response) 
//         {
//         }
//     });
// }

// **************************************************************************************************************************

}



$("#updateEditBtn").on("click", function(){
    
})