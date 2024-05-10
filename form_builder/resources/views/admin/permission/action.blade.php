<a title="Delete Role" data-bs-toggle="modal" data-bs-target="#delete{{ $id }}">
    <i class="bi bi-trash2 fs-3 text-danger ms-3" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete Permission')}}"></i>
</a>

<div id="delete{{ $id }}" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
              {{-- <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"><i class="bi bi-x-lg fs-3"></i></div> --}}
            </div>
            <div class="modal-body text-center">
                <h4 class="modal-heading">{{__('Are You Sure')}} ?</h4>
                <p>{{__('Do you really want to delete this permission ')}} <b class="text-danger">{{ $name }}</b>?<br><br> <b> {{__('By Clicking YES permission has been deleted!')}}</b><br>{{__(' This process cannot be undone.')}}</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ route('permission.destroy',$id) }}" class="pull-right">
                    {{csrf_field()}}
                    {{method_field("DELETE")}}
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">{{__('No')}}</button>
                    {{-- @can('role.delete') --}}
                    <button type="submit" class="btn btn-danger">{{__('Yes')}}</button>
                    {{-- @endcan --}}
                </form>
            </div>
        </div>
    </div>
</div>