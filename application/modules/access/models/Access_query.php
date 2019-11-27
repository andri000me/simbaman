<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access_query extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function getLoginData($usr,$psw)
    {
        $username = $usr;
        $password = md5($psw);
        
        $data = $this->listdataWhere($username,$password);
        if(count($data->result())>0){
            foreach($data->result() as $t){
                $sess_data['logged_in'] = 'lbelmabcaky1u2n3g4';
                $sess_data['idpengguna'] = $t->idpengguna;
                $sess_data['username'] = $t->username;
                $sess_data['namalengkap'] = $t->namalengkap;
                $sess_data['idpeserta'] = $t->idpeserta;
                $sess_data['idgrup'] = $t->idgrup;
                
                $usrm = $t->username;
		$pswd = $t->password;
                
                if ($username != $usrm) {
		    return 101;
		} else if ($password != $pswd) {
		    return 102;
		} else {
                    $this->session->set_userdata($sess_data);
                    return 109;
                }
            }
        } else {
	    return 103;
	}
    }
    
    function listdataWhere($username,$password)
    {                
        $this->db->select('idpengguna, username, password, namalengkap, kelamin, foto, idpeserta, idgrup, publish');
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('publish', 1);
        $query = $this->db->get('tpengguna');
        return $query;
    }
    
    function getHakAkses($idgrup,$url)
    {
        $this->db->select('thakakses.idgrup, tmodul.linkmodul');
        $this->db->from('thakakses');
        $this->db->join('tmodul', 'thakakses.idmodul = tmodul.idmodul');
        $this->db->where('thakakses.idgrup', $idgrup);
        $this->db->where('tmodul.linkmodul', $url);
        $this->db->where('tmodul.publish', 1);
        $this->db->where('thakakses.visited', 1);
        $data = $this->db->get();
        $jml = $data->num_rows();
        return $jml;
    }
    
}