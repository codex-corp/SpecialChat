<?php
/**
 * SPECIAL_DB.php
 *
 * @package SPECIAL CHAT
 * @programmer Hany alsamman ('hany.alsamman@gmail.com')
 * @author Hany alsamman (Project administrator && Original founder)
 * @version $Id$
 * @pattern private
 * @access private
 */

class SPECIAL_DB
{

    private static $_singleton;
    private $_connection;
    protected $HOST = 'localhost';
    protected $USER_NAME = 'root'; //DB user
    protected $USER_PASSWORD = ''; //DB password
    protected $DB_NAME = 'chat'; //DB selected

    private function __construct()
    {
        $this->_connection = mysql_connect($this->HOST, $this->USER_NAME, $this->USER_PASSWORD) or die("Sorry, Cannot perform database!");
        mysql_select_db($this->DB_NAME, $this->_connection) or die("Sorry, Cannot open database!");
//		$status = explode('  ', mysql_stat($this->_connection));
//		print_r($status);
        register_shutdown_function(array(&$this, 'close'));
    }

    public static function getInstance()
    {
        if (is_null(self::$_singleton)) {
            $class = __class__;
            self::$_singleton = new $class;
        }

        return self::$_singleton;
    }

    public function close()
    {
        mysql_close($this->_connection);
    }

    public function __clone()
    {
        trigger_error('It is impossible to clone singleton', E_USER_ERROR);
    }
    
}
?>
