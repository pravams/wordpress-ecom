<?php

class Setup {
    
    const product = 'pravams_product';
    const address = 'pravams_address';
    const country = 'pravams_country';
    const state = 'pravams_state';

    public static function pravams_ecom_activation(){
        self::createTables();
    }
    
    public static function pravams_ecom_deactivation(){
        self::dropTables();
    }
    
    public static function createTables(){
        
        global $wpdb;
        
        $table_name = $wpdb->prefix . Setup::product;
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name(
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `time` datetime NOT NULL DEFAULT now(),
                `qty` int(10) unsigned NOT NULL DEFAULT '0',
                `price` decimal(12,4) DEFAULT NULL,
                `product_id` bigint(20) unsigned NOT NULL DEFAULT '0',
                PRIMARY KEY  (id),
                KEY `product_id` (`product_id`),
                CONSTRAINT `products_wp_posts_key_1`
                FOREIGN KEY (`product_id`)
                REFERENCES `wp_posts` (`ID`) ON DELETE CASCADE
                ) $charset_collate;";
        $wpdb->query($sql);
        
        $table_name_address = $wpdb->prefix . Setup::address;
        $sql = "CREATE TABLE IF NOT EXISTS $table_name_address(
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `time` datetime NOT NULL DEFAULT now(),
                `address` text NOT NULL,
                `city` varchar(255) NOT NULL DEFAULT '',
                `pincode` varchar(255) NOT NULL DEFAULT '',                
                `type` varchar(255) NOT NULL DEFAULT '',
                `state_other` varchar(255) NOT NULL DEFAULT '',
                `state` int(20) unsigned NOT NULL DEFAULT '0',
                `country` int(20) unsigned NOT NULL DEFAULT '0',
                `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
                PRIMARY KEY  (id),
                KEY `user_id` (`user_id`),
                CONSTRAINT `address_wp_user_key_1`
                FOREIGN KEY (`user_id`)
                REFERENCES `wp_users` (`ID`) ON DELETE CASCADE
                ) $charset_collate;";
        $wpdb->query($sql);
        
        $table_name_country = $wpdb->prefix . Setup::country;
        $sql = "CREATE TABLE IF NOT EXISTS $table_name_country(
                `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL DEFAULT '',
                `code` varchar(255) NOT NULL DEFAULT '',
                `currency` varchar(255) NOT NULL DEFAULT '',
                `currency_symbol` varchar(255) NOT NULL DEFAULT '',
                PRIMARY KEY  (id)
                ) $charset_collate;";
        $wpdb->query($sql);
        
        $table_name_state = $wpdb->prefix . Setup::state;
        $sql = "CREATE TABLE IF NOT EXISTS $table_name_state (
                `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL DEFAULT '',
                `code` varchar(255) NOT NULL DEFAULT '',
                `country_code` int(20) unsigned NOT NULL DEFAULT '0',
                PRIMARY KEY  (id),
                KEY `country_code` (`country_code`),
                CONSTRAINT `state_wp_pravams_country_key_1`
                FOREIGN KEY (`country_code`)
                REFERENCES $table_name_country (`id`) ON DELETE CASCADE
                ) $charset_collate;";
        $wpdb->query($sql);
        
//        require_once(ABSPATH . "wp-admin/includes/upgrade.php");
//	dbDelta($sql);
        
        //Data::loadDataPayment($wpdb);
        //Data::loadDataShipping($wpdb);
        //Data::loadDataCountry($wpdb, $table_name_country);
        //Data::loadDataState($wpdb, $table_name_country, $table_name_state);
    }
    
    
    
    public static function dropTables(){
        
        global $wpdb;
        
        $table_name = $wpdb->prefix . Setup::product;
        
        $sql = "DROP TABLE $table_name";
        // commented during development	
//        $wpdb->query($sql);
	
        
    }
}