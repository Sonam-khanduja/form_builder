<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormSubmitMail;

class Form extends Model
{
    use HasFactory;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'layout',
        'description',
        'user_id'        
    ];

    // /**
    //  * create a new form
    //  *
    //  * @Query Request
    // */
    // public function createNewForm($data)
    // {      

    //    $data = DB::table('forms')->insert($data);
    //    return $data;

    // }
     /**
     * Delete a Form
     *
     * @Query <integer>,Request
    */
    public function deleteFormById($id)
    {
        $form = Form::find($id)->delete();       
        return $form;
    }

     /**
     * Edit/Update custom fields
     *
     * @Query <integer>,Request
    */
    public function updateCustomField($req)
    {
        
        Form::where('id', $req['form_id'])->update(['name' => $req['formName'],'description'=>$req['formDescription']]);
    }


    /**
     * Add custom fields
     *
     * @Query <integer>,Request
    */
    public function addCustomElements($id,$req,$otherOptions)
    {
        $data = [];
        $req = json_decode($req, true);
        $otherOptions = json_decode($otherOptions, true);        
        if(!empty($req)) 
        {      
            try {
                foreach($req as $key => $val) {
                    $val['form_id'] = $id;
                    $val['user_id'] = auth()->id();
                    if($val['field_data']) {
                        $value = $val['field_data'];
                        $val['field_data'] = addslashes($value);
                    }
                    $getIds =  DB::table('custom_fields')->insertGetId($val);                
                    if(!empty($otherOptions[$key])) {
                        foreach($otherOptions[$key] as  $getVal) {
                            if(is_array($getVal)) {
                                DB::table('elements_options')->insert(['custom_field_id' => $getIds,'field_option' => $getVal[1],'field_value' => $getVal[0]]);
                            } else {
                                DB::table('elements_options')->insert(['custom_field_id' => $getIds,'field_option' => $getVal,'field_value' => $getVal]);
                            }
                        }
                    }
                }
            }catch(\Exception $e)
            {
                dd( $e->getMessage());
            }   
        }
    }
   

    /**
     * Get Custom Fields From Custom Fields Tables
     *
     * @Query <integer>,Request
    */
    public function getCustomFieldsElement($formId)
    {
       $data =  DB::table('custom_fields')->where('form_id',$formId)->get();
       return  $data;      
    }

     /**
     * Get Custom Other optional Fields From Element Options Tables
     *
     * @Query <integer>,Request
    */
    public function getOtherFieldsElement($formId)
    {
       $data =  DB::table('custom_fields')
                    ->join('elements_options','elements_options.custom_field_id','=','custom_fields.id')                   
                    ->where('custom_fields.form_id',$formId)->get();                   
       return  $data;      
    }


    /**
     * Get Form List 
     *
     * @Query <integer>,Request
    */
    public function getFormListForRoles()
    {
        // if(auth()->user()->is_admin == 1){
            $form = Form::select('id','name','layout','description');         
        // }else{
            // $form = Form::join('users', 'users.id', '=', 'forms.user_id')
            //         ->where('users.id', '=',  auth()->id())            
            //         ->where('users.is_admin', '=', 0)            
            //         ->select(['forms.id','forms.name','forms.layout','forms.description']);
        // }      
       return $form;      
    }
    

    /**
     * Get Element by Id
     *
     * @Query <integer>,Request<integer>
    */
    public function getOtherElement($field_id,$form_id)
    {

        $data =  DB::table('custom_fields')
                    ->where('custom_fields.form_id',$form_id)
                    ->where('custom_fields.id',$field_id)
                    ->get()->toArray();
        
        if($data[0]->fieldType == "radio" || $data[0]->fieldType == "checkbox" ||  $data[0]->fieldType == "select" )
        {
          $data =  DB::table('custom_fields')
                ->join('elements_options','elements_options.custom_field_id','=','custom_fields.id')                   
                ->where('custom_fields.form_id',$form_id)
                ->where('elements_options.custom_field_id',$field_id)
                ->get();
        }
        
        return  $data; 
    }



     /**
     * Insert Additional Logics values
     *
     * Request<Array>
    */
    public function insertAdditionalogicValues($data)
    { 
        // dd($data);
        $data1 =['form_id'=>$data['form_id'], 'select_fieldType_to'=> $data['select_fieldType_to'] ,'select_fieldTypeFrom'=> $data['select_fieldTypeFrom'],'visibility'=>$data['select_visibility_option'],'conditionalField'=>$data['conditionalField'],'change_event'=>1,'selected_option'=>"0"];
        DB::table('additional_logic')->insert($data1);    
    }



    /**
     * Get Additional Logics values By form ID
     *
     * Request<integer>
    */
    public function getAdditionalogicValues($id)
    {      
        $data =  DB::table('custom_fields')
        ->join('elements_options','elements_options.custom_field_id','=','custom_fields.id')    
        ->join('additional_logic','additional_logic.conditionalField','=','elements_options.id')
        ->where('custom_fields.form_id',$id)   
        ->get(['additional_logic.id','additional_logic.conditionalField','additional_logic.visibility','additional_logic.select_fieldType_to','additional_logic.select_fieldTypeFrom','additional_logic.change_event','additional_logic.selected_option' ])->toArray();  
        return  $data; 
    }

    /**
     * Get other elements to HIDE/SHOW By Element ID
     *
     * Request<integer>
    */
    public function getAdditionalogicValuesByElementId($id,$conditionalId)
    {  
        //dd($conditionalId);
        // echo $id. "condition==".$conditionalId;       
        $data =  DB::table('additional_logic')
                   ->join('custom_fields','additional_logic.select_fieldType_to','=','custom_fields.id')    
                   ->where('additional_logic.select_fieldTypeFrom',$id)
                   ->where('additional_logic.conditionalField',$conditionalId)
                  ->get()->toArray();
        if(!empty($data))
        {
            return  $data;
        }


                //   dd("============". $data);
        
    }


    /**
     * Update on HIDE/SHOW  elements On edit
     *
     * Request<integer>
    */
    public function updateAdditionalLogicOnEvent($id,$condition,$conditionalId)
    {   

        $data1 =  DB::table('additional_logic')
        ->join('custom_fields','additional_logic.select_fieldType_to','=','custom_fields.id')    
        ->where('additional_logic.conditionalField',$conditionalId)
        ->where('additional_logic.select_fieldTypeFrom',$id)
        ->get();
       

        if(!empty($condition) && $condition =="checked")
        {     
            if($data1[0]->visibility == "show")
                {
                    $data1 =  DB::table('additional_logic')
                    ->where('additional_logic.conditionalField',$conditionalId)
                    ->where('additional_logic.select_fieldTypeFrom',$id)
                    ->update(['change_event'=>1,'selected_option'=>1,'visibility'=>'hide']); 
                }
          
        }

        if(!empty($condition) && $condition =="unchecked")
        {   
            
            if($data1[0]->visibility == "hide")
            {
                $data1 =  DB::table('additional_logic')
                ->where('additional_logic.conditionalField',$conditionalId)
                ->where('additional_logic.select_fieldTypeFrom',$id)
                ->update(['change_event'=>1,'selected_option'=>0,'visibility'=>'show']); 
            }     
          
           
        }
     
    }

    /**
     * Delete Field Element From Database
     *
     * Request<Array>
    */
    public function deleteFormElement($data)
    {
        if(!empty($data['id']))
        {
        $res = DB::table('custom_fields')
             ->where('id',$data['id'])->delete();  
        return $res;
        }      
    }


    /** Edit Form Element By Form Id 
     * 
     *
     * Request<Array>
    */
    public function editFormElements($request)
    {
        if(!empty($request['id']))
        {
            $res =   DB::table('forms')
                ->where('id',$request['form_id'])
                ->update(['formName'=>$request['formName'],'formDescription'=>$request['formDescription']]);
            return $res;
        }      
    }




    /** Insert Form Values By User
     * 
     *
     * Request<Array>
    */
    public function insertSubmitFormValuesByUser($request)
    {
       
      $requestKeys = collect($request->all())->keys();
      $getKeys =[];
      $formName = '';    
      if(isset($request['form_id']))
        {
         $data =  $this->getCustomFieldsElement($request['form_id']);

         foreach($requestKeys as $key1 => $keyVal)
         {
            $getKeys[] = $keyVal;
         }       

            foreach($data as $key => $value)
            {  
                if(in_array( $value->field_id,  $getKeys) )  
                {
                    
                   DB::table('user_submit_forms')
                    ->insert(['form_id'=>$request['form_id'],'user_id'=>$request['user_id'],'element_name'=> $value->field_id,'element_values'=>$request[$value->field_id],'element_id'=>$value->id] );
                    
                }
            }

          $formName =  Form::select('name')
                       ->where('id',$request['form_id'])
                       ->get();



            try {

                $details = [
                    'title' => 'Dynamic Form Submission',
                     'name' =>$formName[0]['name'],
                ];
            
                Mail::to(auth()->user()->email)->send(new FormSubmitMail($details));
    
            } catch (\Exception $e) {
                info("Error: ". $e->getMessage());
                dd($e);
            }        
            
        }
    
    }



    
    /** Insert Form Values By User
     * 
     *
     * Request<Array>
    */

    public function formlisting()
    {          
        if(auth()->user()->is_admin == 1)
        {
            $form =  DB::table('user_submit_forms')
                     ->join('forms','forms.id','=','user_submit_forms.form_id')
                     ->select('user_submit_forms.id','forms.name')
                     ->groupBy('user_submit_forms.form_id')->get()->toArray();
            return $form; 
        }else{
            $form =  DB::table('user_submit_forms')
                     ->join('forms','forms.id','=','user_submit_forms.form_id')                
                     ->where('forms.user_id', '=',  auth()->id()) 
                     ->select('user_submit_forms.id','forms.name')
                     ->groupBy('user_submit_forms.form_id')->get()->toArray();
            return $form;
        }  
    }




}
