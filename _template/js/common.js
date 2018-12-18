// JavaScript Document

function setfocus(textbox_id) {
	if(document.getElementById(textbox_id) != undefined)
		document.getElementById(textbox_id).focus();	
}


function search_record ( ) {
	document.getElementById('hdnmode').value = 'search';
	document.getElementById('frm').submit();
}

function set_action ( straction ) {
	if ( straction == 'delete' ) {
		if ( document.getElementById('chkdelete') != undefined ) {
			boolvalid_delete = false;
			if ( document.frm.chkdelete.length == undefined ) {
				if ( document.getElementById('chkdelete').checked == true ) {
					boolvalid_delete = true;	
				}
			}
			else {
				inttotal_record = document.frm.chkdelete.length;
				for ( intcounter = 0; intcounter < inttotal_record; intcounter++ ) {
					if ( document.frm.chkdelete[intcounter].checked == true ) {
						boolvalid_delete = true;
						break;
					}	
				}
			}
			if ( boolvalid_delete == false ) {
				alert('Please select at least one record to delete.');
				return false;
			}
		}
		if ( confirm('Are you sure to delete select record(s)?') == false ){
			return false;	
		}
	}
	document.getElementById('hdnmode').value = straction;
	document.getElementById('frm').submit();
}

function trim ( field_value ) {
	return field_value.split(' ').join('');	
}

function check_file_extension ( file_control, extensions ) {
	boolreturn_val = false;
	var strfile = file_control.value;
	if ( strfile != '' ) {
		var strextension = strfile.substr(strfile.lastIndexOf('.')+1).toLowerCase();
		if ( extensions != '' ) {
			arextension = extensions.split(',');
			for ( intcounter = 0; intcounter < arextension.length; intcounter++ ) {
				if ( strextension == arextension[intcounter]) {
					boolreturn_val = true;
					break;
				}
			}
		}
	}
	return boolreturn_val;
}

function select_checkboxes ( status ) {
	if ( document.frm.chkdelete != undefined ) {
		if ( document.frm.chkdelete.length == undefined ) {
			document.frm.chkdelete.checked = status;
		}
		else {
			var total_checkboxes = document.frm.chkdelete.length;
			for ( var i = 0; i < total_checkboxes; i++ ) {
				document.frm.chkdelete[i].checked = status;
			}
		}	
	}
}


