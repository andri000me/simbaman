<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-21 13:09:17
 * @modify date 2019-09-21 13:09:17
 * @desc [description]
 */

class Pengajuanbahan extends MX_Controller {

    protected $data = '';

    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('pengajuanbahan_query');
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

            $data['tanggalsekarang'] = date('Y-m-d', strtotime("+1 day"));
            
            $this->template
                    ->set_layout('default')
                    ->build('pengajuanbahan_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function tanggalrekappasien()
    {
        set_time_limit(1200);

        $idgrup = $this->session->userdata('idgrup');
        $idmodul = $this->session->userdata('idmodul');
        $btnaksi = $this->listmenu->btnaksi($idmodul,$idgrup);
        foreach($btnaksi->result() as $t){
            $data['add'] = $t->created;
            $data['edit'] = $t->updated;
            $data['delete'] = $t->deleted;
        }

        $data['tglpengajuanbahan'] = $this->security->xss_clean($this->input->post('tglpengajuanbahan'));
        $tglpengajuan = $data['tglpengajuanbahan'];
        $cektglpengajuanbahan = $this->pengajuanbahan_query->cektglpengajuanbahan($tglpengajuan);

        if (count($cektglpengajuanbahan) == 0) {
            //tanggal pengajuan masih kosong            
            $daypengajuan = date('D', strtotime($tglpengajuan));
            switch ($daypengajuan) {
                case 'Sun':
                    $hari = '-2 days';
                    break;
                case 'Mon':
                    $hari = '-3 days';
                    break;
                default:
                    $hari = '-1 days';
            } 

            if ($daypengajuan == 'Sat' or $daypengajuan == 'Sun' or $daypengajuan == 'Mon') {

                if ($daypengajuan == 'Sun' or $daypengajuan == 'Mon') {
                    echo 'Pilih hari Sabtu';
                    exit();
                }
                
                $data['tanggalpengajuan'] = $tglpengajuan;
                $tglrekappasien = date('Y-m-d', strtotime($hari, strtotime($tglpengajuan))); //operasi penjumlahan tanggal sebanyak 6 hari
                $dayrekappasien = date('D', strtotime($tglrekappasien));
                $data['tanggalrekappasien'] = $tglrekappasien;                

                $dayList = array(
                    'Sun' => 'Minggu',
                    'Mon' => 'Senin',
                    'Tue' => 'Selasa',
                    'Wed' => 'Rabu',
                    'Thu' => 'Kamis',
                    'Fri' => 'Jumat',
                    'Sat' => 'Sabtu'
                );

                $data['tglrekappasien'] = $tglrekappasien.', '.$dayList[$dayrekappasien];                
                $data['jumlahpasien'] = $this->pengajuanbahan_query->jumlah_pasien($tglrekappasien);

                $pengajuan = [];
                $tanggalajuan = [];
                for( $i = 0; $i<3; $i++ ) {
                    $hr = '+'.$i.'days';
                    $tanggal = date('Y-m-d', strtotime($hr, strtotime($tglpengajuan)));
                    $hari = date('D', strtotime($hr, strtotime($tglpengajuan)));
                    $pengajuan[] = $tanggal.', '.$dayList[$hari];
                    $tanggalajuan[] = $tanggal;
                }
                $data['pengajuan'] = $pengajuan;

                $i = 0;
                foreach ($tanggalajuan as $tgltgl) {
                    $datepengajuan = date('d', strtotime($tgltgl));
                    $karakter = strlen($datepengajuan);
                    if ($karakter = 2) {
                        if ($datepengajuan == 31) {
                            $tgl = $datepengajuan;
                        } else {
                            $tgl = substr($datepengajuan,1,1);
                        }
                    } else if ($karakter == 1) {
                        $tgl = $datepengajuan;
                    }

                    $data['jenismenumasakan'][] = $this->pengajuanbahan_query->jenismenumasakantgl($tgl);
                    $data['menumasakanwaktu'][] = $this->pengajuanbahan_query->menumasakanwaktu($tgl);
                    $idjenismenu = $data['jenismenumasakan'][$i][0]['idjenismenu'];
                    $data['pengajuanbahan'][] = $this->pengajuanbahan_query->pengajuanbahan($tglrekappasien,$idjenismenu); 
                    $data['tgltgl'][] = $tgltgl;
                    $i++;
                }

                $this->load->view('pengajuanbahan_tglpengajuan_sat', $data);
            } else {
                $datepengajuan = date('d', strtotime($tglpengajuan));
                $karakter = strlen($datepengajuan);
                if ($karakter = 2) {
                    if ($datepengajuan == 31) {
                        $tgl = $datepengajuan;
                    } else {
                        $tgl = substr($datepengajuan,1,1);
                    }
                } else if ($karakter == 1) {
                    $tgl = $datepengajuan;
                }

                $tglrekappasien = date('Y-m-d', strtotime($hari, strtotime($tglpengajuan))); //operasi penjumlahan tanggal sebanyak 6 hari
                $dayrekappasien = date('D', strtotime($tglrekappasien));
                $data['tanggalrekappasien'] = $tglrekappasien;

                $dayList = array(
                    'Sun' => 'Minggu',
                    'Mon' => 'Senin',
                    'Tue' => 'Selasa',
                    'Wed' => 'Rabu',
                    'Thu' => 'Kamis',
                    'Fri' => 'Jumat',
                    'Sat' => 'Sabtu'
                );

                $data['jenismenumasakan'] = $this->pengajuanbahan_query->jenismenumasakantgl($tgl);
                $idjenismenu = $data['jenismenumasakan'][0]['idjenismenu'];
                $data['menumasakanwaktu'] = $this->pengajuanbahan_query->menumasakanwaktu($tgl);

                $data['tglpengajuan'] = $tglpengajuan.', '.$dayList[$daypengajuan];
                $data['tglrekappasien'] = $tglrekappasien.', '.$dayList[$dayrekappasien];
                $data['pengajuanbahan'] = $this->pengajuanbahan_query->pengajuanbahan($tglrekappasien,$idjenismenu);
                $data['jumlahpasien'] = $this->pengajuanbahan_query->jumlah_pasien($tglrekappasien);

                $this->load->view('pengajuanbahan_tglpengajuan', $data);
            }

        } else {
            //tanggal pengajuan sudah terisi

            $daypengajuan = date('D', strtotime($tglpengajuan));
            switch ($daypengajuan) {
                case 'Sun':
                    $hari = '-2 days';
                    break;
                case 'Mon':
                    $hari = '-3 days';
                    break;
                default:
                    $hari = '-1 days';
            }

            if ($daypengajuan == 'Sat' or $daypengajuan == 'Sun' or $daypengajuan == 'Mon') {

                if ($daypengajuan == 'Sun' or $daypengajuan == 'Mon') {
                    echo 'Pilih hari Sabtu';
                    exit();
                }

                $data['pengajuanbahan_cek'] = $this->pengajuanbahan_query->pengajuanbahan_cek($tglpengajuan);
                $data['kelas'] = $this->pengajuanbahan_query->get_kelaspengajuan($tglpengajuan);
                $data['waktumenu'] = $this->pengajuanbahan_query->get_waktumenupengajuan($tglpengajuan);
                $data['pengajuan_tanggalpengajuan'] = $this->pengajuanbahan_query->get_pengajuan_tanggalpengajuan($tglpengajuan);

                $data['tanggalpengajuan_bahan'] = $tglpengajuan;
                $tglrekappasien = date('Y-m-d', strtotime($hari, strtotime($tglpengajuan))); //operasi penjumlahan tanggal sebanyak 6 hari
                $dayrekappasien = date('D', strtotime($tglrekappasien));
                $data['tanggalrekappasien'] = $tglrekappasien;                

                $dayList = array(
                    'Sun' => 'Minggu',
                    'Mon' => 'Senin',
                    'Tue' => 'Selasa',
                    'Wed' => 'Rabu',
                    'Thu' => 'Kamis',
                    'Fri' => 'Jumat',
                    'Sat' => 'Sabtu'
                );

                $data['tglrekappasien'] = $tglrekappasien.', '.$dayList[$dayrekappasien];                
                $data['jumlahpasien'] = $this->pengajuanbahan_query->jumlah_pasien($tglrekappasien);

                $pengajuan = [];
                $tanggalajuan = [];
                for( $i = 0; $i<3; $i++ ) {
                    $hr = '+'.$i.'days';
                    $tanggal = date('Y-m-d', strtotime($hr, strtotime($tglpengajuan)));
                    $hari = date('D', strtotime($hr, strtotime($tglpengajuan)));
                    $pengajuan[] = $tanggal.', '.$dayList[$hari];
                    $tanggalajuan[] = $tanggal;
                }
                $data['pengajuan'] = $pengajuan;

                $i = 0;
                foreach ($tanggalajuan as $tgltgl) {
                    $datepengajuan = date('d', strtotime($tgltgl));
                    $karakter = strlen($datepengajuan);
                    if ($karakter = 2) {
                        if ($datepengajuan == 31) {
                            $tgl = $datepengajuan;
                        } else {
                            $tgl = substr($datepengajuan,1,1);
                        }
                    } else if ($karakter == 1) {
                        $tgl = $datepengajuan;
                    }

                    $data['jenismenumasakan'][] = $this->pengajuanbahan_query->jenismenumasakantgl($tgl);
                    $data['menumasakanwaktu'][] = $this->pengajuanbahan_query->menumasakanwaktu($tgl);
                    $idjenismenu = $data['jenismenumasakan'][$i][0]['idjenismenu'];
                    $data['pengajuanbahan'][] = $this->pengajuanbahan_query->pengajuanbahanfix($tgltgl,$idjenismenu); 
                    $data['tgltgl'][] = $tgltgl;
                    $i++;
                }

                $this->load->view('pengajuanbahan_tglpengajuanfix_sat', $data);

            } else {

                $data['pengajuanbahan_cek'] = $this->pengajuanbahan_query->pengajuanbahan_cek($tglpengajuan);
                $data['kelas'] = $this->pengajuanbahan_query->get_kelaspengajuan($tglpengajuan);
                $data['waktumenu'] = $this->pengajuanbahan_query->get_waktumenupengajuan($tglpengajuan);
                $tanggal = $this->pengajuanbahan_query->get_tanggalpengajuan($tglpengajuan);
                $tglpengajuan_1 = $tanggal[0]['tanggalrekap'];
                $daypengajuan_1 = date('D', strtotime($tglpengajuan_1));
                $tglrekappasien_1 = $tanggal[0]['tanggalpengajuan'];
                $dayrekappasien_1 = date('D', strtotime($tglrekappasien_1));

                $dayList = array(
                    'Sun' => 'Minggu',
                    'Mon' => 'Senin',
                    'Tue' => 'Selasa',
                    'Wed' => 'Rabu',
                    'Thu' => 'Kamis',
                    'Fri' => 'Jumat',
                    'Sat' => 'Sabtu'
                );

                $data['tglpengajuan'] = $tglpengajuan_1.', '.$dayList[$daypengajuan_1];
                $data['tglrekappasien'] = $tglrekappasien_1.', '.$dayList[$dayrekappasien_1];
                $data['jumlahpasien'] = $this->pengajuanbahan_query->jumlah_pasienpengajuan($tglpengajuan);
                $data['jenismenumasakan'] = $this->pengajuanbahan_query->jenismenumasakanpengajuan($tglpengajuan);
                $idjenismenu_1 = $data['jenismenumasakan'][0]['idjenismenu'];
                $data['menumasakanwaktu'] = $this->pengajuanbahan_query->get_waktumenupengajuan($tglpengajuan);
                $data['pengajuanbahan'] = $this->pengajuanbahan_query->pengajuanbahanfix($tglpengajuan,$idjenismenu_1);
                $data['idpengajuan'] = $tanggal[0]['idpengajuan'];
                $data['tanggalpengajuan_bahan'] = $tanggal[0]['tanggalpengajuan'];

                $this->load->view('pengajuanbahan_tglpengajuanfix', $data);
            }
        }        
    }

    public function detailmenumasakan()
    {
        $data['idjenismenu'] = $this->security->xss_clean($this->input->post('idjenismenu'));

        $data['jenismenumasakan'] = $this->pengajuanbahan_query->jenismenumasakan($data['idjenismenu']);

        $data['kelasmenumasakan'] = $this->pengajuanbahan_query->kelasmenumasakan($data['idjenismenu']);
        $data['waktumenumasakan'] = $this->pengajuanbahan_query->waktumenumasakan($data['idjenismenu']);
        $data['menumasakan'] = $this->pengajuanbahan_query->menumasakan($data['idjenismenu']);

        $this->load->view('pengajuanbahan_detailmenumasakan', $data);
    }

    public function generatepengajuanbahan_semua()
    {
        set_time_limit(1200);
        
        $tanggalrekappasien = $this->security->xss_clean($this->input->post('tanggalrekappasien'));
        $tanggalpengajuan = $this->security->xss_clean($this->input->post('tanggalpengajuan'));

        for( $i = 0; $i<3; $i++ ) {
            $tgl_rekappasien = $tanggalrekappasien;
            $hr = '+'.$i.'days';
            $tgl_pengajuan = date('Y-m-d', strtotime($hr, strtotime($tanggalpengajuan)));

            $datepengajuan = date('d', strtotime($tgl_pengajuan));
            $karakter = strlen($datepengajuan);
            if ($karakter = 2) {
                if ($datepengajuan == 31) {
                    $tgl = $datepengajuan;
                } else {
                    $tgl = substr($datepengajuan,1,1);
                }
            } else if ($karakter == 1) {
                $tgl = $datepengajuan;
            }

            $jenismenumasakan = $this->pengajuanbahan_query->jenismenumasakantgl($tgl);
            $id_jenismenu = $jenismenumasakan[0]['idjenismenu'];

            $generate = $this->pengajuanbahan_query->genaratepengajuanbahan($tgl_rekappasien,$id_jenismenu,$tgl_pengajuan);
        }

        return true;
    }

    public function generatepengajuanbahan()
    {
        $data['tanggalrekappasien'] = $this->security->xss_clean($this->input->post('tanggalrekappasien'));
        $data['idjenismenu'] = $this->security->xss_clean($this->input->post('idjenismenu'));
        $data['tanggalpengajuan'] = $this->security->xss_clean($this->input->post('tanggalpengajuan'));

        $generate = $this->pengajuanbahan_query->genaratepengajuanbahan($data['tanggalrekappasien'],$data['idjenismenu'],$data['tanggalpengajuan']);

        return $generate;
    }

    public function resetpengajuanbahan()
    {
        $data['idpengajuan'] = $this->security->xss_clean($this->input->post('idpengajuan'));

        $generate = $this->pengajuanbahan_query->resetpengajuanbahan($data['idpengajuan']);

        return $generate;
    }

    public function cetakpengajuan()
    {
        $data['idpengajuan'] = $this->security->xss_clean($this->input->get('idpengajuan'));
        $data['idkelas'] = $this->security->xss_clean($this->input->get('idkelas'));
        $data['idwaktumenu'] = $this->security->xss_clean($this->input->get('idwaktumenu'));
        
        $kelas = $this->pengajuanbahan_query->pengajuanbahan_kelas($data['idkelas'],$data['idpengajuan']);
        $waktumenu = $this->pengajuanbahan_query->pengajuanbahan_waktumenu($data['idwaktumenu'],$data['idpengajuan']);
        $pengajuanbahan = $this->pengajuanbahan_query->pengajuanbahanfixcetak($data);
        $tanggalpengajuan = $this->pengajuanbahan_query->tanggalpengajuan($data['idpengajuan']);

        $klss = array();
        foreach ($kelas as $kls) {
            $klss[] = $kls['namakelas'];
        }
        $kelas_pengajuan = str_replace("]",'',str_replace("[",'',str_replace('"','', json_encode($klss))));

        $wkts = array();
        foreach ($waktumenu as $wkt) {
            $wkts[] = $wkt['namawaktumenu'];
        }
        $waktu_pengajuan = str_replace("]",'',str_replace("[",'',str_replace('"','', json_encode($wkts))));

        $tanggalpengajuan = $tanggalpengajuan[0]['tanggalpengajuan'];

        include_once APPPATH."third_party/fpdf17/custom/PDF_PengajuanBahanMasakan.php";

        $pdf=new PDF_absensi('P','mm','A4');
        $pdf -> setPengajuanBahan($pengajuanbahan);
        $pdf -> setKelasPengajuanBahan($kelas_pengajuan);
        $pdf -> setWaktuPengajuanBahan($waktu_pengajuan);
        $pdf -> setTanggalPengajuanBahan($tanggalpengajuan);

		$pdf->SetMargins(5,5,5,5);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Content();
        // $pdf->Output();
        $tanggal = str_replace("-","",$tanggalpengajuan);
        $fileName = 'pengajuan_bm_'.$tanggal.'.pdf';
        $pdf->Output($fileName, 'D');
    }

    public function form_pengajuandiet()
    {
        $data['idpengajuan'] = $this->security->xss_clean($this->input->post('idpengajuan'));
        $pengajuan = $this->pengajuanbahan_query->get_pengajuan($data['idpengajuan']);
        $data['diet'] = $this->pengajuanbahan_query->list_diet();        

        $data['tanggalrekap'] = $pengajuan[0]['tanggalrekap'];

        $data['kelas'] = $this->pengajuanbahan_query->get_kelas_pengajuan($data['tanggalrekap']);
        $data['bangsal'] = $this->pengajuanbahan_query->list_bangsal_tglrekap($data['tanggalrekap']);
        $this->load->view('form_pengajuandiet', $data);
    }

    public function get_bangsal_pengajuan()
    {
        echo $this->pengajuanbahan_query->get_bangsal_pengajuan();
    }

    public function savedata_pengajuandiet()
    {
        $up['idpengajuanbahandietdetail'] = $this->security->xss_clean($this->input->post('idpengajuanbahandietdetail'));
        $up['idpengajuan'] = $this->security->xss_clean($this->input->post('idpengajuan'));
        $up['iddiet'] = $this->security->xss_clean($this->input->post('iddiet'));
        $up['idkelas'] = $this->security->xss_clean($this->input->post('idkelas'));
        $up['idbangsal'] = $this->security->xss_clean($this->input->post('idbangsal'));
        $up['jumlahpasien'] = $this->security->xss_clean($this->input->post('jumlahpasien'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));

        $this->pengajuanbahan_query->ExecData_pengajuandiet($up);
    }

    public function detail_pengajuandiet()
    {
        $data['idpengajuan'] = $this->security->xss_clean($this->input->post('idpengajuan'));
        $data['pengajuandetail'] = $this->pengajuanbahan_query->list_pengajuandetail($data['idpengajuan']);
        $this->load->view('detail_pengajuandiet', $data);
    }

    public function hapus_bahandiet()
    {
        $up['idpengajuanbahandietdetail'] = $this->security->xss_clean($this->input->post('idpengajuanbahandietdetail'));
        $up['idpengajuan'] = "";
        $up['iddiet'] = "";
        $up['idkelas'] = "";
        $up['idbangsal'] = "";
        $up['jumlahpasien'] = "";
        $up['pembuatid'] = $this->session->userdata('idpengguna');
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $this->pengajuanbahan_query->ExecData_pengajuandiet($up);
    }

    public function form_ubah_pengajuandiet()
    {
        $up['idpengajuanbahandietdetail'] = $this->security->xss_clean($this->input->post('idpengajuanbahandietdetail'));

        $data['pengajuandiet'] = $this->pengajuanbahan_query->get_datapengajuandiet($up['idpengajuanbahandietdetail']);

        $data['diet'] = $this->pengajuanbahan_query->list_diet();
        $data['kelas'] = $this->pengajuanbahan_query->list_kelas();
        $data['bangsal'] = $this->pengajuanbahan_query->list_bangsal();
        $this->load->view('form_ubah_pengajuandiet', $data);
    }

    public function form_pengajuandiet_sat()
    {
        $data['tanggalpengajuan'] = $this->security->xss_clean($this->input->post('tanggalpengajuan'));
        $pengajuan = $this->pengajuanbahan_query->get_pengajuan_tanggal($data['tanggalpengajuan']);
        $data['diet'] = $this->pengajuanbahan_query->list_diet();        

        $data['tanggalrekap'] = $pengajuan[0]['tanggalrekap'];

        $data['kelas'] = $this->pengajuanbahan_query->get_kelas_pengajuan($data['tanggalrekap']);
        $data['bangsal'] = $this->pengajuanbahan_query->list_bangsal_tglrekap($data['tanggalrekap']);
        $this->load->view('form_pengajuandiet_sat', $data);
    }

    public function savedata_pengajuandiet_sat()
    {
        $up['idpengajuanbahandietdetail'] = $this->security->xss_clean($this->input->post('idpengajuanbahandietdetail'));
        $up['tanggalpengajuan'] = $this->security->xss_clean($this->input->post('tanggalpengajuan'));
        $up['iddiet'] = $this->security->xss_clean($this->input->post('iddiet'));
        $up['idkelas'] = $this->security->xss_clean($this->input->post('idkelas'));
        $up['idbangsal'] = $this->security->xss_clean($this->input->post('idbangsal'));
        $up['jumlahpasien'] = $this->security->xss_clean($this->input->post('jumlahpasien'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));

        $this->pengajuanbahan_query->ExecData_pengajuandiet_sat($up);
    }

    public function detail_pengajuandiet_sat()
    {
        $data['tanggalpengajuan'] = $this->security->xss_clean($this->input->post('tanggalpengajuan'));
        $data['pengajuandetail'] = $this->pengajuanbahan_query->list_pengajuandetail_tglpengajuan($data['tanggalpengajuan']);
        $this->load->view('detail_pengajuandiet_sat', $data);
    }

    public function detail_bahansisa()
    {
        $data['tanggalpengajuan'] = $this->security->xss_clean($this->input->post('tanggalpengajuan'));
        $pengajuan = $this->pengajuanbahan_query->get_tanggalpengajuan($data['tanggalpengajuan']);
        $data['idpengajuan'] = $pengajuan[0]['idpengajuan'];
        $tanggalpengajuan = $data['tanggalpengajuan'];
        $tanggalbahansisa = date('Y-m-d', strtotime('-1 days', strtotime($data['tanggalpengajuan'])));
        $data['tanggalbahansisa'] = $tanggalbahansisa;
        $data['bahansisa'] = $this->pengajuanbahan_query->list_bahansisa($tanggalpengajuan,$tanggalbahansisa);
        $data['satuan'] = $this->pengajuanbahan_query->list_satuan($tanggalbahansisa);

        $data['sisabahanmasakan'] = $this->pengajuanbahan_query->list_sisabahanmasakan($data['idpengajuan']);
        
        $this->load->view('detail_bahansisa', $data);
    }

    public function form_bahansisa()
    {
        $data['tanggalpengajuan'] = $this->security->xss_clean($this->input->post('tanggalpengajuan'));
        $pengajuan = $this->pengajuanbahan_query->get_tanggalpengajuan($data['tanggalpengajuan']);
        $data['idpengajuan'] = $pengajuan[0]['idpengajuan'];
        $tanggalpengajuan = $data['tanggalpengajuan'];
        $tanggalbahansisa = date('Y-m-d', strtotime('-1 days', strtotime($data['tanggalpengajuan'])));
        $data['tanggalbahansisa'] = $tanggalbahansisa;
        $data['bahansisa'] = $this->pengajuanbahan_query->list_bahansisa($tanggalpengajuan,$tanggalbahansisa);
        $data['satuan'] = $this->pengajuanbahan_query->list_satuan($tanggalbahansisa);

        $data['sisabahanmasakan'] = $this->pengajuanbahan_query->list_sisabahanmasakan($data['idpengajuan']);
        
        $this->load->view('form_bahansisa', $data);
    }

    public function savedata_bahansisamasakan()
    {
        $up['idsisabahan'] = $this->security->xss_clean($this->input->post('idsisabahan'));
        $up['idpengajuan'] = $this->security->xss_clean($this->input->post('idpengajuan'));
        $up['tanggalpengajuan'] = $this->security->xss_clean($this->input->post('tanggalpengajuan'));
        $up['tanggalbahansisa'] = $this->security->xss_clean($this->input->post('tanggalbahansisa'));
        $up['idbahansisa'] = $this->security->xss_clean($this->input->post('idbahansisa'));
        $up['jumlahkuantitas'] = $this->security->xss_clean($this->input->post('jumlahkuantitas'));
        $up['satuan'] = $this->security->xss_clean($this->input->post('satuan'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));

        $this->pengajuanbahan_query->ExecData_bahansisamasakan($up);
    }

    public function hapus_bahansisa()
    {
        $up['idsisabahan'] = $this->security->xss_clean($this->input->post('idsisabahan'));
        $up['idpengajuan'] = "";
        $up['tanggalpengajuan'] = "";
        $up['tanggalbahansisa'] = "";
        $up['idbahansisa'] = "";
        $up['jumlahkuantitas'] = "";
        $up['satuan'] = "";
        $up['pembuatid'] = $this->session->userdata('idpengguna');
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));

        $this->pengajuanbahan_query->ExecData_bahansisamasakan($up);
    }
}