jQuery(document).ready(function($) {
    if(document.querySelector("#wp-madoda-manager-single #madoda_manager_single_wp_id")){
        let radios = document.querySelectorAll("#wp-madoda-manager-single input[type='radio'].select_function")
        let post_id = document.querySelector("#wp-madoda-manager-single #madoda_manager_single_wp_id").value
        radios.forEach((el)=>{el.addEventListener("click", ()=>{
        setTimeout(()=>{ 
                console.log("btn cli")
                let data = {
                    'action': 'madoda_manager_swith_function',
                    'post_id': post_id,
                    'function_name': el.value
                };
            
                jQuery.post(ajaxurl, data, function(response) {
                    console.log(response)
                });
            }, 3000)

        })})


    
    // $("#wp-madoda-manager-single #wpmmr-single-upload-list").off().on("click", ()=>{
    //     let data = {
    //         'action': 'madoda_manager_upload_urls'
    //     };
    
    //     jQuery.post(ajaxurl, data, function(response) {
    //        console.log(response)
    //     });
    // })  

    }
});