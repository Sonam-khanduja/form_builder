/** 
 * this method use to create header content which is opening on hambergar icon
 * 
 * @params dropdown String
 * @return void
 */
const getTopBarContent = (dropdown) => {
    let prevNewUrl = pageRecord.prevUrl != '#' ? `${pageRecord.prevUrl}&capture=${pageRecord.captureEventId}` : '#';
    let nextNewUrl = pageRecord.nextUrl != '#' ? `${pageRecord.nextUrl}&capture=${pageRecord.captureEventId}` : '#';

    $(`<div class="container-fluid mb-5 header-title">
        <div class="mt-2 clearfix header-container" >
            
                <div class="navbarToggleExternalContent site-page" >
                    <div class="">
                        <a class="uef-btn-custom uef-btn-custom-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Back to listing" href="${pageRecord.listingPage}">&#8592;
                        </a>
                    </div>
                    <div class="text-white">${pageRecord.pageTitle}
                        <div class="d-block page-url">
                        <a href="${pageRecord.pageUrl}" target="__blank">(${pageRecord.pageUrl})
                        </a>
                    </div> 
                </div>   
            </div>
            <div class="button-Steps" >
                    <div class="navbarToggleExternalContent">
                        ${dropdown}
                    </div>
                    <div class="navbarToggleExternalContent">
                        <select class="captureEvent" data-currentid="${pageRecord.dataCurrentId}" id="capture-event" data-bs-toggle="tooltip" data-bs-placement="top" title="Select capture event">
                            <option value="0" ${pageRecord.isPre} >Pre</option>
                            <option value="1" ${pageRecord.isManual} >Manual</option>
                            <option value="2" ${pageRecord.isPost} >Post</option>
                            <option value="3">All</option>
                        </select>
                    </div>
                    <div class="navbarToggleExternalContent nextPrevBtn">
                        <a href="${prevNewUrl}" 
                        class="uef-btn-custom uef-btn-custom-secondary previousBtnWeb previous menu_btn_prev" id="change-prev-btn">&laquo; Previous</a>
                        <a href="${nextNewUrl}" 
                        id="change-next-btn" class="uef-btn-custom uef-btn-custom-primary nextBtnWeb next">Next &raquo;</a> 
                    </div>
                <div class="">
                    <span id="close" class="d-block">&times;</span>
                    <span class="d-none" id="humburgerButton">&#9776;</span>
                </div>
        </div>
    </div>
</div>`).prependTo('body');
}

/**
 * this method use add/remove the dynamic selectors
 * 
 * @params selection String
 * @params classSel String
 * @params isRemove Boolean
 * @return void
 */
const removeContent = (selection, classSel, isRemove) => {
    if(isRemove) {
        $(selection).removeClass(classSel);
    } else {
        $(selection).addClass(classSel);
    } 
}

/**
 * this method use check content has push to right class
 * if have then remove the class as per the params
 * 
 * @params null
 * @return Boolean
 */
const checkHasPushToRight = () => {
    let isRemove = $("div").hasClass("push-to-right") ? false : true;
    removeContent("#humburgerButton", 'without-chrome', isRemove);
    return true;
}

/**
 * this method use get the attribute url and add/remove class for button
 * Selection and disable
 * 
 * @params sel String
 * @params pushClass String
 * @return Boolean
 */
const getAttrUrl = (sel, pushClass) => {
    let attrVal = $(sel).attr('href');
    if(attrVal != '#') {
        $(sel).removeClass(pushClass)
    } else {
        $(sel).addClass(pushClass)
    }

    return true;
}

/**
 * this method use get the enable/diable next and previous buttons
 * 
 * @params null
 * @return void
 */
const nextPrevBtnActivity = () => {
    getAttrUrl ('.previousBtnWeb', 'menu_btn_prev');
    getAttrUrl ('.nextBtnWeb', 'menu_btn_next');
}

/**
 * this method use get the enable/diable next and previous buttons
 * 
 * @params null
 * @return void
 */
const resetBtnEvents = () => {
    document.querySelectorAll('[type="submit"]').forEach(item => item.type = 'button');
}

/**
 * this method use redirect the pages as per function url on prev and next button
 * if we found yes in isNext then it will be next otherwise its previous button
 * 
 * @params isNext Boolean
 * @return void
 */
const redirectUrlFn = (isNext) => {
    let redirectUrl = isNext ? $('#change-next-btn').attr('href') : $('#change-prev-btn').attr('href');
    if(redirectUrl != '#') {
        window.location.href = redirectUrl;
    } 
}

/**
 * this method call when DOM Element is in ready state
 * 
 * @params null
 * @return void
 */
$(document).ready(function(){

    window.onbeforeunload = function() {
        return;
    };

    if(!pageRecord.hambergarMenuOpen){
        sessionStorage.setItem("hamburger-menu-open", 0);
    }

    getTopBarContent(pageRecord.dropdownContent);

    setTimeout(() => {
        $("#capture-event").val(pageRecord.captureEventId);
    }, 500);

    resetBtnEvents ();

    if(pageRecord.hambergarMenuOpen == 0){
        /**
         * Execute this block when hamber icon is not open
         */
        removeContent("#humburgerButton", 'd-none', true);
        removeContent("#humburgerButton", 'd-block', false);
        removeContent("#close", 'd-block', true);
        removeContent("#close", 'd-none', false);
       
        $('.navbarToggleExternalContent').hide(10);
        $('.header-title').css({'padding-top': '0px', 'padding-bottom':'0px', 'background':'transparent'});
        
        checkHasPushToRight ();
    }else if (pageRecord.hambergarMenuOpen== 1) {
        /**
         * Execute this block when hamber icon is open
         */
        $("#close").removeClass('d-none').addClass('d-block');
    }
    
    nextPrevBtnActivity ();  
});

/**
 * this event call when capture event dropdown value change
 * and it will redirect to selected pages
 * 
 * @params null
 * @return void
 */
$(document).on('change', "#capture-event", function () {
    window.location.href = `${pageRecord.newUrl}?capture=${$(this).val()}`;
});

/**
 * this event call when user click on close button of header
 * 
 * @params null
 * @return void
 */
$(document).on('click', "#close", function () {
    sessionStorage.setItem("hamburger-menu-open", 0);

    $("#humburgerButton").removeClass('d-none').addClass('d-block');
    // close icon
    $("#close").removeClass('d-block').addClass('d-none');
  
    $('.navbarToggleExternalContent').hide('fast');
    $('.header-title').css({'padding-top':'0px', 'padding-bottom': '0px', 'background': 'transparent'});
    checkHasPushToRight ();
});

/**
 * this event call when user click on hamburger icon to open header content
 * 
 * @params null
 * @return void
 */
$(document).on('click', "#humburgerButton", function () {
    sessionStorage.setItem("hamburger-menu-open", 1);

    $("#humburgerButton").hide("fast").removeClass('d-block').addClass('d-none');
    $("#close").removeClass('d-none').addClass('d-block').css('z-index',10);

    $('.navbarToggleExternalContent').show('slow');
    $('.header-title').css({'padding-top':'5px', 'padding-bottom': '16px', 'background': '#212529'});
        
    checkHasPushToRight ();
});

/**
 * this event call when user click on next and save button in captured pages
 * 
 * @params e DOMObject
 * @return void
 */
$(document).on('click', "#btn_next, #btn_save, #btn_done", function (e) {
    redirectUrlFn (true);
});

/**
 * this event call when user click on previous button in captured pages
 * 
 * @params e DOMObject
 * @return void
 */
$(document).on('click', "#btn_previous", function (e) {
    redirectUrlFn (false);
});

/**
 * this event call when user selected page url dropdown on header
 * 
 * @params e DOMObject
 * @return void
 */
$(document).on('change','.titleCheck',function(e){
    window.location.href = `${pageRecord.newUrl}?id=${$(this).val()}&capture=${pageRecord.captureEventId}`;
});