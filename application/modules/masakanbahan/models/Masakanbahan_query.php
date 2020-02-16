<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-26 06:49:36
 * @modify date 2019-09-26 06:49:36
 * @desc [description]
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Masakanbahan_query extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }

    public function list_satuan()
    {
        $sql = "SELECT satuan FROM bahan GROUP BY satuan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function list_jenismasakan()
    {
        $sql = "SELECT namajenismasakan FROM jenismasakan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listDataMasakan()
    {
        $sql = "SELECT a.idmasakan, a.namamasakan, a.stat, COUNT(idmasakanbahan) AS jml
                FROM masakan AS a
                LEFT JOIN masakanbahan AS b ON a.idmasakan = b.idmasakan
                GROUP BY a.idmasakan, a.namamasakan, a.stat
                ORDER BY a.namamasakan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listDataMasakanBahan()
    {
        $sql = "SELECT a.idmasakan, b.idbahan, c.namabahan, c.satuan, c.jenis, b.kuantitas, b.stat, b.idmasakanbahan
                FROM masakan AS a
                LEFT JOIN masakanbahan AS b ON a.idmasakan = b.idmasakan
                INNER JOIN bahan AS c ON b.idbahan = c.idbahan
                ORDER BY b.namabahan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listDataBahan()
    {
        $sql = "SELECT a.idbahan, a.namabahan, a.satuan, a.jenis, a.stat, b.jml
                FROM bahan AS a
                LEFT OUTER JOIN (SELECT idbahan, COUNT(idmasakanbahan) AS jml
                FROM masakanbahan
                GROUP by idbahan) AS b ON a.idbahan = b.idbahan
                ORDER BY a.namabahan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listdataMasakanWhere($idmasakan)
    {
        $sql = "SELECT idmasakan, namamasakan
                FROM masakan
                WHERE idmasakan = '$idmasakan';";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function id()
    {
        $sql = "SELECT UUID() AS id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]['id'];
    }

    public function cek_namamasakan($namamasakan) 
    {
        $sql = "SELECT namamasakan
                FROM masakan
                WHERE namamasakan = '$namamasakan';";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function ExecData_masakan($data)
    {
        $idmasakan = $data['idmasakan'];
        $namamasakan = $data['namamasakan'];
        $stat = $data['stat'];
        
        $q = $this->listdataMasakanWhere($idmasakan);
        foreach ($q as $t){
            $nama_his = $t['namamasakan'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        if ($stat == 'delete') {
            $this->db->where('idmasakan', $idmasakan);
            $res = $this->db->delete('masakan');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$nama_his.', IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idmasakan == '') {

                $id = $this->id();

                $sql = "INSERT INTO masakan
                    (idmasakan,namamasakan,tanggalinsert,stat)
                    VALUES ('$id','$namamasakan',NOW(),'aktif');";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namamasakan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    echo $id;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE masakan
                        SET namamasakan = '$namamasakan'
                            , tanggalinsert = NOW()
                        WHERE idmasakan = '$idmasakan';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namamasakan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    public function masakanbahan($idmasakan)
    {
        $sql = "SELECT a.idmasakanbahan, a.idmasakan, a.idbahan, a.kuantitas, a.satuan
                        , b.namamasakan
                        , c.namabahan, c.jenis
                FROM masakanbahan AS a
                    INNER JOIN masakan AS b ON a.idmasakan = b.idmasakan
                    INNER JOIN bahan AS c ON a.idbahan = c.idbahan
                WHERE a.idmasakan = '$idmasakan'
                ORDER BY c.namabahan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function bahan()
    {
        $sql = "SELECT idbahan, namabahan, satuan, jenis
                FROM bahan ORDER BY namabahan";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function listdataBahanWhere($idbahan)
    {
        $sql = "SELECT idbahan, namabahan, satuan, jenis
                FROM bahan
                WHERE idbahan = '$idbahan';";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function ExecData_masakanbahan($data)
    {
        $idmasakanbahan = $data['idmasakanbahan'];
        $idmasakan = $data['idmasakan'];
        $idbahan = $data['idbahan'];
        $kuantitas = $data['kuantitas'];
        $satuan = $data['satuan'];
        $stat = $data['stat'];

        $q = $this->listdataMasakanWhere($idmasakan);
        foreach ($q as $t){
            $namamasakan = $t['namamasakan'];
        }

        $r = $this->listdataBahanWhere($idbahan);
        foreach ($r as $t){
            $namabahan = $t['namabahan'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        if ($stat == 'delete') {
            $this->db->where('idmasakanbahan', $idmasakanbahan);
            $res = $this->db->delete('masakanbahan');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$namamasakan.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idmasakanbahan == '') {

                $sql = "INSERT INTO masakanbahan
                    (idmasakanbahan,idmasakan,namamasakan,idbahan,namabahan,kuantitas,satuan,tanggalinsert,stat)
                    VALUES (UUID(),'$idmasakan','$namamasakan','$idbahan','$namabahan',$kuantitas,'$satuan',NOW(),'aktif');";

                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namamasakan.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE masakanbahan
                        SET idmasakan = '$idmasakan'
                            ,namamasakan = '$namamasakan'
                            ,idbahan = '$idbahan'
                            ,namabahan = '$namabahan'
                            ,kuantitas = $kuantitas
                            ,satuan = '$satuan'
                            ,tanggalinsert = NOW()
                        WHERE idmasakanbahan = '$idmasakanbahan';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namamasakan.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    public function listdataMasakanBahanWhere($idmasakanbahan)
    {
        $sql = "SELECT a.idmasakanbahan, a.idmasakan, a.idbahan, a.kuantitas, a.satuan
                        , b.namamasakan
                        , c.namabahan, c.jenis
                FROM masakanbahan AS a
                    INNER JOIN masakan AS b ON a.idmasakan = b.idmasakan
                    INNER JOIN bahan AS c ON a.idbahan = c.idbahan
                WHERE a.idmasakanbahan = '$idmasakanbahan'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function ExecData_bahan($data)
    {
        $idbahan = $data['idbahan'];
        $namabahan = $data['namabahan'];
        $satuan = $data['satuan'];
        $jenis = $data['jenis'];
        $stat = $data['stat'];
        
        $q = $this->listdataBahanWhere($idbahan);
        foreach ($q as $t){
            $nama_his = $t['namabahan'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        if ($stat == 'delete') {
            $this->db->where('idbahan', $idbahan);
            $res = $this->db->delete('bahan');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$nama_his.', IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idbahan == '') {

                $sql = "INSERT INTO bahan
                    (idbahan,namabahan,satuan,jenis,tanggalinsert,stat)
                    VALUES (UUID(),'$namabahan','$satuan','$jenis',NOW(),'aktif');";
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
                        SET namabahan = '$namabahan'
                            , satuan = '$satuan'
                            , jenis = '$jenis'
                            , tanggalinsert = NOW()
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

}