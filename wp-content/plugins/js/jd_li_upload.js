jQuery(document).ready(function ($) {
    $('#upload_logo_button').click(function () {
        tb_show('Upload a logo', 'media-upload.php?referer=jdlisettings&type=image&TB_iframe=true&post_id=0', false);
        return false;
    });
});

window.send_to_editor = function (html) {
    var image_url = jQuery('img', html).attr('src');
    jQuery('#logo').val(image_url);
    tb_remove();
    jQuery('#upload_logo_preview img').attr('src', image_url);
    jQuery('#submit_options_form').trigger('click');
}
