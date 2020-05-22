<?php
function madoda_manager_registe_custom_rest_api() {
    
    register_rest_route( "madoda-manager/v1", "get_cred", array(
        "methods" => WP_REST_SERVER::EDITABLE,
        "callback" => "madoda_manager_getCredentials",
        "permission_callback" => function($data) {
            $allowed_ips = mddr_get_allowed_ips();
            if($data["user"] && $data["pass"] && in_array( $_SERVER['REMOTE_ADDR'], $allowed_ips ) ) {
                return true;
            }else{
                return false;
            }
        
        }
    ) );

    register_rest_route( "madoda-manager/v1", "update/gdrive-links", array(
        "methods" => WP_REST_SERVER::EDITABLE,
        "callback" => "madoda_manager_update_gdriveLinks",
        "permission_callback" => function($data) {
            $allowed_ips = mddr_get_allowed_ips();
            if( wp_verify_nonce( $data["token"], "madoda_manager_nonce" ) && in_array( $_SERVER['REMOTE_ADDR'], $allowed_ips ) ) {
                return true;
            }else{
                return false;
            }
        
        }
    ) );
    
}
add_action("rest_api_init", "madoda_manager_registe_custom_rest_api");


function madoda_manager_getCredentials($data) {
    $user = sanitize_text_field( $data["user"] );
    $pass = sanitize_text_field( $data["pass"] );
    
    $settings = mddr_get_settrings_conf();

    $luser =  $settings["user"];
    $lpass = $settings["pass"];
    
    if($luser == $user && $lpass == $pass) {
        return wp_create_nonce( "madoda_manager_nonce" );
    }else {
        return "Auth Failed...";
    }
}

function madoda_manager_update_gdriveLinks ($data) {
    $posts_data = $data['posts'];
    // $settings = $data["data"]["settings"];
    if ($posts_data) {
        foreach ($posts_data as $key => $post_data) {
           $wp_id = $post_data["id"];
           $drive_links = mmr_get_madoda_drive_link_format($post_data["drive_links"]);
            if(get_post( $wp_id)) {
                update_field("google_drive_link",$drive_links, $wp_id);
                if(get_post_status($wp_id) != "publish") {
                    wp_update_post( array("ID"=> $wp_id, "post_status"=>"publish") );
                }
            }
        }
    
        return $post_data;
    }
}
