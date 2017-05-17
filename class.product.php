<?php

class Product{
    
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
        
        self::pravams_product_init();
        
        /* change the response of the page to ecommerce data*/
        add_action( 'the_post', array('Product','pravams_post_action' ));

        /* adding attributes for qty and price*/
        add_action('add_meta_boxes', array('Product','pravams_product_meta_box'));
        
        add_action('save_post', array('Product', 'pravams_product_save_attr'));
        
        add_action('wp_enqueue_scripts', array('Product', 'load_js_files'));
        
        add_action('wp_enqueue_scripts', array('Product', 'load_css_files'));
    }
    
   public static function load_js_files(){
        //loading the jquery library
        wp_enqueue_script('jquery');
        
        //loading the checkout js
        wp_register_script('pravams_checkout', plugins_url('js/checkout.js', __FILE__));
        wp_enqueue_script('pravams_checkout');
        
    }
    
    public static function load_css_files(){
        //loading the default css
        wp_register_style('pravams_default', plugins_url('css/default.css', __FILE__));
        wp_enqueue_style('pravams_default');
    }

    
    public static function pravams_product_meta_box(){
        add_meta_box('pravams-product-attr', "Product Attributes", array('Product','pravams_product_attr_box'), 'pravams_product', 'normal', 'high');
    }
    
    public static function pravams_post_action( $post_object ) {
        
        global $wpdb;
        
	// modify post object here
        if($post_object->post_title == PRAVAMS_PLUGIN_URL && (!is_admin())){
            $uri = Ecom::get_site_url($wpdb);
            $plist = $wpdb;
            
            $query = "select p.ID, p.guid, p.post_title, p.post_content, pr.qty, pr.price "
                    . "from wp_posts p "
                    . "LEFT JOIN wp_pravams_products pr ON  p.ID = pr.product_id "
                    . "where  p.post_type='pravams_product' "
                    . "and p.post_status = 'publish';";
            $allProducts = $plist->get_results($query);
            $listData['url'] = $uri;
            $listData['products'] = $allProducts;
            Ecom::view('list', $listData );
            $post_object->post_title = '';
        }
        
        
    }


    public static function pravams_product_init(){
        
        $labels = array(
            'name' => _x('Products'),
            'singular_name' => _x('Product'),
            'menu_name' => _x('Products'),
            'name_admin_bar' => _x('Product', 'add new on admin bar'),
            'add_new' => _x('Add New', 'pravams_product'),
            'add_new_item' => __('Add New Product'),
            'new_item' => __('New Product'),
            'edit_item' => __('Edit Product'),
            'view_item' => __('View Product'),
            'all_items' => __('All Products'),
            'search_items' => __('Search Products'),
            'not_found' => __('No Products Found'),
            'not_found_in_trash' => __('No Products found in Trash')
        );
        
        $args = array(
                'labels' => $labels,
                'description' => __('Product Details and description'),
                'public' => true,
                'public_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'pravams_product'),
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
            
        );

	register_post_type('pravams_product', $args);

    }
    
    public static function pravams_product_attr_box(){
        Ecom::view('attributes', array() );
    }
    
    public static function pravams_product_save_attr($post_id){
        
        // verify nonce
        if(wp_verify_nonce($_POST['pravams_product_attr_nonce'], basename(__FILE__))){
            return $post_id;
        }
        
        //check auto save
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return $post_id;
        }
    
        if('pravams_product'== $_POST['post_type']  && current_user_can('edit_post', $post_id)){
            global $wpdb;
        
            $table_name = $wpdb->prefix . 'pravams_products';
            
            $sql = "Select * from $table_name where product_id = $post_id";
            
            $qty = Ecom::sanitize_qty($_POST['pravams_product_qty']);
            $price = Ecom::sanitize_price($_POST['pravams_product_price']);
            
            $list = $wpdb->get_results($sql);
            if(empty($list)){
                //insert data
                $sqli = "INSERT INTO $table_name (qty,price, product_id) values ( $qty, $price, $post_id );";
                $wpdb->query($sqli);
            }else{
                //update data
                $sqlu = "UPDATE $table_name set qty = $qty, price = $price WHERE product_id = $post_id";
                $wpdb->query($sqlu);
            }
        }else{
            return $post_id;
        }
    
    }
    
    public static function product_load($id){
        global $wpdb;
        
        $query = "select p.ID, p.guid, p.post_title, p.post_content, pr.qty, pr.price "
                    . "from wp_posts p "
                    . "LEFT JOIN wp_pravams_products pr ON  p.ID = pr.product_id "
                    . "where  p.post_type='pravams_product' "
                    . "and p.post_status = 'publish'"
                    . "and p.ID = ".$id;
        $product = $wpdb->get_results($query);
        return $product;
    }
}

