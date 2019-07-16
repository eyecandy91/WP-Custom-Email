<?php
/*
Plugin Name: Custom New User Email
Description: Changes the copy in the email sent out to new users
*/
 
/**
 * redefine new user notification function
 *
 * emails new users their login info
 *
 * @author  Joe Sexton <joe@webtipblog.com>
 * @param   integer $user_id user id
 * @param   string $plaintext_pass optional password
 */
if ( !function_exists( 'wp_new_user_notification' ) ) {
    function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {

        // set content type to html
        add_filter( 'wp_mail_content_type', 'wpmail_content_type' );

        // user
        $user                   = new WP_User( $user_id );
        $userEmail              = stripslashes( $user->user_email );
        $siteUrl                = get_site_url();
        $site                   = $siteUrl;
        $site_without_http      = trim( str_replace( array( 'http://', 'https://' ), '', $site ), '/' );
        $head_email             = myprefix_get_theme_option('head_email');

        $subject = 'Welcome to '.$site_without_http;
        $headers = 'From:'. $head_email;

        // admin email
        $message  = "A new user has been created"."\r\n\r\n";
        $message .= 'Email: '.$userEmail."\r\n";
        @wp_mail( get_option( 'admin_email' ), 'New User Created', $message, $headers );

        ob_start();
        include plugin_dir_path( __FILE__ ).'/email_welcome.php';
        $message = ob_get_contents();
        ob_end_clean();

        @wp_mail( $userEmail, $subject, $message, $headers );

        // remove html content type
        remove_filter ( 'wp_mail_content_type', 'wpmail_content_type' );
    }
}

/**
 * wpmail_content_type
 * allow html emails
 *
 * @author Joe Sexton <joe@webtipblog.com>
 * @return string
 */
function wpmail_content_type() {

    return 'text/html';
}
 
?>