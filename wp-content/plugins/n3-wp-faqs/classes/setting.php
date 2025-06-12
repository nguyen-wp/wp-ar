<?php 
// Submit Data
if (isset($_POST['submit'])) {

    // Secure Form 
    if ( ! isset( $_POST['n3_faqs_nonce'] ) || ! wp_verify_nonce( $_POST['n3_faqs_nonce'], 'n3_faqs_nonce' ) ) {
        return;
    }

    function ___n3_teams_sanitize_text_field($value) {
        $arr = array('[', ']');
        $value = str_replace($arr, array('{{', '}}'), $value);
        return $value;
    }

    // Update Category Meta Data
    $get_meta_layout = isset($_POST['layout']) ? $_POST['layout'] : 'accordion';
    $get_meta_limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 100;
    $get_meta_class = isset($_POST['class']) ? ___n3_teams_sanitize_text_field($_POST['class']) : '';
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
    $get_meta_active_first = isset($_POST['active_first']) ? $_POST['active_first'] : 'no';

    // Update taxonomy n3_faqs_categories
    update_term_meta($category_id, 'n3_faq_limit', $get_meta_limit);
    update_term_meta($category_id, 'n3_faq_layout', $get_meta_layout);
    update_term_meta($category_id, 'n3_faq_class', $get_meta_class);
    update_term_meta($category_id, 'n3_faq_active_first', $get_meta_active_first);

    // Show Success Message
    echo '<div class="updated notice is-dismissible"><p>Updated Successfully</p></div>';
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
    This is the settings page for the FAQ plugin. Here you can see all the categories and their settings.
</p>
<div class="wrap madetable n3_faqs">
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
                    $faq_categories = get_terms( array(
                        'taxonomy' => 'n3_faqs_categories',
                        'hide_empty' => false,
                    ) );
                    if ( ! empty( $faq_categories ) && ! is_wp_error( $faq_categories ) ) {
                        foreach ($faq_categories as $faq_category) {
                            $category_id = $faq_category->term_id;
                            $category_name = $faq_category->name;
                            $category_slug = $faq_category->slug;
                            $get_categoty_meta = get_term_meta($category_id);
                            $meta_layout = isset($get_categoty_meta['n3_faq_layout'][0]) ? $get_categoty_meta['n3_faq_layout'][0] : 'accordion';
                            $meta_limit = isset($get_categoty_meta['n3_faq_limit'][0]) ? $get_categoty_meta['n3_faq_limit'][0] : 100;
                            $meta_class = isset($get_categoty_meta['n3_faq_class'][0]) ? $get_categoty_meta['n3_faq_class'][0] : '';
                            $meta_active_first = isset($get_categoty_meta['n3_faq_active_first'][0]) ? $get_categoty_meta['n3_faq_active_first'][0] : 'no';
                        ?>
                <tr>
                    <td>
                        <p><strong><a href="<?php echo admin_url('edit.php?post_type=n3_faqs&n3_faqs_categories='.$category_slug); ?>"><?php echo $category_name; ?></a></strong>
                        </p>
                        <p>Total: <?php echo $faq_category->count; ?></p>
                    </td>
                    <td>
                        <?php

                        $args = array(
                            'post_type' => 'n3_faqs',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'n3_faqs_categories',
                                    'field' => 'term_id',
                                    'terms' => $category_id,
                                )
                            )
                        );
                        $query = new WP_Query($args);

						(new GPC_Core_FAQ)->___madelab_faqs_generate($query, $meta_layout, $meta_limit, $meta_class, $meta_active_first);
                        ?>
                    </td>
                    <td>
                        <div class="mb-3">
                            <label for="shortcode-<?php echo $category_id; ?>">Shortcode</label>
                            <input type="text" class="sm" id="shortcode-<?php echo $category_id; ?>" name="shortcode"
                                value='[n3_faq_group id="<?php echo $category_id; ?>" layout="<?php echo $meta_layout; ?>" limit="<?php echo $meta_limit; ?>" class="<?php echo $meta_class; ?>" active_first="<?php echo $meta_active_first; ?>"]'
                                readonly='readonly' style="width:100%" />
                        </div>
                        <form method="post"
                            action="<?php echo admin_url('edit.php?post_type=n3_faqs&page=n3_faqs_settings'); ?>">
                            <?php wp_nonce_field( 'n3_faqs_nonce', 'n3_faqs_nonce' ); ?>
                            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>" />
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label >
                                            Layout
                                        </label>
                                        <select name="layout" id="layout-<?php echo $category_id; ?>" class="w-100">
                                            <option value="accordion" <?php echo $meta_layout == 'accordion' ? 'selected' : ''; ?>>
                                            Accordion
                                            </option>
                                            <option value="list" <?php echo $meta_layout == 'list' ? 'selected' : ''; ?>>
                                                List
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="limit-<?php echo $category_id; ?>">
                                            Items to show
                                        </label>
                                        <input type="number" name="limit" id="limit-<?php echo $category_id; ?>" class="w-100"
                                            value="<?php echo $meta_limit; ?>" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="active_first-<?php echo $category_id; ?>">
                                            Active First
                                        </label>
                                        <select name="active_first" id="active_first-<?php echo $category_id; ?>" class="w-100">
                                            <option value="yes" <?php echo $meta_active_first == 'yes' ? 'selected' : ''; ?>>
                                                Yes
                                            </option>
                                            <option value="no" <?php echo $meta_active_first == 'no' ? 'selected' : ''; ?>>
                                                No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-2">
                                        <label for="class-<?php echo $category_id; ?>">
                                            Class
                                        </label>
                                        <input type="text" name="class" id="class-<?php echo $category_id; ?>" class="form-control"
                                            value="<?php echo $meta_class; ?>" />
                                    </div>
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