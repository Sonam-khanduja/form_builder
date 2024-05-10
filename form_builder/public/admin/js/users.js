"use strict";

/**
 * This method is used to check validations
 *
 * @author DEVIT
 */

$(function () {
    /**
     * Form validation of specific rule
     *
     * @author DEVIT
     */
    $('#users').validate({
        rules: {
          email: {
            required: true,
            validEmail:true
          },
          status: {
            select: true
         },
         name: {
            required: true,
            specialChar: true
         },
         userpassword: {
            required: true
         }, 
        },
        messages: {
          email: {
            required: "Email is required"
          },
          name: {
            required: "Name is required"
          },
          userpassword: {
            required: "Password is required"
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
    
    jQuery.validator.addMethod('select', function (value) {
        return (value != 'none');
    }, "Please Select Status");

    $.validator.addMethod('specialChar', function(value, element) {     
        return   /^[a-z][a-z\s]*$/i.test(value);
         },'Please enter only alphabets');


    $.validator.addMethod('validEmail', function(value, element) {    
    var regex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/; 
    return   regex.test(value);
        },'Please enter valid email');
         

       

    /**
     * Initialize Data table for User listing
     * GET the ajax user information from "userList"
     *
     * @author DEVIT
     */
    var table = $('.user_datatable').DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 1000,
        order: [
            [0, 'DESC']
        ],
        ajax: {
            url: userList,
            // "dataSrc": function(json) {
            //     $usersInf = [...json.data];
            //     return json.data;
            // },
        },
        columns: [
            {data: 'DT_RowIndex', name: 'users.id', searchable: false},
            {data: 'name', name: 'users.name'},
            {data: 'email', name: 'users.email'},
            {data: 'created_at', name: 'users.created_at'},
            {data: 'status', name: 'users.status'},            
            { data: 'action', name: 'action', orderable: false, searchable: false },     
        ]
    });

  
});
