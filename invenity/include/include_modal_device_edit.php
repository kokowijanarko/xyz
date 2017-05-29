<div class="modal fade" tabindex="-1" role="dialog" id="modal_dialog_device_edit">
    <form class="form-horizontal" name="form_device" id="form_device_edit" method="post" enctype="multipart/form-data" action="process.php">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal_title_device_edit">Edit Device</h4>
                </div>
                <div class="modal-body" id="modal_content_device_edit">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Device Type</label>
                        <div class="col-sm-6">
                            <select class="form-control chosen-select" name="dev_type_id" id="dev_type_id_edit" data-placeholder="Device Type">
                                <option value=""></option>
                                <?php
                                $type_select = ""; 
                                $dev_type_select = $devClass->show_device_type();
								var_dump($dev_type_select);
                                if (count($dev_type_select)>0) {
                                    foreach ($dev_type_select as $dts) {
                                        // set variable
                                        $dev_type_id   = $dts["type_id"];
                                        $dev_type_name = ucwords(stripslashes($dts["type_name"]));

                                        // if isset new dev type - set selected
                                        if (isset($_SESSION['new_type_id'])) {
                                            if ($_SESSION['new_type_id']==$dev_type_id) {
                                                $type_select  .= "<option value='$dev_type_id' selected>$dev_type_name</option>";
                                            }
                                            else {
                                                $type_select  .= "<option value='$dev_type_id'>$dev_type_name</option>";
                                            }
                                        }
                                        // else
                                        else {
                                            $type_select  .= "<option value='$dev_type_id'>$dev_type_name</option>";
                                        }
                                    }
                                }
                                echo $type_select;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Device Brand</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_brand" id="dev_brand_edit" <?php if (isset($_SESSION["new_dev_brand"])) { echo " value='".$_SESSION["new_dev_brand"]."'"; } ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Device Model</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_model" id="dev_model_edit" <?php if (isset($_SESSION["new_dev_model"])) { echo " value='".$_SESSION["new_dev_model"]."'"; } ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Device Serial</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_serial" id="dev_serial_edit" <?php if (isset($_SESSION["new_dev_serial"])) { echo " value='".$_SESSION["new_dev_serial"]."'"; } ?>>
                            <?php if (isset($device_serial_info)) { echo $device_serial_info; } ?>
                        </div>
						<div class="form-group">
                        <label class="control-label col-sm-3">M2</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_mx2" id="dev_mx2_edit" <?php if (isset($_SESSION["new_dev_m2"])) { echo " value='".$_SESSION["new_dev_m2"]."'"; } ?>>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3">kg</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_kg" id="dev_kg_edit" <?php if (isset($_SESSION["new_dev_kg"])) { echo " value='".$_SESSION["new_dev_kg"]."'"; } ?>>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3">kg</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_mprod" id="dev_mprod_edit" <?php if (isset($_SESSION["new_dev_mprod"])) { echo " value='".$_SESSION["new_dev_mprod"]."'"; } ?>>
                        </div>
                    </div>
					
					
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Device Photo</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="dev_photo" id="dev_photo_edit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Device Description</label>
                        <div class="col-sm-8">
                            <textarea class="form-control tinymce" name="dev_description" id="dev_description_edit"> <?php if (isset($_SESSION["new_dev_description"])) { echo $_SESSION["new_dev_description"]; } ?></textarea>
                        </div>
                    </div>
                    <hr class="dashed">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Status</label>
                        <div class="col-sm-6">
                            <select class="form-control chosen-select" name="dev_status" id="dev_status_edit" data-placeholder="Status">
                                <option value=""></option>
                                <option value="new" <?php if(isset($_SESSION['new_dev_status']) && $_SESSION['new_dev_status']=="new") {echo "selected";} ?>>New</option>
                                <option value="in use" <?php if(isset($_SESSION['new_dev_status']) && $_SESSION['new_dev_status']=="in use") {echo "selected";} ?>>In Use</option>
                                <option value="damaged" <?php if(isset($_SESSION['new_dev_status']) && $_SESSION['new_dev_status']=="damaged") {echo "selected";} ?>>Damaged</option>
                                <option value="repaired" <?php if(isset($_SESSION['new_dev_status']) && $_SESSION['new_dev_status']=="repaired") {echo "selected";} ?>>Repaired</option>
                                <option value="discarded" <?php if(isset($_SESSION['new_dev_status']) && $_SESSION['new_dev_status']=="discarded") {echo "selected";} ?>>Discarded</option>
                            </select> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Location</label>
                        <div class="col-sm-6">
                            <select class="form-control chosen-select" name="location_id" id="location_id_edit" data-placeholder="Location">
                                    <option value=""></option>
                                <?php
                                $location_select = ""; 
                                $location_select = $locClass->show_location();
                                if (count($location_select)>0) {
                                    foreach ($location_select as $ls) {
                                        $location_id     = $ls["location_id"];
                                        $location_name   = stripslashes($ls["location_name"]);

                                        // if isset new location - set selected
                                        if ($_SESSION['new_location_id']) {
                                            if ($_SESSION['new_location_id']==$location_id) {
                                                $location_select .= "<option value='$location_id' selected>$location_name</option>";
                                            }
                                            else {
                                                $location_select .= "<option value='$location_id'>$location_name</option>";
                                            }
                                        }
                                        else {
                                            $location_select .= "<option value='$location_id'>$location_name</option>";
                                        }
                                    }
                                }
                                echo $location_select;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="modal_footer_device_edit">
                    <input type="hidden" name="action" id="action" value="edit_device">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->
<?php 
include("./include/init_chosen.php");

// Unset session
if (isset($_SESSION["new_dev_serial"])) {
    unset($_SESSION['new_type_id'], 
        $_SESSION['new_dev_brand'], 
        $_SESSION['new_dev_model'], 
        $_SESSION['new_dev_serial'], 
        $_SESSION['new_dev_description'], 
		$_SESSION['new_dev_m2'], 
        $_SESSION['new_dev_mx2'],
        $_SESSION['new_dev_kg'], 
        $_SESSION['new_dev_kg1'], 		
        $_SESSION['new_dev_mprod']
    );
}
?>