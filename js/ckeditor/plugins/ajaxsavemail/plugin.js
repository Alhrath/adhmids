﻿/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
* 
* // Edited by Jonas boiziau for ajax save 
*/

/**
 * @fileSave plugin.
 */

(function()
{
	var saveCmd =
	{
		modes : { wysiwyg:1, source:1 },

		exec : function( editor )
		{
			var $form = editor.element.$.form;

			if ( $form )
			{
				try
				{
					editor.updateElement();
          setReq('mailedition', true, false, 'reqtype', true, false, 'pagech_id', true, false, 'object', true, false, 'replyto', true, false);
				}
				catch( e )
				{
					alert(e);
				}
			}
		}
	}

	var pluginName = 'ajaxsavemail';

	CKEDITOR.plugins.add( pluginName,
	{
		init : function( editor )
		{
			var command = editor.addCommand( pluginName, saveCmd );
			command.modes = { wysiwyg : !!( editor.element.$.form ) };

			editor.ui.addButton( 'AjaxSaveMail',
				{
					label : editor.lang.save,
					command : pluginName,
          				icon: this.path + 'ajaxsave.png'

				});
		}
	});
})();
