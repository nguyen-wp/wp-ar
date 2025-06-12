<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

function madelab_mediaURL($form_fields, $post) {
    // $form_fields is a special array of fields to include in the attachment form
    // $post is the attachment record in the database
    //     $post->post_type == 'attachment'
    // (attachments are treated as posts in Wordpress)
     
    // add our custom field to the $form_fields array
    // input type="text" name/id="attachments[$attachment->ID][made_url]"
    $form_fields["made_url"] = array(
        "label" => __("URL (by Restore Construction)"),
        "input" => "text", // this is default if "input" is omitted
        "value" => esc_url(get_post_meta($post->ID, "_made_url", true))
    );
    // if you will be adding error messages for your field, 
    // then in order to not overwrite them, as they are pre-attached 
    // to this array, you would need to set the field up like this:
    $form_fields["made_url"]["label"] = __("URL (by Restore Construction)");
    $form_fields["made_url"]["input"] = "text";
    $form_fields["made_url"]["value"] = esc_url(get_post_meta($post->ID, "_made_url", true));
     
    return $form_fields;
}
add_filter("attachment_fields_to_edit", "madelab_mediaURL", null, 2);

function madelab_attachment_fields_to_save($post, $attachment) {
    if ( substr($post['post_mime_type'], 0, 5) == 'image' ) {
        if ( isset( $attachment['made_url'] ) ) {
            // $post['made_url'] = esc_url(trim($post['made_url']));
            update_post_meta( $post['ID'], '_made_url', esc_url($attachment['made_url']) );
        }
    }
    return $post;
}

add_filter("attachment_fields_to_save", "madelab_attachment_fields_to_save", null , 2 );