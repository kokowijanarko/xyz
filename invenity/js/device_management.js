/**
*	Device Management js
*	
*	@author 	Noerman Agustiyan
* 	@version 	0.2
*/
jQuery(document).ready(function($) {
	$('#btn_close').click(function(){
		$('#photo').empty();
	})
	
	$('.delete').click(function(){
		console.log('ceking aja');
		confirm('Apakah yakin menghapus gambar ini?', function(){
			commentContainer.slideUp('slow', function() {$(this).remove();});
		})
	})

});

	/**
	*	Show device detail
	*	
	*	@param 		device_id
	*	
	*/
	function show_device_detail (device_id) {
		$('#photo').empty();
		$("#dl_dev_code").html($("#l_dev_code_"+device_id).val());
		$("#dl_dev_type").html($("#l_dev_type_name_"+device_id).val());
		$("#dl_dev_brand").html($("#l_dev_brand_"+device_id).val());
		$("#dl_dev_model").html($("#l_dev_model_"+device_id).val());
		$("#dl_dev_color").html($("#l_dev_color_"+device_id).val());
		$("#dl_dev_m2").html($("#l_dev_m2_"+device_id).val());
		$("#dl_dev_kg").html($("#l_dev_kg_"+device_id).val());
		$("#dl_dev_kg1").html($("#l_dev_kg1_"+device_id).val());
		$("#dl_dev_cek").html($("#l_dev_cek_"+device_id).val());
		$("#dl_dev_mx2").html($("#l_dev_mx2_"+device_id).val());
		$("#dl_dev_mprod").html($("#l_dev_mprod_"+device_id).val());
		$("#dl_dev_serial").html($("#l_dev_serial_"+device_id).val());
		
		var photo_count = $("#l_dev_count_images_"+device_id).val();
		console.log(photo_count);
		for(i=0; i < photo_count; i++){
			var img_src = $("#l_dev_photo_"+device_id+'_'+i).val();
			var img_src_real = $("#l_dev_photo_real_"+device_id+'_'+i).val();
			console.log(img_src);
			if($("#l_dev_photo_"+device_id+'_'+i).attr('class') == 'photo'){
				var photo = '<a class="fancybox" rel="group" href="'+ img_src_real +'" id="dl_dev_photo_real_' + i 
				+ '"><img src="'+ img_src +'" class="img-thumbnail" alt="Device Image" id="dl_dev_photo'+ i 
				+ '" style="max-height:180px"></a><p class="help-block">Click the image to enlarge.</p>';
			}else{			
				var file_name = img_src.split('/');
				// console.log(file_name[4]);
				var photo = '<a class="fancybox" rel="group" href ="'+img_src
				+'" >'+file_name[4]+'</a><p class="help-block">Click to download File.</p>';
			}
			
			$('#photo').append(photo);
		}
		
		// $("#dl_dev_photo_real").prop('href', $("#l_dev_photo_real_"+device_id).val());
		// $("#dl_dev_photo_real").prop('title', $("#l_dev_photo_description_"+device_id).val());
		
		// $("#dl_dev_photo").prop('src', $("#l_dev_photo_"+device_id).val());
		
		$("#dl_dev_description").html($("#l_dev_description_"+device_id).val());
		$("#dl_dev_status").html($("#l_dev_status_"+device_id).val());
		$("#dl_dev_location").html($("#l_dev_location_name_"+device_id).val());
		$("#dl_dev_place").html($("#l_place_name_"+device_id).val());
		$("#dl_dev_building").html($("#l_building_name_"+device_id).val());
		$("#dl_dev_floor").html($("#l_floor_name_"+device_id).val());
		
		$("#modal_dialog_device_detail").modal("show");
	}
	

	/**
	*	Show  add device type
	*
	*/
	function show_add_device_type () {
		$("#type_name").val("");
		$("#active").val("yes");
		$("#action").val("add_device_type");
		$("#modal_dialog_device_type").modal("show");
	}


	/**
	*	Deactive Device Type
	*
	*	@param 		type_id
	*	@param 		type_name
	*	@param 		status
	*
	*/
	function device_type_change_status (type_id, type_name, status) {
		// If status yes, activate. If status no, deactivate
		if (status=="yes") {
			confirm_info = "<strong>activate</strong>";
		}
		else if (status=="no") {
			confirm_info = "<strong>deactive</strong>";
		}
		// Set modal value and show it!
		$("#modal_form").attr('action', './process.php');
		$("#modal_title").html("Confirmation");
		$("#modal_content").html("<p class='text-center'>Device Type Name : "+type_name+"<br>Sure want to "+confirm_info+" this device type?</p><input type='hidden' name='type_id' value='"+type_id+"'><input type='hidden' name='status' value='"+status+"'><input type='hidden' name='action' value='device_type_change_status'>");
		$("#modal_footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button> <button type='submit' class='btn btn-primary'>Yes</button>");
		$("#modal_dialog").modal("show");
	}


	/**
	* 	Show Add device
	*
	*/
	function show_add_device () {
		$("#only_edit").hide();
		$("#only_add").show();
		$("#photo_info").hide();

		$("#dev_id").val("");
		$("#dev_type_id").val("");
		$("#dev_brand").val("");
		$("#dev_model").val("");
		$("#dev_color").val("");
		$("#dev_serial").val("");
		$("#dev_photo").val("");
		tinyMCE.get('dev_description').setContent("");
		$("#dev_status").val("new");
		$("#location_id").val("");
		$("#dev_m2").val("");
		$("#dev_mx2").val("");
		$("#dev_cek").val("");
		$("#dev_mprod").val("");
		$("#dev_kg1").val("");
		$('select').trigger("chosen:updated");
		$("#action").val("add_device");
		$("#modal_title_device").html("Add Device");
		$("#modal_dialog_device").modal("show");
	}


	/**
	*	Show Edit device
	*
	*/
	function show_edit_device (device_id) {
		$('#photos').empty();
		$('#files').empty();
		
		$("#only_edit").show();
		$("#only_add").hide();
		$("#photo_info").show();

		$("#dev_id").val($("#l_dev_id_"+device_id).val());
		$("#dev_code_view_edit").html($("#l_dev_code_"+device_id).val());
		$("#dev_code_edit").val($("#l_dev_code_"+device_id).val());
		$("#dev_type_id_edit").html($("#l_type_id_"+device_id).val());
		$("#dev_type_id").val($("#l_type_id_"+device_id).val());
		$("#dev_brand").val($("#l_dev_brand_"+device_id).val());
		$("#dev_model").val($("#l_dev_model_"+device_id).val());
		$("#dev_color").val($("#l_dev_color_"+device_id).val());
		$("#dev_serial").val($("#l_dev_serial_"+device_id).val());
		$("#dev_photo").val("");
		$("#dev_color").val($("#l_dev_color_"+device_id).val());
		// $("#dev_photo_edit").prop('src', $("#l_dev_photo_"+device_id).val());
		tinyMCE.get('dev_description').setContent($("#l_dev_description_"+device_id).val());
		$("#dev_status").val($("#l_dev_status_"+device_id).val());
		$("#dev_cek").val($("#l_dev_cek_"+device_id).val());
		$("#location_id").val($("#l_dev_location_id_"+device_id).val());
		$("#dev_m2").val($("#l_dev_m2_"+device_id).val());
		$("#dev_mx2").val($("#l_dev_mx2_"+device_id).val());
		$("#dev_kg1").val($("#l_dev_kg1_"+device_id).val());
		$("#dev_kg").val($("#l_dev_kg_"+device_id).val());
		$("#dev_serial").val($("#l_dev_serial_"+device_id).val());
		$('select').trigger("chosen:updated");
		$("#action").val("edit_device");
		$("#modal_title_device").html("Edit Device");
		
		var photo_count = $("#l_dev_count_images_"+device_id).val();
		// console.log(photo_count);
		for(i=0; i < photo_count; i++){
			var img_src = $("#l_dev_photo_"+device_id+'_'+i).val();
			var img_src_real = $("#l_dev_photo_real_"+device_id+'_'+i).val();
			// console.log(img_src);
			var id = 'attachment_' + i;
			if($("#l_dev_photo_"+device_id+'_'+i).attr('class') == 'photo'){
				var file_name = img_src_real.split('/');				
				var photo = '<div id="'+id+'" ><a class="fancybox" rel="group" href="'+ img_src_real +'" id="dl_dev_photo_real_' + i 
				+ '"><img src="'+ img_src +'" class="img-thumbnail" alt="Device Image" id="dl_dev_photo'+ i 
				+ '" style="max-height:180px"></a><button type="button" onclick="deleteFile('+id+')" class="delete">Delete</button><p class="help-block"></p>'+
				'<input type="hidden" name="dev_photo[]" value="'+file_name[4]+'"></div>';
				$('#photos').append(photo);
			}else{			
				var file_name = img_src.split('/');
				var photo = '<div id="'+id+'"><a class="fancybox" rel="group" href ="'+img_src
				+'" >'+file_name[4]+'</a><button type="button" class="delete" onclick="deleteFile('+id+')">Delete</button><p class="help-block"></p>'+
				'<input type="hidden" name="dev_files[]" value="'+file_name[4]+'"></div>';
				$('#files').append(photo);
			}
		}
		$("#modal_dialog_device").modal("show");
	}
	
	function deleteFile(id){
		var x = '#' + id.getAttribute('id');
		console.log(id.lastChild.value);
		var r = confirm('Apakah yakin menghapus gambar ini?');
		if (r == true) {
			$(x).remove();
		}
			var deleted= '<input type="text" name="deleted[]" value="'+id.lastChild.value+'">';
			$('.deleted').append(deleted);
	}
	
	
	
	