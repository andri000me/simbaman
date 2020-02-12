<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class Bahan_qry extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }
    
    function listDataMenu()
    {
        $this->db->select('idbahan, namabahan, satuan, jenis, tanggalinsert, stat');
        $this->db->order_by('namabahan', 'ASC');
        $query = $this->db->get('bahan');
        return $query->result_array();
    }

    function listDataMenuWhere($id)
    {
        $this->db->select('idbahan, namabahan, satuan, jenis, tanggalinsert, stat');
        $this->db->where('idbahan', $id);
        $query = $this->db->get('bahan');
        return $query;
    }

    function ExecData($data)
    {
        $idbahan = $data['idbahan'];
        $namabahan = $data['namabahan'];
        $satuan = $data['satuan'];
        $jenis = $data['jenis']; 
        $stat = $data['stat'];
        $status = $data['status'];
        
        $q = $this->listDataMenuWhere($idbahan);
        foreach ($q->result() as $t){
            $nama_his = $t->namabahan;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();

        if ($status == 'delete') {
            
            $this->db->where('idbahan', $idbahan);
            $res = $this->db->delete('bahan');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$nama_his.', IP: '.$ip_address.', Browser: '.$user_agent;;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idbahan == '') {

                $sql = "INSERT INTO bahan
                    (idbahan, namabahan, satuan, jenis, tanggalinsert, stat)
                    VALUES (UUID(),'$namabahan','$satuan','$jenis',NOW(),'$stat');";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE bahan
                        SET namabahan = '$namabahan',
                            satuan = '$satuan',
                            jenis = '$jenis',
                          tanggalinsert = NOW(),
                          stat = '$stat'
                        WHERE idbahan = '$idbahan';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }        
    }

    public function cekDataBahan($id)
    {
        $this->db->select('idmasakanbahan, idbahan');
        $this->db->from('masakanbahan');
        $this->db->where('idbahan', $id);
        $query = $this->db->get();
        return $query;
    }
    

}