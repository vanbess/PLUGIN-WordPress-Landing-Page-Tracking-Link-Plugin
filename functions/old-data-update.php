<?php
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// one time update relevant pages to new tracking meta data and delete old data
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// check if updated flag exists in options table and bail if true (prevents constant running of update function)
add_action('admin_head', function () {

    // retrieve previously updated pages
    $previously_updated = maybe_unserialize(get_option('_lpt_pages_updated'));

    // page query
    $page_query = new WP_Query([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'is_it_a_landing_page',
                'value'   => array('Yes', 'No'),
                'compare' => 'IN',
            ),
        ),
        'fields' => 'ids'
    ]);

    // updated page ids array
    $updated_ids = [];

    // if posts, retrieve page ids array, loop and update tracking post meta
    if ($page_query->have_posts()) :

        // retrieve page ids
        $page_ids = $page_query->posts;

        // if $page_ids is array and not empty
        if (is_array($page_ids) && !empty($page_ids)) :

            // loop
            foreach ($page_ids as $page_id) :

                // check if page has already been updated
                if (!in_array($page_id, $previously_updated)) :

                    // retrieve old tracking meta
                    $is_landing_page = get_post_meta($page_id, 'is_it_a_landing_page', true);
                    $tracking_data   = get_field('tracking_landing_default_url', $page_id);

                    // file_put_contents(LP_TRACKING_PATH . 'old-tracking-data-alt.txt', print_r($tracking_data, true), FILE_APPEND);

                    // setup new data $class_names array
                    $class_names = [];

                    // setup new data $tracking_links array
                    $tracking_links = [];

                    // loop to extract old tracking data
                    foreach ($tracking_data as $index => $tracking_data) :

                        // push class names to $class_names array
                        $class_names[] = $tracking_data['class'];

                        // push $tracking_link to $tracking_links array
                        $tracking_links[] = $tracking_data['value'];

                    endforeach;

                    // update to new tracking meta structure
                    $is_landing_updated     = update_post_meta($page_id, '_lpt_is_landing', $is_landing_page);
                    $classes_updated        = update_post_meta($page_id, '_lpt_class_name', maybe_serialize($class_names));
                    $tracking_links_updated = update_post_meta($page_id, '_lpt_tracking_link', maybe_serialize($tracking_links));

                    // push page id to $updated_ids array once update complete
                    if ($is_landing_updated || $classes_updated || $tracking_links_updated) :
                        $updated_ids[] = $page_id;
                    endif;

                // delete old post meta (optional - uncomment below to activate)
                // if ($is_landing_updated) :
                //     delete_post_meta($page_id, 'is_it_a_landing_page');
                // endif;
                // if ($class_updated) :
                //     delete_post_meta($page_id, 'tracking_landing_default_url_0_class');
                // endif;
                // if ($tracking_link_updated) :
                //     delete_post_meta($page_id, '_lpt_tracking_link');
                // endif;

                endif;

            endforeach;

        endif;

    endif;

    // update updated page id array in options table
    if (!empty($updated_ids)) :
        update_option('_lpt_pages_updated', maybe_serialize($updated_ids));
    endif;
});
