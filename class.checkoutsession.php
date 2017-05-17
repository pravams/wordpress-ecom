<?php

class Checkoutsession{
    
    private $initiated = false;
    
    private $cart;
    
    const ADD = 'add';
    const DEL = 'del';
    const CART = 'cart';
    const CHECKOUT = 'checkout';
    
    public function __construct(){
        if(!get_current_user_id()){
            return;
        }
        if(!session_id()){
            session_start();
            $_SESSION['userid'] = get_current_user_id();        
            $this->initiated = true;
        }else{
            $this->cart = $_SESSION['cart'];
            $this->initiated = true;
        }
        return $this;
    }
    

    public function isInitiated(){
        return $this->initiated;
    }
    
    public function getCart(){
        return $this->cart;
    }
    
    public function add($params){
        $typeofreq = $params['type'];
        unset($params['type']);
        
        $productId = key($params);
        $qty = $params[$productId];
        
        $this->cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
        
        // check if product is already in cart
        if(isset($this->cart[$productId])){
            if($typeofreq == Checkoutsession::ADD){
                $this->cart[$productId] = $this->cart[$productId] + $qty;
            }elseif($typeofreq == Checkoutsession::DEL){
                $this->cart[$productId] = $this->cart[$productId] - $qty;
            }
            
            if( ($this->cart[$productId] < 0) || $this->cart[$productId] == 0 ){
                unset($this->cart[$productId]);
            }
        }else{
            if($typeofreq == Checkoutsession::ADD && $qty > 0){
                $this->cart[$productId] = $qty;
            }
        }
           
        $_SESSION['cart'] = $this->cart;
        
        return true;
    }
    
    public function getCartData(){
        if(isset($this->cart)){
            $cartD = array();
            foreach($this->cart as $item => $qty){
                $product = Product::product_load($item);
                $productDesc = array();
                foreach($product[0] as $key => $val){
                    $productDesc[$key] = $val;
                }
                $productDesc['cart_qty'] = $qty;
                $cartD[$item] = $productDesc;
            }
            return $cartD;
        }else{
            return array();
        }
    }
    
}
