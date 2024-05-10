class switchProtoClass {}

/**
 * this method is used t get class node for application
 * @params classfield string
 * @params dynamicClass string
 * @returns DOMElement Object 
 */
switchProtoClass.prototype.getClassNodeType = (classfield, dynamicClass) => {
    return document.querySelectorAll(`.${classfield}-${dynamicClass}`);
}

/**
 * this method is used to remove the duplicate content
 * @params null
 * @returns void  
 */
switchProtoClass.prototype.removeDupliceClass = () => {
    switchProtoType.SC = [...new Set(switchProtoType.SC)]
}

/**
 * this method is used to get uique Switch cases
 * @params null
 * @returns void 
 */
switchProtoClass.prototype.getUniqueSwitchClass = () => {
    document.querySelectorAll('[class*="switch-"]').forEach(item => {
        switchProtoType.SC.push(...item.className.split(" "))
    })

    switchProtoType.helpers.removeDupliceClass();
}

/**
 * this method is use to hide/show the contents
 * @params dynamicClass string
 * @params isEnable Boolean
 * @returns Boolean 
 */
switchProtoClass.prototype.hideShowCheckedContent = (dynamicClass, isEnable) => {
    let nodeItems = isEnable ? switchProtoType.OFS : switchProtoType.ONS;

    nodeItems.forEach((items) => {
         if(isEnable) {
            items.classList.replace(`offstate-${dynamicClass}`, `onstate-${dynamicClass}`);
        } else {
            items.classList.replace(`onstate-${dynamicClass}`, `offstate-${dynamicClass}`);
        }
    })

    return true;
}

/**
 * this method is use to find and update the onstate and offstate content
 * @params item string
 * @returns void 
 */
switchProtoClass.prototype.findAndUpdateContent = (item) => {
    let matchContent = item.split('-')[1];

    switchProtoType.OFS = switchProtoType.helpers.getClassNodeType('offstate', matchContent);
    switchProtoType.ONS = switchProtoType.helpers.getClassNodeType('onstate', matchContent);

    if(document.querySelectorAll(`.${item}:checked`).length > 0) {
        switchProtoType.helpers.hideShowCheckedContent(matchContent, true);
    } else {
        switchProtoType.helpers.hideShowCheckedContent(matchContent, false);
    }
}

/**
 * this method is use add dynamic events of switch contents
 * @params null
 * @returns void 
 */
switchProtoClass.prototype.getDynamicSelectionFields = () => {
    switchProtoType.DF = [...document.querySelectorAll("[rel*='wfHandled']")];
   
    if(switchProtoType.DF.length > 0) {
        switchProtoType.DF.forEach(item => {
            return item.addEventListener('click', function (e) { switchProtoType.helpers.run() });
        });
    } 
}

/**
 * this method is called to initialize the prototype events and content
 * @params null
 * @returns void 
 */
switchProtoClass.prototype.init = () => {
    switchProtoType.helpers.getDynamicSelectionFields();
    switchProtoType.helpers.getUniqueSwitchClass();
}

/**
 * this method is execute when changes detect in prototype
 * @params null
 * @returns void 
 */
switchProtoClass.prototype.run = () => {
    switchProtoType.OFS = [];
    switchProtoType.ONS = [];

    if(switchProtoType.SC.length > 0) {
        for (let item of switchProtoType.SC) {
            switchProtoType.helpers.findAndUpdateContent (item);  
        }
    }
}

/**
* this method is execute to stop the alert message
* @params null
* @returns void 
*/
switchProtoClass.prototype.stopAlert = () => {
    if(SSA.page.timeout !== undefined){
        SSA.page.timeout.popupTimedOutAlert = () => { return; }
        SSA.page.timeout.popuplaunchAlert = () => { return; }
    }
 
    if(YAHOO && YAHOO.timeout !== undefined){
        YAHOO.timeout = () => { return; }
    }
}

/**
 * this object is created to pre-define the object and helpers of auto fill prototype
 * @params null
 * @returns void 
 */
window.switchProtoType = {
    DF: [],
    SC: [],
    OFS: [],
    ONS: [],
    helpers: new switchProtoClass()
}

document.addEventListener("DOMContentLoaded", window.switchProtoType.helpers.stopAlert);
