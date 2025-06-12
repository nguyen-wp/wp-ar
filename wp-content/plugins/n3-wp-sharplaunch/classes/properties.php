<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<div class="wrap settingfp">
    <div id="wp-content-editor-tools" class="wp-heading">
        <h1 style="padding: 0">
            <?php echo esc_html( get_admin_page_title() ); ?>
        </h1>
        <div class="clear"></div>
        <hr>
    </div>
    <div class="form-wrap">

        <table class="wp-list-table widefat fixed striped table-view-list pages">
            <thead>
                <tr>
                    <th scope="col" id="id" class="manage-column column-id column-primary" style="width: 80px;">ID</th>
                    <th scope="col" id="name" class="manage-column column-name">Name</th>
                    <th scope="col" id="domain" class="manage-column column-domain">Domain</th>
                    <th scope="col" id="status" class="manage-column column-status">Status</th>
                    <th scope="col" id="archived" class="manage-column column-archived">Archived</th>
                    <th scope="col" id="external_url" class="manage-column column-external_url">External URL</th>
                    <th scope="col" id="ready" class="manage-column column-external_url" style="width: 60px;">Ready</th>
                    <th scope="col" id="cms" class="manage-column column-external_url" style="width: 80px;">CMS</th>
                </tr>
            </thead>
            <tbody id="the-list">
        <?php
        $sharplaunch = new GPC_Core_SHARPLAUNCH();
        $lists = $sharplaunch->SL_GetProperties();
        foreach ($lists as $list) {
            // Find post by meta 
            $find_post_by_meta = get_posts(array(
                'post_type' => 'n3_properties',
                'meta_key' => 'sharplaunch',
                'meta_value' => $list->id,
            ));
            $search_post_by_meta = $find_post_by_meta ? $find_post_by_meta[0]->ID : false;
            ?>
            <tr class="hentry">
                <td>
                    <?php echo $list->id; ?>
                </td>
                <td>
                    <?php echo $list->name; ?>
                </td>
                <td>
                    <?php echo $list->domain; ?>
                </td>
                <td>
                    <?php echo $list->status ? 'Active' : '<span style="color: red;">Inactive</span>'; ?>
                </td>
                <td>
                    <?php echo $list->archived ? 'Yes' : ''; ?>
                </td>
                <td>
                    <?php echo $list->external_url; ?>
                </td>
                <td>
                    <?php echo $search_post_by_meta ? '<a href="post.php?post=' . $search_post_by_meta . '&action=edit" class="button button-primary">Edit</a>' : '<a href="admin.php?page=n3_sharplaunchs_properties_view&id=' . $list->id . '" class="button button-primary">Create</a>'; ?>
                </td>
                <td>
                    <a href="https://admin.sharplaunch.com/#/<?php echo $list->id; ?>/cms/sections/building/" class="button button-primary" target="_blank">Go App</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>


    </div>

</div>