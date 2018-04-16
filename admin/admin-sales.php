<?php
require('fpdf2.php');
include ("connection.php");

				session_start();
				
				
	class PDF extends FPDF
	{
		function Header()
{
	
		$this->SetFont('courier','BI',20);
		
		$this->Cell(68);
		
		$this->Cell(150,5,'Sales Report',0,0,'C');
		$this->Ln(10);
		$this->Cell(6);
		$this->SetFont('Helvetica','B',10);
		$this->Cell(0,15,'Mushroom Sisisg Haus Atbp.',0,0,'L');
		$this->Ln(5);
		$this->Cell(6);
		$this->SetFont('Helvetica','',10);
		$this->Cell(0,15,'Capitol Exit Malolos, Bulacan',0,0,'L');
		$this->Ln(5);
		$this->Cell(6);
		$this->Cell(0,15,'0922 849 0700',0,0,'L');
		
		$this->Image("images/logo.jpg",247,12,44,0,"","admin-close.php");
		
		$this->Ln(15);
	}

	
	function Footer()
	{
		
		$this->SetY(-15);
		
		$this->SetFont('Arial','I',8);
		
		$this->Cell(0,10,'Page. '.$this->PageNo().' Sales-Report',0,0,'C');
	}
	
		
		function Pending()
		{
				$salesStart = $_SESSION['salesStart'];
				$salesEnd = $_SESSION['salesEnd'];
				$category = $_SESSION['category'];
				$result = "";
				if($category=="All"){
					$result=mysql_query("Select * from mushroom_delivery where delivery_sales_date >= '$salesStart' AND delivery_sales_date <= '$salesEnd' and delivery_status = 'Completed' and delivery_archive='No' order by delivery_seconds asc");					
				}
				else{
					$result=mysql_query("Select * from mushroom_delivery where delivery_sales_date >= '$salesStart' AND delivery_sales_date <= '$salesEnd' and delivery_status = 'Completed' and delivery_archive='No' and delivery_type='$category' order by delivery_seconds asc");				
				}
		
			$result2 = mysql_num_rows($result);
				if($result2){
					while($row=mysql_fetch_array($result)) 
				{ 
					$val = array($row['delivery_code'],$row['delivery_type']);
					$quantity = 0;
					$subtotal = 0;
					$code = $row['delivery_code'];
					$sql2 = "Select * from mushroom_orders where delivery_code = '$code'";
					$exist2 = mysql_query($sql2);							
					if($exist2){
						while($row2 = mysql_fetch_array($exist2)){			
							$qty = $row2['order_quantity'];
							$qty = floatval(str_replace(",","",$qty));														
							$totals =$row2['order_subtotal'];
							$totals = floatval(str_replace(",","",$totals));
							$quantity += $qty;
							$subtotal += $totals;
						}
						array_push($val,$quantity,$subtotal);	
						$data[] = $val;
					} 
				
				}
				return $data;
				
			}
		}
			
		function ShowTable($header,$data)
		{

			$this->SetFillColor(52,69,79);
			$this->SetTextColor(255,255,255);
			$this->SetDrawColor(244,244,244);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			
			
			$ctr = 1;
			$fee = 0;
			$this->Ln();
			
			foreach($header as $col)
				
			$this->Cell(69,10,$col,1,0,'C',true);
			$this->Ln();
	
			if($data){
				$count = 0;
				foreach($data as $row)
				{
					$count++;
					if($count==1){
							$this->SetFillColor(254,254,254);
					}
					else{
						$this->SetFillColor(233,240,245);
						$count=0;
					}
					foreach($row as $col){		
						
						if($ctr==4){
							$fees = $row[3];
							$fee = $fee + $fees;
							$ctr =0;
							$col = number_format($col,"2");
						}
						$this->SetTextColor(0,0,0);					
						$this->SetFont('','');
						$this->Cell(69,6,$col,'L R B',0,'C',true);
						$ctr++;
						
						
					}						
					$this->Ln();
					
				}
			}
			else{
				
				$this->Cell(46,4,"",1,0,'C');
				$this->Cell(46,4,"",1,0,'C');	
				$this->Cell(46,4,"",1,0,'C');
				$this->Cell(46,4,"",1,0,'C');	
				$this->Cell(46,4,"",1,0,'C');
				$this->Cell(46,4,"",1,0,'C');	
				$this->Ln();
				
			}
			$this->Cell(0,10,'Total Income: '.number_format($fee,2),0,1,'R');
			$this->Ln();
		
			
		}
		function ShowTotal($header,$data)
		{

			
			
		}
			
	} 
	

$pdf=new PDF();


$header=array('Order No.','Order Type','No. of Items','Amount');
$data=$pdf->Pending();
$pdf->SetFont('Arial','',12);
$pdf->AddPage();
$pdf->ShowTable($header,$data);


$pdf->Output();	

?>