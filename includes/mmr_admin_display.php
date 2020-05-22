<?php
//Menu PAGE
function madoda_index() {
    require_once plugin_dir_path( __FILE__ ) . "../templates/index.html";
    // printHtml(get_option("madoda_manager_youtube_urls"));
    if (is_user_logged_in(  )) {
        // printHtml("<h1>Logged</h1>");
    }
}
 function madoda_manager_custom_menu_page() {
    add_menu_page( "Madoda Manager", "Madoda Manager", "manage_options", "madoda_manager", "madoda_index", "dashicons-admin-settings",  50);
}
add_action( 'admin_menu', 'madoda_manager_custom_menu_page' );


/**
 * Register meta box(es).
 */
function madoda_manager_register_meta_boxes() {
    $screen = ["post", "page", "playlist", "albums", "artist", "blog"];
    add_meta_box( 'madoda_manager_metaBox', __( 'Madoda Manager', 'wp_madoda_manager' ), 'madoda_manager_side_display', null, "side", "high");
}
add_action( 'add_meta_boxes', 'madoda_manager_register_meta_boxes', 2 );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function madoda_manager_side_display( $post ) {
    wp_nonce_field( "madoda_manager_inner_display_side", "madoda_manager_inner_display_side_nonce" );
    if(get_post_type( $post ) == "post") {
        require_once plugin_dir_path( __FILE__ ) . "../templates/single.php";
    }else{
        echo "Else";
    }
    
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */

function save_metabox_callback( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

 
    if ( isset( $_POST['post_type'] ) ) {
        if(get_post_meta( $post_id, "madoda_manager_function_selected" )) {
            $function_name = get_post_meta( $post_id, "madoda_manager_function_selected" )[0];
            switch ($function_name) {
                case 'madoda_manager_upload_url':
                    madoda_manager_upload_urls();
                    break;
               
                case 'madoda_manager_set_urls':
                    $url = mddr_get_url_content($post_id);
                    madoda_manager_set_urls([$url]);
                    break;
                
                case 'madoda_manager_upload_urls':
                    madoda_manager_upload_urls();
                    break;
                
                
                case 'madoda_manager_do_nothing':
                    break;
                default:
                    $url = mddr_get_url_content($post_id);
                    madoda_manager_set_urls([$url]);
                break;
            }
  
        }else{
            add_post_meta($post_id, "madoda_manager_function_selected", "madoda_manager_set_urls");
        }
        update_post_meta($post_id, "madoda_manager_function_selected", "madoda_manager_do_nothing");
    }
 
    // Check if $_POST field(s) are available
 
    // Sanitize
 
    // Save
     
}
add_action( 'save_post', 'save_metabox_callback' );