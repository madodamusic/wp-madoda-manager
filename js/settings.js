async function settings_page_setup() {
    jQuery("#wp-madoda-manager-main #menu-settings").off().on("click", async ()=>{
        var $ = jQuery
        $("#wp-madoda-manager-main #main-body>#home-page").css("display", "none")
        $("#wp-madoda-manager-main #main-body>#settings-page").css("display", "block")
        var data = {
            'action': 'madoda_manager_get_settings_html'
        };
        
        await jQuery.post(ajaxurl, data, function(response) {
            jQuery("#wp-madoda-manager-main #main-body>#settings-page").html(response)
        });

        get_settrings()
        $("#wp-madoda-manager-main #settings-page #save-settings").off().on("click", ()=>{
            jQuery("#wp-madoda-manager-main #main-body>#settings-page .response").html("<p>...</p>")
            set_settrings()
        })
        
        $("#wp-madoda-manager-main #settings-page #mddr_allowed_ip_btn").off().on("click", ()=>{
            jQuery("#wp-madoda-manager-main #main-body>#settings-page .aw-ips-response").html("<p>...</p>")
            add_rm_alowed_ips()
        })

        

    })
}

jQuery(document).ready(function($) {  
    settings_page_setup($)
});

function get_settrings() {
    var data = {
        'action': 'madoda_manager_get_settings'
    };
    jQuery.post(ajaxurl, data, function(response) {
        // jQuery("#wp-madoda-manager-main #main-body>#settings-page").html(response)
        let obj ={response}
        console.log(response)
    });
}

let set_settrings = function () {
    let server_ip = jQuery("#wp-madoda-manager-main #main-body>#settings-page #server_ip").val()
    let urls_save_folder = jQuery("#wp-madoda-manager-main #main-body>#settings-page #downl_urls_folder").val()
    let mmr_exec_file = jQuery("#wp-madoda-manager-main #main-body>#settings-page #mmr_exec_file").val()
    let user = jQuery("#wp-madoda-manager-main #main-body>#settings-page #mddr_user_auth").val()
    let pass = jQuery("#wp-madoda-manager-main #main-body>#settings-page #mddr_pass_auth").val()
    console.log(mmr_exec_file)
    var data = {
        'action': 'madoda_manager_set_settings',
        "server_ip":server_ip,
        "urls_save_folder": urls_save_folder,
        "mmr_exec_file": mmr_exec_file,
        "user": user,
        "pass": pass
    };
    jQuery.post(ajaxurl, data, function(response) {
        jQuery("#wp-madoda-manager-main #main-body>#settings-page .response").html("<p>"+response+"</p>")
    });
}

let add_rm_alowed_ips = function() {
    let ip = jQuery("#wp-madoda-manager-main #main-body>#settings-page #mddr_allowed_ip_input").val()

    var data = {
        'action': 'madoda_manager_allowd_ips',
        "ip":ip
    };
    jQuery.post(ajaxurl, data, function(response) {
        console.log(response)
        jQuery("#wp-madoda-manager-main #main-body>#settings-page .aw-ips-response").html("<p>"+response+"</p>")
    });
}