//TODO: refaire ce JS une seule extension ou client peut être coché

jQuery('#extensions input:checkbox, #clients input:checkbox').click(function()
	{
		jQuery('#clients input:checkbox').attr('checked', false);
		jQuery('#extensions input:checkbox').attr('checked', false);
		jQuery(this).attr('checked', true);
	});