<?php
function madoda_manager_files() {
    wp_enqueue_script('main-madoda_manager-js', plugins_url() . '/wp-madoda-manager/js/script.js', NULL, '1.0', true);
    wp_enqueue_script('settings-madoda_manager-js', plugins_url() . '/wp-madoda-manager/js/settings.js', NULL, '1.0', true);
    wp_enqueue_script('single-madoda_manager-js', plugins_url() . '/wp-madoda-manager/js/single.js', NULL, '1.0', true);
    wp_enqueue_style('main-madoda_manager-css', plugins_url() . '/wp-madoda-manager/css/style.css');
 

    // wp_localize_script('main-madoda_manager', 'madodamanagerData', array(
    //     'post_id' => get_the_ID()
    // ));


}
add_action('admin_enqueue_scripts', 'madoda_manager_files');

function madoda_manager_add_type_attribute($tag, $hamdle, $src){
    if("main-madoda_manager-js" == $hamdle){ 
        $tag = '<script type="module" src="' .esc_url( $src ).'"></script>';
        return $tag;
    
    }
    
    if("settings-madoda_manager-js" == $hamdle){ 
        $tag = '<script type="module" src="' .esc_url( $src ).'"></script>';
        return $tag;
    }

    return $tag;
  
}

add_filter( "script_loader_tag", "madoda_manager_add_type_attribute",10, 3 );