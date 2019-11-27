<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Sistemlog_query extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function listData()
    {
        $this->db->select('log_id, log_type, id, log_location, log_msg, log_date');
        $this->db->order_by('log_id', 'DESC');
        $query = $this->db->get('system_log');
        return $query->result_array();
    }
    
    function log_aktifitas($d)
    {
        $type = $d['type'];
        $username = $d['username'];
        $url = $d['url'];
        $msg = $d['msg'];
//        $date = date("Y-m-d H:i:s");
        
//        $data = array(
//            'log_type' => $type ,
//            'id' => $username ,
//            'log_location' => $url,
//            'log_msg' => $msg,
//            'log_date' => 'NOW()'
//        );
//
//        $this->db->insert('system_log', $data);
        
        $sql = "INSERT INTO system_log
                    (log_type,id,log_location,log_msg,log_date)
                VALUES ('$type','$username','$url','$msg',NOW());";
        $this->db->query($sql);
    }
    
}