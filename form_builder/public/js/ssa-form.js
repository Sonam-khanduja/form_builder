"use strict";

$(function () {
     
    var table = $('.ssaForm_datatable').DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 1000,
        ajax: {
            url: ssaFormList,
            data: function (d) {
                  d.statusCode = $("#status_filter").is(":checked")
            },
            error: function (jqXHR, textStatus, errorThrown) {
                location.reload();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'ssa_forms.id'},
            {data: 'page_title', name: 'ssa_forms.page_title'},
            {data: 'tab_id', name: 'ssa_forms.tab_id'},
            {data: 'agent_name', name: 'users.name'},
            {data: 'unique_id', name: 'ssa_forms.unique_id'},
            {data: 'description', name: 'filing_helper_agent_uniqueids.description'},
            {data: 'page_url', name: 'ssa_forms.page_url'},
            {data: 'page_count', name: 'page_count'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    //On change event
    $(document).on("change",'#status_filter',function(){
        table.draw();
    });

    

    $(document).on("click",'#showForm',function(){
        $('h3').css('display','block');
    });

    $('#ssaForm').on('submit', '.edit_description', function(e){
        e.preventDefault();
        $('#update_button').attr('disabled', 'disabled');
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $.ajax({
            url: ajaxEditDescription,
            method: 'POST',
            data: formData,
            before: function () {
               
            },
            success: function (response) {
                if(response.content != null){
                        window.location.reload();
                }else{
                    $('#msg_div-'+ response.id).show();
                    $('#res_message-'+ response.id).html('<p class="alert alert-danger">' + response.msg + '</p>');
                    setTimeout(() => {
                        $('#msg_div-'+ response.id).hide();
                        $('#res_message-'+ response.id).html('');
                        $('#update_button').removeAttr('disabled', 'disabled');
                    }, 3000);
                    
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('#ssaForm').on('click', '#reset', function(){
        var idValue =  $('#desc-id').val();
        $('#msg_div-'+ idValue).hide();
        $('.edit-modal').modal('hide');
    });

    
});