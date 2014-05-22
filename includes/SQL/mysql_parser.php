<?php

class mysql_parser
{

    var $SPECIAL_CORE;

    public function __construct(&$SPECIAL_CORE)
    {
       // session_start();

        $this->SPECIAL_CORE = &$SPECIAL_CORE;
    }

    function showops()
    {
        $result = mysql_query("select id,nick,registered,last_seen,level,font,nickfont from `users` where `nick` != 'Chat System' and `level` > '0' order by level DESC") or FUNCTIONS::debug(mysql_error(), "mysql_parser", __line__);
        while ($row = mysql_fetch_object($result))
            $out[] = $row;
        return $out;
    }

    /*-------------------------------------------------------------------------*/
    // get operator action's logs (kick, banuser, mkick, unbanip, unbanuser)
    /*-------------------------------------------------------------------------*/

    function get_logs()
    {
        $result = mysql_query("select * from `logs` where `type` = 'kick' OR `type` = 'banuser' OR `type` = 'mkick' OR `type` = 'unbanip'  OR `type` = 'unbanuser'") or FUNCTIONS::debug(mysql_error(), "mysql_parser", __line__);

        while ($row = mysql_fetch_array($result))
            $out[] = $row;

        return $out;
    }

    /*-------------------------------------------------------------------------*/
    // get operator stoped logs (jail, sus, unsus, kill)
    /*-------------------------------------------------------------------------*/


    function get_stoped_logs()
    {
        $result = mysql_query("SELECT * from `logs` where `type` = 'jail' OR `type` = 'sus' OR `type` = 'unsus' OR `type` = 'kill'") or FUNCTIONS::debug(mysql_error(), "mysql_parser", __line__);

        while ($row = mysql_fetch_array($result))
            $out[] = $row;

        return $out;
    }

    function get_apply_logs()
    {
        $result = mysql_query("SELECT * from `logs` where `type` = 'apply'") or FUNCTIONS::debug(mysql_error(), "mysql_parser", __line__);

        while ($row = mysql_fetch_array($result))
            $out[] = $row;

        return $out;
    }

    function get_users_online_list()
    {
        $query_select = "SELECT `O`.`users_id`, `O`.`online`, `O`.`room`, `O`.`action_time`, U.`nick`, U.`id`, U.`last_ip`, U.`level`, U.`comment` FROM `who_is_online` O, `users` U WHERE O.users_id = U.id and O.online = '1' order by who_id asc";

        $result = mysql_query($query_select) or FUNCTIONS::debug(mysql_error(), "mysql_parser",__line__);
        while ($row = mysql_fetch_array($result)) {
            $out[] = $row;
        }
        return $out;
    }

    function get_updologs()
    {
        $result = mysql_query("select * from `logs` where (`type` = 'upgrade') OR (`type` = 'downgrade')") or FUNCTIONS::debug(mysql_error(), "mysql_parser", __line__);

        while ($row = mysql_fetch_array($result))
            $out[] = $row;

        return $out;
    }

    function showsus()
    {
        $result = mysql_query("select * from `actions` where `type` = 'sus'") or FUNCTIONS::debug(mysql_error(), "mysql_parser",
            __line__);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_object($result)) {
                $out[] = $row;
            }
            return $out;
        } else {
            return false;
        }
    }

    function showban()
    {
        $result = mysql_query("select * from `actions` where `type` = 'banuser' or `type` = 'banip'") or FUNCTIONS::debug(mysql_error(),"mysql_parser", __line__);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_object($result)) {
                $out[] = $row;
            }
            return $out;
        } else {
            return false;
        }
    }

    function showbanpc()
    {
        $result = mysql_query("select * from `actions` where `type` = 'banuser' or `type` = 'banip'") or FUNCTIONS::debug(mysql_error(),"mysql_parser", __line__);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_object($result)) {
                $out[] = $row;
            }
            return $out;
        } else {
            return false;
        }
    }

    function delete_ban($ip, $room)
    {
    	
    	$id = $this->SPECIAL_CORE->mysql_actions->check_ban_address($ip);
    	
        //query for get the info the (action) by id
        $q = mysql_query("SELECT * from `actions` where `id` = '{$id}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_parser", __line__);

        if ($row = mysql_fetch_object($q)) {
            $type = $row->type;
            $action_by = $row->action_by;
            $action_on = $row->action_on;
            $banip = $row->banip;
        }

        switch ($type) {

            case "banip":
                $msg = str_replace(array("#ip#", "#sender#", "#sender_original#"), 
								   array($banip,$this->SPECIAL_CORE->mysql_login->get_user_nick(), $action_by), ChFun_un_banned_ip);
                $logs_type = 'unbanip';
            break;

            case "banuser":
                $msg = str_replace(array("#user#", "#sender#", "#sender_original#"), 
								   array($action_on,$this->SPECIAL_CORE->mysql_login->get_user_nick(), $action_by), ChFun_un_banned_nick);
                $logs_type = 'unbanuser';
            break;

        }
        //post the logs on logs table
        $this->SPECIAL_CORE->mysql_public_private->post_logs($msg, $room, $logs_type, false);
		//$this->SPECIAL_CORE->mysql_public_private->post_reason($msg, $room);		
		$this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($msg), ChFun_private_logs_syntex));
        

        mysql_query("delete from `actions` where `id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_parser", __line__);

        if (mysql_affected_rows() == -1) {
            return false;
        } else {
            return true;
        }

    }

    function showdisable()
    {
        $result = mysql_query("select * from `actions` where `type` = 'disable'") or FUNCTIONS::debug(mysql_error(), "mysql_parser",
            __line__);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_object($result)) {
                $out[] = $row;
            }
            return $out;
        } else {
            return false;
        }
    }

    function delete_disable($users_id)
    {
        mysql_query("delete from `actions` where `type` = 'disable' and `users_id` = '{$users_id}'") or FUNCTIONS::debug(mysql_error(), "mysql_parser", __line__);

        mysql_query("update `check` set `disable` = '0' where `users_id` = '{$users_id}'") or FUNCTIONS::debug(mysql_error(), "mysql_parser", __line__);

        if (mysql_affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


}


?>