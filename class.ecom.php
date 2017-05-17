<?php

class Ecom{
        
    public static function view($name, array $args = array()){
//        foreach($args as $key => $val){
//            $$key = $val;
//        }
        $file = PRAVAMS_PLUGIN_DIR . 'views/'.$name.'.php';
        include($file);
    }
    
    public static function get_site_url($wpdb){
        $sql = "select * from wp_options where option_name='siteurl'";
        $res = $wpdb->get_results($sql);
        $modUrl = $res[0]->option_value;
        return $modUrl;
    }

    public function sanitize_qty($qty){
        $modQty = sanitize_text_field($qty);
        $modQty = preg_replace("/[^0-9]/", "",$modQty);
        return $modQty;
    }
    
    public function sanitize_price($price){
        $modPrice = sanitize_text_field($price);
        $modPrice = preg_replace("/[^0-9.]*/", "",$modPrice);
        return $modPrice;
    }
}
