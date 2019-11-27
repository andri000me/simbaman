<?php 

  // $this->load->model('cetaknilaibagian_qry');
  $this->load->model("cetaknilaibagian_qry","",true);
include_once dirname(dirname(__FILE__)) . "/fpdf.php";

class PDF_username_password extends FPDF
{
	protected $participants;
    // Page header
	public function setDataPeserta($mhs,$bagian,$nilaiBag)
	{
		$this -> participants = $mhs;
                $this->dtmhs = $mhs;
               $this->dtbag = $bagian;
               $this->nilaibag = $nilaiBag;
                // var_dump($this->dtbag);die;
	}
	
	function Header()
	{
//	
//	foreach($this -> participants as $key => $mhs){
          $this->setFont('Arial','B',10);
          $this->Cell(180,5,'Evaluasi Hasil Belajar Pendidikan Klinik',0,1,'C');
          $this->Cell(180,5,$this->dtmhs[0]['NamaBagian'],0,1,'C');
        }
        
        //Page Content
	function Content()
	{       
          
//                 $this->SetXY(30, 30);
		$this->setFont('Arial','',12);
		$width_nama = 25;
		$width_subnama = 25;
		$width_upass = 50;
		$height =5;
		$value_height = 10;
                $this->Ln(5);
//                $this->setFont('Arial','',7);
		foreach($this -> participants as $key => $mhs){
                        $this->setFont('Arial','',9);
                        $this->cell(20,$height,'Nama');
                        $this->cell(75,$height,': '.$mhs['NM_MHS'],0,0,'L',0);
                        $this->cell(24,$height,'Periode Coas');
                        $this->cell(75,$height,': '.$mhs['NamaPeriode'],0,1,'L',0);

                        $this->cell(20,$height,'N.I.M');
                        $this->cell(75,$height,': '.$mhs['NO_MHS'],0,0,'L',0);
                        $this->cell(24,$height,'Tanggal Cetak');
                        $this->cell(75,$height,': '.date('d M Y'),0,1,'L',0);
//			
                        $this->cell(20,$height,'Tempat');
                        $this->cell(75,$height,': '.$mhs['NamaRs'],0,1,'L',0);
                        // $this->Ln();

                        $this->setFont('Arial','B',9);
                        $this->cell(7,$height,'No',1,0,'C',0);
                        $this->cell(88,$height,'Kegiatan',1,0,'C',0);
                        $this->cell($width_subnama,$height,'Rerata',1,0,'C',0);
                        $this->cell($width_upass,$height,'Persentase',1,1,'C',0);
                        $MahasiswaID = $mhs['NM_MHS'];
                        // $bagian = $this->cetaknilaibagian_qry->getColBagian($MahasiswaID, $periode_id, $bagian_id, $rs_id);
                        // var_dump($bagian);die;
                        $no = 1;
                        foreach ($this->dtbag as $bg) {
                            $this->setFont('Arial','B',9);
                             $this->Cell(170,5,$bg->Katagori,1,1,'L');
                             foreach ($this->nilaibag as $nilai) {
                                $this->setFont('Arial','',9);
                                 $this->cell(7,$height,$no,1,0,'C',0);
                                    $this->cell(88,$height,$nilai->NamaKegiatan,1,0,'L',0);
                                    $this->cell($width_subnama,$height,$nilai->nilai,1,0,'C',0);
                                    $this->cell($width_upass,$height,$nilai->Perentase,1,1,'C',0);
                             } 
                        }
                        $no++;
                        // $this->Ln();
                        
                        $this->setFont('Arial','B',10);
                        $this->cell(100,$height,'Formatif '.$mhs['NilaiFormatif'].' + Sumatif '.$mhs['NilaiSumatif'],0,1,'L',0);
                        $this->cell($width_upass,$height,'Kondite ',0,0,'C',0);
                        $this->cell($width_upass,$height,'Nilai Akhir  '.$mhs['nilaiakhirTotal'],0,1,'L',0);
                        $this->cell($width_upass,$height,'Sufficient',0,0,'C',0);
                        $this->cell($width_upass,$height,'Nilai Huruf  '.$mhs['Huruftotal'],0,0,'L',0);
                        $this->Ln();

                        $this->setFont('Arial','',8);
                        $this->cell(20,4,'Bobot Nilai');
                        $this->cell(20,4,'',0,0,'C',0);
                        $this->cell(65,4,'Mengetahui',0,0,'C',0);
                        $this->cell(65,4,'Mengetahui',0,1,'C',0);

                        $this->setFont('Arial','',8);
                        $this->cell(20,4,'A   >= 81');
                        $this->cell(20,4,'C   53 - 59.9',0,0,'C',0);
                        $this->cell(65,4,'Koordinator Pendidikan',0,0,'C',0);
                        $this->cell(65,4,'Kepala Departemen',0,1,'C',0);

                        $this->setFont('Arial','',8);
                        $this->cell(20,4,'AB   74 - 80.9');
                        $this->cell(20,4,'D   46 - 52.9',0,0,'C',0);
                        $this->cell(65,4,'');
                        $this->cell(65,4,$this->dtmhs[0]['NamaBagian'],0,1,'C',0);

                        $this->setFont('Arial','',8);
                        $this->cell(20,4,'B   67 - 73.9');
                        $this->cell(20,4,'E   <= 45.9',0,0,'C',0);
                        $this->cell(65,4,'');
                        $this->cell(65,4,'',0,1,'C',0);

                        $this->setFont('Arial','',8);
                        $this->cell(20,4,'BC   60 - 80.9');
                        $this->cell(20,4,'',0,0,'C',0);
                        $this->cell(65,4,'');
                        $this->cell(65,4,'',0,1,'C',0);

                        $this->setFont('Arial','',8);
                        $this->cell(20,4,'Dicetak oleh ');
                        $this->cell(20,4,$mhs['Pencetak'],0,0,'C',0);
                        $this->cell(65,4,'(.....................................)',0,0,'C',0);
                        $this->cell(65,4,'(....................................)',0,1,'C',0);

                        $this->Ln();

                        
//                        $MahasiswaID = $mhs['NO_MHS'];
//                        $periode_id = $mhs['IdPeriode'];
//                        $bagian_id = $mhs['IdBag'];
//                        $rs_id = $mhs['IdRs'];
//                        $persencoas = $this->cetaknilaibagian_qry->getPersenCoas($MahasiswaID,$periode_id,$bagian_id,$rs_id);
//                        var_dump($persencoas);
//                        exit;
		}
    }
          

        // Page footer
	function Footer()
	{            
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}