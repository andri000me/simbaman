<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listmenu extends MX_Controller {

    public function __construct() 
    {
        parent::__construct();
        
        $this->load->model('listmenu_query');
    }
    
    function index()
    {
        $data['idpengguna'] = $this->session->userdata('idpengguna');
//        $data['idpeserta'] = $this->session->userdata('idpeserta');
        $data['idgrup'] = $this->session->userdata('idgrup');
        $idpengguna = $this->session->userdata('idpengguna');
        $data = $this->listmenu_query->listdataWherePengguna($idpengguna);
        foreach($data->result() as $t){
            $d['idpengguna'] = $t->idpengguna;
            $d['username'] = $t->username;
            $d['namalengkap'] = $t->namalengkap;
            $d['kelamin'] = $t->kelamin;
            $d['foto'] = $t->foto;
            $d['idpeserta'] = $t->idpeserta;
            $d['idgrup'] = $t->idgrup;
            $d['tglinsert'] = $t->tglinsert;
        }        
        $this->load->view("listmenu_view", $d);
    }
    
    function namamodul($url)
    {
        $data = $this->listmenu_query->listNamaModul($url);
        return $data;
    }
    
    function btnaksi($idmodul,$idgrup)
    {
        $data = $this->listmenu_query->listAksesModul($idmodul,$idgrup);
        return $data;
    }
    
    function bulanindo($bln)
    {
	if($bln == "01") { $bulane = "Januari"; }
	if($bln == "02") { $bulane = "Februari"; }
	if($bln == "03") { $bulane = "Maret"; }
	if($bln == "04") { $bulane = "April"; }
	if($bln == "05") { $bulane = "Mei"; }
	if($bln == "06") { $bulane = "Juni"; }
	if($bln == "07") { $bulane = "Juli"; }
	if($bln == "08") { $bulane = "Agustus"; }
	if($bln == "09") { $bulane = "September"; }
	if($bln == "10") { $bulane = "Oktober"; }
	if($bln == "11") { $bulane = "November"; }
	if($bln == "12") { $bulane = "Desember"; }
	return $bulane;
    }
}