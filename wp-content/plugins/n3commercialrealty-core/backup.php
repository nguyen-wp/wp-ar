<?php
define("TABLES", '*'); // Full backup //define("TABLES", 'table1, table2, table3'); // Partial backup
define('IGNORE_TABLES',array()); // Tables to ignore
define("GZIP_BACKUP_FILE", true); // Set to false if you want plain SQL backup files (not gzipped)
define("DISABLE_FOREIGN_KEY_CHECKS", true); // Set to true if you are having foreign key constraint fails
define("BATCH_SIZE", 10000000); // Batch size when selecting rows from database in order to not exhaust system memory
// Path to mysqldump executable
use Ifsnop\Mysqldump as IMysqldump;
// use Ifsnop\Mysqldump as IMysqldump;
require plugin_dir_path( __FILE__ ) . 'classes/made-db-backup.php';

global $wpdb;
$get_db_name = $wpdb->dbname;
$plugin_name = 'general_public_backup';
$upload_path = ABSPATH;
// Create Folder 
$folder = $upload_path . $plugin_name . '/database';
// Check Folder Exits 
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

?>
<div class="wrap madetable">
    <div class="form-wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <!-- Begin Form -->
        <?php


        // Test Connection to Database 
        $conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            echo '<div class="alert alert-danger alert-dismissible fade show"><p>Connection failed: ' . mysqli_connect_error() . '</p>
            <p><strong>DB_HOST:</strong> ' . DB_HOST . '</p>
            <p><strong>DB_USER:</strong> ' . DB_USER . '</p>
            <p><strong>DB_NAME:</strong> ' . DB_NAME . '</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
        
        // Backup the db OR Restore the db
        $get_action = isset($_GET['action']) ? $_GET['action'] : '';
        $get_file = isset($_GET['file']) ? $_GET['file'] : '';
        if($get_action == 'delete_backup' && $get_file != ''){
            $file = $folder . '/' . $get_file;
            if (file_exists($file)) {
                unlink($file);
                $url = admin_url('admin.php?page=madelab-core-backup&status=success');
            } else {
                // Redirect 
                $url = admin_url('admin.php?page=madelab-core-backup&status=error');
            }
            echo '<script>window.location.href = "' . $url . '";</script>';
        }

        if(isset($_GET['status']) && $_GET['status'] == 'success'){
            echo '<div class="alert alert-success alert-dismissible fade show"><p>Backup file deleted successfully.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } else if(isset($_GET['status']) && $_GET['status'] == 'error'){
            echo '<div class="alert alert-danger alert-dismissible fade show"><p>Backup file not found.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }

        // Backup mySQL database by PHP
        if (isset($_POST['backup'])) {
            
            $get_db_name = isset($_POST['db_name']) ? $_POST['db_name'] : null;

            // Check Field dump checked 
            if (isset($_POST['dump'])) {

                if($get_db_name != null){
                    $backup_file = $folder . '/' . $get_db_name . '.sql.gz';
                } else {
                    $backup_file = $folder . '/' . DB_NAME . '-' . date('Y-m-d') . '.sql.gz';
                }

                try {
                    $dump = new IMysqldump\Mysqldump('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, array(
                        // Compress 
                        'compress' => IMysqldump\Mysqldump::GZIP
                    ));
                    $dump->start($backup_file);
                    echo '<div class="alert alert-success alert-dismissible fade show"><p>Backup successfully created.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                } catch (\Exception $e) {
                    echo 'mysqldump-php error: ' . $e->getMessage();
                }

            } else {

                /**
                 * Instantiate Backup_Database and perform backup
                 */
    
                // Report all errors
                error_reporting(E_ALL);
                // Set script max execution time
                set_time_limit(900); // 15 minutes
    
                if (php_sapi_name() != "cli") {
                    echo '<div style="font-family: monospace; margin: 1rem 0">';
                }
    
                
                if($get_db_name != null){
                    $backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_CHARSET, $get_db_name);
                } else {
                    $backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_CHARSET);
                }
    
                // Option-1: Backup tables already defined above
                $result = $backupDatabase->backupTables(TABLES) ? 'OK' : 'Failed';
    
                // Option-2: Backup changed tables only - uncomment block below
                /*
                $since = '1 day';
                $changed = $backupDatabase->getChangedTables($since);
                if(!$changed){
                $backupDatabase->obfPrint('No tables modified since last ' . $since . '! Quitting..', 1);
                die();
                }
                $result = $backupDatabase->backupTables($changed) ? 'OK' : 'Failed';
                */
    
                $backupDatabase->obfPrint('Backup result: ' . $result, 1);
    
                // Use $output variable for further processing, for example to send it by email
                $output = $backupDatabase->getOutput();
    
                if (php_sapi_name() != "cli") {
                    echo '</div>';
                }
    
                echo '<div class="alert alert-success alert-dismissible fade show"><p>Backup successfully created.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

            }

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
        <div style="margin: 1rem 0; display: block; background: #ffcfcf; border: 1px solid #d28585; padding: 1rem; border-radius: 5px;">
            <h3 style="margin: 0 0 .5rem 0; font-size: 1.2rem; font-weight: 600; color: #8b4545;">Warning</h3>
            <p style="margin: 0; font-size: 1rem; color: #8b4545;">This action will backup your database to a file. Please make sure you have enough space on your server to store the backup file.</p>
            <p style="margin: 0; font-size: 1rem; color: #8b4545;">If you want to ignore some table from backup, please add them to the <strong>IGNORE_TABLES</strong> array in <strong>backup.php</strong> file.</p>
            <hr style="margin: 1rem 0; border: 1px solid #d28585;">
            <form method="post" action="">
                <div class="mb-1">
                    <label for="">DB Name: <strong><code><?php echo $get_db_name; ?></code></strong></label> 
                </div>
                <div class="mb-2">
                    <label for="">Backup Path: <strong><code><?php echo $folder; ?></code></strong></label>
                </div>
                <label for="dump" class="mb-2"><input type="checkbox" name="dump" id="dump" checked> Use SQL Dump</label>
                <?php if ($conn) {?>
                <div class="form-group mb-1">
                    <input type="text" name="db_name">
                </div>
                <div class="form-group">
                    <button type="submit" name="backup" class="browser button button-hero">Backup now</button>
                </div>
                <?php } ?>
            </form>
        </div>
        <!-- Warning box -->
        
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
                            $site_url = site_url();
                            $download_url = $site_url .'/'. $plugin_name . '/database/' . $file_name;
                            echo '<tr>';
                            echo '<td><input type="checkbox" name="check[]" value="' . $file_name . '" id="backup_' . $file_name . '" class="m-0"></td>';
                            echo '<td><label for="backup_' . $file_name . '">' . $file_name . '</label></td>';
                            echo '<td>' . $file_size . '</td>';
                            echo '<td><a href="' . $download_url . '" download>Download</a></td>';
                            echo '<td><a onclick="return confirm(\'Are you sure you want to delete this file?\')" href="' . admin_url('admin.php?page=madelab-core-backup&action=delete_backup&file=' . $file_name) . '"><i class="fas fa-trash-alt"></i> Delete</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No backup file found.</td></tr>';
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