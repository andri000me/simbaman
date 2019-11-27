<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Menu_query extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }
    
    function listDataMenu()
    {
        $this->db->select('idmenu, namamenu, ikon, keterangan, publish, urutan');
        $this->db->order_by('urutan', 'ASC');
        $query = $this->db->get('tmenu');
        return $query->result_array();
    }
            
    function listDataMenuWhere($id)
    {
        $this->db->select('idmenu, namamenu, ikon, keterangan, publish, urutan');
        $this->db->where('idmenu', $id);
        $query = $this->db->get('tmenu');
        return $query;
    }
    
    function ExecData($data)
    {
        $idmenu = $data['idmenu'];
        $namamenu = $data['namamenu'];
        $ikonmenu = $data['ikonmenu'];
        $keteranganmenu = $data['keteranganmenu']; 
        $urutanmenu = $data['urutanmenu'];
        $pembuatid = $data['pembuatid'];
        $stat = $data['stat'];
        
        $q = $this->listDataMenuWhere($idmenu);
        foreach ($q->result() as $t){
            $nama_his = $t->namamenu;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();

        if ($stat == 'delete') {
            
            $this->db->where('idmenu', $idmenu);
            $res = $this->db->delete('tmenu');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$nama_his.', IP: '.$ip_address.', Browser: '.$user_agent;;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idmenu == '') {

                $sql = "INSERT INTO tmenu
                    (idmenu,urutan,namamenu,ikon,keterangan,tglinsert,tglupdate,pembuatid,publish)
                    VALUES (UUID(),'$urutanmenu','$namamenu','$ikonmenu','$keteranganmenu',NOW(),NULL,'$pembuatid',1);";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namamenu.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE tmenu
                        SET urutan = '$urutanmenu',
                          namamenu = '$namamenu',
                          ikon = '$ikonmenu',
                          keterangan = '$keteranganmenu',
                          tglupdate = NOW(),
                          pembuatid = '$pembuatid'
                        WHERE idmenu = '$idmenu';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namamenu.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }        
    }
    
    function ExecPublish($data)
    {
        $idmenu = $data['idmenu'];
        $pembuatid = $data['pembuatid'];
        $publish = $data['publish'];
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $q = $this->listDataMenuWhere($idmenu);
        foreach ($q->result() as $t){
            $nama_his = $t->namamenu;
        }
        
        $sql = "UPDATE tmenu
                SET tglupdate = NOW(),
                  pembuatid = '$pembuatid',
                  publish = '$publish'
                WHERE idmenu = '$idmenu';";
        $res = $this->db->query($sql);

        if($res) {
            $data['msg'] = 'Publish data: '.$nama_his.' stat : '.$publish.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    //====== Master data modul ===============
    
    function cekDataMenuModul($id)
    {
        $this->db->select('idmodul, idmenu');
        $this->db->from('tmodul');
        $this->db->where('idmenu', $id);
        $query = $this->db->get();
        return $query;
    }

    function listDataModulWhere_Menu($id)
    {
        $this->db->select('tmodul.idmodul, tmodul.idmenu, tmodul.namamodul, tmodul.linkmodul, tmodul.keterangan, tmodul.publish, tmodul.urutan, tmenu.namamenu');
        $this->db->from('tmodul');
        $this->db->join('tmenu', 'tmodul.idmenu = tmenu.idmenu');
        $this->db->where('tmodul.idmenu', $id);
        $this->db->order_by('tmodul.urutan', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function listDataWhere_Modul($id)
    {
        $this->db->select('tmodul.idmodul, tmodul.idmenu, tmodul.namamodul, tmodul.linkmodul, tmodul.keterangan, tmodul.publish, tmodul.urutan, tmenu.namamenu');
        $this->db->from('tmodul');
        $this->db->join('tmenu', 'tmodul.idmenu = tmenu.idmenu');
        $this->db->where('tmodul.idmodul', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function ExecData_Modul($data)
    {
        $idmodul = $data['idmodul'];
        $idmenu = $data['idmenu'];
        $namamodul = $data['namamodul'];
        $linkmodul = $data['linkmodul'];
        $keteranganmodul = $data['keteranganmodul'];
        $urutanmodul = $data['urutanmodul'];
        $pembuatid = $data['pembuatid'];
        $stat = $data['stat'];
        
        $q = $this->listDataWhere_Modul($idmodul);
        foreach ($q as $key => $val){
            $nama_his = $val['namamodul'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        if ($stat == 'delete') {
            $this->db->where('idmodul', $idmodul);
            $res = $this->db->delete('tmodul');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$nama_his.', IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idmodul == '') {

                $sql = "INSERT INTO tmodul
                    (idmodul,idmenu,urutan,namamodul,linkmodul,keterangan,tglinsert,tglupdate,pembuatid,publish)
                    VALUES (UUID(),'$idmenu','$urutanmodul','$namamodul','$linkmodul','$keteranganmodul',NOW(),NULL,'$pembuatid',1);";
                $res = $this->db->query($sql);                
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namamodul.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE tmodul
                        SET idmenu = '$idmenu',
                          urutan = '$urutanmodul',
                          namamodul = '$namamodul',
                          linkmodul = '$linkmodul',
                          keterangan = '$keteranganmodul',
                          tglupdate = NOW(),
                          pembuatid = '$pembuatid'
                        WHERE idmodul = '$idmodul';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namamodul.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }
    
    function ExecPublish_Modul($data)
    {
        $idmodul = $data['idmodul'];
        $pembuatid = $data['pembuatid'];
        $publish = $data['publish'];
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $q = $this->listDataWhere_Modul($idmodul);
        foreach ($q as $key => $val){
            $nama_his = $val['namamodul'];
        }

        $sql = "UPDATE tmodul
                SET tglupdate = NOW(),
                  pembuatid = '$pembuatid',
                  publish = '$publish'
                WHERE idmodul = '$idmodul';";
        $res = $this->db->query($sql);

        if($res) {
            $data['msg'] = 'Publish data: '.$nama_his.' stat : '.$publish.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
}