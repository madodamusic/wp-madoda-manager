<?php
/*
=================================
    CLIENT ENDPOITS CALLBACKS
=================================
*/
require_once plugin_dir_path( __FILE__ ) . "/functions/ajax_functions.php";

// function madoda_manager_clean_urls($data) {
//     // $mmr_download_urls = get_option( "madoda_manager_download_urls" );
//     // update_option('madoda_manager_download_urls', []);
//     return $_SERVER["REMOTE_ADDR"];
// }

// function madoda_manager_get_urls($data) {
//     if(is_user_admin(  ) && current_user_can( "edit_posts" )){
//         $mmr_download_urls = get_option( "madoda_manager_download_urls" );
//         return $mmr_download_urls;
//     }else{
//         return $data["auth"];
//     }
// }


// function madoda_manager_upload_url($data) {
//     $mmr_download_urls = get_option( "madoda_manager_download_urls" );
    

//     $com = "echo ".(["llll","llll"]);
//     $allurl = "";
//     foreach ($mmr_download_urls as $key => $durl) {
//         if($mmr_download_urls[array_key_last($mmr_download_urls)] == $durl){
//             $allurl = $allurl.$durl;
//         }else{
//             $allurl = $allurl.$durl.",";
//         }
//     }
//     $res= shell_exec("cat file.txt");
//     return $res;
    
//     // return $mmr_download_urls;
// }

function mddr_gete_artists() {
    $artists = get_field('artist');
    $artists_num = (count($artists));
    
    if($artists_num >= 2){
        $sec_artists = "";
        for ($i=1; $i < $artists_num; $i++) { 
            if($i == ($artists_num -1) ){
                $sec_artists = $sec_artists.$artists[$i]->post_title;
            }else{
                $sec_artists .= $artists[$i]->post_title.", ";
            }
        } 
        return $artists[0]->post_title."(feat. ".$sec_artists.")";
    }else{
        return $artists[0]->post_title;
    }
}

function mddr_get_url_content($post_id) {
    $youtube_url = str_replace(" ","", get_post_meta( $post_id, "download_youtube_url" )[0]);
    $title =  str_replace(" ","", get_post_meta( $post_id, "title" )[0]);
    $artist =  str_replace(" ","", mddr_gete_artists());
    $url_content = $youtube_url.' wp_id='.$post_id.' -t {"Artist":"'.$artist.'","Title":"'.$title.'"}';

    return $url_content;
}

function mddr_get_settrings_conf() {
    $confs = "";
    $settrings_conf_path = plugin_dir_path( __FILE__ ) . "../assets/conf/settrings.json";     
    if( file_exists($settrings_conf_path) ){
        $settrings_conf = file_get_contents($settrings_conf_path);
        $confs = json_decode( $settrings_conf, true);
    }

    return $confs;
}

function mddr_get_allowed_ips() {
    $aw_ips = "";
    $aw_ips_path = plugin_dir_path( __FILE__ ) . "../assets/conf/allowed_ips.json";     
    if( file_exists($aw_ips_path) ){
        $aw_ips_cont = file_get_contents($aw_ips_path);
        $aw_ips = json_decode( $aw_ips_cont, true);
    }

    return $aw_ips;
}

function mmr_get_madoda_drive_link_format($links) {
    $mdd_format_ids = "";
    for($i=0; $i < count($links); $i++){
        $new_id = sanitize_text_field( $links[$i] );
        if($i == (count($links) - 1)){
            $mdd_format_ids = $mdd_format_ids.$new_id;
        }else {
            $mdd_format_ids = $mdd_format_ids.$new_id."&&\n";
        }
    }

    return $mdd_format_ids;
}
