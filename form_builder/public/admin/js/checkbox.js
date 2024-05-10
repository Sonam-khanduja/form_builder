"use strict"

$(function () {
    // Attach a change event listener to the grand_selectall checkboxes
    $('.permissionTable').on('change', '.grand_selectall', function() {
        // Get the parent card element
        var parentCard = $(this).closest('.card');
        // Get all the permissioncheckbox checkboxes within the parent card element
        var permissionCheckboxes = parentCard.find('.permissioncheckbox');
        // Set the checked state of all permissioncheckbox checkboxes to the state of the grand_selectall checkbox
        permissionCheckboxes.prop('checked', $(this).prop('checked'));
        // Get all the selectall checkboxes within the parent card element
        var selectAllCheckboxes = parentCard.find('.selectall');
        // Set the checked state of all selectall checkboxes to the state of the grand_selectall checkbox
        selectAllCheckboxes.prop('checked', $(this).prop('checked'));
    });
    
    // Attach a change event listener to the selectall checkboxes
    $('.permissionTable').on('change','.selectall', function() {
        // Get the parent card element
        var parentCard = $(this).closest('.card');
        // Get all the permissioncheckbox checkboxes within the parent card element
        var permissionCheckboxes = parentCard.find('.permissioncheckbox');
        // Set the checked state of all permissioncheckbox checkboxes to the state of the selectall checkbox
        permissionCheckboxes.prop('checked', $(this).prop('checked'));
        // Get the grand_selectall checkbox within the parent card element
        var grandSelectAllCheckbox = $('.grand_selectall');

        var allPermissioncheckbox = $('.permissioncheckbox');

        // Set the checked state of the grand_selectall checkbox based on the checked state of all permissioncheckbox checkboxes
        grandSelectAllCheckbox.prop('checked', allPermissioncheckbox.filter(':checked').length == allPermissioncheckbox.length);
    });

    $('.permissionTable').on('change', '.permissioncheckbox', function() {
        var $cardBody = $(this).closest('.card-body');
        var $cardHeader = $cardBody.prev('.card-header');
        var $grandSelectAll = $('.grand_selectall');
        var $selectall = $cardHeader.find('.selectall');
        var $permissionCheckboxes = $cardBody.find('.permissioncheckbox');
        var $allpermissionCheckboxes = $('.permissioncheckbox').length;
        
        if ($permissionCheckboxes.length == $permissionCheckboxes.filter(':checked').length) {
            $selectall.prop('checked', true);
           
        } else {
            $selectall.prop('checked', false);
           
        }
    
       if($('.permissioncheckbox:checked').length === $allpermissionCheckboxes){
        $grandSelectAll.prop('checked', true);
       }else{
        $grandSelectAll.prop('checked', false);
       }
        
    });
});

$(function(){
    //edit page
    var $grandSelectAll = $('.grand_selectall');

    if($('.permissioncheckbox:checked').length == $(".permissioncheckbox").length){
        $grandSelectAll.prop('checked', true);
    }else{
        $grandSelectAll.prop('checked', false);
    }

    $('.child-checkbox').each(function(card){
        var $selectAll = $(this).find('.card-header').find('.card-toolbar').find('.selectall');
        var $permissionCheckboxesChecked = $(this).find('.card-body').find('.row .col-md-6').find('.permissioncheckbox:checked');
        var $permissionCheckboxes = $(this).find('.card-body').find('.row .col-md-6').find('.permissioncheckbox');
        if( $permissionCheckboxesChecked.length == $permissionCheckboxes.length){
                $selectAll.prop('checked', true);
        }else{
                $selectAll.prop('checked', false);
        }
    });
})











