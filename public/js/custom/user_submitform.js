"use strict";

$(function () {

/**
     * Initialize Data table for form listing
     * GET the ajax user information from "form list"
     *
     * @author DEVIT
     */
var table = $('.userform_datatable').DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 1000,
    order: [
        [0, 'DESC']
    ],
    ajax: {
        url: formlisting,          
    },
    columns: [
        {data: 'DT_RowIndex', id: 'user_submit_forms.id', searchable: false},
        {data: 'name', name: 'forms.name'},                  
        { name: 'action', orderable: false, searchable: false },     
    ]
  });

  
});