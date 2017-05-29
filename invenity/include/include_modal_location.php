<?php 
    // If form error, show error
    if (isset($_SESSION["new_location_name"])) { 
        echo "<script type='text/javascript'>
            jQuery(document).ready(function($) {
                $('#modal_dialog_location').modal('show');
            });
        </script>";
        $location_info = "<span class='text-danger' id='location_info'>Location '$_SESSION[new_location_name]' is already exists!</span>";
    }
?>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_dialog_location">
    <form name="form_location" class="form-horizontal validetta" enctype="multipart/form-data" id="form_location" method="post" action="process.php">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal_title_location"></h4>
                </div>
                <div class="modal-body" id="modal_content_location">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="location_name">Location Name</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="location_id" id="location_id" value=""> 
                            <input type="text" class="form-control" name="location_name" id="location_name" placeholder="Location Name" data-validetta="required">
                            <?php if (isset($location_info)) { echo $location_info; } ?>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="control-label col-sm-3" for="location_photo">Location Photo</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="location_photo" id="location_photo" placeholder="Location Photo">
                            <span class="help-block">Max file size 2 Mb. Jpg, png and gif. (Optional)</span>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="active">Active</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="active" id="active">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr class="dashed" />
                <div class="modal-footer" id="modal_footer_location">
                    <input type="hidden" name="action" id="action" value="add_location">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->
<?php 
if (isset($_SESSION["new_location_name"])) {
    unset($_SESSION["new_location_name"]);
}
?>