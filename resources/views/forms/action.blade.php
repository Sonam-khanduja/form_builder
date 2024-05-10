<div class="d-flex align-items-center">

<a class="d-inline me-3 btn btn-primary" href="{{ route('forms.view', $id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('View Form')}}">
        <i class="fa fa-pencil" aria-hidden="true"></i> View
    </a>
    <a class="d-inline me-3 btn btn-success" href="{{ route('forms.submitForm', $id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Submit a form')}}">
        <i class="fa fa-pencil" aria-hidden="true"></i> Submit a form
    </a>
    <a class="d-inline me-3 btn btn-success" href="{{ route('forms.edit', $id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Edit Form')}}">
        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
    </a>
      <div class="d-flex align-items-center" style="height: 20px;"></div> 
      <a class=" btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $id }}">    
        <i data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete User')}}"></i>
        Delete
    </a>   
</div>
  
<div id="delete{{ $id }}" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body text-center">
                <h4 class="modal-heading">{{__('Are You Sure')}} ?</h4>
                <p>{{__('Do you really want to delete this user ')}} <b class="text-danger">{{ $name }}</b>?<br> <br/><b> {{__('By Clicking YES, user will be deleted!')}}</b><br>{{__(' This process cannot be undone.')}}</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ route('forms.destroy',$id) }}" class="pull-right">
                    {{csrf_field()}}
                    {{method_field("DELETE")}}
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">{{__('No')}}</button>
                  
                    <button type="submit" class="btn btn-danger">{{__('Yes')}}</button>
                   
                </form>
            </div>
        </div>
    </div>
</div>
      
  