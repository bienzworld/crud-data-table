<?php
	function generateRow(){
		$contents = '';
		include_once('connection.php');
		$sql = "SELECT * FROM items";

		//use for MySQLi OOP
		$query = $conn->query($sql);
		while($row = $query->fetch_assoc()){
			$contents .= "
			<tr>
			<td>".$row['item_name']."</td>
			<td>".number_format($row['own_price'], 2)."</td>
			<td>".number_format($row['comp_price1'], 2)."</td>
			<td>".number_format($row['comp_price2'], 2)."</td>
			<td>".number_format($row['comp_price3'], 2)."</td>
			<td>".number_format($row['comp_price4'], 2)."</td>
			</tr>
			";
		}
		////////////////

		//use for MySQLi Procedural
		// $query = mysqli_query($conn, $sql);
		// while($row = mysqli_fetch_assoc($query)){
		// 	$contents .= "
		// 	<tr>
		// 		<td>".$row['id']."</td>
		// 		<td>".$row['firstname']."</td>
		// 		<td>".$row['lastname']."</td>
		// 		<td>".$row['address']."</td>
		// 	</tr>
		// 	";
		// }
		////////////////
		
		return $contents;
	}

	require_once('tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle("Generated PDF using TCPDF");  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage();  
    $content = '';  
    $content .= '
      	<h2 align="center">Generated PDF using TCPDF</h2>
      	<h4>Items Table</h4>
      	<table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
                <th width="15%">Item Name</th>
				<th width="15%">Own Price</th>
				<th width="15%">Competitor Price 1</th>
				<th width="15%">Competitor Price 2</th>
				<th width="15%">Competitor Price 3</th>
				<th width="15%">Competitor Price 4</th>
           </tr>  
      ';  
	$filename = 'items_' . date('Y-m-d') . '.pdf';  
    $content .= generateRow();  
    $content .= '</table>';  
    $pdf->writeHTML($content);  
    $pdf->Output($filename, 'I');
	

?>