<?php 
   session_start();

   include("php/connection.php");
   if(!isset($_SESSION['user_name'])){
    header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Items</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="datatable/dataTable.bootstrap.min.css">
	<style>
	.height10{
    height:10px;
	}
	.mtop10{
    	margin-top:10px;
	}
	.modal-label{
 	   position:relative;
  	  top:7px;
	}
	.table-format{
 	   text-align: center;
  	  vertical-align: middle;
	}	
	</style>
</head>
<body>
<div class="container">
	<a href="php/logout.php"> <button class="btn btn-danger btn-sm pull-right">Log Out</button> </a>
	<h1 class="page-header text-center">Item List</h1>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<div class="row">
			<?php
				if(isset($_SESSION['error'])){
					echo
					"
					<div class='alert alert-danger text-center'>
						<button class='close'>&times;</button>
						".$_SESSION['error']."
					</div>
					";
					unset($_SESSION['error']);
				}
				if(isset($_SESSION['success'])){
					echo
					"
					<div class='alert alert-success text-center'>
						<button class='close'>&times;</button>
						".$_SESSION['success']."
					</div>
					";
					unset($_SESSION['success']);
				}
			?>
			</div>
			<div class="row">
				<button id="exportCsvBtn" class="btn btn-success pull-right"><span class="glyphicon glyphicon-print"></span> CSV</button>

			</div>
			<div class="height10">
			</div>
			<div class="row">
				<table id="myTable" class="table table-bordered table-striped">
					<thead>
						<th>Item Name</th>
						<th>Own Price</th>
						<th>Competitor Price 1</th>
						<th>Competitor Price 2</th>
						<th>Competitor Price 3</th>
						<th>Competitor Price 4</th>
					</thead>
					<tbody>
						<?php
							include_once('php/connection.php');
							$sql = "SELECT * FROM items";
							$query = $conn->query($sql);
							while($row = $query->fetch_assoc()){
								$itemImage = $row['images'];
								echo 
								"<tr class='table-format'>
                                    <div class='text-center'>
									<td><button class='btn btn-primary view-image-button' data-image='$itemImage'>View Image</button>
                                    </div>
                                    <div class='text-center'>
									$row[item_name]</td>
                                    </div>
									<td style='vertical-align: middle'>"."₱".number_format($row['own_price'], 2)."</td>
									<td style='vertical-align: middle'>"."₱".number_format($row['comp_price1'], 2)."</td>
									<td style='vertical-align: middle'>"."₱".number_format($row['comp_price2'], 2)."</td>
									<td style='vertical-align: middle'>"."₱".number_format($row['comp_price3'], 2)."</td>
									<td style='vertical-align: middle'>"."₱".number_format($row['comp_price4'], 2)."</td>
								</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include('add_modal.php') ?>
<script src="jquery/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="datatable/jquery.dataTables.min.js"></script>
<script src="datatable/dataTable.bootstrap.min.js"></script>
<!-- generate datatable on our table -->
<script>
$(document).ready(function(){
	//inialize datatable
	var dataTable = $('#myTable').DataTable();

    //hide alert
    $(document).on('click', '.close', function(){
    	$('.alert').hide();
    })
	$('#exportCsvBtn').on('click', function () {
    var currentData = dataTable.rows({ page: 'current' }).data().toArray();
    var csvContent = "Item Name,Own Price,Competitor Price 1,Competitor Price 2,Competitor Price 3,Competitor Price 4\n";

    for (var i = 0; i < currentData.length; i++) {
        // Replace HTML tags with an empty string to remove them from the data
        var rowData = currentData[i].map(function (cellData) {
            var cellWithoutViewImage = cellData.replace(/<[^>]*>/g, '').trim();
            return cellWithoutViewImage.replace(/View Image/g, '').trim();
        });

        csvContent += '"' + rowData[0] + '","' + rowData[1] + '","' + rowData[2] + '","' + rowData[3] + '","' + rowData[4] + '","' + rowData[5] + '"\n';
    }

    // Rest of the code for creating and downloading the CSV remains the same
    var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    var currentDate = new Date();
    var filename = 'items_' + currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' + ('0' + currentDate.getDate()).slice(-2) + '.csv';
    var downloadLink = document.createElement("a");
    downloadLink.href = URL.createObjectURL(blob);
    downloadLink.download = filename;
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
	});

});
</script>
<script>
	$(document).ready(function() {
    // Define a click event handler for the buttons with the class view-image-button
    	$(".view-image-button").click(function() {
   	     var imageUrl = $(this).data('image'); // Get the image URL from the data attribute
  	      window.open(imageUrl, '_blank');
 	   });
	});
</script>
</body>
<style>
.PP{
	text-align: center;
}
</style>
</html>