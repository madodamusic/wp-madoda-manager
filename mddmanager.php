<?php
/*
Plugin Name: WP Madoda Manager
Description: madoda manager link
Author: Assedio Horacio
Version: 1.0
*/
// function_exists("add_action") or die("you can acess this file from outside");
require_once plugin_dir_path( __FILE__ ) . "includes/madoda_manager_files.php";
require_once plugin_dir_path( __FILE__ ) . "includes/mmr_admin_display.php";
require_once plugin_dir_path( __FILE__ ) . "includes/mmr_functions.php";
require_once plugin_dir_path( __FILE__ ) . "includes/rest_api.php";


// if (!get_option("madoda_manager_youtube_urls")) {
//     add_option("madoda_manager_youtube_urls", "");
// }
// update_option('madoda_manager_youtube_urls', "yourspace");




