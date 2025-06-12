<?php
define("TABLES", '*'); // Full backup //define("TABLES", 'table1, table2, table3'); // Partial backup
define('IGNORE_TABLES',array()); // Tables to ignore
define("GZIP_BACKUP_FILE", true); // Set to false if you want plain SQL backup files (not gzipped)
define("DISABLE_FOREIGN_KEY_CHECKS", true); // Set to true if you are having foreign key constraint fails
define("BATCH_SIZE", 1000); // Batch size when selecting rows from database in order to not exhaust system memory
// Path to mysqldump executable
use Thamaraiselvam\MysqlImport\Import;
require plugin_dir_path( __FILE__ ) . 'classes/made-db-restore.php';

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
        ?>

        <!-- Warning box -->
        <div style="margin: 1rem 0; display: block; background: #ffcfcf; border: 1px solid #d28585; padding: 1rem; border-radius: 5px;">
            <h3 style="margin: 0 0 .5rem 0; font-size: 1.2rem; font-weight: 600; color: #8b4545;">Warning</h3>
            <p style="margin: 0; font-size: 1rem; color: #8b4545;">This action will restore your database to the state it was in when you created the backup file. All data currently in the database will be lost.</p>
            <hr style="margin: 1rem 0; border: 1px solid #d28585;">
            <div class="mb-2">
                <label for="">DB Name: <strong><code><?php echo $get_db_name; ?></code></strong></label> 
            </div>
        </div>
        <!-- Warning box -->
        <!-- Begin Form -->
        <?php
        
        // Restore mySQL database by PHP
        if (isset($_POST['restore'])) {

            

            /**
             * Instantiate Restore_Database and perform backup
             */
            // Report all errors
            error_reporting(E_ALL);
            // Set script max execution time
            set_time_limit(900); // 15 minutes

            if (php_sapi_name() != "cli") {
                echo '<div style="font-family: monospace; margin: 1rem 0">';
            }

            // Upload file 
            if(isset($_FILES['backup_file_upload']) && $_FILES['backup_file_upload']['error'] == 0){
                $file = $_FILES['backup_file_upload']['name'];
                $file_loc = $_FILES['backup_file_upload']['tmp_name'];
                $file_size = $_FILES['backup_file_upload']['size'];
                $file_type = $_FILES['backup_file_upload']['type'];
                $folder = $upload_path . $plugin_name . '/database';
                $new_file_name = strtolower($file);
                $final_file = str_replace(' ', '-', $new_file_name);
                if($file_type == "application/x-gzip") {
                    if (move_uploaded_file($file_loc, $folder . '/' . $final_file)) {
                        echo 'File uploaded successfully';
                        // Check Field dump checked 
                        if (isset($_POST['dump'])) {
                            /** Gunzip file if gzipped */
                            if (substr($final_file, -3) == '.gz') {
                                $final_file = substr($final_file, 0, -3);
                                $gz = gzopen($folder . '/' . $final_file . '.gz', 'rb');
                                $fp = fopen($folder . '/' . $final_file, 'w');
                                while (!gzeof($gz)) {
                                    $string = gzread($gz, 4096);
                                    fwrite($fp, $string, strlen($string));
                                }
                                gzclose($gz);
                                fclose($fp);
                            }
                            try {
                                // Drop All Tables 
                                
                                // // Empty all table and trunk 
                                // $wpdb->query('SET FOREIGN_KEY_CHECKS = 0');
                                // $tables = $wpdb->get_results('SHOW TABLES', ARRAY_N);
                                // // Clean up database
                                // foreach ($tables as $table) {
                                //     $wpdb->query('DELETE FROM ' . $table[0]);
                                //     $wpdb->query('TRUNCATE TABLE ' . $table[0]);
                                // }
                                // $wpdb->query('SET FOREIGN_KEY_CHECKS = 1');
                                new Import($folder .'/'. $final_file , DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
                                // Clean up
                                if (file_exists($folder .'/'. $final_file)) {
                                    unlink($folder .'/'. $final_file);
                                }
                            } catch (Exception $e) {
                                echo '<div class="mt-2 alert-dismissible fade show alert alert-danger"><p>Database restore failed.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            }
                        } else {
                            $restoreDatabase = new Restore_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, $folder, $final_file);
                            $result = $restoreDatabase->restoreDb() ? 'OK' : 'Failed';
                            $restoreDatabase->obfPrint("Restoration result: ".$result, 1);
                        }
                        echo '<div class="mt-2 alert-dismissible fade show alert alert-success"><p>Database restored successfully.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    } else {
                        echo '<div class="mt-2 alert-dismissible fade show alert alert-danger"><p>Database restore failed.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    }
                } else {
                    echo '<div class="mt-2 alert-dismissible fade show alert alert-danger"><p>Not a GZIP (.gz) file</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            } else {
                if(isset($_POST['backup_file']) && $_POST['backup_file'] != '') {
                    $backup_file = $_POST['backup_file'];
                    if (isset($_POST['dump'])) {
                        /** Gunzip file if gzipped */
                        if (substr($backup_file, -3) == '.gz') {
                            $backup_file = substr($backup_file, 0, -3);
                            $gz = gzopen($folder . '/' . $backup_file . '.gz', 'rb');
                            $fp = fopen($folder . '/' . $backup_file, 'w');
                            while (!gzeof($gz)) {
                                $string = gzread($gz, 4096);
                                fwrite($fp, $string, strlen($string));
                            }
                            gzclose($gz);
                            fclose($fp);
                        }
                        try {
                            // DROP ALL TABLES
                            $drop_tables = $wpdb->get_results("SHOW TABLES");
                            foreach($drop_tables as $table) {
                                foreach($table as $key => $value) {
                                    $wpdb->query("DROP TABLE IF EXISTS $value");
                                }
                            }
                            $newImport = new RestoreMade(DB_HOST,DB_NAME,DB_USER,DB_PASSWORD);
                            $newImport->restore($folder .'/'. $backup_file);
                            // Clean up
                            if (file_exists($folder .'/'. $backup_file)) {
                                unlink($folder .'/'. $backup_file);
                            }
                        } catch (Exception $e) {
                            echo '<div class="mt-2 alert-dismissible fade show alert alert-danger"><p>Database restore failed.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                    } else {
                        $restoreDatabase = new Restore_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, $folder, $backup_file);
                        $result = $restoreDatabase->restoreDb() ? 'OK' : 'Failed';
                        $restoreDatabase->obfPrint("Restoration result: ".$result, 1);
                    }
                    echo '<div class="mt-2 alert-dismissible fade show alert alert-success"><p>Database restored successfully.</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                } else {
                    echo '<div class="mt-2 alert-dismissible fade show alert alert-danger"><p>Please select a backup file</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }

            if (php_sapi_name() != "cli") {
                echo '</div>';
            }

        }

        ?>
        <form method="post" id="frmrestore" action="" enctype="multipart/form-data">
            <div class="media-frame mode-grid">
                <div class="uploader-inline">
                    <div class="mb-2 p-4 wp-core-ui text-center">
                        <label for="">Upload the Backup File: </label>
                        <div class="py-3">
                            <label class="browser button button-hero" for="backup_file_upload">
                                <span class="upload-text">Upload</span>
                            </label>
                        </div>
                        <div id="display_upload_file"></div>
                        <input type="file" name="backup_file_upload" id="backup_file_upload" class="d-none">
                    </div>
                </div>
            </div>
            <hr>
            <p>Or Select the Backup File: </p>
            <table class="wp-list-table widefat fixed mb-3 striped">
                <thead>
                    <tr>
                        <th width="30"></th>
                        <th>File Name</th>
                        <th>Date</th>
                        <th>File Size</th>
                        <th>File Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $files = scandir($folder);
                    $countFIles = 0;
                    foreach ($files as $file) {
                        if ($file != '.' && $file != '..' && $file != '.DS_Store' && $file != 'index.php') {
                            $countFIles++;
                        ?>
                            <tr>
                                <td><input type="radio" name="backup_file" value="<?php echo $file; ?>" id="backup_file_<?php echo $countFIles; ?>"></td>
                                <td><label for="backup_file_<?php echo $countFIles; ?>"><?php echo $file; ?></label></td>
                                <td><?php echo date("F d Y H:i:s", filemtime($folder . '/' . $file)); ?></td>
                                <td><?php echo size_format(filesize($folder . '/' . $file)); ?></td>
                                <td><?php echo mime_content_type($folder . '/' . $file); ?></td>
                            </tr>
                        <?php
                        }
                    }
                    if ($countFIles == 0) {
                        ?>
                        <tr>
                            <td colspan="5">No Backup File Found</td>
                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
            <label for="dump" class="mb-2"><input type="checkbox" name="dump" id="dump" checked> Use SQL Dump</label>
            <?php if ($conn) {?>
            <button type="submit" name="restore" class="button button-primary">Restore</button>
            <?php } ?>
        </form>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        // Check Form Restore Submit
        $('#frmrestore').submit(function() {
            if ($('#backup_file_upload').val() == '' && $('input[name="backup_file"]:checked').val() == undefined) {
                alert('Please select a backup file');
                return false;
            }
        });
        $('#backup_file_upload').change(function() {
            $('input[name="backup_file"]').prop('checked', false);
            var fileName = $(this).val().split('\\').pop();
            $('#display_upload_file').html('<strong>'+fileName+'</strong>');
        });

    });
</script>