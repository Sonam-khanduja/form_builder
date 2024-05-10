
<div class="d-flex align-items-center">
  
    <a class="d-inline me-3" href="{{ route('roles.edit', $id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Edit Role')}}">
      <i class="bi bi-pencil fs-3 text-primary"></i>Edit
    </a>
   
    
      
        <div class="border-start border-2 border-gray-200" style="height: 20px;"></div> 

      <a title="Delete Role" data-bs-toggle="modal" data-bs-target="#delete{{ $id }}">
        <i class="bi bi-trash2 fs-3 text-danger ms-3" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete Role')}}"></i>
        Delete
      </a>
    
   
 
 

</div>

<div id="delete{{ $id }}" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
            {{-- <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"><i class="bi bi-x-lg fs-3"></i></div> --}}
          </div>
          <div class="modal-body text-center">
              <h4 class="modal-heading">{{__('Are You Sure')}} ?</h4>
              <p>{{__('Do you really want to delete this role ')}} <b class="text-danger">{{ $name }}</b>?<br><br> <b> {{__('By Clicking YES IF any user attach to this role will be unroled!')}}</b><br>{{__(' This process cannot be undone.')}}</p>
          </div>
          <div class="modal-footer">
              <form method="post" action="{{ route('roles.destroy',$id) }}" class="pull-right">
                  {{csrf_field()}}
                  {{method_field("DELETE")}}
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">{{__('No')}}</button>
                  @can('role.delete')
                  <button type="submit" class="btn btn-danger">{{__('Yes')}}</button>
                  @endcan
              </form>
          </div>
      </div>
  </div>
</div>
	
