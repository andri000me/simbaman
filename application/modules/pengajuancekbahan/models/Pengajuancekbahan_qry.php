<?php

class Pengajuancekbahan_qry extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }

    public function get_tanggalkelas()
    {
        $sql = "select stat
                    , tanggalpengajuan
                    , hargatotal
                    , 'false' as allDay
                    , case when stat = 'pengajuan' then '#00a65a'
                                when stat = 'pengecekan' then '#f39c12'
                                else '#f56954' end color
                    from (
                    select z.stat
                        , z.tanggalpengajuan
                        , sum(z.hargatotal) as hargatotal		
                        from (
                                select a.namabahan, a.tanggalpengajuan
                                        , sum(a.jumlahpasien) as jumlahpasien
                                        , sum(a.jumlahkuantitas) as jumlahkuantitas
                                        , a.hargasatuansupplier
                                        , sum(a.hargatotal) as hargatotal
                                        , 'pengajuan' as stat
                                from pengajuanbahandetail as a
                                group by a.namabahan, a.tanggalpengajuan, a.hargasatuansupplier ) as z
                        group by z.tanggalpengajuan
                    union all
                    select y.stat
                        , y.tanggalpengajuan
                        , sum(y.hargatotalreal) as hargatotal
                    from (
                    select b.namabahan, b.tanggalpengajuan
                                        , sum(b.hargatotalreal) as hargatotalreal
                                        , 'pengecekan' as stat
                                from pengajuanbahan as b
                                group by b.namabahan, b.tanggalpengajuan) as y
                    group by y.tanggalpengajuan) as bahanmasakan";
        // $sql = "SELECT a.namakelas, sum(a.jumlahpasien) as jmlpasien
        //         , a.tanggalrekap
        //         , 'false' as allDay
        //         , case when a.namakelas = 'kelas 1' then '#f56954'
        //             when a.namakelas = 'kelas 2' then '#f39c12'
        //             when a.namakelas = 'kelas 3' then '#0073b7' 
        //             when a.namakelas = 'vip' then '#00c0ef'
        //             else '#00a65a' end color
        //     FROM rekapjumlahpasien as a
        //     WHERE a.jumlahpasien <> 0
        //     GROUP BY a.namakelas, a.tanggalrekap
        //     ORDER BY a.tanggalrekap desc, a.namakelas asc";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

}