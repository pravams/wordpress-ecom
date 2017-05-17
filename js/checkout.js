jQuery(function(){
    const PLUGIN_URL = "ecommerce";
    
    jQuery('.add-to-cart').click(function(){
        var id = jQuery(this).attr('productid');
        var url = jQuery(this).attr('url');
        url += "/"+PLUGIN_URL+"/add/id/"+id+"/qty/1";
        jQuery.ajax({url: url, 
        success: function(result){
            console.log(result);
        }});
    });
    
     jQuery('.remove-from-cart').click(function(){
        var id = jQuery(this).attr('productid');
        var url = jQuery(this).attr('url');
        url += "/"+PLUGIN_URL+"/del/id/"+id+"/qty/1";
        jQuery.ajax({url: url,
        success: function(result){
            console.log(result);
        }});
    });
    
    // view the cart page
    jQuery('.menu-cart').click(function(){
        var url = jQuery(this).attr('url');
        url += "/"+PLUGIN_URL+"/cart/view";
        jQuery.ajax({url: url,
        success: function(result){
            jQuery('#primary').html(result);
            loadcheckout();
        }});
    });
    
    function loadcheckout(){
       // view the checkout page
        jQuery('#checkout-button').click(function(){
           var url = jQuery('.menu-cart').attr('url'); 
           url += "/"+PLUGIN_URL+"/checkout/view";
           jQuery.ajax({
               url: url,
               success: function(result){
                   jQuery('#primary').html(result);
               }
           });
        }); 
    }
    
    
});