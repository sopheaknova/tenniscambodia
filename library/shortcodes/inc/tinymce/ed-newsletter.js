/**
 * Newsletter Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.newsletter', {
        init : function( ed, url ) {
             ed.addButton( 'newsletter', {
                title : 'Insert Newsletter or Bulletin',
                image : url + '/ed-icons/insert_posts.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Newsletter or Bulletin Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-newsletter-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'newsletter', tinymce.plugins.newsletter );
	jQuery( function() {
		var form = jQuery( '<div id="sc-newsletter-form"><table id="sc-newsletter-table" class="form-table">\
							<tr>\
							<th><label for="sc-post-num">Post per page</label></th>\
							<td><input type="text" name="sc-post-num" id="sc-post-num" value="-1" /><small> (-1 show all)</small></td>\
							</tr>\
							<tr>\
							<th><label for="sc-cols">Post columns</label></th>\
							<td><input type="text" name="sc-post-cols" id="sc-post-cols" value="2" /><small> (max. 4)</small></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-newsletter-submit" class="button-primary" value="Insert Newsletter" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-newsletter-submit' ).click( function() {
			var post_num = table.find( '#sc-post-num' ).val(),
			cols = table.find( '#sc-post-cols' ).val(),
			shortcode = '[newsletter post_num="' + post_num + '" cols="' + cols + '"]';

			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
 } )();