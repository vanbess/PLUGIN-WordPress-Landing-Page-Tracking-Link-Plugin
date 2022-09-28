<?php
// ~~~~~~~~~~~~~~~
// save post page
// ~~~~~~~~~~~~~~~
add_action('save_post', function ($post_id) {

    // bail if not page,
    if (get_post_type($post_id) !== 'page') :
        return;
    endif;

    // save page type
    if (isset($_POST['landing-page'])) :
        update_post_meta($post_id, '_lpt_is_landing', $_POST['landing-page']);
    else :
        delete_post_meta($post_id, '_lpt_is_landing');
    endif;

    // save link class
    if (isset($_POST['class-name'])  && !empty($_POST['class-name'])) :
        update_post_meta($post_id, '_lpt_class_name', maybe_serialize(array_filter($_POST['class-name'])));
    else :
        delete_post_meta($post_id, '_lpt_class_name');
    endif;

    // save tracking url
    if (isset($_POST['tracking-link']) && !empty($_POST['tracking-link'])) :
        update_post_meta($post_id, '_lpt_tracking_link', maybe_serialize(array_filter($_POST['tracking-link'])));
    else :
        delete_post_meta($post_id, '_lpt_tracking_link');
    endif;
}, 10, 1);

// ~~~~~~~~~~~~~~~~~~
// save post landing
// ~~~~~~~~~~~~~~~~~~
add_action('save_post', function ($post_id) {

    // bail if not page,
    if (get_post_type($post_id) !== 'landing') :
        return;
    endif;

    // save page type
    if (isset($_POST['landing-page'])) :
        update_post_meta($post_id, '_lpt_is_landing', $_POST['landing-page']);
    else :
        delete_post_meta($post_id, '_lpt_is_landing');
    endif;

    // save link class
    if (isset($_POST['class-name'])  && !empty($_POST['class-name'])) :
        update_post_meta($post_id, '_lpt_class_name', maybe_serialize(array_filter($_POST['class-name'])));
    else :
        delete_post_meta($post_id, '_lpt_class_name');
    endif;

    // save tracking url
    if (isset($_POST['tracking-link']) && !empty($_POST['tracking-link'])) :
        update_post_meta($post_id, '_lpt_tracking_link', maybe_serialize(array_filter($_POST['tracking-link'])));
    else :
        delete_post_meta($post_id, '_lpt_tracking_link');
    endif;
}, 10, 1);

// ~~~~~~~~~~~~~~~~~~~~~
// save post collection
// ~~~~~~~~~~~~~~~~~~~~~
add_action('save_post', function ($post_id) {

    // bail if not collection post type
    if (get_post_type($post_id) !== 'collection') :
        return;
    endif;

    // save page type
    if (isset($_POST['landing-page'])) :
        update_post_meta($post_id, '_lpt_is_landing', $_POST['landing-page']);
    else :
        delete_post_meta($post_id, '_lpt_is_landing');
    endif;

    // save link class
    if (isset($_POST['class-name'])  && !empty($_POST['class-name'])) :
        update_post_meta($post_id, '_lpt_class_name', maybe_serialize(array_filter($_POST['class-name'])));
    else :
        delete_post_meta($post_id, '_lpt_class_name');
    endif;

    // save tracking url
    if (isset($_POST['tracking-link']) && !empty($_POST['tracking-link'])) :
        update_post_meta($post_id, '_lpt_tracking_link', maybe_serialize(array_filter($_POST['tracking-link'])));
    else :
        delete_post_meta($post_id, '_lpt_tracking_link');
    endif;
}, 10, 1);
