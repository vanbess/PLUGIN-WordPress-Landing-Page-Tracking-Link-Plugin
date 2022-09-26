<?php
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// update tracking link on front-end
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
add_action('wp_head', function () {

    global $post;

    // get landing page setting
    $lp_setting = get_post_meta($post->ID, '_lpt_is_landing', true);

    // if landing page, search for class names and insert tracking urls
    if ($lp_setting == 'Yes' && get_post_meta($post->ID, '_lpt_class_name', true) && get_post_meta($post->ID, '_lpt_tracking_link', true)) :

        // get class names and tracking links
        $class_names    = maybe_unserialize(get_post_meta($post->ID, '_lpt_class_name', true));
        $tracking_links = maybe_unserialize(get_post_meta($post->ID, '_lpt_tracking_link', true));

        // setup $class_name => $tracking_link array
        $lp_default_urls = array_combine($class_names, $tracking_links);

        // js to search for class name(s) and set href attribute for each found instance
?>
        <script>
            const lp_default_urls = <?php echo (json_encode($lp_default_urls)) ?>;

            // replace url landing page
            function lp_getSearchParams(k) {
                var p = {};
                location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(s, k, v) {
                    p[k] = v
                })
                return k ? p[k] : p;
            }

            jQuery(document).ready(function($) {
                if (typeof(lp_default_urls) != "undefined") {
                    if (lp_default_urls && typeof(lp_getSearchParams('rtkcid')) === "undefined" && typeof(lp_getSearchParams('rtkcmpid')) === "undefined" && typeof(lp_getSearchParams('cmpid')) === "undefined") {
                        setTimeout(function() {
                            jQuery.each(lp_default_urls, function(index, value) {
                                jQuery('.' + index).attr('href', value);
                            });
                        }, 5e2);
                    }
                }
            });
        </script>
<?php
    endif;
});
?>