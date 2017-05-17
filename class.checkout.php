<?php

class Checkout{
    
    private static $initiated = false;
    
    public static function init(){
        if(!self::$initiated){
            self::init_hooks();
        }
    }
    
    /*
     * Initialize Wordpress Hooks
     */
    private static function init_hooks(){
        self::$initiated = true;
        
        add_action('parse_request', array('Checkout', 'get_http_var_and_redirect'));
        
        add_action('admin_bar_menu', array('Checkout', 'add_cart_menu'), 3);
    }
    
    public static function add_cart_menu(){
        global $wpdb;
        $uri = Ecom::get_site_url($wpdb);
        // adding the header for cart
        Ecom::view('header_cart', array('url'=> $uri) );
    }
    
    
    public static function get_http_var_and_redirect($query){
        
        $userID = get_current_user_id();
        $session = new Checkoutsession();
                
        //check for add to cart or update
        $req = $query->request;
        $params = self::request_type($req);
        if( ($params['type'] == Checkoutsession::ADD) || ($params['type'] == Checkoutsession::DEL) ){
            
            if($session->isInitiated()){
                $session->add($params);
            }
            
            self::reset_query($query);
            
        }else if($params['type'] == Checkoutsession::CART){
            // adding the cart view page
            Ecom::view('view_cart', array() );
            exit;
        }else if($params['type'] == Checkoutsession::CHECKOUT){
            // checkout view page
            Ecom::view('view_checkout', array());
            exit;
        }
        
        return $query;
    }
    
    private function request_params($arrayP){
        $productIdQty = explode('/',$arrayP);
        $productId = $productIdQty[0];
        $qty = $productIdQty[2];
        
        $params[$productId] = $qty; 
        return $params;
    }
    
    private function request_type($req){
        $arrayAdd = explode('ecommerce/add/id/', $req);
        $arrayDel = explode('ecommerce/del/id/', $req);
        $arrayCart = explode('ecommerce/cart/', $req);
        $arrayCheckout = explode('ecommerce/checkout/', $req);
        $params = array();
        
        if(isset($arrayAdd[1])){
            $params = self::request_params($arrayAdd[1]);
            $params['type'] = Checkoutsession::ADD;
        }elseif(isset($arrayDel[1])){
            $params = self::request_params($arrayDel[1]);
            $params['type'] = Checkoutsession::DEL;
        }elseif(isset($arrayCart[1])){
            $params = self::request_params($arrayCart[1]);
            $params['type'] = Checkoutsession::CART;
        }elseif(isset($arrayCheckout[1])){
            $params = self::request_params($arrayCheckout[1]);
            $params['type'] = Checkoutsession::CHECKOUT;
        }
        return $params;
    }
    
    private function reset_query($query){
        echo "success";
        exit;
//        $query->query_vars[ 'page' ] = "";
//        $query->query_vars[ 'pagename' ] = "ecommerce";
//        $query->matched_query = 'pagename=ecommerce&page=';
//        return $query;
    }
     
}
