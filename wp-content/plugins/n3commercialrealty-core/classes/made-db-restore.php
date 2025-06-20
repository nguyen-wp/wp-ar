<?php 
/**
 * This file contains the Restore_Database class wich performs
 * a partial or complete restoration of any given MySQL database
 * @author Daniel López Azaña <daniloaz@gmail.com>
 * @version 1.0
 */

/**
 * Define database parameters here
 */
// define("DB_USER", 'your_username');
// define("DB_PASSWORD", 'your_password');
// define("DB_NAME", 'your_db_name');
// define("DB_HOST", 'localhost');
// define("BACKUP_DIR", 'myphp-backup-files'); // Comment this line to use same script's directory ('.')
// define("BACKUP_FILE", 'myphp-backup-your_db_name-20181022_164459.sql.gz'); // Script will autodetect if backup file is gzipped based on .gz extension
// define("CHARSET", 'utf8');
// define("DISABLE_FOREIGN_KEY_CHECKS", true); // Set to true if you are having foreign key constraint fails

/**
 * The Restore_Database class
 */
class Restore_Database {
    /**
     * Host where the database is located
     */
    var $host;

    /**
     * Username used to connect to database
     */
    var $username;

    /**
     * Password used to connect to database
     */
    var $passwd;

    /**
     * Database to backup
     */
    var $dbName;

    /**
     * Database charset
     */
    var $charset;

    /**
     * Database connection
     */
    var $conn;

    /**
     * Disable foreign key checks
     */
    var $disableForeignKeyChecks;

    /**
     * Constructor initializes database
     */
    function __construct($host, $username, $passwd, $dbName, $folder = null, $file = null, $charset = 'utf8') {

        global $wpdb;
        $get_db_name = $wpdb->dbname;
        $plugin_name = 'general_public_backup';
        $upload_path = wp_upload_dir();

        if(!$folder) {
            // Create Folder 
            $folder = $upload_path  . $plugin_name . '/database';
            // Check Folder Exits 
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
        }

        $this->host                    = $host;
        $this->username                = $username;
        $this->passwd                  = $passwd;
        $this->dbName                  = $dbName;
        $this->charset                 = $charset;
        $this->disableForeignKeyChecks = defined('DISABLE_FOREIGN_KEY_CHECKS') ? DISABLE_FOREIGN_KEY_CHECKS : false;
        $this->conn                    = $this->initializeDatabase();
        $this->backupDir               = $folder ? $folder : '.';
        $this->backupFile              = $file;
    }

    /**
     * Destructor re-enables foreign key checks
     */
    function __destructor() {
        /**
         * Re-enable foreign key checks 
         */
        if ($this->disableForeignKeyChecks === true) {
            mysqli_query($this->conn, 'SET foreign_key_checks = 0');
            mysqli_query($this->conn, 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"');
            mysqli_query($this->conn, 'START TRANSACTION');
            mysqli_query($this->conn, 'SET time_zone = "+00:00"');
        }
    }

    protected function initializeDatabase() {
        try {
            $conn = mysqli_connect($this->host, $this->username, $this->passwd, $this->dbName);
            if (mysqli_connect_errno()) {
                throw new Exception('ERROR connecting database: ' . mysqli_connect_error());
                die();
            }
            if (!mysqli_set_charset($conn, $this->charset)) {
                mysqli_query($conn, 'SET NAMES '.$this->charset);
            }

            /**
             * Disable foreign key checks 
             */
            if ($this->disableForeignKeyChecks === true) {
                mysqli_query($conn, 'SET foreign_key_checks = 0');
            }

            // mysqli_query($conn, "SET SESSION sql_mode = 'NO_ZERO_IN_DATE,NO_ZERO_DATE'");
            mysqli_query($conn, 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO,NO_ZERO_IN_DATE,NO_ZERO_DATE"');
            mysqli_query($conn, 'START TRANSACTION');
            mysqli_query($conn, 'SET time_zone = "+00:00"');


        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }

        return $conn;
    }

    /**
     * Backup the whole database or just some tables
     * Use '*' for whole database or 'table1 table2 table3...'
     * @param string $tables
     */
    public function restoreDb() {
        try {
            $sql = '';
            $multiLineComment = false;

            $backupDir = $this->backupDir;
            $backupFile = $this->backupFile;

            /**
             * Gunzip file if gzipped
             */
            $backupFileIsGzipped = substr($backupFile, -3, 3) == '.gz' ? true : false;
            if ($backupFileIsGzipped) {
                if (!$backupFile = $this->gunzipBackupFile()) {
                    throw new Exception("ERROR: couldn't gunzip backup file " . $backupDir . '/' . $backupFile);
                }
            }

            /**
            * Read backup file line by line
            */
            $handle = fopen($backupDir . '/' . $backupFile, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $line = ltrim(rtrim($line));
                    if (strlen($line) > 1) { // avoid blank lines
                        $lineIsComment = false;
                        if (preg_match('/^\/\*/', $line)) {
                            $multiLineComment = true;
                            $lineIsComment = true;
                        }
                        if ($multiLineComment or preg_match('/^\/\//', $line)) {
                            $lineIsComment = true;
                        }
                        if (!$lineIsComment) {
                            $sql .= $line;
                            if (preg_match('/;$/', $line)) {
                                // execute query
                                if(mysqli_query($this->conn, $sql)) {
                                    if (preg_match('/^CREATE TABLE `([^`]+)`/i', $sql, $tableName)) {
                                        $this->obfPrint("Table succesfully created: `" . $tableName[1] . "`");
                                    }
                                    $sql = '';
                                } else {
                                    throw new Exception("ERROR: SQL execution error: " . mysqli_error($this->conn));
                                }
                            }
                        } else if (preg_match('/\*\/$/', $line)) {
                            $multiLineComment = false;
                        }
                    }
                }
                fclose($handle);
            } else {
                throw new Exception("ERROR: couldn't open backup file " . $backupDir . '/' . $backupFile);
            } 
        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }

        if ($backupFileIsGzipped) {
            unlink($backupDir . '/' . $backupFile);
        }

        return true;
    }

    /*
     * Gunzip backup file
     *
     * @return string New filename (without .gz appended and without backup directory) if success, or false if operation fails
     */
    protected function gunzipBackupFile() {
        // Raising this value may increase performance
        $bufferSize = 4096; // read 4kb at a time
        $error = false;

        $source = $this->backupDir . '/' . $this->backupFile;
        $dest = $this->backupDir . '/' . date("Ymd_His", time()) . '_' . substr($this->backupFile, 0, -3);

        $this->obfPrint('Gunzipping backup file ' . $source . '... ', 1, 1);

        // Remove $dest file if exists
        if (file_exists($dest)) {
            if (!unlink($dest)) {
                return false;
            }
        }
        
        // Open gzipped and destination files in binary mode
        if (!$srcFile = gzopen($this->backupDir . '/' . $this->backupFile, 'rb')) {
            return false;
        }
        if (!$dstFile = fopen($dest, 'wb')) {
            return false;
        }

        while (!gzeof($srcFile)) {
            // Read buffer-size bytes
            // Both fwrite and gzread are binary-safe
            if(!fwrite($dstFile, gzread($srcFile, $bufferSize))) {
                return false;
            }
        }

        fclose($dstFile);
        gzclose($srcFile);

        // Return backup filename excluding backup directory
        return str_replace($this->backupDir . '/', '', $dest);
    }

    /**
     * Prints message forcing output buffer flush
     *
     */
    public function obfPrint ($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1) {
        if (!$msg) {
            return false;
        }

        $msg = date("Y-m-d H:i:s") . ' - ' . $msg;
        $output = '';

        if (php_sapi_name() != "cli") {
            $lineBreak = "<br />";
        } else {
            $lineBreak = "\n";
        }

        if ($lineBreaksBefore > 0) {
            for ($i = 1; $i <= $lineBreaksBefore; $i++) {
                $output .= $lineBreak;
            }                
        }

        $output .= $msg;

        if ($lineBreaksAfter > 0) {
            for ($i = 1; $i <= $lineBreaksAfter; $i++) {
                $output .= $lineBreak;
            }                
        }

        if (php_sapi_name() == "cli") {
            $output .= "\n";
        }

        echo $output;

        if (php_sapi_name() != "cli") {
            ob_flush();
        }

        flush();
    }
}

class RestoreMade {

	const DEBUG = 0;

	/**
	 * The path where the backup file should be saved
	 *
	 * @string
	 * @access private
	 */
	private $path = '';

	/**
	 * The backup type, must be either complete, file or database
	 *
	 * @string
	 * @access private
	 */
	private $type = '';

	/**
	 * The filename of the backup file
	 *
	 * @string
	 * @access private
	 */
	private $archive_filename = '';

	/**
	 * The filename of the database dump
	 *
	 * @string
	 * @access private
	 */
	private $database_dump_filename = '';

	/**
	 * The path to the zip command
	 *
	 * @string
	 * @access private
	 */
	private $zip_command_path;


	/**
	 * The archive method used
	 *
	 * @var string
	 * @access private
	 */
	private $archive_method = '';

	private $link;
	/**
	 * Sets up the default properties
	 *
	 * @access public
	 */
	public function __construct($dbhost,$database,$dbUser ,$dbPass, $path="") {
		// Raise the memory limit and max_execution time
		@ini_set( 'memory_limit', '32M' );
		@set_time_limit( 0 );

		$this->host = $dbhost;
		$this->database = $database;
		$this->user = $dbUser;
		$this->pass = $dbPass ;
		$this->file_path = ($path) ? $path : dirname(__FILE__) ;

	}

	public static function dump($what) {
		if(self::DEBUG == 1)
			echo '<pre>'.print_r($what,1).'</pre>';
	}

	/**
	 * Sets up bd connectio
	 *
	 * @access private
	 */
	private function Connect() {
		if(!$this->link) {
			$this->link = mysqli_connect($this->host, $this->user, $this->pass) or die(mysqli_error());
			mysqli_select_db($this->link, $this->database) or die(mysqli_error());
		}
		return $this->link;
	}

	/************************** SET GET METHOD FOR FILE AND PATH ******************/

	/**
	 * Get the directory backups are saved to
	 *
	 * @access public
	 * @return string
	 */
	private function get_path() {

		if ( empty( $this->path ) )
			$this->set_path( self::conform_dir( $this->file_path ) );

		//  echo $this->path;die;
		return $this->path;

	}

	/**
	 * Set the directory backups are saved to
	 *
	 * @access public
	 * @param string $path
	 * @return null
	 */

	private function set_path( $path ) {

		if ( empty( $path ) || ! is_string( $path ) )
			throw new Exception( 'Invalid backup path <code>' . $path . '</code> must be a non empty (string)' );

		$this->path = self::conform_dir( $path );

	}

	/**
	 * Sanitize a directory path
	 *
	 * @access public
	 * @static
	 * @param string $dir
	 * @param bool $rel. (default: false)
	 * @return string $dir
	 */
	public static function conform_dir( $dir, $recursive = false ) {

		// Assume empty dir is root
		if ( ! $dir )
			$dir = '/';

		// Replace single forward slash (looks like double slash because we have to escape it)
		$dir = str_replace( '\\', '/', $dir );
		$dir = str_replace( '//', '/', $dir );

		// Remove the trailing slash
		if ( $dir !== '/' )
			$dir = self::untrailingslashit( $dir );

		// Carry on until completely normalized
		if ( ! $recursive && self::conform_dir( $dir, true ) != $dir )
			return self::conform_dir( $dir );

		return (string) $dir;

	}

	/**
	 * Get the full filepath to the database dump file.
	 *
	 * @access public
	 * @return string
	 */
	public function get_database_dump_filepath() {

		return $this->trailingslashit( $this->get_path() ) . $this->get_database_dump_filename();

	}

	/**
	 * Get the filename of the database dump file
	 *
	 * @access public
	 * @return string
	 */
	public function get_database_dump_filename() {

		if ( empty( $this->database_dump_filename ) )
			$this->set_database_dump_filename( 'database_' . $this->database . '.sql' );

		return $this->database_dump_filename;

	}

	/**
	 * Set the filename of the database dump file
	 *
	 * @access public
	 * @param string $filename
	 */
	public function set_database_dump_filename( $filename ) {

		if ( empty( $filename ) || ! is_string( $filename ) )
			throw new Exception( 'database dump filename must be a non empty string' );

		if ( pathinfo( $filename, PATHINFO_EXTENSION ) !== 'sql' )
			throw new Exception( 'invalid file extension for database dump filename <code>' . $filename . '</code>' );

		//$this->database_dump_filename = strtolower( sanitize_file_name( remove_accents( $filename ) ) );
		$this->database_dump_filename = strtolower( $this->remove_accents( $filename ) ) ;

	}

	/********************************** END **********************************/


	/******************************** THE CORE ******************************/

	/**
	 * Kick off a backup
	 *
	 * @access public
	 * @return bool
	 */
	public function backup() {


		$link = $this->Connect();

//	    mysqli_set_charset( DB_CHARSET, $this->db );

		// Begin new backup of MySql
		$tables = mysqli_query($link, 'SHOW TABLES' );

		$sql_file  = "# MySQL database backup\n";
		$sql_file .= "#\n";
		$sql_file .= "# Generated: " . date( 'l j. F Y H:i T' ) . "\n";
		$sql_file .= "# Hostname: " . $this->host . "\n";
		$sql_file .= "# Database: " . $this->sql_backquote( $this->database ) . "\n";
		$sql_file .= "# --------------------------------------------------------\n";

		for ( $i = 0; $i < mysqli_num_rows( $tables ); $i++ ) {
			mysqli_data_seek( $tables, $i );
			$f = mysqli_fetch_array( $tables );
			$curr_table = $f[0];
			self::dump($curr_table);
			// Create the SQL statements
			$sql_file .= "# --------------------------------------------------------\n";
			$sql_file .= "# Table: " . $this->sql_backquote( $curr_table ) . "\n";
			$sql_file .= "# --------------------------------------------------------\n";

			$this->make_sql( $sql_file, $curr_table );

		}

		// Read the backup file into string then remove the file
		$finalbackup = file_get_contents($this->database_dump_filename);
		unlink($this->database_dump_filename);
		return $finalbackup;

	}


	//Restore
	public function restore($file = NULL) {

		$link = $this->Connect();
		$file = (empty($file))? $this->get_database_dump_filepath():$file;
		if (file_exists($file))
			$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		else {
			return "File is missing ,Please upload a backup using this form or to " . $this->get_database_dump_filename();
			exit;
		}

		$buffer = '';

		foreach ($lines as $line) {
			// Skipping comments
			if (substr(ltrim($line), 0, 2) == '--' || $line[0]=='#')
				continue;

			// Skip empty lines
			if (($line = trim($line)) == ''){
				continue;
			}
			// Multiline query
			else if($line[strlen($line)-1] !=";"){
				$buffer .= $line;
				continue;
			}
			else
				if ($buffer) {
//						$line = htmlspecialchars_decode($line);
					$line = $buffer . $line;
					// reset the buffer

					$buffer = '';
				}
			// clean it
			//	$line = trim($line,"buffernowdotcom");
			//	$line = substr($line, 0, -1);

			//// here we go
			$result = @mysqli_query($link, $line) or die(mysqli_error($link).$line);
			////

			if (!$result ) {

				$this->msg =  mysqli_error() ;	die;
				return $this->msg;
				break;


			}

		}

		$this->msg ="Sucessfullly restored";


		return $this->msg;
	}

	/**
	 * Reads the Database table in $table and creates
	 * SQL Statements for recreating structure and data
	 * Taken partially from phpMyAdmin and partially from
	 * Alain Wolf, Zurich - Switzerland
	 * Website: http://restkultur.ch/personal/wolf/scripts/db_backup/
	 *
	 * @access private
	 * @param string $sql_file
	 * @param string $table
	 */
	private function make_sql( $sql_file, $table ) {
		$link = $this->Connect();
		// Add SQL statement to drop existing table
		$sql_file .= "\n";
		$sql_file .= "\n";
		$sql_file .= "#\n";
		$sql_file .= "# Delete any existing table " . $this->sql_backquote( $table ) . "\n";
		$sql_file .= "#\n";
		$sql_file .= "\n";
		$sql_file .= "DROP TABLE IF EXISTS " . $this->sql_backquote( $table ) . ";\n";

		/* Table Structure */

		// Comment in SQL-file
		$sql_file .= "\n";
		$sql_file .= "\n";
		$sql_file .= "#\n";
		$sql_file .= "# Table structure of table " . $this->sql_backquote( $table ) . "\n";
		$sql_file .= "#\n";
		$sql_file .= "\n";

		// Get table structure
		$query = 'SHOW CREATE TABLE ' . $this->sql_backquote( $table );

		$result = mysqli_query($link, $query );

		if ( $result ) {

			if ( mysqli_num_rows( $result ) > 0 ) {
				$sql_create_arr = mysqli_fetch_array( $result );
				$sql_file .= $sql_create_arr[1];
			}

			mysqli_free_result( $result );
			$sql_file .= ' ;';

		}


		/* Table Contents */

		// Get table contents
		$query = 'SELECT * FROM ' . $this->sql_backquote( $table );
		$result = mysqli_query($link, $query);

//			self::dump($result);

		if ( $result ) {
			$fields_cnt = mysqli_num_fields( $result );
			$rows_cnt   = mysqli_num_rows( $result );
		}

		// Comment in SQL-file
		$sql_file .= "\n";
		$sql_file .= "\n";
		$sql_file .= "#\n";
		$sql_file .= "# Data contents of table " . $table . " (" . $rows_cnt . " records)\n";
		$sql_file .= "#\n";

		// Checks whether the field is an integer or not
		for ( $j = 0; $j < $fields_cnt; $j++ ) {

			$table_info = mysqli_fetch_field_direct( $result, $j );
			$field_set[$j] = $this->sql_backquote( $table_info->name );
			$type = $table_info->type;

			//if ( $type === 'tinyint' || $type === 'smallint' || $type === 'mediumint' || $type === 'int' || $type === 'bigint'  || $type === 'timestamp')
			# Remove timestamp to avoid error while restore
			if ( $type === 'tinyint' || $type === 'smallint' || $type === 'mediumint' || $type === 'int' || $type === 'bigint')
				$field_num[$j] = true;

			else
				$field_num[$j] = false;

		}

		// Sets the scheme
		$entries = 'INSERT INTO ' . $this->sql_backquote( $table ) . ' VALUES (';
		$search   = array( '\x00', '\x0a', '\x0d', '\x1a' );  //\x08\\x09, not required
		$replace  = array( '\0', '\n', '\r', '\Z' );
		$current_row = 0;
		$batch_write = 0;

		while ( $row = mysqli_fetch_row( $result ) ) {

			$current_row++;

			// build the statement
			for ( $j = 0; $j < $fields_cnt; $j++ ) {

				if ( ! isset($row[$j] ) ) {
					$values[]     = 'NULL';

				} elseif ( $row[$j] === '0' || $row[$j] !== '' ) {

					// a number
					if ( $field_num[$j] )
						$values[] = $row[$j];

					else {
//								str_replace($search, $replace, $this->sql_addslashes($row[$j])
						$value = mysqli_real_escape_string($link, $row[$j]);
						$values[] = "'" . $value . "'";
					}

				} else {
					$values[] = "''";

				}

			}

			$sql_file .= " \n" . $entries . implode( ', ', $values ) . ") ;";

			// write the rows in batches of 100
			if ( $batch_write === 100 ) {
				$batch_write = 0;
				$this->write_sql( $sql_file );
				$sql_file = '';
			}

			$batch_write++;
			self::dump($values);
			unset( $values );

		}

		mysqli_free_result( $result );

		// Create footer/closing comment in SQL-file
		$sql_file .= "\n";
		$sql_file .= "#\n";
		$sql_file .= "# End of data contents of table " . $table . "\n";
		$sql_file .= "# --------------------------------------------------------\n";
		$sql_file .= "\n";
//		self::dump($sql_file);
		$this->write_sql( $sql_file );

	}

	/**
	 * Write the SQL file
	 *
	 * @access private
	 * @param string $sql
	 */
	private function write_sql( $sql ) {

		$sqlname = $this->get_database_dump_filepath();

		self::dump('path='.$sqlname);
		// Actually write the sql file
//	    if ( is_writable( $sqlname ) || ! file_exists( $sqlname ) ) {

		if ( ! $handle = fopen( $sqlname, 'a' ) ) {
			self::dump('did not create file');
			return false;
		}

		self::dump('file opend');
//		$sql = htmlspecialchars($sql);
		self::dump($sql);
		if ( ! fwrite( $handle, $sql ) ) {
			self::dump('file does not writeble');
			return false;
		}


		fclose( $handle );

		return true;

//	    }

	}


	/*********************************** END ********************************/



	/******************* FORMATING FUNCTIONS FOR CLEAN OUTPUT  *************/

	/**
	 * Better addslashes for SQL queries.
	 * Taken from phpMyAdmin.
	 *
	 * @access private
	 * @param string $a_string. (default: '')
	 * @param bool $is_like. (default: false)
	 */
	private function sql_addslashes( $a_string = '', $is_like = false ) {

		if ( $is_like )
			$a_string = str_replace( '\\', '\\\\\\\\', $a_string );

		else
			$a_string = str_replace( '\\', '\\\\', $a_string );

		$a_string = str_replace( '\'', '\\\'', $a_string );

		return $a_string;
	}

	/**
	 * Add backquotes to tables and db-names in SQL queries. Taken from phpMyAdmin.
	 *
	 * @access private
	 * @param mixed $a_name
	 */
	private function sql_backquote( $a_name ) {


		if ( ! empty( $a_name ) && $a_name !== '*' ) {

			if ( is_array( $a_name ) ) {

				$result = array();

				reset( $a_name );

				while ( list( $key, $val ) = each( $a_name ) )
					$result[$key] = '`' . $val . '`';

				return $result;

			} else {

				return '`' . $a_name . '`';

			}

		} else {

			return $a_name;

		}

	}

	private function remove_accents($string) {
		if ( !preg_match('/[\x80-\xff]/', $string) )
			return $string;

		if (seems_utf8($string)) {
			$chars = array(
				// Decompositions for Latin-1 Supplement
				chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
				chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
				chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
				chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
				chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
				chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
				chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
				chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
				chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
				chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
				chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
				chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
				chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
				chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
				chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
				chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
				chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
				chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
				chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
				chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
				chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
				chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
				chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
				chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
				chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
				chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
				chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
				chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
				chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
				chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
				chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
				chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',
				// Decompositions for Latin Extended-A
				chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
				chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
				chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
				chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
				chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
				chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
				chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
				chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
				chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
				chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
				chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
				chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
				chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
				chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
				chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
				chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
				chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
				chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
				chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
				chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
				chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
				chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
				chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
				chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
				chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
				chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
				chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
				chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
				chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
				chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
				chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
				chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
				chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
				chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
				chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
				chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
				chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
				chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
				chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
				chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
				chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
				chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
				chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
				chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
				chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
				chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
				chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
				chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
				chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
				chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
				chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
				chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
				chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
				chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
				chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
				chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
				chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
				chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
				chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
				chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
				chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
				chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
				chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
				chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
				// Decompositions for Latin Extended-B
				chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
				chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
				// Euro Sign
				chr(226).chr(130).chr(172) => 'E',
				// GBP (Pound) Sign
				chr(194).chr(163) => '',
				// Vowels with diacritic (Vietnamese)
				// unmarked
				chr(198).chr(160) => 'O', chr(198).chr(161) => 'o',
				chr(198).chr(175) => 'U', chr(198).chr(176) => 'u',
				// grave accent
				chr(225).chr(186).chr(166) => 'A', chr(225).chr(186).chr(167) => 'a',
				chr(225).chr(186).chr(176) => 'A', chr(225).chr(186).chr(177) => 'a',
				chr(225).chr(187).chr(128) => 'E', chr(225).chr(187).chr(129) => 'e',
				chr(225).chr(187).chr(146) => 'O', chr(225).chr(187).chr(147) => 'o',
				chr(225).chr(187).chr(156) => 'O', chr(225).chr(187).chr(157) => 'o',
				chr(225).chr(187).chr(170) => 'U', chr(225).chr(187).chr(171) => 'u',
				chr(225).chr(187).chr(178) => 'Y', chr(225).chr(187).chr(179) => 'y',
				// hook
				chr(225).chr(186).chr(162) => 'A', chr(225).chr(186).chr(163) => 'a',
				chr(225).chr(186).chr(168) => 'A', chr(225).chr(186).chr(169) => 'a',
				chr(225).chr(186).chr(178) => 'A', chr(225).chr(186).chr(179) => 'a',
				chr(225).chr(186).chr(186) => 'E', chr(225).chr(186).chr(187) => 'e',
				chr(225).chr(187).chr(130) => 'E', chr(225).chr(187).chr(131) => 'e',
				chr(225).chr(187).chr(136) => 'I', chr(225).chr(187).chr(137) => 'i',
				chr(225).chr(187).chr(142) => 'O', chr(225).chr(187).chr(143) => 'o',
				chr(225).chr(187).chr(148) => 'O', chr(225).chr(187).chr(149) => 'o',
				chr(225).chr(187).chr(158) => 'O', chr(225).chr(187).chr(159) => 'o',
				chr(225).chr(187).chr(166) => 'U', chr(225).chr(187).chr(167) => 'u',
				chr(225).chr(187).chr(172) => 'U', chr(225).chr(187).chr(173) => 'u',
				chr(225).chr(187).chr(182) => 'Y', chr(225).chr(187).chr(183) => 'y',
				// tilde
				chr(225).chr(186).chr(170) => 'A', chr(225).chr(186).chr(171) => 'a',
				chr(225).chr(186).chr(180) => 'A', chr(225).chr(186).chr(181) => 'a',
				chr(225).chr(186).chr(188) => 'E', chr(225).chr(186).chr(189) => 'e',
				chr(225).chr(187).chr(132) => 'E', chr(225).chr(187).chr(133) => 'e',
				chr(225).chr(187).chr(150) => 'O', chr(225).chr(187).chr(151) => 'o',
				chr(225).chr(187).chr(160) => 'O', chr(225).chr(187).chr(161) => 'o',
				chr(225).chr(187).chr(174) => 'U', chr(225).chr(187).chr(175) => 'u',
				chr(225).chr(187).chr(184) => 'Y', chr(225).chr(187).chr(185) => 'y',
				// acute accent
				chr(225).chr(186).chr(164) => 'A', chr(225).chr(186).chr(165) => 'a',
				chr(225).chr(186).chr(174) => 'A', chr(225).chr(186).chr(175) => 'a',
				chr(225).chr(186).chr(190) => 'E', chr(225).chr(186).chr(191) => 'e',
				chr(225).chr(187).chr(144) => 'O', chr(225).chr(187).chr(145) => 'o',
				chr(225).chr(187).chr(154) => 'O', chr(225).chr(187).chr(155) => 'o',
				chr(225).chr(187).chr(168) => 'U', chr(225).chr(187).chr(169) => 'u',
				// dot below
				chr(225).chr(186).chr(160) => 'A', chr(225).chr(186).chr(161) => 'a',
				chr(225).chr(186).chr(172) => 'A', chr(225).chr(186).chr(173) => 'a',
				chr(225).chr(186).chr(182) => 'A', chr(225).chr(186).chr(183) => 'a',
				chr(225).chr(186).chr(184) => 'E', chr(225).chr(186).chr(185) => 'e',
				chr(225).chr(187).chr(134) => 'E', chr(225).chr(187).chr(135) => 'e',
				chr(225).chr(187).chr(138) => 'I', chr(225).chr(187).chr(139) => 'i',
				chr(225).chr(187).chr(140) => 'O', chr(225).chr(187).chr(141) => 'o',
				chr(225).chr(187).chr(152) => 'O', chr(225).chr(187).chr(153) => 'o',
				chr(225).chr(187).chr(162) => 'O', chr(225).chr(187).chr(163) => 'o',
				chr(225).chr(187).chr(164) => 'U', chr(225).chr(187).chr(165) => 'u',
				chr(225).chr(187).chr(176) => 'U', chr(225).chr(187).chr(177) => 'u',
				chr(225).chr(187).chr(180) => 'Y', chr(225).chr(187).chr(181) => 'y',
				// Vowels with diacritic (Chinese, Hanyu Pinyin)
				chr(201).chr(145) => 'a',
				// macron
				chr(199).chr(149) => 'U', chr(199).chr(150) => 'u',
				// acute accent
				chr(199).chr(151) => 'U', chr(199).chr(152) => 'u',
				// caron
				chr(199).chr(141) => 'A', chr(199).chr(142) => 'a',
				chr(199).chr(143) => 'I', chr(199).chr(144) => 'i',
				chr(199).chr(145) => 'O', chr(199).chr(146) => 'o',
				chr(199).chr(147) => 'U', chr(199).chr(148) => 'u',
				chr(199).chr(153) => 'U', chr(199).chr(154) => 'u',
				// grave accent
				chr(199).chr(155) => 'U', chr(199).chr(156) => 'u',
			);

			$string = strtr($string, $chars);
		} else {
			// Assume ISO-8859-1 if not UTF-8
			$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
				.chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
				.chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
				.chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
				.chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
				.chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
				.chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
				.chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
				.chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
				.chr(252).chr(253).chr(255);

			$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

			$string = strtr($string, $chars['in'], $chars['out']);
			$double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
			$double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
			$string = str_replace($double_chars['in'], $double_chars['out'], $string);
		}

		return $string;
	}

	private function trailingslashit($string) {
		return $this->untrailingslashit($string) . '/';
	}

	private static function untrailingslashit($string) {
		return rtrim($string, '/');
	}

	/************************************ END *****************************/
}