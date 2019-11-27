<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-26 20:51:42
 * @modify date 2019-09-26 20:51:42
 * @desc [description]
 */


class Supplier_query extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }

    public function listDataSupplier()
    {
        $sql = "SELECT a.idsupplier, a.namasupplier, a.kontraktanggalawal, a.kontraktanggalakhir, a.stat, COUNT(b.idbahansupplier) AS jml
                FROM supplier AS a
                LEFT OUTER JOIN bahansupplier AS b ON a.idsupplier = b.idsupplier
                GROUP BY a.idsupplier, a.namasupplier, a.kontraktanggalawal, a.kontraktanggalakhir, a.stat";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listdataSupplierWhere($idsupplier) 
    {
        $sql = "SELECT idsupplier, namasupplier, kontraktanggalawal, kontraktanggalakhir, stat
                FROM supplier
                WHERE idsupplier = '$idsupplier'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listDataBahanSupplier($idsupplier)
    {
        $sql = "SELECT a.idbahansupplier, a.idsupplier, a.idbahan, b.namabahan, a.hargasatuan, a.satuan, a.jenis, a.spesifikasi, a.stat, c.jml
                FROM bahansupplier AS a INNER JOIN
                    bahan AS b ON a.idbahan = b.idbahan LEFT OUTER JOIN 
                    (SELECT idbahansupplier, COUNT(idpengajuanbahandetail) AS jml
                    FROM pengajuanbahandetail
                    GROUP BY idbahansupplier) AS c ON a.idbahansupplier = c.idbahansupplier
                WHERE a.idsupplier = '$idsupplier'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function ExecData_supplier($data)
    {
        $idsupplier = $data['idsupplier'];
        $namasupplier = $data['namasupplier'];
        $kontraktanggalawal = $data['kontraktanggalawal'];        
        $kontraktanggalakhir = $data['kontraktanggalakhir'];
        $stat_supplier = $data['stat_supplier'];
        $stat = $data['stat'];
        
        $q = $this->listdataSupplierWhere($idsupplier);
        foreach ($q as $t){
            $nama_his = $t['namasupplier'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        if ($stat == 'delete') {
            $this->db->where('idsupplier', $idsupplier);
            $res = $this->db->delete('supplier');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$nama_his.', IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idsupplier == '') {

                $sql = "INSERT INTO supplier
                    (idsupplier,namasupplier,kontraktanggalawal,kontraktanggalakhir,tanggalinsert,stat)
                    VALUES (UUID(),'$namasupplier','$kontraktanggalawal','$kontraktanggalakhir',NOW(),'aktif');";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namasupplier.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE supplier
                        SET namasupplier = '$namasupplier',
                            kontraktanggalawal = '$kontraktanggalawal',
                            kontraktanggalakhir = '$kontraktanggalakhir',
                            stat = '$stat_supplier',
                            tanggalinsert = NOW()
                        WHERE idsupplier = '$idsupplier';";
                        
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namasupplier.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    public function get_supplierbahan($idsupplier)
    {
        $sql = "SELECT a.idsupplier, a.namasupplier, a.kontraktanggalawal, a.kontraktanggalakhir, a.stat, COUNT(b.idbahansupplier) AS jml
                FROM supplier AS a
                LEFT OUTER JOIN bahansupplier AS b ON a.idsupplier = b.idsupplier
                WHERE a.idsupplier <> '$idsupplier'
                GROUP BY a.idsupplier, a.namasupplier, a.kontraktanggalawal, a.kontraktanggalakhir, a.stat";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function copy_supplier($idsupplier,$idsupplier_copy)
    {
        $insert_select = "INSERT INTO bahansupplier
                (idbahansupplier, idsupplier, namasupplier, idbahan, namabahan, hargasatuan, satuan, jenis, spesifikasi, tanggalinsert, stat)
                SELECT UUID() AS idbahansupplier, c.idsupplier, c.namasupplier, a.idbahan, b.namabahan, a.hargasatuan, a.satuan, a.jenis, a.spesifikasi, NOW() AS tanggalinsert, a.stat
                FROM bahansupplier AS a
                INNER JOIN bahan AS b ON a.idbahan = b.idbahan
                CROSS JOIN (SELECT idsupplier, namasupplier FROM supplier WHERE idsupplier = '$idsupplier') AS c
                WHERE a.idsupplier = '$idsupplier_copy'";

        $query = $this->db->query($insert_select);
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function hapussemua_bahansupplier($idsupplier)
    {
        $this->db->where('idsupplier', $idsupplier);
        $res = $this->db->delete('bahansupplier');

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function listdataBahanSupplierWhere($idbahansupplier)
    {
        $sql = "SELECT idbahansupplier, idsupplier, idbahan, hargasatuan, satuan, jenis, spesifikasi
                FROM bahansupplier
                WHERE idbahansupplier = '$idbahansupplier'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listDataBahan()
    {
        $sql = "SELECT idbahan, namabahan, satuan, jenis
                FROM bahan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listdataBahanWhere($idbahan)
    {
        $sql = "SELECT idbahan, namabahan, satuan, jenis
                FROM bahan WHERE idbahan = '$idbahan'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function ExecData_bahansupplier($data)
    {
        $idbahansupplier = $data['idbahansupplier'];
        $idsupplier = $data['idsupplier'];
        $idbahan = $data['idbahan'];
        $hargasatuan = $data['hargasatuan'];        
        $satuan = $data['satuan'];
        $jenis = $data['jenis'];
        $spesifikasi = $data['spesifikasi'];
        $stat = $data['stat'];
        
        $q = $this->listdataSupplierWhere($idsupplier);
        foreach ($q as $t){
            $namasupplier = $t['namasupplier'];
        }

        $q = $this->listdataBahanWhere($idbahan);
        foreach ($q as $t){
            $namabahan = $t['namabahan'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        if ($stat == 'delete') {
            $this->db->where('idbahansupplier', $idbahansupplier);
            $res = $this->db->delete('bahansupplier');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$namasupplier.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idsupplier == '') {

                $sql = "INSERT INTO bahansupplier
                    (idbahansupplier, idsupplier, namasupplier, idbahan, namabahan, hargasatuan, satuan, jenis, spesifikasi, tanggalinsert,stat)
                    VALUES (UUID(),'$idsupplier','$namasupplier','$idbahan','$namabahan','$hargasatuan','$satuan','$jenis','$spesifikasi',NOW(),'aktif');";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namasupplier.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE bahansupplier
                        SET hargasatuan = '$hargasatuan',
                            satuan = '$satuan',
                            jenis = '$jenis',
                            spesifikasi = '$spesifikasi',
                            tanggalinsert = NOW()
                        WHERE idbahansupplier = '$idbahansupplier';";
                        
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namasupplier.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

}