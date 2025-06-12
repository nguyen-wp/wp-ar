<?php 
// Submit Data
if (isset($_POST['submit'])) {

    // Secure Form 
    if ( ! isset( $_POST['n3_testimonials_nonce'] ) || ! wp_verify_nonce( $_POST['n3_testimonials_nonce'], 'n3_testimonials_nonce' ) ) {
        return;
    }


    // Update Category Meta Data
    $get_meta_autoplay = isset($_POST['autoplay']) ? $_POST['autoplay'] : 'false';
    $get_meta_speed = isset($_POST['speed']) ? (int)$_POST['speed'] : 5000;
    $get_meta_limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;
    $get_meta_infinite = isset($_POST['infinite']) ? $_POST['infinite'] : 'false';
    $get_meta_arrows = isset($_POST['arrows']) ? $_POST['arrows'] : 'false';
    $get_meta_dots = isset($_POST['dots']) ? $_POST['dots'] : 'false';
    $get_meta_autoheight = isset($_POST['autoheight']) ? $_POST['autoheight'] : 'false';
    $get_meta_layout = isset($_POST['layout']) ? $_POST['layout'] : 'default';
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;

    // Update taxonomy n3_testimonial_categories
    update_term_meta($category_id, 'n3_testimonial_autoplay', $get_meta_autoplay);
    update_term_meta($category_id, 'n3_testimonial_speed', $get_meta_speed);
    update_term_meta($category_id, 'n3_testimonial_limit', $get_meta_limit);
    update_term_meta($category_id, 'n3_testimonial_infinite', $get_meta_infinite);
    update_term_meta($category_id, 'n3_testimonial_arrows', $get_meta_arrows);
    update_term_meta($category_id, 'n3_testimonial_dots', $get_meta_dots);
    update_term_meta($category_id, 'n3_testimonial_autoheight', $get_meta_autoheight);
    update_term_meta($category_id, 'n3_testimonial_layout', $get_meta_layout);

    // Show Success Message
    echo '<div class="updated notice is-dismissible"><p>Testimonial Category Updated Successfully</p></div>';
}
?>
<style>
.madetable table * {
    box-sizing: border-box;
}
</style>
<h1>
<?php echo esc_html( get_admin_page_title() ); ?>
</h1>
<p>
    This is a list of testimonials. Please copy the shortcode and paste it in the page/post where you want to display
    the testimonial.
</p>
<div class="wrap madetable n3_testimonials">
    <div class="form-wrap">
        <table class="table wp-list-table">
            <thead>
                <tr>
                    <th width="200">Category</th>
                    <th>Preview</th>
                    <th width="400">Setting/Shortcode</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $testimonial_categories = get_terms( array(
                        'taxonomy' => 'n3_testimonial_categories',
                        'hide_empty' => false,
                    ) );
                    
                    if ( ! empty( $testimonial_categories ) && ! is_wp_error( $testimonial_categories ) ) {
                        foreach ($testimonial_categories as $testimonial_category) {
                            $category_id = $testimonial_category->term_id;
                            $category_name = $testimonial_category->name;
                            $category_slug = $testimonial_category->slug;
                            $get_categoty_meta = get_term_meta($category_id);
                            $meta_autoplay = isset($get_categoty_meta['n3_testimonial_autoplay'][0]) ? $get_categoty_meta['n3_testimonial_autoplay'][0] : 'false';
                            $meta_speed = isset($get_categoty_meta['n3_testimonial_speed'][0]) ? $get_categoty_meta['n3_testimonial_speed'][0] : 5000;
                            $meta_infinite = isset($get_categoty_meta['n3_testimonial_infinite'][0]) ? $get_categoty_meta['n3_testimonial_infinite'][0] : 'false';
                            $meta_limit = isset($get_categoty_meta['n3_testimonial_limit'][0]) ? $get_categoty_meta['n3_testimonial_limit'][0] : 10;
                            $meta_arrows = isset($get_categoty_meta['n3_testimonial_arrows'][0]) ? $get_categoty_meta['n3_testimonial_arrows'][0] : 'false';
                            $meta_dots = isset($get_categoty_meta['n3_testimonial_dots'][0]) ? $get_categoty_meta['n3_testimonial_dots'][0] : 'false';
                            $meta_autoheight = isset($get_categoty_meta['n3_testimonial_autoheight'][0]) ? $get_categoty_meta['n3_testimonial_autoheight'][0] : 'false';
                            $meta_layout = isset($get_categoty_meta['n3_testimonial_layout'][0]) ? $get_categoty_meta['n3_testimonial_layout'][0] : 'default';
                        ?>
                <tr>
                    <td>
                        <p><strong><a href="<?php echo admin_url('edit.php?post_type=n3_testimonials&n3_testimonial_categories='.$category_slug); ?>"><?php echo $category_name; ?></a></strong>
                        </p>
                        <p>Total: <?php echo $testimonial_category->count; ?></p>
                    </td>
                    <td>
                        <?php
                        $args = array(
                            'post_type' => 'n3_testimonials',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'n3_testimonial_categories',
                                    'field' => 'term_id',
                                    'terms' => $category_id
                                )
                            )
                        );

                        $query = new WP_Query($args);

						(new MADE_LabCore_Core_TESTIMONIAL)->___madelab_testimonials_generate($query, $category_id, $meta_layout, $meta_speed, $meta_limit, $meta_autoplay, $meta_infinite, $meta_arrows, $meta_dots, $meta_autoheight);
                        ?>
                    </td>
                    <td>
                        <div class="mb-3">
                            <label for="shortcode-<?php echo $category_id; ?>">Shortcode</label>
                            <input type="text" class="sm" id="shortcode-<?php echo $category_id; ?>" name="shortcode"
                                value='[n3_testimonial id="<?php echo $category_id; ?>" layout="<?php echo $meta_layout; ?>" limit="<?php echo $meta_limit; ?>" speed="<?php echo $meta_speed; ?>" autoplay="<?php echo $meta_autoplay; ?>" infinite="<?php echo $meta_infinite; ?>" arrows="<?php echo $meta_arrows; ?>" dots="<?php echo $meta_dots; ?>" autoheight="<?php echo $meta_autoheight; ?>"]'
                                readonly='readonly' style="width:100%" />

                        </div>
                        <form method="post"
                            action="<?php echo admin_url('edit.php?post_type=n3_testimonials&page=n3_testimonials_settings'); ?>">
                            <?php wp_nonce_field( 'n3_testimonials_nonce', 'n3_testimonials_nonce' ); ?>
                            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>" />
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label for="speed-<?php echo $category_id; ?>">
                                            Speed
                                        </label>
                                        <input type="number" name="speed" id="speed-<?php echo $category_id; ?>" class="w-100"
                                            value="<?php echo $meta_speed; ?>" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label for="limit-<?php echo $category_id; ?>">
                                            Slides to show
                                        </label>
                                        <input type="number" name="limit" id="limit-<?php echo $category_id; ?>" class="w-100"
                                            value="<?php echo $meta_limit; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <select name="layout" id="layout-<?php echo $category_id; ?>">
                                            <option value="default" <?php echo $meta_layout == 'default' ? 'selected' : ''; ?>>
                                                Default
                                            </option>
                                            <option value="modern" <?php echo $meta_layout == 'modern' ? 'selected' : ''; ?>>
                                                Modern
                                            </option>
                                            <option value="azure" <?php echo $meta_layout == 'azure' ? 'selected' : ''; ?>>
                                                Azure
                                            </option>
                                            <option value="minimal" <?php echo $meta_layout == 'minimal' ? 'selected' : ''; ?>>
                                                Minimal
                                            </option>
                                            <option value="quote" <?php echo $meta_layout == 'quote' ? 'selected' : ''; ?>>
                                                Quote
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="autoplay-<?php echo $category_id; ?>">
                                        <input type="checkbox" name="autoplay" id="autoplay-<?php echo $category_id; ?>"
                                            value="true" <?php echo ($meta_autoplay == 'true') ? 'checked' : ''; ?> />
                                        Autoplay
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label for="infinite-<?php echo $category_id; ?>">
                                        <input type="checkbox" name="infinite" id="infinite-<?php echo $category_id; ?>"
                                            value="true" <?php echo ($meta_infinite == 'true') ? 'checked' : ''; ?> />
                                        Infinite
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label for="arrows-<?php echo $category_id; ?>">
                                        <input type="checkbox" name="arrows" id="arrows-<?php echo $category_id; ?>"
                                            value="true" <?php echo ($meta_arrows == 'true') ? 'checked' : ''; ?> />
                                        Arrows
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label for="dots-<?php echo $category_id; ?>">
                                        <input type="checkbox" name="dots" id="dots-<?php echo $category_id; ?>"
                                            value="true" <?php echo ($meta_dots == 'true') ? 'checked' : ''; ?> />
                                        Dots
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label for="autoheight-<?php echo $category_id; ?>">
                                        <input type="checkbox" name="autoheight" id="autoheight-<?php echo $category_id; ?>"
                                            value="true" <?php echo ($meta_autoheight == 'true') ? 'checked' : ''; ?> />
                                        Autoheight
                                    </label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                                <input type="submit" name="submit" id="submit" class="button button-primary" value="Update">
                            </div>
                        </form>
                    </td>
                    
                </tr>

                <?php
                        }
                    } else {
                        ?>
                <tr>
                    <td colspan="3">No categories found.</td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>