<?php

class Pengajuancekbahan extends MX_Controller {
    protected $data = '';

    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('pengajuancekbahan_qry');
        $this->load->module('access'); 
        $this->load->module('listmenu');
        
        $cek = $this->session->userdata('logged_in');
        if (!$cek) {
            header('location:'.base_url().'access');
        }
    }

    public function index()
    {
        $idgrup = $this->session->userdata('idgrup');
        $url = $this->uri->segment(1);
        $cekhakakses = $this->access->hakakses($idgrup,$url);
        if ($cekhakakses == 1) {
            $modul = $this->listmenu->namamodul($url);
            foreach($modul->result() as $t){
                $sess_data['idmodul'] = $t->idmodul;
                $data['idmodul'] = $t->idmodul;
                $data['idmenu'] = $t->idmenu;
                $data['namamodul'] = $t->namamodul;
                $data['keteranganmodul'] = $t->keterangan;
                $data['namamenu'] = $t->namamenu;
            }
            $this->session->set_userdata($sess_data);
            
            $idmodul = $this->session->userdata('idmodul');
            $btnaksi = $this->listmenu->btnaksi($idmodul,$idgrup);
            foreach($btnaksi->result() as $t){
                $data['add'] = $t->created;
                $data['edit'] = $t->updated;
                $data['delete'] = $t->deleted;
            }

            $get_tanggalkelas = $this->pengajuancekbahan_qry->get_tanggalkelas();

            $events = array();
            foreach ($get_tanggalkelas as $kelas) {
                $e = array();
                $hargatotal = number_format($kelas['hargatotal'],2,",",".");
                $e['title'] = $kelas['stat'].' : Rp. '.$hargatotal;
                $e['start'] = $kelas['tanggalpengajuan'];
                $e['allDay'] = $kelas['allDay'];
                $e['backgroundColor'] = $kelas['color'];
                $e['borderColor'] = $kelas['color'];

                array_push($events, $e);
            }
            $data['event'] = json_encode($events);
            
            $this->template
                    ->set_layout('default')
                    ->build('pengajuancekbahan_view',$data);
        } else {
            $this->access->statHakAkses();
        }        
    }

}