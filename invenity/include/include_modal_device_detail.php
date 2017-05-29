<div class="modal fade" tabindex="-1" role="dialog" id="modal_dialog_device_detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modal_title_device_detail">Detail</h4>
            </div>
            <div class="modal-body form-horizontal" id="modal_content_device_detail">
                <div class="form-group">
                    <label class="control-label col-sm-3">ID :</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_code"> </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Kategori :</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_type"> </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Nama :</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_brand"> </div>
                </div>
				
                <div class="form-group">
                    <label class="control-label col-sm-3">Kode :</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_serial"> </div>
                </div>
				
                <div class="form-group">
                    <label class="control-label col-sm-3">Ukuran:</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_color"> </div>
                </div>
                
				<div class="form-group">
                    <label class="control-label col-sm-3">M3 Full :</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_model"> </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-sm-3">M3 PROD :</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_mprod"> </div>
                </div>
				
			    <div class="form-group">
                    <label class="control-label col-sm-3">M2 x 2 :</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_mx2"> </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-sm-3">M2 :</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_m2"> </div>
                </div>
				
                <div class="form-group">
                    <label class="control-label col-sm-3">Photo :</label>
                    <div class="col-sm-8 form-control-static" id="photo">
                        
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-sm-3">Harga Umum:</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_description"> </div>
                </div>
                
				<div class="form-group">
                    <label class="control-label col-sm-3">Suplier:</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_cek"> </div>
                </div>
				
				
				
				<div class="form-group">
                    <label class="control-label col-sm-3">Keterangan :</label>
                    <div class="col-sm-8 form-control-static" id="dl_dev_kg"> </div>
                </div>
				
				
                
                <?php if ($setting_location_details=="enable"): ?>
                
                
                <?php endif ?>
            </div>
            <div class="modal-footer" id="modal_footer_device_detail">
                <button type="button" id="btn_close"class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->