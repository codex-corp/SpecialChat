<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

define("SITE_DIR","http://127.0.0.1/chat");

define("CHAT_TITLE","Special Chat");

define ( 'IN_SCRIPT', 1 );

define("ROOT_LOGS_PATH","./loggers/");

## Site internal path
//define("SITE_PATH", $_SERVER["DOCUMENT_ROOT"]."/chat");

## check guest aloww to login
define("GUEST_ACCOUNT",true);

define("from_level", 1);

define("to_level", 20);

define("MESSAGE_EXPIRED_AFTER", 60*60*24*24);

define("DELETE_OFFLINE_GUEST", 60*10);

define("DELETE_IDEL_MEMBER", 60*60*1);

// show message quit after 2 min for the level
define("QUIT_MSG", 120);

define("MAX_MSG_ON_ENETER", 16);

// timer limits for members level => hours
  $autoup = array(FALSE ,'1' => '4', '2' => '40', '3' => '80', '4' => '90', '5' => '1',
                         '6' => '3', '7' => '120', '8' => '125', '9' => '130','10' => '140',
				         '11' => '145', '12' => '150', '13' => '200', '14' => '225', '15' => '250',
						 '16' => '300', '17' => '325', '18' => '350', '19' => '400', '20' => '500');

function __autoload($class_name)
{
    //class directories
    $directorys = array(SITE_PATH.'/includes/', SITE_PATH.'/admin/', SITE_PATH.'/includes/SQL/', SITE_PATH.'/includes/COMMANDS/');
    //for each directory
    foreach ($directorys as $directory)
    {
        //see if the file exsists
        if (file_exists($directory . $class_name . '.php'))
        {
            require_once ($directory . $class_name . '.php');
            return;
        }
    }
}


?>