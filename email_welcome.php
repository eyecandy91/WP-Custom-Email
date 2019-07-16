<!-- wp-content/plugins/user-emails/email_welcome.php -->
<?php
$email_title            = myprefix_get_theme_option('email_header');
$email_body             = myprefix_get_theme_option('email_body');
$email_link             = myprefix_get_theme_option('email_link');
$head_email             = myprefix_get_theme_option('head_email');

$user = new WP_User( (int) $user_id );
$adt_rp_key = get_password_reset_key( $user );
$user_login = $user->user_login;
$rp_link = '<a href="' . network_site_url("wp-login.php?action=rp&key=$adt_rp_key&login=" . rawurlencode($user_login), 'login') . '">Set your passowrd</a>';
?>

<img src="<?php echo content_url(); ?>/uploads/2019/06/oil-baron.png" alt="Oil baron" width="100px"/>

<?php if ( $user->first_name != '' ) : ?>
    <h3><?php echo $user->first_name; ?>, <?php echo $email_title ?></h3>
<?php else : ?>
    <h3><?php echo $email_title ?></h3>
<?php endif; ?>

<p>
<?php echo $email_body; ?>
</p>

<p><?php _e('Username:'); ?></span> <?php echo $user->user_login ?></p>
<p><?php echo $email_link ?><p>
<?php echo $rp_link; ?>

<p>
If you have an issue, email us at <a class="has-text-centered is-block" href="mailto:<?php echo $head_email; ?>" target="_blank"><?php echo $head_email; ?></a>
</p>