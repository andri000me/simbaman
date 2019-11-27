<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-13 07:24:37
 * @modify date 2019-09-13 07:24:37
 * @desc [description]
 */

class Rekappasien_query extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }

    public function get_tglterakhir($tanggalrekap)
    {
        $sql = "SELECT tanggalrekap
            FROM rekapjumlahpasien
            WHERE tanggalrekap = '$tanggalrekap'
            GROUP BY tanggalrekap
            ORDER BY tanggalrekap DESC LIMIT 1";
        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_grupkelas($tglterakhir)
    {
        $sql = "SELECT namakelas
            FROM rekapjumlahpasien
            WHERE tanggalrekap = '$tglterakhir'
            GROUP BY namakelas, tanggalrekap";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_grupruangan($tglterakhir)
    {
        $sql = "SELECT b.namaruang, b.namabangsal, c.jml, SUM(b.jumlahpasien) AS jumlahpasien
                    FROM rekapjumlahpasien AS b
                    INNER JOIN (SELECT a.namaruang, COUNT(namabangsal) AS jml
                    FROM (SELECT namaruang, namabangsal
                    FROM rekapjumlahpasien
                    WHERE tanggalrekap = '$tglterakhir'
                    GROUP BY namaruang, namabangsal, tanggalrekap) AS a GROUP BY a.namaruang) AS c ON c.namaruang = b.namaruang
                    WHERE b.tanggalrekap = '$tglterakhir'
                    GROUP BY b.namaruang, b.namabangsal, b.tanggalrekap
                    ORDER BY b.namaruang ASC, b.namabangsal ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_jumlahpasien($tglterakhir)
    {
        $sql = "SELECT idrekapjumlahpasien, namabangsal, namakelas, jumlahpasien
                FROM rekapjumlahpasien
                WHERE tanggalrekap = '$tglterakhir'";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_data_jumlahpasien($idjumlahpasien)
    {
        $sql = "SELECT idrekapjumlahpasien, namaruang, namabangsal, namakelas, jumlahpasien, tanggalrekap
                FROM rekapjumlahpasien
                WHERE idrekapjumlahpasien = '$idjumlahpasien'";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function ubahjumlahpasien($idrekapjumlahpasien,$jumlahpasien)
    {
        $ubah = "UPDATE rekapjumlahpasien
                    SET jumlahpasien = $jumlahpasien,
                        tanggalupdate = NOW()
                    WHERE idrekapjumlahpasien = '$idrekapjumlahpasien'";

        $res = $this->db->query($ubah);
        return $res;
    }

    public function default_kelas_kamar()
    {
        $sql = "SELECT a.idruang, b.idbangsal, c.idkelas
                    , a.namaruang, b.namabangsal, c.namakelas
                    FROM ruang AS a
                    INNER JOIN bangsal AS b ON a.idruang = b.idruang
                    CROSS JOIN (SELECT idkelas, namakelas FROM kelas WHERE stat = 'reguler') AS c
                    ORDER BY a.namaruang ASC, b.namabangsal ASC, c.namakelas ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }
    
    public function import_data($sheet)
    {
        $data = array();

        $numrow = 1;
		foreach($sheet as $row){
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'idruang' => $row['A'],
					'idbangsal' => $row['B'], 
					'idkelas' => $row['C'], 
                    'namaruang' => $row['D'], 
                    'namabangsal' => $row['E'],
                    'namakelas' => $row['F'],
                    'jumlahpasien' => $row['G'],
				));
			}
			
			$numrow++;
        }
        
        $this->db->truncate('rekapjumlahpasien_tmp');

        $insert = $this->db->insert_batch('rekapjumlahpasien_tmp', $data);

        if ($insert) {
            return true;
        } else {
            return false;
        }
    }

    public function get_grupkelas_tmp()
    {
        $sql = "SELECT namakelas
            FROM rekapjumlahpasien_tmp
            GROUP BY namakelas, tanggalrekap";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }
    
    public function get_grupruangan_tmp()
    {
        $sql = "SELECT b.namaruang, b.namabangsal, c.jml, SUM(b.jumlahpasien) AS jumlahpasien
                    FROM rekapjumlahpasien_tmp AS b
                    INNER JOIN (SELECT a.namaruang, COUNT(namabangsal) AS jml
                    FROM (SELECT namaruang, namabangsal
                    FROM rekapjumlahpasien_tmp
                    GROUP BY namaruang, namabangsal, tanggalrekap) AS a GROUP BY a.namaruang) AS c ON c.namaruang = b.namaruang
                    GROUP BY b.namaruang, b.namabangsal, b.tanggalrekap
                    ORDER BY b.namaruang ASC, b.namabangsal ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_jumlahpasien_tmp()
    {
        $sql = "SELECT namabangsal, namakelas, jumlahpasien
                FROM rekapjumlahpasien_tmp";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function importdata($tglrekap)
    {
        $insert = "INSERT INTO rekapjumlahpasien
                (idrekapjumlahpasien, idruang, namaruang, idbangsal, namabangsal, idkelas, namakelas, jumlahpasien, tanggalrekap, tanggalupdate)
                SELECT UUID(), d.idruang, d.namaruang
                    , d.idbangsal, d.namabangsal
                    , d.idkelas, d.namakelas
                    , IFNULL(e.jumlahpasien, 0) AS jumlahpasien, '$tglrekap' AS tanggalrekap
                    , NOW() AS tanggalupdate
                FROM (SELECT a.idruang, a.koderuang, a.namaruang
                            , b.idbangsal, b.kodebangsal, b.namabangsal
                            , c.idkelas, c.kodekelas, c.namakelas
                        FROM ruang AS a
                        INNER JOIN bangsal AS b ON a.idruang = b.idruang
                    CROSS JOIN kelas AS c
                WHERE a.koderuang IS NOT NULL) AS d
                LEFT OUTER JOIN (SELECT namaruang, koderuang, namabangsal, kodebangsal, namakelas, kodekelas, jumlahpasien, tanggalrekap FROM rekapjumlahpasien_tmp WHERE tanggalrekap = '$tglrekap') AS e ON d.koderuang = e.koderuang
                AND d.kodebangsal = e.kodebangsal
                AND d.kodekelas = e.kodekelas";

                echo $insert;

        $query = $this->db->query($insert);
        if ($query) {
            $this->db->truncate('rekapjumlahpasien_tmp');
            return true;
        } else {
            return false;
        }
    }

    public function import_data_json($sheet)
    {
        $data = array();

        $numrow = 1;
		foreach($sheet['data'] as $row){
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'koderuang' => $row['kd_ruang'],
					'kodebangsal' => $row['kd_bangsal'], 
					'kodekelas' => $row['kd_kelas'], 
                    'namaruang' => $row['nm_ruang'], 
                    'namabangsal' => $row['nm_bangsal'],
                    'namakelas' => $row['nm_kelas'],
                    'jumlahpasien' => $row['jml_pasien'],
                    'tanggalrekap' => $row['tanggalrekap'],
				));
			}
			
			$numrow++;
        }

        $this->db->truncate('rekapjumlahpasien_tmp');

        $insert = $this->db->insert_batch('rekapjumlahpasien_tmp', $data);

        if ($insert) {
            return true;
        } else {
            return false;
        }
    }

    public function get_tanggalrekappasien_tmp()
    {
        $sql = "SELECT tanggalrekap
                FROM rekapjumlahpasien_tmp
                GROUP BY tanggalrekap";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }
}