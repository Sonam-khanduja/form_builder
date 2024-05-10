<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Form;
use Yajra\DataTables\DataTables;


class UserSubmitFormController extends Controller
{
    public function __construct()
    {
        
        $this->formObj = new Form();
    }


     /**
     * Display a listing of the Form 
     *
     * @author DEVIT
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $formdata =  $this->formObj->formlisting();    
        if ($request->ajax())
        {
            return DataTables::of($formdata)
            ->addIndexColumn()
            ->addColumn('name', function ($formdata) {
                return $formdata->name;
            })
            ->editColumn('action', 'userforms.action')
            ->rawColumns(['name'])
            ->make(true);
        }
        return view('userforms.index');
    }
}
