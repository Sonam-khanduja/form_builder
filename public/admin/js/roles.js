"use strict";

$(function () {
    $('#roles').validate({
        rules: {
          name: {
            required: true,
          }
        },
        messages: {
          name: {
            required: "Role Name is required"
          }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('fv-plugins-message-container invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
    });

    var table = $('.role_datatable').DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 1000,
        order: [
            [0, 'ASC']
        ],
        ajax: {
            url: roleList,
         
        },
        columns: [
            {data: 'DT_RowIndex', name: 'roles.id',searchable: false},
            {data: 'name', name: 'roles.name'},          
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});