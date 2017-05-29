<?php 
    // If form error, show error
    if (isset($_SESSION["new_dev_serial"])) { 
        echo "<script type='text/javascript'>
            jQuery(document).ready(function($) {
                $('#modal_dialog_device').modal('show');
            });
        </script>";
        $device_serial_info = "<span class='text-danger' id='device_serial_info'>Device with serial number : '$_SESSION[new_dev_serial]' is already exists!</span>";
    }
?>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_dialog_device">
    <form class="form-horizontal" name="form_device" id="form_device" method="post" enctype="multipart/form-data" action="process.php">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal_title_device">Data</h4>
                </div>
                <div class="modal-body" id="modal_content_device">
                    <div id="only_edit">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Data Code</label>
                            <div class="col-sm-6">
                                <p class="form-control-static" id="dev_code_view_edit"></p>
                                <input type="hidden" name="dev_code_edit" id="dev_code_edit" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Produk Type</label>
                            <div class="col-sm-6">
                                <p class="form-control-static" id="dev_type_id_edit"></p>
                            </div>
                        </div>
                    </div>

                    <div id="only_add">
                        <div class="form-group">
                            <label class="control-label col-sm-3">ID</label>
                            <div class="col-sm-6">
                                <p class="form-control-static" id="dev_code_view"><?php 
                                $generated_code = $devClass->generate_device_code(); 
                                if (strpos($generated_code, "devtype")!==FALSE) {
                                    $generated_code = str_replace("devtype", "<span id='dynamic_devtype'>devtype</span>", $generated_code);
                                }
                                echo $generated_code;
                                ?></p>
                                <input type="hidden" name="dev_code" id="dev_code" value="<?php echo $devClass->generate_device_code(); ?>">
                                <!-- <p class="help-block">If you assign 'devtype' in device code format, the code will change based on your device type.</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Produk Type</label>
                            <div class="col-sm-6">
                                <select class="form-control chosen-select" name="dev_type_id" id="dev_type_id" data-placeholder="Device Type"required>
                                    <option value=""></option>
                                    <?php
                                    $type_select = ""; 
                                    $dev_type_select = $devClass->show_device_type();
                                    if (count($dev_type_select)>0) {
                                        foreach ($dev_type_select as $dts) {
                                            // set variable
                                            $dev_type_id   = $dts["type_id"];
                                            $dev_type_name = ucwords(stripslashes($dts["type_name"]));

                                            // if isset new dev type - set selected
                                            if (isset($_SESSION['new_type_id'])) {
                                                if ($_SESSION['new_type_id']==$dev_type_id) {
                                                    $type_select  .= "<option value='$dev_type_id' type_code='$dts[type_code]' selected>$dev_type_name</option>";
                                                }
                                                else {
                                                    $type_select  .= "<option value='$dev_type_id' type_code='$dts[type_code]'>$dev_type_name</option>";
                                                }
                                                unset($_SESSION['new_type_id']);
                                            }
                                            // else
                                            else {
                                                $type_select  .= "<option value='$dev_type_id' type_code='$dts[type_code]'>$dev_type_name</option>";
                                            }
                                        }
                                    }
                                    echo $type_select;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                         <label class="control-label col-sm-3">Nama</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" name="dev_brand" id="dev_brand" <?php if (isset($_SESSION["new_dev_brand"])) { echo " value='".$_SESSION["new_dev_brand"]."'"; unset($_SESSION['new_dev_brand']); } ?> required>
                                <div class="input-group-addon">*</div>
                            </div>
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label class="control-label col-sm-3">Kode</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" name="dev_serial" id="dev_serial" <?php if (isset($_SESSION["new_dev_serial"])) { echo " value='".$_SESSION["new_dev_serial"]."'"; unset($_SESSION['new_dev_serial']); } ?> required>
                                <div class="input-group-addon">*</div>
                            </div>
                            <?php if (isset($device_serial_info)) { echo $device_serial_info; } ?>
                        </div>
                    </div>
					
					 
                    <div class="form-group">
                        <label class="control-label col-sm-3">M3 Full</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_model" id="dev_model" <?php if (isset($_SESSION["new_dev_model"])) { echo " value='".$_SESSION["new_dev_model"]."'"; unset($_SESSION['new_dev_model']); } ?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Ukuran</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_color" id="dev_color" <?php if (isset($_SESSION["new_dev_color"])) { echo " value='".$_SESSION["new_dev_color"]."'"; unset($_SESSION['new_dev_color']); } ?>>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3">M2</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_m2" id="dev_m2" <?php if (isset($_SESSION["new_m2"])) { echo " value='".$_SESSION["new_m2"]."'"; unset($_SESSION['new_m2']); } ?>>
                        </div>
                    </div>
                    
					
					<div class="form-group">
                        <label class="control-label col-sm-3">M2 X 2</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_mx2" id="dev_mx2" <?php if (isset($_SESSION["new_mx2"])) { echo " value='".$_SESSION["new_mx2"]."'"; unset($_SESSION['new_mx2']); } ?>>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3">M3 PROD</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_mprod" id="dev_mprod" <?php if (isset($_SESSION["new_mprod"])) { echo " value='".$_SESSION["new_mprod"]."'"; unset($_SESSION['new_mprod']); } ?>>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3">Keterangan</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_kg" id="dev_kg" <?php if (isset($_SESSION["new_kg"])) { echo " value='".$_SESSION["new_kg"]."'"; unset($_SESSION['new_kg']); } ?>>
                        </div>
                    </div>
                   

                   <hr class="dashed">

                    <div class="form-group">
                        <label class="control-label col-sm-3">Photo</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="dev_photo[]" id="dev_photo" multiple>
                            <p class="help-block" id="photo_info">Leave empty if you don't want to change the photo.</p>
                        </div>
                    </div>
					<div class="form-group">
						<label class="control-label col-sm-3"></label>
						<div class="col-sm-6" id="photos">
							
						</div>
					</div>
					
					<hr class="dashed">
					
					<div class="form-group">
                        <label class="control-label col-sm-3">Files</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="dev_files[]" id="dev_files" multiple>
                            <p class="help-block" id="files_info">Leave empty if you don't want to change the Files.</p>
							
                        </div>
                    </div>
					<div class="form-group">
						<label class="control-label col-sm-3"></label>
						<div class="col-sm-6" id="files">
							
						</div>
					</div>
					<hr class="dashed">

                    <div class="form-group">
                        <label class="control-label col-sm-3">Harga Umum</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="dev_description" id="dev_description"> <?php if (isset($_SESSION["new_dev_description"])) { echo $_SESSION["new_dev_description"]; unset($_SESSION['new_dev_description']); } ?></textarea>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3">Suplier</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="dev_cek" id="dev_cek" <?php if (isset($_SESSION["new_cek"])) { echo " value='".$_SESSION["new_cek"]."'"; unset($_SESSION['new_cek']); } ?>>
                        </div>
                    </div>
                    
					
					<hr class="dashed">
						<div class="deleted"></div>
                    <hr class="dashed">
					
				
                <div class="modal-footer" id="modal_footer_device">
                    <p class="pull-left">* Required fields</p>
                    <input type="hidden" name="dev_id" id="dev_id" value="">
                    <input type="hidden" name="action" id="action" value="add_device">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->
<script type="text/javascript">
    jQuery(document).ready(function($) {
		//cek jumlah foto ketika memilih file
		$("#dev_photo").change(function(){
			var $fileUpload = $("#dev_photo");			
			if (parseInt($fileUpload.get(0).files.length)>4){
			 alert("You can only upload a maximum of 4 files");
			}
			
		});
		//cek jumlah foto ketika clik submit file
		$("input[type='submit']").click(function(){
			var $fileUpload = $("#dev_photo");
			if (parseInt($fileUpload.get(0).files.length)>4){
			 alert("You can only upload a maximum of 4 files");
			}
		});  
		//cek jumlah file ketika clik submit file
		$("#dev_files").change(function(){
			var $fileUpload = $("#dev_files");			
			if (parseInt($fileUpload.get(0).files.length)>3){
			 alert("You can only upload a maximum of 3 files");
			}
			
		});
		//cek jumlah file ketika clik submit file
		$("input[type='submit']").click(function(){
			var $fileUpload = $("#dev_files");
			if (parseInt($fileUpload.get(0).files.length)>3){
			 alert("You can only upload a maximum of 3 files");
			}
		});
		
		
        $("#dev_type_id").on('change', function(event) {
            var devtype = $(this).find('option:selected').attr('type_code');
            $("#dynamic_devtype").html(devtype);

            // trim the span, set the value
            var dev_code = $("#dev_code_view").html().replace('<span id="dynamic_devtype">','');
            var dev_code = dev_code.replace("</span>","");
            $("#dev_code").val(dev_code);
        });
    });
</script>
<?php 
include("./include/init_chosen.php");
?>