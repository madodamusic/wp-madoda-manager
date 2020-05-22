async function home_page_setup() {
    let $ = jQuery
    let data = {
        'action': 'madoda_manager_get_home_html',
    };

    await jQuery.post(ajaxurl, data, function(response) {
        $("#wp-madoda-manager-main #main-body>#home-page").html(response)
    });

    get_urls()

    $("#wp-madoda-manager-main #menu-home").off().on("click", ()=>{
        $("#wp-madoda-manager-main #main-body>#settings-page").css("display", "none")
        $("#wp-madoda-manager-main #main-body>#home-page").css("display", "block")
    })
    
    $("#wp-madoda-manager-main #upload-btn").off().on("click", ()=>{
        console.log("uplo")
        upload()
    })
    
    $("#wp-madoda-manager-main #remove-all-btn").off().on("click", ()=>{
        remove_all()
    })
    

}

jQuery(document).ready(function($) {  
    if ( document.querySelector("#wp-madoda-manager-main #main-body>#home-page") ){
        home_page_setup()
        console.log("work")
    }
});

// import {set} from "./settings.js"

// const settings_menu = document.querySelector("#wp-madoda-manager-main #menu-settings")
// let youtube_urls_field = document.querySelector("#youtube_url")

// let save_btn = document.querySelector("#save-btn")
// let upload_btn = document.querySelector("#upload-btn")
// let remove_all_btn = document.querySelector("#remove-all-btn")

async function get_urls() {
    let $ = jQuery
    let res = []
    let data = {
        'action': 'madoda_manager_getUrls',
    };

    await jQuery.post(ajaxurl, data, function(response) {
       $("#wp-madoda-manager-main #youtube_url").html(response)
    });

//    for (let index = 0; index < res.length; index++) {
//        const element = res[index];
//        console.log(element)
       
//    }
}

// function save_urls() {
//     console.log("save")
// }

// function add_url() {

// }

async function upload() {
    let data = {
        'action': 'madoda_manager_upload_urls',
    };

    await jQuery.post(ajaxurl, data, function(response) {
    //    $("#wp-madoda-manager-main #youtube_url").html(response)
        console.log(response);
    });
}

async function remove_all() {
    let data = {
        'action': 'madoda_manager_rm_allUrls',
    };

    await jQuery.post(ajaxurl, data, function(response) {
    //    $("#wp-madoda-manager-main #youtube_url").html(response)
        console.log(response);
    });
}

// save_btn.addEventListener("click", ()=>{
//     console.log(youtube_urls_field.value.split("\n"))
//     console.log(set())
// })
// let urls = ["url1", "url2", "url3"]
// urls.forEach(x => {

//     youtube_urls_field.value += x+"\n"
// })


