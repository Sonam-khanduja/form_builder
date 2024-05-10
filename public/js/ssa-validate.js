"use strict";

$(function () { 
    $('#edit_desc').validate({
        rules: {
            description: {
                required: true,
            },
        },
        messages: {
            description: {
                required: "Please enter description"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
    });
});