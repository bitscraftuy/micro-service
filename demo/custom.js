/** CUSTOM JS FUNCTIONS */
/** @author js */
//console.log("custom js");

var CustomJs = (function(window,undefined){
    
    _attachLinkTarget = function(lk){
        
        var myLink = lk;
        jQuery(myLink).attr('target','_blank');
        
    };
    
    _checkVendor = function(val){

        let clientEmail = val;
        /*if(jQuery("input[name='your-email']")){
            clientEmail = jQuery("input[name='your-email']").val();
        }else if(jQuery("input[name='email']")){
            clientEmail = jQuery("input[name='email']").val();
        }else{
            clientEmail = false;
        }*/

        console.log('clientEmail',clientEmail);
        
        if(clientEmail){
            if(_isValidEmailAddress(clientEmail)){
                let params = {
                    email : clientEmail,
                    controller: "clients",
                    action:"findByEmail"
                };

                _request('', 'GET', params, '', '', function(data){
                    
                    
                    console.log("response1---->",data);
                    var response = JSON.parse(data.responseText);
                    
                    console.log("response text", response);
                    console.log("type", typeof response);
                    
                    if(response.error == 0){
                        let client = response.collection;
                        let vendorId = client[0].vendorId;
                        
                        let options = {
                            id : vendorId,
                            controller: "vendors",
                            action:"show"
                        };
                        
                            _request('', 'GET', options, '', '', function(data){
                                
                                var response = JSON.parse(data.responseText);
                                console.log("response2----->",response);
                                
                                if(response.error == 0){
                                    let vendor = response.collection;
                                    let vendorEmail = vendor[0].email;
                                    jQuery("#vendorEmail").val(vendorEmail);
                                }else{
                                    console.error("vendor not found");
                                }

                            }, '', '');
                        
                    }else{
                        console.log("new client");
                        let vendorDefaultEmail = "user@yourdomain.com";
                        jQuery("#vendorEmail").val(vendorDefaultEmail);
                        
                        sessionStorage.setItem("newClientEmail",clientEmail);
                    }
                    
                }, '', '');
            }else{
                console.log("not valid email");
            }
            
        }else{
            console.log("must add an email address");
        }
         
    };
    
    
    _isValidEmailAddress = function(emailAddress){
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};
    
    _request = function(pUrl, pType, pData, pContentType, pDataType, pCallBack, pContainer, pTimeout, pComplete) { 


    var successCallback = function(result) {
      //$(pContainer).html('');
      //$('#status-container').html('');
        
        console.log("successCallback",result);
        var response = JSON.parse(result.responseText);
      pCallBack(response);

    };
    var errorCallback = function(fault, x) {
      //$(pContainer).html('<span class="label label-danger">'+fault+'</span>');
      pCallBack(fault);

    };
    var cleanUpCallBack = function(e) {
        jQuery(pContainer).html("");

    };
    var completeCallBack = function(id,card){

      if(pComplete !== undefined)
        pComplete(id,card);
    };
   
    var callParameters = pData || {};

    var callUrl = pUrl || "/service/";

    switch (pType) {
      case "POST":
        jQuery.post(callUrl, callParameters, pCallBack, 'json');
      break;

      case "UPLOAD":

      // Ajax Submit
        jQuery.ajax({
          url: callUrl,
          type: 'POST',
          dataType: 'json',
          data: callParameters,
          cache: false,
          contentType: false,
          processData: false,
          forceSync: false,
          xhr: function(){
            var xhrobj = jQuery.ajaxSettings.xhr();
            if(xhrobj.upload){
              xhrobj.upload.addEventListener('progress', function(event) {
                var percent = 0;
                var position = event.loaded || event.position;
                var total = event.total || e.totalSize;
                if(event.lengthComputable){
                  percent = Math.ceil(position / total * 100);
                }

                //widget.settings.onUploadProgress.call(widget.element, widget.queuePos, percent);
                jQuery('#progress').html("<div><span></span></div>");
                jQuery('#progress').find('span').css("width", percent + "%");
                console.log("percent:",percent);
              }, false);
            }

            return xhrobj;
          },
          success: function (data, message, xhr){
            console.log("data",data);
            pCallBack(data);

           
          },
          error: function (xhr, status, errMsg){
            console.log("err",errMsg);
            
          },
          complete: function(xhr, textStatus){
            console.log('textStatus',textStatus);
            cleanUpCallBack();
            completeCallBack(null,localStorage.getItem("cardId"));
          }
        });

      break;
      
      default:
          var callConfig = {
            timeout: pTimeout || 120000,
            url: callUrl,
            type: pType || 'GET',
            async: true,
            data: callParameters,
            contentType: pContentType || "application/json",
            dataType: pDataType || "jsonp",
            complete:function(){completeCallBack();}
          };
          jQuery.ajax(callConfig).done(successCallback).fail(errorCallback).always(cleanUpCallBack);
        break;
    }


  };
    
    return {
        attachTarget : function(lk){
            _attachLinkTarget(lk);
        },
        checkVendor : function(val){
            _checkVendor(val);
        }
    };
})(window);

jQuery(document).ready(function(){
   
    CustomJs.attachTarget('a.c-button');
    console.log("checking email...");
    
    jQuery("input[name='your-email']").change(function() {
        
        CustomJs.checkVendor(jQuery(this).val());    
    });

    jQuery("input[name='email']").change(function(e) {
        
        CustomJs.checkVendor(jQuery(this).val());    
    });
    
    //jQuery("#confirm_form").submit(function() {
        if(sessionStorage.getItem("newClientEmail")){

            console.log("newClientEmail stored");
            
            var options = {
                controller : "vendors",
                action:"getDefaultVendor"
            };
            
            
            
            _request('', 'GET', options, '', '', function(data){
                                
                var response = JSON.parse(data.responseText);
                console.log("vendordata----->",response);

                if(response.error == 0){
                    let vendor = response.collection;
                    
                    var params = {};
                    params.vendorId = vendor[0].id;
                    params.email = sessionStorage.getItem("newClientEmail");
                    
                    _request('/service/?controller=clients&action=add', 'POST', params, '', 'json', function(data){
                        
                        console.log("data",data);
                                
                        var response = JSON.parse(data.responseText);
                        console.log("clientadded----->",response);

                        if(response.error == 0){
                            let client = response.collection;
                            console.log("client",client);
                            sessionStorage.clear();
                            //return client; 

                        }else{
                            console.error("client not added");
                        }

                    }, '', '');
                    
                    
                }else{
                    console.error("vendor not found");
                }

            }, '', '');
            
            
            
        }
    //});
    
    
    
});

