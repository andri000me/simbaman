<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class prediksipengajuan_query extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    public function get_prediksibahan($tglprediksi,$harix)
    {
        $sql = "SELECT namabahan, rata_kuantitasreal*$harix AS rata_kuantitasreal
                    , satuan, hargasatuansupplier
                    , rata_totalreal*$harix AS rata_totalreal
                FROM (SELECT namabahan, avg(jumlahkuantitasreal) as rata_kuantitasreal
                            , satuan, hargasatuansupplier
                            , avg(hargatotalreal) as rata_totalreal
                        from pengajuanbahan
                        where tanggalpengajuan >= '$tglprediksi'
                        group by namabahan, satuan, hargasatuansupplier) AS a";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

}