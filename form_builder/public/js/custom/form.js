"use strict";

$(function () {
        /**
         * Form validation of specific rule
         *
         * @author DEVIT
         */
        $('#formsId').validate({
            rules: {             
             name: {
                required: true,
             },
            },
            messages: {             
              name: {
                required: "Name is required"
              }            
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
              error.addClass('fv-plugins-message-container invalid-feedback');
              element.closest('.form-group').append(error);
              $("#createNewForm").find(".form-control ").removeAttr("required");
              $("#createNewForm").find(".form-control ").removeClass("is-invalid");   
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
            }
        });
  
    /**
     * Initialize Data table for form listing
     * GET the ajax user information from "form list"
     *
     * @author DEVIT
     */
    var table = $('.form_datatable').DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 1000,
        order: [
            [0, 'DESC']
        ],
        ajax: {
            url: formList,          
        },
        columns: [
            {data: 'DT_RowIndex', name: 'forms.id', searchable: false},
            {data: 'name', name: 'forms.name'},
            {data: 'layout', name: 'forms.layout'},
            {data: 'description', name: 'forms.created_at'},               
            { data: 'action', name: 'action', orderable: false, searchable: false },     
        ]
    });

  
});
