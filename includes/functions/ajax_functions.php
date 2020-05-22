<?php
add_action( 'wp_ajax_madoda_manager_get_home_html', 'madoda_manager_get_home_html' );
function madoda_manager_get_home_html() {   
    echo  require_once plugin_dir_path( __FILE__ ) . "../../templates/home.html";
	wp_die();
}


add_action( 'wp_ajax_madoda_manager_get_settings_html', 'madoda_manager_get_settings_html' );
function madoda_manager_get_settings_html() {     
    echo  esc_html(require_once plugin_dir_path( __FILE__ ) . "../../templates/settings.html");
	wp_die();
}

add_action( 'wp_ajax_madoda_manager_getUrls', 'madoda_manager_getUrls' );
function madoda_manager_getUrls() {
    $mmr_download_urls = get_option( "madoda_manager_download_urls" );
    $all_urls = "";
    foreach ($mmr_download_urls as $key => $value) {
        $all_urls = $all_urls . $value."\n";
    }
    echo $all_urls;
    wp_die();
}

add_action( 'wp_ajax_madoda_manager_rm_allUrls', 'madoda_manager_rm_allUrls' );
function madoda_manager_rm_allUrls() {
    // $mmr_download_urls = madoda_manager_getUrls();
    update_option('madoda_manager_download_urls', []);
    // echo $mmr_download_urls;
    echo "delete";
    wp_die();
}

add_action( 'wp_ajax_madoda_manager_rm_url', 'madoda_manager_rm_url' );
function madoda_manager_rm_url() {
    $mmr_download_urls = get_option( "madoda_manager_download_urls" );
    $url = $_POST["url"];
    $url_index = array_search($url, $mmr_download_urls);
    unset($mmr_download_urls[$url_index]);
    update_option('madoda_manager_download_urls', $mmr_download_urls);
    echo $mmr_download_urls;
    wp_die();
}

add_action( 'wp_ajax_madoda_manager_set_urls', 'madoda_manager_set_urls' );
function madoda_manager_set_urls($urls=NULL) {
    if( $_POST["urls"] || $urls) {
        ($urls != NULL)?$urls = $urls : $urls = $_POST["urls"];
        
        if (!get_option("madoda_manager_download_urls")) {
            add_option("madoda_manager_download_urls", "");
            $mmr_download_urls = [];
        }else {
            $mmr_download_urls = get_option( "madoda_manager_download_urls" );
        }
        foreach ($urls as $url) {
            if(!in_array($url, $mmr_download_urls)){
                array_push($mmr_download_urls, $url);
            }
        }

        update_option('madoda_manager_download_urls', $mmr_download_urls);
        
        echo $mmr_download_urls[count($mmr_download_urls) - 1];
    }else {
        echo "URLS NOT FOUND";      
    }
}


add_action( 'wp_ajax_madoda_manager_upload_urls', 'madoda_manager_upload_urls' );
function madoda_manager_upload_urls() {
    $mmr_download_urls = get_option( "madoda_manager_download_urls" );
    $urls_file_name = date("d_m_Y__H_i_s") . "(" . rand(0,9) . rand(0,9) . rand(0,9) . ")".".txt";
    $urls_file_path = plugin_dir_path( __FILE__ ) . "../../assets/wp_download_files/$urls_file_name";
    $urls_file = fopen($urls_file_path, "w");

    $settrings = mddr_get_settrings_conf();
    $server_ip = $settrings["serverIP"];
    $urls_save_folder= $settrings["urls_save_folder"];
    $mmr_exec_file = $settrings["mmr_exec_file"];


    $allurl = "";
    foreach ($mmr_download_urls as $key => $durl) {
        if($mmr_download_urls[array_key_last($mmr_download_urls)] == $durl){
            $allurl = $allurl.$durl;
        }else{
            $allurl = $allurl.$durl."\n";
        }
    }
    
    fwrite($urls_file, $allurl);
    fclose($urls_file);
    update_option('madoda_manager_download_urls', []);

    echo "update in progress";
}


/*
==========================
    single
==========================
*/

add_action( 'wp_ajax_madoda_manager_swith_function', 'madoda_manager_swith_function' );
function madoda_manager_swith_function() {    
    if($_POST["post_id"] && $_POST["function_name"]) {
        $post_id = $_POST["post_id"];
        $function_name = sanitize_text_field( $_POST["function_name"] );
        if(get_post_meta( $post_id, "madoda_manager_function_selected" )) {
            update_post_meta($post_id, "madoda_manager_function_selected", $function_name);
        }else{
            add_post_meta($post_id, "madoda_manager_function_selected", "madoda_manager_set_urls");
        }
        
        echo get_post_meta( $post_id, "madoda_manager_function_selected" )[0];
    }else{
        echo "error no data";
    }
   
}

/*
==========================
    settings
==========================
*/
add_action( 'wp_ajax_madoda_manager_get_settings', 'madoda_manager_get_settings' );
function madoda_manager_get_settings() {     
    $settrings_conf_path = plugin_dir_path( __FILE__ ) . "../../assets/conf/settrings.json";     
    $settrings_conf = file_get_contents($settrings_conf_path);
    $confs = json_decode( $settrings_conf);
    
    $serverIP = $confs->serverIP;
    $folder_name = $confs->urls_save_folder;

    echo "server_ip,$serverIP,save_path,$folder_name,";
	
}

add_action( 'wp_ajax_madoda_manager_set_settings', 'madoda_manager_set_settings' );
function madoda_manager_set_settings() {

    $serverIP = $_POST["server_ip"];
    $folder_name = $_POST["urls_save_folder"];
    $mmr_exec_file = $_POST["mmr_exec_file"];
    $user = $_POST["user"];
    $pass = $_POST["pass"];

    if( mddr_get_settrings_conf() ) {
        $settrings = mddr_get_settrings_conf();
        if($serverIP) {
            $settrings["serverIP"] = $serverIP;
        }
        
        if($folder_name) {
            $settrings["urls_save_folder"] = $folder_name;
        }
        
        if($mmr_exec_file) {
            $settrings["mmr_exec_file"] = $mmr_exec_file;
        }
        
        if($user) {
            $settrings["user"] = $user;
        }
        
        if($pass) {
            $settrings["pass"] = $pass;
        }

    }else{
        if (!$mmr_exec_file) {
            $mmr_exec_file = "wp_mddmanager.py";
        }
        $settrings = [
            "serverIP" => $serverIP,
            "urls_save_folder" => $folder_name,
            "mmr_exec_file" => $mmr_exec_file,
            "user"=> $user,
            "pass"=> $pass
        ];        
    }
    $settrings_path = plugin_dir_path( __FILE__ ) . "../../assets/conf/settrings.json";     
    $settrings_file = fopen($settrings_path, "w");
    fwrite($settrings_file, json_encode($settrings));
    fclose($settrings_file);   
    
    echo "Saved ";
}

add_action( 'wp_ajax_madoda_manager_allowd_ips', 'madoda_manager_allowd_ips' );
function madoda_manager_allowd_ips() {
    if( !$_POST["ip"]) {
        echo "no ip";
        return false;
    }
    $ip = $_POST["ip"];

    $allowed_ips = mddr_get_allowed_ips();
    
    $res = "";
    
    if(in_array($ip, $allowed_ips)) {
        $ip_index = array_search($ip, $allowed_ips);
        unset($allowed_ips[$ip_index]);
        $res = $ip." Removed ";
    }else{
        array_push($allowed_ips, $ip);       
        $res = $ip." Added ";
    }

    $aw_ips_path = plugin_dir_path( __FILE__ ) . "../../assets/conf/allowed_ips.json";     
    $aw_ips_file = fopen($aw_ips_path, "w");
    fwrite($aw_ips_file, json_encode($allowed_ips));
    fclose($aw_ips_file); 
    
    echo $res;

}