<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_query extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    public function get_datepasien()
    {
        $sql = "SELECT a.tanggalrekap
                FROM rekapjumlahpasien AS a
                GROUP BY a.tanggalrekap
                ORDER BY a.tanggalrekap DESC";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_pasien($tgl_sekarang)
    {
        $sql = "SELECT a.idkelas, a.namakelas, SUM(a.jumlahpasien) AS jumlah, a.tanggalrekap
                FROM rekapjumlahpasien AS a
                WHERE a.tanggalrekap = '$tgl_sekarang'
                GROUP BY a.idkelas, a.namakelas, a.tanggalrekap
                ORDER BY a.namakelas";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_detailpasien($idkelas,$tanggalrekap)
    {
        $sql = "SELECT a.idruang, b.koderuang, a.namaruang
                    , a.idbangsal, c.kodebangsal, a.namabangsal
                    , a.idkelas, a.namakelas, a.jumlahpasien, a.tanggalrekap
                FROM rekapjumlahpasien AS a
                    INNER JOIN ruang AS b ON a.idruang = b.idruang
                    INNER JOIN bangsal AS c ON a.idbangsal = c.idbangsal
                WHERE a.tanggalrekap = '$tanggalrekap'
                    AND a.idkelas = '$idkelas'
                    AND a.jumlahpasien <> 0
                ORDER BY b.koderuang ASC, c.kodebangsal ASC";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }
}