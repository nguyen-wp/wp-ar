<?php 
// Submit Data
if (isset($_POST['submit'])) {

    // Secure Form 
    if ( ! isset( $_POST['n3_teams_nonce'] ) || ! wp_verify_nonce( $_POST['n3_teams_nonce'], 'n3_teams_nonce' ) ) {
        return;
    }

    function ___n3_teams_sanitize_text_field($value) {
        $arr = array('[', ']');
        $value = str_replace($arr, array('{{', '}}'), $value);
        return $value;
    }

    // Update Category Meta Data
    $get_meta_layout = isset($_POST['layout']) ? $_POST['layout'] : 'grid';
    $get_meta_limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 100;
    $get_meta_class = isset($_POST['class']) ? ___n3_teams_sanitize_text_field($_POST['class']) : '';
    $get_meta_item_class = isset($_POST['item_class']) ? ___n3_teams_sanitize_text_field($_POST['item_class']) : '';
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
    
    // Update taxonomy n3_teams_categories
    update_term_meta($category_id, 'n3_team_limit', $get_meta_limit);
    update_term_meta($category_id, 'n3_team_layout', $get_meta_layout);
    update_term_meta($category_id, 'n3_team_class', $get_meta_class);
    update_term_meta($category_id, 'n3_team_item_class', $get_meta_item_class);

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
This is a list of all the categories you have created. You can use the shortcode to display the teams on your website. You can also customize the settings for each category. Class should be a valid CSS class Eg: <span style="color:#e91e63">grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4</span>
</p>
<div class="wrap madetable n3_teams">
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
                    $team_categories = get_terms( array(
                        'taxonomy' => 'n3_team_categories',
                        'hide_empty' => false,
                    ) );
                    if ( ! empty( $team_categories ) && ! is_wp_error( $team_categories ) ) {
                        foreach ($team_categories as $team_category) {
                            $category_id = $team_category->term_id;
                            $category_name = $team_category->name;
                            $category_slug = $team_category->slug;
                            $get_categoty_meta = get_term_meta($category_id);
                            $meta_layout = isset($get_categoty_meta['n3_team_layout'][0]) ? $get_categoty_meta['n3_team_layout'][0] : 'grid';
                            $meta_class = isset($get_categoty_meta['n3_team_class'][0]) ? $get_categoty_meta['n3_team_class'][0] : '';
                            $meta_item_class = isset($get_categoty_meta['n3_team_item_class'][0]) ? $get_categoty_meta['n3_team_item_class'][0] : 'max-w-3xl mx-auto';
                        ?>
                <tr>
                    <td>
                        <p><strong><a href="<?php echo admin_url('edit.php?post_type=n3_teams&n3_teams_categories='.$category_slug); ?>"><?php echo $category_name; ?></a></strong>
                        </p>
                        <p>Total: <?php echo $team_category->count; ?></p>
                    </td>
                    <td>
                        <?php

                        $args = array(
                            'post_type' => 'n3_teams',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'n3_team_categories',
                                    'field' => 'term_id',
                                    'terms' => $category_id,
                                )
                            )
                        );

                        $query = new WP_Query($args);

						(new GPC_Core_TEAM)->___madelab_teams_generate($query, $meta_layout, $meta_class, $meta_item_class);
                        ?>
                    </td>
                    <td>
                        <div class="mb-3">
                            <label for="shortcode-<?php echo $category_id; ?>">Shortcode</label>
                            <input type="text" class="sm" id="shortcode-<?php echo $category_id; ?>" name="shortcode"
                                value='[n3_team_group id="<?php echo $category_id; ?>" layout="<?php echo $meta_layout; ?>" limit="<?php echo $meta_limit; ?>" class="<?php echo $meta_class; ?>" item_class="<?php echo $meta_item_class; ?>"]'
                                readonly='readonly' style="width:100%" />
                        </div>
                        <form method="post"
                            action="<?php echo admin_url('edit.php?post_type=n3_teams&page=n3_teams_shortcodes'); ?>">
                            <?php wp_nonce_field( 'n3_teams_nonce', 'n3_teams_nonce' ); ?>
                            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>" />
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label >
                                            Layout
                                        </label>
                                        <select name="layout" id="layout-<?php echo $category_id; ?>" class="w-100">
                                            <option value="grid" <?php echo $meta_layout == 'grid' ? 'selected' : ''; ?>>
                                                Grid
                                            </option>
                                            <option value="list" <?php echo $meta_layout == 'list' ? 'selected' : ''; ?>>
                                                List
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label for="limit-<?php echo $category_id; ?>">
                                            Items to show
                                        </label>
                                        <input type="number" name="limit" id="limit-<?php echo $category_id; ?>" class="w-100"
                                            value="<?php echo $meta_limit; ?>" />
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
                                <div class="col-12">
                                    <div class="form-group mb-2">
                                        <label for="item_class-<?php echo $category_id; ?>">
                                            Popup Class
                                        </label>
                                        <input type="text" name="item_class" id="item_class-<?php echo $category_id; ?>" class="form-control"
                                            value="<?php echo $meta_item_class; ?>" />
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