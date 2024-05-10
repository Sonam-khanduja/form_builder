"use strict";

// $( document ).ready(function() {
//     alert("Test"+permissionList);
//     console.log( "ready!" );
// });

$(function () {
    $('#singlePermission').validate({
        rules: {
          name: {
            required: true,
            // specialChar:true,
          },
        },
        messages: {
          name: {
            required: "Permission Name is required"
          },
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

    $('#bulkPermission').validate({
        rules: {
          bulk_name: {
            required: true,
            // specialChar:true,
          },
        },
        messages: {
            bulk_name: {
            required: "Bulk Permission Name is required"
          },
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


    var table = $('.permission_datatable').DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 1000,
        order: [
            [0, 'ASC']
        ],
        ajax: {
            url: permissionList
        },
        columns: [
            {data: 'DT_RowIndex', name: 'permissions.id',searchable: false},
            {data: 'name', name: 'permissions.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});

