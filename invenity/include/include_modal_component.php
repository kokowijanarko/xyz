<div class="modal fade" tabindex="-1" role="dialog" id="modal_dialog_component">
    <form class="form-horizontal" name="form_component" id="form_component" method="post" action="process.php">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal_title_component">Add New Component</h4>
                </div>
                <div class="modal-body" id="modal_content_component">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Component Name</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="component_id" id="component_id" value=""> 
                            <input type="text" class="form-control" name="component_name" id="component_name" required> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Component Page</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="component_page" id="component_page" required> 
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
                <div class="modal-footer" id="modal_footer_component">
                    <input type="hidden" name="action" id="action" value="add_component">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->