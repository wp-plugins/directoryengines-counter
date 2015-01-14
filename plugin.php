<?php
/*
Plugin Name: DE Counter
Version: 1.0.0
Description: Add view counter to Directory Engine theme
Author: Nguyen Van Duoc
Author URI: http://wordpresskite.com
Plugin URI: http://wordpresskite.com
Copyright (C) 2014 Nguyen Van Duoc
*/
require dirname(__FILE__) . '/framework/load.php';

require_once(dirname(__FILE__)."/De_Counter.php");

define('DE_COUNTER_TABLE', apply_filters('de_counter_tablename','de_counter') );

function _de_counter_init() {
    global $wpdb;
    De_Counter::getInstance()->register();
    new scbTable( DE_COUNTER_TABLE, __FILE__, apply_filters("de_counter_cols","
        post_id bigint(20),
		view_count int(20),
		PRIMARY KEY  (post_id)
    "));
}

scb_init( '_de_counter_init' );