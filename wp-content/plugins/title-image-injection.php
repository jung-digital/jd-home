<?php
/**
 * @package Title_Image_Injection
 * @version 1.0
 */
/*
Plugin Name: Title Image Injection
Plugin URI: http://jungdigital.com
Description: Injects a customizable image before or after the_title.
Author: Joshua Jung
Version: 1.0
Author URI: http://jungdigital.com
*/

/*--------------------------------------------------
 * Debugging
 *------------------------------------------------*/
if (!function_exists('_log')) {
    function _log($message) {
        if (WP_DEBUG === true) {
            if (is_array($message) || is_object($message)) {
                error_log(print_r($message, true));
            }else {
                error_log($message);
            }
        }
    }
}

/*--------------------------------------------------
 * Settings
 *------------------------------------------------*/
add_action('admin_menu', 'jd_li_add_page');

function jd_li_add_page() {
    add_options_page('Logo Injector', 'Choose Logo', 'manage_options', 'plugin', 'jd_li_options_page');
}

function jd_li_options_page() {
?>
<div>
    <h2>Logo Injector</h2>
    Options
    <form action="options.php" method="post">
        <?php settings_fields('jd_li_settings'); ?>
        <?php do_settings_sections('jd_li_plugin'); ?>
        <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form>
</div>
<?php
}

/*------------------------------------------------
 * Adding Settings
 *----------------------------------------------*/
add_action('admin_init', 'plugin_admin_init');

function plugin_admin_init() {
    register_setting('jd_li_settings', 'jd_li_options', 'plugin_options_validate');
    add_settings_section('jd_li_main', 'Logo Settings', 'plugin_section_text', 'jd_li_plugin');
    add_settings_field('jd_li_logo', 'Logo Image', 'jd_li_logo_image', 'jd_li_plugin', 'jd_li_main');
    add_settings_field('jd_li_logo_preview', __('Logo Preview', 'jdli'), 'jdli_settings_logo_preview', 'jd_li_plugin', 'jd_li_main');
}

function plugin_section_text() {
    echo '<p>Main description of this section here.</p>';
}

function jd_li_logo_image() {
    $opts = get_option('jd_li_options');
?>
    <input type='hidden' id='logo' name="jd_li_options[logo]" value="<?php echo esc_url($opts['logo']);?>"/>
    <input type="button" id="upload_logo_button" class="button" value="Upload Logo" />
<?php
}

function plugin_options_validate($input) {
    $newinput['logo'] = trim($input['logo']);
    return $newinput;
}

function jdli_settings_logo_preview() {
    $opts = get_option('jd_li_options'); ?>
    <div id="upload_logo_preview" style="min-height: 100px">
        <img style="max-width:100%;" src="<?php echo esc_url( $opts['logo']); ?>" />
    </div>
    <?php
}

/*-----------------------------------------------------
 * Javascript/CSS
 *---------------------------------------------------*/
function jd_li_enqueue_scripts() {
    wp_register_script('jd_li_upload', plugins_url() .'/js/jd_li_upload.js', array('jquery', 'media-upload', 'thickbox'));

    $screen = get_current_screen();

    if ('settings_page_plugin' == $screen->id) {
        wp_enqueue_script('jquery');

        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');

        wp_enqueue_script('media-upload');
        wp_enqueue_script('jd_li_upload');
    }
}

add_action('admin_enqueue_scripts', 'jd_li_enqueue_scripts');

function options_setup() {
    global $pagenow;

    if ('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow) {
        add_filter('gettext', 'replace_thickbox_text', 1, 3);
    }
}

add_action('admin_init', 'options_setup');

function replace_thickbox_text($translated_text, $text, $domain) {
    if ('Insert into Post' == $text) {
        $referer = strpos(wp_get_referer(), 'jdlisettings');
        if ($referer != '') {
            return __('I want this to be my logo!', 'jdli');
        }
    }
    
    return $translated_text;
}
?>
