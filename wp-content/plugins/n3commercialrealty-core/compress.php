<?php
define("GZIP_BACKUP_FILE", true); // Set to false if you want plain SQL backup files (not gzipped)
define("BATCH_SIZE", 10000); // Batch size when selecting rows from database in order to not exhaust system memory
global $wpdb;
$get_db_name = $wpdb->dbname;
$plugin_name = 'general_public_backup';
$upload_path = ABSPATH;
// Create Folder 
$folder = $upload_path . $plugin_name . '/files';
// Check Folder Exits 
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

?>
<style>
.loading {
    --gradient-lavender: #d300c5;
    --gradient-orange: #ff7a00;
    --gradient-pink: #ff0169;
    --gradient-purple: #7638fa;
    --gradient-yellow: #ffd600;
    border-radius: 10px
}

.loading {
    animation: 2s linear infinite RefreshedLoadingBarProgress,
        0.5s ease-out LoadingBarEnter;
    background: linear-gradient(to right,
            var(--gradient-yellow),
            var(--gradient-orange),
            var(--gradient-pink),
            var(--gradient-lavender),
            var(--gradient-purple),
            var(--gradient-yellow));
    background-size: 500%;
    height: 10px;
    transform-origin: left;
    width: 100%;
}

@keyframes RefreshedLoadingBarProgress {
    0% {
        background-position: 125% 0;
    }

    100% {
        background-position: 0% 0;
    }
}

@keyframes LoadingBarEnter {
    0% {
        transform: scaleX(0);
    }

    100% {
        transform: scaleX(1);
    }
}
</style>

<script>
function fullSiteBackup() {
    // Call Ajax
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    jQuery('#fullSiteBackup').hide();
    jQuery('#process_display').html('<div class="loading"> </div>Processing...').show();

    // Call AJAX 

    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'made_core_backup_fullsite',
            nonce: '<?php echo wp_create_nonce('made_core_backup_fullsite_nonce'); ?>',
        },
        success: function(response) {
            jQuery('#process_display').html('Backup successfully created.');
            // Redirect 
            setTimeout(function() {
                window.location.href = "<?php echo admin_url('admin.php?page=madelab-core-compress&status=ok'); ?>";
            }, 1000);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        },
    });
}
</script>


<div class="wrap madetable">
    <div class="form-wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <!-- Begin Form -->
        <?php

        // Backup the db OR Restore the db
        $get_action = isset($_GET['action']) ? $_GET['action'] : '';
        $get_file = isset($_GET['file']) ? $_GET['file'] : '';
        if($get_action == 'delete_backup' && $get_file != ''){
            $file = $folder . '/' . $get_file;
            if (file_exists($file)) {
                unlink($file);
                $url = admin_url('admin.php?page=madelab-core-compress&status=success');
            } else {
                $url = admin_url('admin.php?page=madelab-core-compress&status=error');
            }
            echo '<script>window.location.href = "'.$url.'";</script>';
        }

        if(isset($_GET['status']) && $_GET['status'] == 'success'){
            echo '<div class="alert alert-success alert-dismissible fade show"><p>Backup file deleted successfully.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } else if(isset($_GET['status']) && $_GET['status'] == 'error'){
            echo '<div class="alert alert-danger alert-dismissible fade show"><p>Backup file not found.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } else if(isset($_GET['status']) && $_GET['status'] == 'ok'){
            echo '<div class="alert alert-success alert-dismissible fade show"><p>Backup successfully created.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }

        if (isset($_POST['delete'])) {
            $files_check = isset($_POST['check']) ? $_POST['check'] : null;
            if ($files_check) {
                foreach ($files_check as $file) {
                    $file = $folder . '/' . $file;
                    $filename = basename($file);
                    if (file_exists($file)) {
                        unlink($file);
                        echo '<div class="alert alert-success alert-dismissible fade show"><p>File <strong>' . $filename . '</strong> deleted successfully.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    }
                }
            }
        }
        ?>

        <!-- Warning box -->
        <div
            style="margin: 1rem 0; display: block; background: #ffcfcf; border: 1px solid #d28585; padding: 1rem; border-radius: 5px;">
            <h3 style="margin: 0 0 .5rem 0; font-size: 1.2rem; font-weight: 600; color: #8b4545;">Warning</h3>
            <p style="margin: 0; font-size: 1rem; color: #8b4545;">This action will backup your all files. Please make
                sure you have enough space on your server.</p>
            <hr style="margin: 1rem 0; border: 1px solid #d28585;">
            <div class="mb-2">
                <label for="">Backup Path: <strong><code><?php echo $folder; ?></code></strong></label>
            </div>
            <button type="button" name="backup" class="browser button button-hero" id="fullSiteBackup"
                onclick="fullSiteBackup()">Backup Now</button>
        </div>
        <!-- Warning box -->

        <div id="process_display" style="display:none; font-family: monospace; margin: 1rem 0; max-height: 300px; overflow: auto; background: #f5f5f5; border: 1px solid #e5e5e5; padding: 1rem; border-radius: 5px;">
            <loading />
        </div>

        <h2 class="mt-3 mb-2">Backup List</h2>
        <form action="" method="post" id="backup-list">
            <div class="mb-2">
                <button type="submit" name="delete" class="button button-primary mt-2">Delete Selected</button>
            </div>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" name="checkall" id="checkall" class="m-0"></th>
                        <th>File Name</th>
                        <th>File Size</th>
                        <th>Download</th>
                        <th>Created</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $files = glob($folder . '/*');
                    if($files) {
                        foreach ($files as $file) {
                            $file_name = basename($file);
                            $file_size = size_format(filesize($file));
                            $file_time = date('Y-m-d H:i:s', filemtime($file));
                            echo '<tr>';
                            echo '<td><input type="checkbox" name="check[]" value="' . $file_name . '" id="backup_' . $file_name . '" class="m-0"></td>';
                            echo '<td><label for="backup_' . $file_name . '">' . $file_name . '</label></td>';
                            echo '<td>' . $file_size . '</td>';
                            echo '<td>' . $file_time . '</td>';
                            echo '<td><a href="' . $file . '" download>Download</a></td>';
                            echo '<td><a onclick="return confirm(\'Are you sure you want to delete this file?\')" href="' . admin_url('admin.php?page=madelab-core-compress&action=delete_backup&file=' . $file_name) . '"><i class="fas fa-trash-alt"></i> Delete</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6">No backup file found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit" name="delete" class="button button-primary mt-2">Delete Selected</button>
        </form>
        <script>
        jQuery(document).ready(function($) {
            $('#checkall').click(function() {
                if ($(this).is(':checked')) {
                    $('input[name="check[]"]').prop('checked', true);
                } else {
                    $('input[name="check[]"]').prop('checked', false);
                }
            });
            // Check Backup form submit
            $('#backup-list').submit(function() {
                var checked = $('input[name="check[]"]:checked').length;
                if (checked == 0) {
                    alert('Please select file to delete.');
                    return false;
                }
            });
        });
        </script>
    </div>
</div>