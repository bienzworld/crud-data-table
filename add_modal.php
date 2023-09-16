<!-- Add New -->
<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Add New Item</h4></center>
            </div>
            <div class="modal-body">
            <div class="container-fluid">
            <form method="POST" action="add.php">
                <div class="row form-group">
                    <div class="col-sm-2">
                        <label class="control-label modal-label">Item Name:</label>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="item_name" placeholder="Item Name" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-2">
                        <label class="control-label modal-label">Own Price:</label>
                    </div>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="own_price" placeholder="Own Price" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-2">
                        <label class="control-label modal-label">Competitor Price 1:</label>
                    </div>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="comp_price1" placeholder="Competitor Price" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-2">
                        <label class="control-label modal-label">Competitor Price 2:</label>
                    </div>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="comp_price2" placeholder="Competitor Price" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-2">
                        <label class="control-label modal-label">Competitor Price 3:</label>
                    </div>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="comp_price3" placeholder="Competitor Price" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-2">
                        <label class="control-label modal-label">Competitor Price 4:</label>
                    </div>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="comp_price4" placeholder="Competitor Price" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-2">
                        <label class="control-label modal-label">Image:</label>
                    </div>
                    <div class="col-sm-10">
                        <!-- Give your file input an id -->
                        <input type="file" class="form-control custom-file-input" name="images" id="images" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-2">
                        <label class="control-label modal-label">Uploaded Image:</label>
                    </div>
                    <div class="col-sm-10">
                        <!-- Add the ID to the img tag to display the uploaded image -->
                        <img src="" id="uploadedImage" alt="" style="max-width: 50%; max-height: 100px;">
                    </div>
                </div>
            </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="submit" name="add" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
            </div>
            </form> <!-- Close the form here -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#addnew').on('shown.bs.modal', function() {
        // When the modal is shown, reset the file input
        $('#images').val('');
        // Clear the displayed image
        $('#uploadedImage').attr('src', '');
    });
    
    $('#images').on('change', function() {
        const uploadedImage = $('#uploadedImage');
        const fileInput = this;

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                uploadedImage.attr('src', e.target.result);
            };

            reader.readAsDataURL(fileInput.files[0]);
        } else {
            // Clear the image if no file is selected
            uploadedImage.attr('src', '');
        }
    });
});
</script>