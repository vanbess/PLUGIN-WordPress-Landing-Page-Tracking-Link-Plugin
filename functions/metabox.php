<?php

// ~~~~~~~~~~~~~~~~~ 
// register metabox
// ~~~~~~~~~~~~~~~~~ 
add_action('add_meta_boxes', function () {

    add_meta_box(
        'landing-page-tracking-link',
        __('Landing Page Tracking Link Settings', 'lp-tracking'),
        'landing_page_tracking_link',
        'page',
        'normal'
    );

    add_meta_box(
        'landing-page-tracking-link',
        __('Landing Page Tracking Link Settings', 'lp-tracking'),
        'landing_page_tracking_link',
        'landing',
        'normal'
    );

    add_meta_box(
        'landing-page-tracking-link',
        __('Landing Page Tracking Link Settings', 'lp-tracking'),
        'landing_page_tracking_link',
        'collection',
        'normal'
    );
});

// ~~~~~~~~~~~~~~~~~~~~
// render metabox html
// ~~~~~~~~~~~~~~~~~~~~
function landing_page_tracking_link() {

    global $post;
?>

    <!-- tracking link input cont -->
    <div id="lp-tracking-link-input-cont">

        <!-- is it landing page select -->
        <p style="margin-bottom: -10px; font-weight: 500; font-style: italic; padding-left:5px;">

            <label for="landing-page"><?php _e('Is this a landing page?', 'lp-tracking'); ?></label>

        </p>
        <p>
            <select style="min-width: 360px;" name="landing-page" id="landing-page" data-current="<?php echo get_post_meta($post->ID, '_lpt_is_landing', true); ?>">
                <option value=""><?php _e('please select...', 'lp-tracking'); ?></option>
                <option value="Yes"><?php _e('Yes', 'lp-tracking'); ?></option>
                <option value="No"><?php _e('No', 'lp-tracking'); ?></option>
            </select>
        </p>

        <hr style="border: none; margin: 30px 0px; color: #dddddd; background-color: #dddddd; height: 1px;">

        <?php

        // existing tracking metadata
        $class_names    = maybe_unserialize(get_post_meta($post->ID, '_lpt_class_name', true));
        $tracking_links = maybe_unserialize(get_post_meta($post->ID, '_lpt_tracking_link', true));

        // combine arrays into one array for loop (NOTE: this assumes that $class_names are unique, else non-unique values will be lost along with associate tracking links)
        $combined = array_combine($class_names, $tracking_links);

        // loop through existing/current data sets and display
        foreach ($combined as $class_name => $tracking_link) : ?>

            <div class="lpt-tracking-pair" style="border-bottom: 1px solid #ddd; padding-bottom: 25px; margin-bottom: 25px;">

                <!-- class input -->
                <p style="margin-bottom: -10px; font-weight: 500; font-style: italic; padding-left:5px; position: relative;">

                    <label for="class-name"><?php _e('Class name:', 'lp-tracking'); ?></label>

                    <!-- add/remove tracking set -->
                    <span class="add-rem-cont" style="position: absolute; right: 0; top: 26px">

                        <!-- add -->
                        <button class="button button-primary button-small lp-add" style="width: 26px;" title="<?php _e('add tracking link set', 'lp-tracking'); ?>">+</button>

                        <!-- remove -->
                        <button class="button button-secondary button-small lp-rem" style="width: 26px;" title="<?php _e('remove tracking link set', 'lp-tracking'); ?>">-</button>

                    </span>
                </p>
                <p>
                    <input style="min-width: 360px;" type="text" name="class-name[]" id="class-name" value="<?php echo $class_name; ?>">
                </p>

                <!-- url input -->
                <p style="margin-bottom: -10px; font-weight: 500; font-style: italic; padding-left:5px;">
                    <label for="tracking-link"><?php _e('Tracking link:', 'lp-tracking'); ?></label>
                </p>
                <p>
                    <input style="min-width: 360px; width: 100%;" type="url" name="tracking-link[]" id="tracking-link" value="<?php echo $tracking_link; ?>">
                </p>

            </div>

        <?php endforeach; ?>

        <div class="lpt-tracking-pair" style="border-bottom: 1px solid #ddd; padding-bottom: 25px; margin-bottom: 25px;">

            <!-- class input -->
            <p style="margin-bottom: -10px; font-weight: 500; font-style: italic; padding-left:5px; position: relative;">

                <label for="class-name"><?php _e('Class name:', 'lp-tracking'); ?></label>

                <!-- add/remove tracking set -->
                <span class="add-rem-cont" style="position: absolute; right: 0; top: 26px">

                    <!-- add -->
                    <button class="button button-primary button-small lp-add" style="width: 26px;" title="<?php _e('add tracking link set', 'lp-tracking'); ?>">+</button>

                    <!-- remove -->
                    <button class="button button-secondary button-small lp-rem" style="width: 26px;" title="<?php _e('remove tracking link set', 'lp-tracking'); ?>">-</button>

                </span>
            </p>
            <p>
                <input style="min-width: 360px;" type="text" name="class-name[]" id="class-name" value="">
            </p>

            <!-- url input -->
            <p style="margin-bottom: -10px; font-weight: 500; font-style: italic; padding-left:5px;">
                <label for="tracking-link"><?php _e('Tracking link:', 'lp-tracking'); ?></label>
            </p>
            <p>
                <input style="min-width: 360px; width: 100%;" type="url" name="tracking-link[]" id="tracking-link" value="">
            </p>

        </div>

    </div>

    <!-- save/update -->
    <p id="lp-save-cont" style="margin-top: 2em;">
        <input type="submit" class="button button-primary button-large" value="<?php _e('Save tracking settings', 'lp-tracking'); ?>">
    </p>

    <!-- mini script to set correct value for landing page input -->
    <script>
        jQuery(document).ready(function($) {

            // set current value of landing page dropdown
            $('#landing-page').val($('#landing-page').data('current'));

            // insert input set
            $(document).on('click', '.lp-add', function(e) {
                e.preventDefault();

                var to_insert = '<div class="lpt-tracking-pair" style="border-bottom: 1px solid #ddd; padding-bottom: 25px; margin-bottom: 25px;">';
                to_insert += '<p style="margin-bottom: -10px; font-weight: 500; font-style: italic; padding-left:5px; position: relative;">';
                to_insert += '<label for="class-name"><?php _e('Class name:', 'lp-tracking'); ?></label>';
                to_insert += '<span class="add-rem-cont" style="position: absolute; right: 0; top: 26px;">';
                to_insert += '<button class="button button-primary button-small lp-add" style="width: 26px;" title="<?php _e('add tracking link set', 'lp-tracking'); ?>">+</button>';
                to_insert += '<button class="button button-secondary button-small lp-rem" style="width: 26px;" title="<?php _e('remove tracking link set', 'lp-tracking'); ?>">-</button>';
                to_insert += '</span>';
                to_insert += '</p>';
                to_insert += '<p>';
                to_insert += '<input style="min-width: 360px;" type="text" name="class-name[]" id="class-name">';
                to_insert += '</p>';
                to_insert += '<p style="margin-bottom: -10px; font-weight: 500; font-style: italic; padding-left:5px;">';
                to_insert += '<label for="tracking-link"><?php _e('Tracking link:', 'lp-tracking'); ?></label>';
                to_insert += '</p>';
                to_insert += '<p>';
                to_insert += '<input style="min-width: 360px; width: 100%;" type="url" name="tracking-link[]" id="tracking-link">';
                to_insert += '</p>';
                to_insert += '</div>';

                $('#lp-tracking-link-input-cont').append(to_insert);

            });

            // remove input set
            $(document).on('click', '.lp-rem', function(e) {
                e.preventDefault();
                $(this).parents('.lpt-tracking-pair').remove();
            });

        });
    </script>

<?php }
