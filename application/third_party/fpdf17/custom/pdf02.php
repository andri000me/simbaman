<?php 

include_once dirname(dirname(__FILE__)) . "/fpdf.php";


class PDF02 extends FPDF
{
	protected $no_tinjauan;
	protected $caption_tinjauan;
	protected $tinjauan_options;
    // Page header
	public function setData($msttinjuan_one, $tinjauan_options, $data_body)
	{
		if(preg_match("#^tinjauan([0-9]+)$#", $msttinjuan_one["nama_tabel"], $match)){
			$this -> no_tinjauan = $match[1];
		}
		$this -> caption_tinjauan = "Tinjauan {$this -> no_tinjauan}: {$msttinjuan_one["nama"]}";
		$this -> tinjauan_options = $tinjauan_options;
		$this -> data_body = $data_body;
	}
	
	function Header()
	{
		$this->Image(dirname(__FILE__).'/logofk.gif',10,5,20);


		$this->SetFont('Arial', 'B', 15);		
		$this->Text(90,16, 'LAPORAN JUMLAH REVIEW SOAL PER TINJAUAN');
		$this->SetFont('Arial', '', 10);
		$this->Text(30,20, '');
		
		$this->Line(350, 26, 5, 26);
		
		$this->Ln(25);

	}
        
        //Page Content
	function Content()
	{
		$width_nama = 85;
        $this->Text(5,32, $this -> caption_tinjauan);
		$newY = 38;
		$this -> SetY($newY);
        $this->setFont('Arial','B',10);
        $this->setFillColor(237,237,237);
        $this->cell(10,6,'No.',1,0,'C',1);
        $this->cell($width_nama,6,'Nama',1,0,'C',1);
		foreach($this -> tinjauan_options as $key => $option){
			$this->cell(25,6,"Opsi ".($key+1),1,0,'C',1);
			/*$cellWidth = $this->GetStringWidth($option["aspek"]);
			$this->cell($cellWidth,14,$option["aspek"],1,0,'C',1);
			$this->MultiCell( 35, 6, $option["aspek"], 1,'L',0);*/
		}
        $this->cell(30,6,'Jumlah',1,0,'C',1);
		$this->Ln();
        $this->setFont('Arial','',10);
		
		foreach($this -> data_body["users"] as $key => $user){
			$this->cell(10,6,$key+1,1,0,'C',0);
			$this->cell($width_nama,6,$user["namalengkap"],1,0,'L',0);
			foreach($this -> tinjauan_options as $key01 => $option){
				$this->cell(25,6,$user["option_tinjauan".$key01],1,0,'C',0);
			}
			$this->cell(30,6,$user["total_soal"],1,0,'C',0);
			$this->Ln();
		}
		
        $this->setFont('Arial','B',10);
        $this->cell(10,6,'',1,0,'C',0);
        $this->cell($width_nama,6,'Jumlah.',1,0,'C',0);
        $this->setFont('Arial','',10);
		foreach($this -> tinjauan_options as $key01 => $option){
			$this->cell(25,6,$this -> data_body["total"]["option_tinjauan".$key01],1,0,'C',0);
		}
		$this->cell(30,6,$this -> data_body["total"]["total_soal"],1,0,'C',0);
		
		$this->Ln();
		$this->Ln();
			
			
		foreach($this -> tinjauan_options as $key => $option){
			$this->Write(5, "Opsi ".($key+1).": ".$option["aspek"]);
			$this->Ln();
		}
    }
        
	function WordWrap(&$text, $maxwidth)
	{
		$text = trim($text);
		if ($text==='')
			return 0;
		$space = $this->GetStringWidth(' ');
		$lines = explode("\n", $text);
		$text = '';
		$count = 0;

		foreach ($lines as $line)
		{
			$words = preg_split('/ +/', $line);
			$width = 0;

			foreach ($words as $word)
			{
				$wordwidth = $this->GetStringWidth($word);
				if ($wordwidth > $maxwidth)
				{
					// Word is too long, we cut it
					for($i=0; $i<strlen($word); $i++)
					{
						$wordwidth = $this->GetStringWidth(substr($word, $i, 1));
						if($width + $wordwidth <= $maxwidth)
						{
							$width += $wordwidth;
							$text .= substr($word, $i, 1);
						}
						else
						{
							$width = $wordwidth;
							$text = rtrim($text)."\n".substr($word, $i, 1);
							$count++;
						}
					}
				}
				elseif($width + $wordwidth <= $maxwidth)
				{
					$width += $wordwidth + $space;
					$text .= $word.' ';
				}
				else
				{
					$width = $wordwidth + $space;
					$text = rtrim($text)."\n".$word.' ';
					$count++;
				}
			}
			$text = rtrim($text)."\n";
			$count++;
		}
		$text = rtrim($text);
		return $count;
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