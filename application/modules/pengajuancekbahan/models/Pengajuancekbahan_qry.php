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
                        select 'pengajuan' as stat
                        , z.tanggalpengajuan
                        , sum(z.totalhargatotal) as hargatotal		
                        from (
                            SELECT aa.idpengajuan, aa.tanggalrekap, aa.tanggalpengajuan,
                                    aa.idbahan, aa.idbahansupplier, aa.namabahan, aa.satuan,
                                    aa.hargasatuansupplier, aa.satuansupplier,( aa.jumlahkuantitas - IFNULL(bb.jumlahkuantitas, 0)) AS jumlahkuantitas,
                                    (aa.jumlahkuantitas - IFNULL(bb.jumlahkuantitas, 0)) * aa.hargasatuansupplier AS totalhargatotal,
                                    aa.idpengajuandiet,bb.idsisabahan
                                FROM ( SELECT y.idpengajuan, y.tanggalrekap, y.tanggalpengajuan
                                            , y.idbahan, y.idbahansupplier
                                            , y.namabahan, y.satuan
                                            , y.hargasatuansupplier, y.satuansupplier
                                            , ((y.jumlahkuantitas - IFNULL(x.jmlkuantitaspengurangan, 0)) + IFNULL(x.jmlkuantitaspenambahan, 0)) AS jumlahkuantitas
                                            , ((y.jumlahkuantitas - IFNULL(x.jmlkuantitaspengurangan, 0)) + IFNULL(x.jmlkuantitaspenambahan, 0)) * y.hargasatuansupplier AS totalhargatotal
                                            , x.idpengajuan AS idpengajuandiet
                                        FROM ( SELECT  a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                                            , a.idbahan, a.idbahansupplier
                                            , b.namabahan, SUM(a.jumlahkuantitas) AS jumlahkuantitas, a.satuan
                                            , a.hargasatuansupplier, a.satuansupplier, SUM(a.hargatotal) AS hargatotal
                                        FROM pengajuanbahandetail AS a INNER JOIN 
                                            bahan AS b ON a.idbahan = b.idbahan                                        
                                        GROUP BY a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                                            , a.idbahan, a.idbahansupplier
                                            , b.namabahan, a.satuan
                                            , a.hargasatuansupplier, a.satuansupplier) AS y
                                        LEFT OUTER JOIN (SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan
                                        , SUM(z.jmlkuantitaspengurangan) AS jmlkuantitaspengurangan
                                        , SUM(z.jmlkuantitaspenambahan) AS jmlkuantitaspenambahan
                                        FROM (SELECT a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan, a.jumlahpasien
                                                    , a.idbahan, b.namabahan
                                                    , a.kuantitaspengurangan
                                                    , (a.jumlahpasien * a.kuantitaspengurangan) AS jmlkuantitaspengurangan
                                                    , (a.jumlahpasien * a.kuantitaspenambahan) AS jmlkuantitaspenambahan
                                                FROM pengajuanbahandietdetail AS a
                                                    INNER JOIN bahan AS b ON a.idbahan = b.idbahan) AS z
                                                GROUP BY z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan) AS x ON y.idpengajuan = x.idpengajuan
                                                    AND y.tanggalpengajuan = x.tanggalpengajuan
                                                    AND y.tanggalrekap = x.tanggalrekap
                                                    AND y.idbahan = x.idbahan) AS aa
                        LEFT OUTER JOIN sisabahan AS bb ON aa.idpengajuan = bb.idpengajuan AND aa.idbahan = bb.idbahan ) as z
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
                                where b.kesesuaian <> 'batal'
                                group by b.namabahan, b.tanggalpengajuan) as y
                    group by y.tanggalpengajuan) as bahanmasakan";
        
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

}