<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Form;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Response;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpParser\Node\Expr\Cast\Object_;

class FormsController extends Controller
{

    public function __construct()
    {     
        $this->formObj = new Form();
    }

    /**
     * Display a listing of the Form records.
     *
     * @author DEVIT
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $form = $this->formObj->getFormListForRoles();
        if ($request->ajax())
        {
            return DataTables::of($form)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('description', function ($row) {
                return  substr($row->description,0, 26) ;
            })            	
            ->addColumn('layout', function ($row) {
                if($row->layout == 1)
                {
                    $layout = '<span>'.__('Portrait').'</span>';
                }
                else if($row->layout == 0){
                    $layout = '<span>'.__('Lanscape').'</span>';
                }
                return $layout;
            })
            ->editColumn('action', 'forms.action')
            ->rawColumns(['name','description','layout','action'])
            ->make(true);
        }
        return view('forms.index');
    }

    /**
     * This method used Show the form for creating a new form
     *
     * @author DEVIT
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
       return view('forms.create');
    }


     /**
     * This method used to store a Form into database
     *
     * @author DEVIT
     * @param  \Illuminate\Http\StoreFormRequest  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(StoreFormRequest $request)
    {      
        $createFormObject = [
            'name' => $request->name,
            'layout' => $request->layout,
            'user_id' => auth()->id(),
            'description' => $request->description
        ];    
        
        try {
            $createUser = Form::create($createFormObject);           
            if(isset($request->customfield_options))
            { 
                if(!empty($request->addOptions))
                {
                    $request->addOptions =  $request->addOptions;
                }
              $this->formObj->addCustomElements($createUser['id'],$request->customfield_options,$request->addOptions);
            }         
            DB::commit();  
            toastr()->success(__('custom_validation.record_create', ['attribute' => 'Forms']));
            return redirect('admin/forms');      
           
        }catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }
        return back();
    }

     /**
     * This method used Show the form for Edit a new user
     *
     * @author DEVIT
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
        $formDetails        = Form::find($id);  
        $getCustomFields    = $this->formObj->getCustomFieldsElement($id);      
        $getotherFields     =  $this->formObj->getOtherFieldsElement($id);        
        $getAdiitionalLogic = $this->formObj->getAdditionalogicValues($id);  

        return view('forms.edit', compact('formDetails','getCustomFields','getotherFields','getAdiitionalLogic'));
     }

    /**
     * This method used Show the form 
     *
     * @author DEVIT
     * @return \Illuminate\Http\Response
     */

     public function view($id)
     {
        $formDetails = Form::find($id);  
        $getCustomFields    = $this->formObj->getCustomFieldsElement($id);      
        $getotherFields     =  $this->formObj->getOtherFieldsElement($id);        
        $getAdiitionalLogic = $this->formObj->getAdditionalogicValues($id);        
        $view = view('forms.view', compact('formDetails','getCustomFields','getotherFields','getAdiitionalLogic'));
        return   $view;
     }

     
    /**
     * This method used for Additional Logic
     *
     * @author DEVIT
     * @return \Illuminate\Http\Response
     */
    public function getadditionallogic(Request $request)
    { 
       $response =[];
       if(!empty($request['id']))
       {       
        $getOtherElements =  $this->formObj->getOtherElement($request['id'],$request['form_id']);
        $response['data'] = $getOtherElements; 
        $response['success'] = "success";        
       }
       return $response;
    }

    /**
     * This method used to create custom fields and store it into db
     *
     * @author DEVIT
     * @return  \Illuminate\Http\Response
     */
     public function customFields(Request $request)
     {
        $html = '';
        $optionArr = '';
        $createFormObject = [];
        $response = [];
        $validator =  Validator::make($request->all(),[
                    'label_name' => 'required',
                    'fieldType' => 'required'  
                ]);
        
        if($validator->fails())
        {        
            return response()->json([
                    'status' => 400,
                    'errors' => $validator->errors()->all(),
            ]);
        
        }

        if ($request->ajax())
        {         
        if($request->fieldType == "input") 
        {       
            $required  =   $this->checkRequirefields($request);
            $idname    =   $this->checkIDfields($request);
            $className =   $this->checkClassfields($request);
            $labelName  =   $this->checkLabelName($request);
            $html  .= "<div class='form-group fv-row mb-10 fv-plugins-icon-container " . $idname . "'  data-attr='" . $idname . "'>";
            $html  .= '<fieldset style="position:relative">';
            $html  .= "<label class='d-flex align-items-center fs-6 fw-bold mb-2'>" . $labelName . "</label><input type='text'  class='form-control " . $className . "'   name='" . $idname . "'  " . $required . "  id='" . $idname . "' >";

            $html  .= $this->closeButton();
            $html  .= "</fieldset></div>";        
            $createFormObject = [
                'fieldType' => $request->fieldType,
                'required_field' =>  $required,
                'field_id' => $idname,
                'field_classname' => $className,
                'label_name' => $labelName,
                'form_id' =>  $request->form_id,
                'field_data' =>  $html
            ];
        }


        if($request->fieldType == "textarea") 
        {
            $required  =   $this->checkRequirefields($request);
            $idname    =   $this->checkIDfields($request);
            $className =   $this->checkClassfields($request);
            $labelName  =   $this->checkLabelName($request);
            $html  .= "<div class='form-group fv-row mb-10 fv-plugins-icon-container " . $idname . "'  data-attr='" . $idname . "'>";
            $html  .= '<fieldset style="position:relative">';
            $html  .= "<label class='d-flex align-items-center fs-6 fw-bold mb-2'>" . $labelName . "</label>";
            $html  .= "<textarea " . $required . " class='form-control " . $className . "' " . "  id='" . $idname . "' name='" . $idname . "' rows='3' ></textarea>";
            $html  .= $this->closeButton();
            $html  .= "</fieldset></div>";

            $createFormObject = [
                'fieldType' => $request->fieldType,
                'required_field' =>  $required,
                'field_id' => $idname,
                'field_classname' => $className,
                'label_name' => $labelName,
                'form_id' =>  $request->form_id,
                'field_data' =>   $html
                ];
        }

        if($request->fieldType == "radio") 
        {
            $required  =   $this->checkRequirefields($request);
            $idname    =   $this->checkIDfields($request);
            $className =   $this->checkClassfields($request);
            $labelName  =   $this->checkLabelName($request);
            $radioOptions =   $this->addRadioOptions($request);

            if(!empty($radioOptions))
            {
                $optionArr      =   $this->appendOtherOptions($request);
            $html  .= "<div class='form-group fv-row mb-10 fv-plugins-icon-container " . $idname . "' data-attr='" . $idname . "' >";
            $html  .= '<fieldset style="position:relative">';
            $html  .= "<label class='d-flex align-items-center fs-6 fw-bold mb-2'>" . $labelName . "</label>";
            $html  .= $radioOptions;
            $html  .= $this->closeButton();
            $html  .= "</fieldset></div>";
            }
            $createFormObject = 
            [
                'fieldType' => $request->fieldType,
                'required_field' =>  $required,
                'field_id' => $idname,
                'field_classname' => $className,
                'label_name' => $labelName,
                'form_id' =>  $request->form_id,
                'field_data' =>   $html
            ];
        }

        if($request->fieldType == "date")
        {
            $required  =   $this->checkRequirefields($request);
            $idname    =   $this->checkIDfields($request);
            $className =   $this->checkClassfields($request);
            $labelName  =   $this->checkLabelName($request);
            $html  .= "<div class='form-group fv-row mb-10 fv-plugins-icon-container " . $idname . "'  data-attr='" . $idname . "'>";
            $html  .= '<fieldset style="position:relative">';
            $html  .= "<label class='d-flex align-items-center fs-6 fw-bold mb-2'>" . $labelName . "</label><input type='date'  class='form-control " . $className . "'   name='" . $idname . "'  " . $required . "  id='" . $idname . "' >";
            $html  .= $this->closeButton();
            $html  .= "</fieldset></div>";

            $createFormObject = [
                'fieldType' => $request->fieldType,
                'required_field' =>  $required,
                'field_id' => $idname,
                'field_classname' => $className,
                'label_name' => $labelName,
                'form_id' =>  $request->form_id,
                'field_data' =>   $html
            ];

        }
        if($request->fieldType == "select") 
        {            
            $required   =   $this->checkRequirefields($request);
            $idname     =   $this->checkIDfields($request);
            $className  =   $this->checkClassfields($request);
            $labelName  =   $this->checkLabelName($request);
            $options    =   $this->addSelectOptions($request);
            if(!empty($options))
            {
                $optionArr      =   $this->appendOtherOptions($request);
            $html  .= "<div class='form-group fv-row mb-10 fv-plugins-icon-container " . $idname . "' data-attr='" . $idname . "' >";
            $html  .= '<fieldset style="position:relative">';
            $html  .= "<label class='d-flex align-items-center fs-6 fw-bold mb-2'>" . $labelName . "</label>";
            $html  .= $options;
            $html  .= $this->closeButton();
            $html  .= "</fieldset></div>";
            }
            $createFormObject = [
                'fieldType' => $request->fieldType,
                'required_field' =>  $required,
                'field_id' => $idname,
                'field_classname' => $className,
                'label_name' => $labelName,
                'form_id' =>  $request->form_id,
                'field_data' =>  $html
            ];

        }

      
        if($request->fieldType == "checkbox") 
        {
            $required        =   $this->checkRequirefields($request);
            $idname          =   $this->checkIDfields($request);
            $className       =   $this->checkClassfields($request);
            $labelName       =   $this->checkLabelName($request);
            $checkBoxOptions =   $this->addCheckBoxOptions($request); 
            if(!empty($checkBoxOptions))
            {
               $optionArr      =   $this->appendOtherOptions($request);
               
            $html  .= "<div class='form-group fv-row mb-10 fv-plugins-icon-container " . $idname . "' data-attr='" . $idname . "' >";
            $html  .= '<fieldset style="position:relative">';
            $html  .= "<label class='d-flex align-items-center fs-6 fw-bold mb-2'>" . $labelName . "</label>";
            $html  .= $checkBoxOptions;
            $html  .= $this->closeButton();
            $html  .= "</fieldset></div>";
            }
            $createFormObject = [
                'fieldType' => $request->fieldType,
                'required_field' =>  $required,
                'field_id' => $idname,
                'field_classname' => $className,
                'label_name' => $labelName,
                'form_id' =>  $request->form_id,             
                'field_data' =>  $html
                ];
        }
      
        $response['html']    = $html;
        $response['request'] = $createFormObject;
        $response['optionArr'] = $optionArr;
        $response['success'] = "success";
        return $response;
    }
          
}

    

 
     /**
     * Start These method used check some validations
     *
     * @author DEVIT
     * @return string
     */
     public function addSelectOptions($request)
     {  
        $selectButtonOption = '';
        if(isset($request['custom_options'])  && isset($request['custom_value'] )) 
        {
            $labelName  =   $this->checkLabelName($request); 
            $custom_options = $request['custom_options'];
            $custom_value = $request['custom_value'];  
            if(!empty($custom_options) && (!empty($custom_value)))
            {
                $res =  array_map(function ($custom_options, $custom_value) {
                return [$custom_options, $custom_value];
                }, $custom_options, $custom_value);            

                $selectButtonOption .= '<select class="form-select" aria-label="Default select example">';
                $selectButtonOption .= '<option selected>Select    ' . $labelName.'</option>';
                foreach($res as $key => $value) {                                  
                    $selectButtonOption .= '<option value="' . $value[1] . '">' . $value[0] . '</option>';
                }           
                $selectButtonOption .= '</select>';
              
            }                         
        }
        return  $selectButtonOption;	
     }    
     
    

     public function addRadioOptions($request)
     {  
        $radioButtonOption = '';
         if(isset($request['radio_options']) )
         {   
            $labelName  =   $this->checkLabelName($request);  
             foreach($request['radio_options'] as $radioOptions)
             {   
                if(!empty($radioOptions))
                {
                $radioButtonOption  .='<div class="form-check form-check-inline">';
                $radioButtonOption .='<input type="radio" class="custom_fields_options form-check-input" name="'.$labelName.'" value="'.$radioOptions.'"  />';
                $radioButtonOption .='<label class="form-check-label">'.$radioOptions.'</label>';
                $radioButtonOption  .="</div>";  
                }   
                
            }      
        }        
        return  $radioButtonOption;	
    }

    public function addCheckBoxOptions($request)
    {  
        $checkBoxboxOption = '';
        if(isset($request['custom_checkboxoptions']) )
        {   
            $labelName  =   $this->checkLabelName($request);   
            foreach($request['custom_checkboxoptions'] as $checkBoxOptions)
            {                   
                if(!empty($checkBoxOptions))
                {
                $checkBoxboxOption  .='<div class="form-check form-check-inline">';
                $checkBoxboxOption .='<input type="checkbox" class="custom_fields_options form-check-input" name="'.$labelName.'[]" value="'.$checkBoxOptions.'"  />';
                $checkBoxboxOption .='<label class="form-check-label">'.$checkBoxOptions.'</label>';
                $checkBoxboxOption  .="</div>";
                }             
            }
          
        }        
        return  $checkBoxboxOption;	
    }

    public function appendOtherOptions($request)
    {   
        $labelName  =   $this->checkLabelName($request);           
        if(isset($request['custom_checkboxoptions'])) 
        {
            foreach($request['custom_checkboxoptions'] as $checkBoxOptions) 
            {
                if(!empty($checkBoxOptions)) 
                {
                    $newArray[] =  $checkBoxOptions;                
                }
            }
        } // end Adding checkbox values


        // For Radio Button
        if(isset($request['radio_options'])) 
        {
            foreach($request['radio_options'] as $radioOptions) 
            {
                if(!empty($radioOptions)) 
                {
                    $newArray[] =  $radioOptions;      
                }

            }
        } // end Radio Button


        // Select Options
        if(isset($request['custom_options'])  && isset($request['custom_value'] )) 
        {
            $labelName  =   $this->checkLabelName($request); 
            $custom_options = $request['custom_options'];
            $custom_value = $request['custom_value'];  
            if(!empty($custom_options) && (!empty($custom_value)))
            {
                $res =  array_map(function ($custom_options, $custom_value) {
                return [$custom_options, $custom_value];
                }, $custom_options, $custom_value);  
                             
                foreach($res  as $key => $value)
                {                   
                    if(!empty($value))
                    {
                        $newArray[] = $value;
                       
                    }
                }
            }
        } // end Select Options      
            
        return $newArray;
    }

    public function closeButton()
    {
        $closeButton = '<button type="button"  class="closeBtn" style="position: absolute;right:0px;top:1px;outline:1px solid #fff">
        <span>&times;</span>
        </button>';
        return $closeButton;
    }

    public function checkLabelName($request)
    {
        $label_name = '';      
        if($request->label_name !='' )
        {
            $label_name = $request->label_name;          
        }      
        return $label_name;        
    }

    public function checkRequirefields($request)
    {
        $required = '';      
        if($request->required_field !='' || ($request->required_field !="on" ))
        {
            $required =  'required';        
        }      
        return $required;        
    }

    public function checkIDfields($request)
    {        
        $idname = '';  
        if($request->field_id !='')
        {
            $idname =  $request->field_id;           
        }     
        return $idname;        
    }

    

    public function checkClassfields($request)
    {      
        $className ='';
        if($request->field_classname !='')
        {
            $className =  $request->field_classname;          
        }
        return $className;        
    } // end validations
    
     
      /**
     * This method used to delete a specific form
     *
     * @author DEVIT
     * @param  \Illuminate\Http\form  $form
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (isset($id)) {
            $this->formObj->deleteFormById($id);
            toastr()->success(__('custom_validation.record_delete', ['attribute' => 'Form']));
            return back();
        }else {
            toastr()->error(__('404 | custom_validation.record_delete', ['attribute' => 'Form']));
            return back();
        }
    }

    /**
     * This method used to Update a Form Elements Custom fields table
     *
     * @author DEVIT
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request)
    {       
        if(isset($request['form_id']))
        {
            if(!empty($request->addOptions))
            {
                $request->addOptions =  $request->addOptions;
            }
          $this->formObj->addCustomElements($request['form_id'],$request->customfield_options,$request->addOptions);

          if(isset($request['formName']) || isset($request['formDescription']))
          {
            $this->formObj->updateCustomField($request);
          }
        }       
        toastr()->success(__('custom_validation.record_update', ['attribute' => 'Custom Field']));
        return redirect('/admin/forms');      
    }

     /**
     * This method used to Delete a Form Elements
      *
      * @author DEVIT
      * @return  \Illuminate\Http\Response
     */
    public function deleteFormElement(Request $request)
    {
       
        if (isset($request['id'])) {
            $this->formObj->deleteFormElement($request);           
            toastr()->success(__('custom_validation.record_delete', ['attribute' => 'Custom Field']));
            return back();
        }else {
            toastr()->error(__('404 | custom_validation.something_went_wrong', ['attribute' => 'Custom Field']));
            return back();
        }
       
    }

    /**
     * This method used to add additional Logic for HIDE/SHOW
     *
     * @author DEVIT
     * @return  \Illuminate\Http\Response
     */
    public function additionallogic(Request $request)
    {  
        if ($request->ajax())
        {        
            if(isset($request->select_fieldTypeFrom)) 
            {   
                $this->formObj->insertAdditionalogicValues($request);
                toastr()->success(__('custom_validation.record_add', ['attribute' => 'Additional Logic']));
            }
        }
    }

     /**
     * This method used to get Option Id and HIDE/SHOW Element
     * @author DEVIT
     * @return  \Illuminate\Http\Response
     */
    public function getadditionalLogicOption(Request $request)
    {  
      
        $response = [];
        if(isset($request['id']) && isset($request->condition))
        {
          $getAdditionOptions =  $this->formObj->getAdditionalogicValuesByElementId($request['id'],$request->additionalLogicId);          
           $this->formObj->updateAdditionalLogicOnEvent($request['id'],$request->condition,$request->additionalLogicId);       
          $response['success']  = "success";
          $response['elementOptions']  = $getAdditionOptions;
        }
        return $response;
    }




    /**
     * This method used to display Form for Submit By User 
     * @author DEVIT
     * @return  \Illuminate\Http\Response
     */
    public function formcreate($id)
    {
        $formDetails        = Form::find($id);  
        $getCustomFields    = $this->formObj->getCustomFieldsElement($id);      
        $getotherFields     =  $this->formObj->getOtherFieldsElement($id);        
        $getAdiitionalLogic = $this->formObj->getAdditionalogicValues($id);  

        return view('forms.submitForm', compact('formDetails','getCustomFields','getotherFields','getAdiitionalLogic'));
    }

    /**
     *  Form Submit By User
     * @author DEVIT
     * @return  \Illuminate\Http\Response
     */
    public function formSubmit(Request $request)
    {
      $formName =  $this->formObj->insertSubmitFormValuesByUser($request);  
      toastr()->success(__('custom_validation.record_create', ['attribute' => 'Form Submit']));
      return back();
    }


}
