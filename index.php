<?php
	session_start();
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
			top:7px
		}
	</style>
</head>
<body>
<div class="container">
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
				<a href="#addnew" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> New</a>
				<a href="export_csv.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-print"></span> CSV</a>

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
						<th>Action</th>
					</thead>
					<tbody>
						<?php
							include_once('connection.php');
							$sql = "SELECT * FROM items";
							$query = $conn->query($sql);
							while($row = $query->fetch_assoc()){
								echo 
								"<tr>
									<td>".$row['item_name']."</td>
									<td>"."₱".number_format($row['own_price'], 2)."</td>
									<td>"."₱".number_format($row['comp_price1'], 2)."</td>
									<td>"."₱".number_format($row['comp_price2'], 2)."</td>
									<td>"."₱".number_format($row['comp_price3'], 2)."</td>
									<td>"."₱".number_format($row['comp_price4'], 2)."</td>
									<td>
										<a href='#edit_".$row['item_id']."' class='btn btn-success btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-edit'></span> Edit</a>
										<a href='#delete_".$row['item_id']."' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
									</td>
								</tr>";
								include('edit_delete_modal.php');
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
	    // Export CSV button click event
		$('#exportCsvBtn').on('click', function () {
        // Get the current DataTable data
        var currentData = dataTable.rows({ page: 'current' }).data().toArray();

        // Create a CSV string from the current data
        var csvContent = "Item Name,Own Price,Competitor Price 1,Competitor Price 2,Competitor Price 3,Competitor Price 4\n";
        for (var i = 0; i < currentData.length; i++) {
            csvContent += '"' + currentData[i][0] + '","' + currentData[i][1] + '","' + currentData[i][2] + '","' + currentData[i][3] + '","' + currentData[i][4] + '","' + currentData[i][5] + '"\n';
        }

        // Create a Blob containing the CSV data
        var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

        // Create a download link for the CSV file
		var currentDate = new Date();
		var filename = 'items_' + currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' + ('0' + currentDate.getDate()).slice(-2) + '.csv';
        var downloadLink = document.createElement("a");
        downloadLink.href = URL.createObjectURL(blob);
        downloadLink.download = filename;

        // Trigger the download
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
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