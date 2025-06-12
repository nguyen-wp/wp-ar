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
                    <th scope="col" id="name" class="manage-column column-name column-primary">Name</th>
                    <th scope="col" id="email" class="manage-column column-email">Email</th>
                    <th scope="col" id="company" class="manage-column column-company">Company</th>
                    <th scope="col" id="title" class="manage-column column-title">Title</th>
                    <th scope="col" id="phone" class="manage-column column-phone">Phone</th>
                </tr>
            </thead>
            <tbody id="the-list">
        <?php
        $sharplaunch = new GPC_Core_SHARPLAUNCH();
        $lists = $sharplaunch->SL_GetMembers();
        foreach ($lists as $list) {
            ?>
            <tr class="hentry">
                <td>
                    <?php echo $list->first_name; ?> <?php echo $list->last_name; ?>
                </td>
                <td>
                    <?php echo $list->email; ?>
                </td>
                <td>
                    <?php echo $list->company; ?>
                </td>
                <td>
                    <?php echo $list->title; ?>
                </td>
                <td>
                    <?php echo $list->phone; ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>


    </div>

</div>