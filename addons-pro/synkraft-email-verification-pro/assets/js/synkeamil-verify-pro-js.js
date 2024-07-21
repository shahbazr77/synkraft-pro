jQuery(document).ready(function($){
    if(jQuery("#resend-email").length > 0) {
        jQuery("#resend-email").on('click', function () {
             var user_id = jQuery(this).data("user-id");
            var email_send_count=jQuery(this).data("resend-count");
            var email_send_limit=jQuery(this).data("email-set-count");
               jQuery.post(synk_email_string_pro.ajax_url, {
                   action: 'send_verify_email_pro',
                   nonce: synk_email_string_pro.nonce,
                   userid: user_id,
                   resend_count: email_send_count,
                   email_send_limits:email_send_limit
               }).done(function (response) {
                   if (response.success === true) {
                       console.log(response.data.message);
                       jQuery("#email-name").html(response.data.email_name);
                       jQuery("#email-counter").html(response.data.email_count);
                       jQuery("#resend-count").val(response.data.email_count);
                       window.location.href = response.data.url_path;

                   } else {
                       jQuery("#custom-msg").html(response.data.message);

                   }

               })

        })
    }

})