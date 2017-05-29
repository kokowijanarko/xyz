<div class="modal fade" tabindex="-1" role="dialog" id="modal_dialog_device_type">
    <form class="form-horizontal" name="form_device_type" id="form_device_type" method="post" action="process.php">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal_title_device_type">Add Produk Type</h4>
                </div>
                <div class="modal-body" id="modal_content_device_type">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Type Name</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="type_id" id="type_id" value=""> 
                            <input type="text" class="form-control" name="type_name" id="type_name" maxlength="30" required> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Type Code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="type_code" id="type_code" maxlength="30" required> 
                            <p class="help-block">A code to identify this device type. Usually contains the abbreviation of the name. (Ex : Monitor -> MTR)</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Active</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="active" id="active">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="modal_footer_device_type">
                    <input type="hidden" name="action" id="action" value="add_device_type">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->