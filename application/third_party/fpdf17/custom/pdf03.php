<?php 

include_once dirname(dirname(__FILE__)) . "/fpdf.php";


class PDF03 extends FPDF
{
	protected $data;
    // Page header
	public function setData($data)
	{
		$this -> data = $data;
	}
	
	function Header()
	{
		$this->Image(dirname(__FILE__).'/logofk.gif',10,5,20);


		$this->SetFont('Arial', 'B', 14);		
		$this->Text(59,12, 'LAPORAN JUMLAH SOAL PER TINJAUAN');
		$this->SetFont('Arial', '', 10);
		$this->Text(30,20, '');
		
		$this->Line(350, 26, 5, 26);
		
		$this->Ln(25);
	}
        
        //Page Content
	function Content()
	{
		$width_nama = 155;
		$width_jumlah = 30;
		$newY = 38;
		$this -> SetY($newY);
        $this->setFont('Arial','B',10);
        $this->setFillColor(237,237,237);
        $this->cell($width_nama,6,'Tinjauan',1,0,'L',1);
        $this->cell($width_jumlah,6,'Jumlah',1,0,'L',1);
		$this->Ln();
		foreach($this -> data as $row){
			$this->setFont('Arial','B',10);
			$this->cell($width_nama,6,'Tinjauan '.$row["urutan"],1,0,'L',0);
			$this->cell($width_jumlah,6,'',1,0,'L',0);
			$this->Ln();
			$this->setFont('Arial','',10);
			foreach($row["children"] as $row01){
				$this->cell($width_nama,6,$row01["aspek"],1,0,'L',0);
				$this->cell($width_jumlah,6,$row01["jumlah"],1,0,'L',0);
				$this->Ln();
			}
		}
        $this->setFont('Arial','',10);
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