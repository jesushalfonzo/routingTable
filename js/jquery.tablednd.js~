/*
 * Función para detectar navegadores  
 *             */            
function getDocWidth(){var a=document;return Math.max(Math.max(a.body.scrollWidth,a.documentElement.scrollWidth),Math.max(a.body.offsetWidth,a.documentElement.offsetWidth),Math.max(a.body.clientWidth,a.documentElement.clientWidth))}function getDocHeight(){var a=document;return Math.max(Math.max(a.body.scrollHeight,a.documentElement.scrollHeight),Math.max(a.body.offsetHeight,a.documentElement.offsetHeight),Math.max(a.body.clientHeight,a.documentElement.clientHeight))}function getPageScroll(){var a;if(self.pageYOffset){a=self.pageYOffset}else if(document.documentElement&&document.documentElement.scrollTop){a=document.documentElement.scrollTop}else if(document.body){a=document.body.scrollTop}arrayPageScroll=new Array("",a);return arrayPageScroll}
function getMinDocHeight(){var a=document;return Math.min(Math.min(a.body.scrollHeight,a.documentElement.scrollHeight),Math.min(a.body.offsetHeight,a.documentElement.offsetHeight),Math.min(a.body.clientHeight,a.documentElement.clientHeight))}function getRealDocWidth(){var a=document;return Math.min(Math.min(a.body.scrollWidth,a.documentElement.scrollWidth),Math.min(a.body.offsetWidth,a.documentElement.offsetWidth),Math.min(a.body.clientWidth,a.documentElement.clientWidth))}function f_filterResults(a,b,c){var d=a?a:0;if(b&&(!d||d>b))d=b;return c&&(!d||d>c)?c:d}function f_scrollTop(){return f_filterResults(window.pageYOffset?window.pageYOffset:0,document.documentElement?document.documentElement.scrollTop:0,document.body?document.body.scrollTop:0)}function f_scrollLeft(){return f_filterResults(window.pageXOffset?window.pageXOffset:0,document.documentElement?document.documentElement.scrollLeft:0,document.body?document.body.scrollLeft:0)}
var BrowserDetect={init:function(){this.browser=this.searchString(this.dataBrowser)||"An unknown browser";this.version=this.searchVersion(navigator.userAgent)||this.searchVersion(navigator.appVersion)||"an unknown version";this.OS=this.searchString(this.dataOS)||"an unknown OS"},searchString:function(a){for(var b=0;b<a.length;b++){var c=a[b].string;var d=a[b].prop;this.versionSearchString=a[b].versionSearch||a[b].identity;if(c){if(c.indexOf(a[b].subString)!=-1)return a[b].identity}else if(d)return a[b].identity}},searchVersion:function(a){var b=a.indexOf(this.versionSearchString);if(b==-1)return;return parseFloat(a.substring(b+this.versionSearchString.length+1))},dataBrowser:[{string:navigator.userAgent,subString:"Chrome",identity:"Chrome"},{string:navigator.userAgent,subString:"OmniWeb",versionSearch:"OmniWeb/",identity:"OmniWeb"},{string:navigator.vendor,subString:"Apple",identity:"Safari",versionSearch:"Version"},{prop:window.opera,identity:"Opera",versionSearch:"Version"},{string:navigator.vendor,subString:"iCab",identity:"iCab"},{string:navigator.vendor,subString:"KDE",identity:"Konqueror"},{string:navigator.userAgent,subString:"Firefox",identity:"Firefox"},{string:navigator.vendor,subString:"Camino",identity:"Camino"},{string:navigator.userAgent,subString:"Netscape",identity:"Netscape"},{string:navigator.userAgent,subString:"MSIE",identity:"Explorer",versionSearch:"MSIE"},{string:navigator.userAgent,subString:"Gecko",identity:"Mozilla",versionSearch:"rv"},{string:navigator.userAgent,subString:"Mozilla",identity:"Netscape",versionSearch:"Mozilla"}],dataOS:[{string:navigator.platform,subString:"Win",identity:"Windows"},{string:navigator.platform,subString:"Mac",identity:"Mac"},{string:navigator.userAgent,subString:"iPhone",identity:"iPhone/iPod"},{string:navigator.platform,subString:"Linux",identity:"Linux"}]}
BrowserDetect.init();
/*
 * Fin función de detectar navegadores 
 */

$(document).ready(function(){
    // Estilo para los botones bootstrap
    $(":submit").addClass("btn btn-primary");
    
});


function autocompletar(accion, val) {        
    $.getJSON(accion, function(data) {           
        $(val).typeahead({
            source: data
        });            
    });
}

function validarRif(elemento){
    $('#'+elemento).keypress(function(e) { 
        tam = $(this).val().length;
        key = String.fromCharCode(e.which);         
        var Num = '0123456789';

       if ((e.which != '8') && (e.which != '0')) {
           if (Num.indexOf(key.toUpperCase()) == -1 && key.toUpperCase() != 'V' && key.toUpperCase() != 'E' && key.toUpperCase() != 'J' && key.toUpperCase() != 'G'){ //&& key.toUpperCase() != 'J' && key.toUpperCase() != 'G') {
               $(this).val($(this).val());                   
               return false;
           }
           else {
                if (tam == 0) {                            
                   if (e.which == 86 || e.which == 118) {                        
                       $(this).val('V-');                        
                       return false;
                   }
                   else if (e.which == 69 || e.which == 101) {
                        $(this).val('E-');                               
                        return false;
                   } 
                   else if (e.which == 74 || e.which == 106) {
                       $(this).val('J-');
                        return false;
                   } 
                   else if (e.which == 71 || e.which == 103) {
                        $(this).val('G-');
                       return false;
                   } 
                   else {
                        $(this).val($(this).val());                               
                        return false;
                   }
                } 
                else if (tam == 10) {
                   if (e.which != 86 || e.which != 118 || e.which != 69 || e.which != 101){ //|| e.which != 74 || e.which != 106 || e.which != 71 || e.which != 103) {
                       $(this).val($(this).val() + '-' + key);                           
                       return false;
                   }
                   else {
                        $(this).val($(this).val());                               
                        return false;
                   }
                }
                else {
                   if (e.which == 86 || e.which == 118 || e.which == 69 || e.which == 101){ //|| e.which == 74 || e.which == 106 || e.which == 71 || e.which == 103) {
                       return false;
                   }
                }
           }
       }
    });
} 

/**
 * Función para validar la cédula
 * @param {type} elemento
 * @returns {undefined}
 */
function validarCedula(elemento) {
    $('#' + elemento).keypress(function(e) {
        tam = $(this).val().length;
        key = String.fromCharCode(e.which);
        var Num = '0123456789';
        
        if($(this).val() == ''){                                       
                if (e.which == 69 || e.which == 101) {
                    $(".sf_admin_form_field_tiemp_pais").hide();
                }
            }
        if ((e.which != '8') && (e.which != '0')) {
            if (Num.indexOf(key.toUpperCase()) == -1 && key.toUpperCase() != 'V' && key.toUpperCase() != 'E') {
                $(this).val($(this).val());
                return false;
            }
            else {
                if (tam == 0) {
                    if (e.which == 86 || e.which == 118) {
                        $(this).val('V-');
                        return false;
                    }
                    else if (e.which == 69 || e.which == 101) {
                        $(this).val('E-');
                        return false;
                    }
                    else {
                        $(this).val($(this).val());
                        return false;
                    }
                }
                else {
                    if (e.which == 86 || e.which == 118 || e.which == 69 || e.which == 101) {
                        return false;
                    }
                }
            }
        }
    });
}