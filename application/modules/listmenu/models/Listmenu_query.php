<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Listmenu_query extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function listdataWherePengguna($idpengguna)
    {        
        $this->db->select('idpengguna, username, password, namalengkap, kelamin, foto, idpeserta, idgrup, publish, tglinsert');
        $this->db->where('idpengguna', $idpengguna);
        $query = $this->db->get('tpengguna');
        return $query;
    }
    
    function getdataMenuHakAkses($idgrup,$idpengguna)
    {        
        $this->db->select('thakakses.idgrup, tmenu.idmenu, tpengguna.idpengguna, tmenu.namamenu, tmenu.ikon, thakakses.visited, tpengguna.username');
        $this->db->from('thakakses');
        $this->db->join('tmodul', 'thakakses.idmodul = tmodul.idmodul');
        $this->db->join('tmenu', 'tmodul.idmenu = tmenu.idmenu');
        $this->db->join('tpengguna', 'thakakses.idgrup = tpengguna.idgrup');
        $this->db->where('tmenu.publish', 1);
        $this->db->where('tmodul.publish', 1);
        $this->db->where('thakakses.visited', 1);
        $this->db->where('thakakses.idgrup', $idgrup);
        $this->db->where('tpengguna.idpengguna', $idpengguna);
        $this->db->group_by('thakakses.idgrup, tmenu.idmenu, tpengguna.idpengguna, tmenu.namamenu, tmenu.ikon, thakakses.visited, tpengguna.username');
        $this->db->order_by('tmenu.urutan', 'ASC');
        $query = $this->db->get();
        return $query;
    }
            
    function getdataMenuModulHakAkses($idgrup,$idmenu,$idpengguna)
    {        
        $this->db->select('thakakses.idmodul, thakakses.idgrup, tmenu.idmenu, tpengguna.idpengguna, tmenu.namamenu, tmenu.ikon, tmodul.namamodul, tmodul.linkmodul, thakakses.visited, tpengguna.username');
        $this->db->from('thakakses');
        $this->db->join('tmodul', 'thakakses.idmodul = tmodul.idmodul');
        $this->db->join('tmenu', 'tmodul.idmenu = tmenu.idmenu');
        $this->db->join('tpengguna', 'thakakses.idgrup = tpengguna.idgrup');
        $this->db->where('tmenu.publish', 1);
        $this->db->where('tmodul.publish', 1);
        $this->db->where('thakakses.visited', 1);
        $this->db->where('thakakses.idgrup', $idgrup);
        $this->db->where('tmenu.idmenu', $idmenu);
        $this->db->where('tpengguna.idpengguna', $idpengguna);
        $this->db->order_by('tmodul.urutan', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    
    function listNamaModul($url)
    {
        $this->db->select('tmodul.idmodul, tmodul.idmenu, tmodul.namamodul, tmodul.linkmodul, tmodul.keterangan, tmodul.publish, tmodul.urutan, tmenu.namamenu');
        $this->db->from('tmodul');
        $this->db->join('tmenu', 'tmodul.idmenu = tmenu.idmenu');
        $this->db->where('tmodul.linkmodul', $url);
        $query = $this->db->get();
        return $query;
    }
    
    function listAksesModul($idmodul,$idgrup)
    {
        $this->db->select('visited, created, updated, deleted');
        $this->db->where('idmodul', $idmodul);
        $this->db->where('idgrup', $idgrup);
        $this->db->where('visited', 1);
        $query = $this->db->get('thakakses');
        return $query;
    }
    
    function activeMenu($url,$idmenu)
    {
        $this->db->select('tmodul.linkmodul, tmodul.idmenu');
        $this->db->from('tmenu');
        $this->db->join('tmodul', 'tmenu.idmenu = tmodul.idmenu');
        $this->db->where('tmodul.linkmodul', $url);
        $this->db->where('tmodul.idmenu', $idmenu);
        $data = $this->db->get();
        $jml = $data->num_rows();
        return $jml;
    }
}