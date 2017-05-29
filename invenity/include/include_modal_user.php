<?php 
    // If form error, show error
    if (isset($_SESSION["new_first_name"])) { 
        echo "<script type='text/javascript'>
            jQuery(document).ready(function($) {
                $('#modal_dialog_user').modal('show');
            });
        </script>";
        $username_info = "<span class='text-danger' id='username_info'>Username '$_SESSION[new_username]' is already taken!</span>";
    }
?>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_dialog_user">
    <form name="form_user" class="form-horizontal validetta" enctype="multipart/form-data" id="form_user" method="post" action="process.php" autocomplete="off">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal_title_user"></h4>
                </div>
                <div class="modal-body" id="modal_content_user">
                    <legend>User Informations</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="first_name">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" data-validetta="required" <?php if (isset($_SESSION["new_first_name"])) { echo " value='".$_SESSION["new_first_name"]."'"; } ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="last_name">Last Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" <?php if (isset($_SESSION["new_last_name"])) { echo " value='".$_SESSION["new_last_name"]."'"; } ?>> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="username">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" data-validetta="required">
                            <span class="help-block text-danger">This username cannot be changed after you save it.</span>
                            <?php if (isset($username_info)) { echo $username_info; } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="password">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" data-validetta="required" <?php if (isset($_SESSION["new_password"])) { echo " value='".$_SESSION["new_password"]."'"; } ?>> 
                            <label class="text-muted"><input id="show_password" type="checkbox"> Show password</label>
                        </div>
                    </div>
                    <hr class="dashed">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="active">Active</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="active" id="active">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="photo">User Photo</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="photo" id="photo"> 
                            <span class="help-block">Max file size 2 Mb. Jpg, png and gif. (Optional)</span>
                        </div>
                    </div>

                    <legend>Additional Privileges</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-3"> </label>
                        <div class="col-sm-9">
                            <?php echo $userclass->user_privileges(); ?>
                        </div>
                    </div>
                </div>
                <hr class="dashed" />
                <div class="modal-footer" id="modal_footer_user">
                    <input type="hidden" name="level" id="level" value="user">
                    <input type="hidden" name="action" id="action" value="add_user">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->
<?php 
if (isset($_SESSION["new_first_name"])) {
    unset($_SESSION["new_first_name"]);
    unset($_SESSION["new_last_name"]);
    unset($_SESSION["new_password"]);
    unset($_SESSION["new_username"]);
}
?>