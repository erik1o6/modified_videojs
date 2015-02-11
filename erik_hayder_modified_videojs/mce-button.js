(function() {
	tinymce.create('tinymce.plugins.VideoJS', {
		init: function(ed, url) {
			ed.addButton('videojs', {
				title: 'Insert HTML5 Video',
				image: url+'/video-js.png',
				onclick: function() {
					var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 124;
					tb_show('Insert Video.js HTML5 Video', '#TB_inline?inlineId=videoJSpopup&width=' + W + '&height=' + H);
					jQuery("#TB_window").animate({
						height: H + 40 + 'px'
					});
					return false;
				}
			});
		},
		createControl: function(n, cm) {
			return null;
		},
		getInfo: function() {
			return {
				longname: 'VideoJS for WordPress',
				author: 'Dustin Lammiman',
				authorurl: 'http://www.nosecreekweb.ca/',
				infourl: 'http://blog.nosecreekweb.ca/',
				version: '1.0'
			};
		}
	});
	tinymce.PluginManager.add('videojs', tinymce.plugins.VideoJS);
	
	jQuery(function() {
		//get the checkbox defaults
		var autoplay_default = jQuery('#videojs-autoplay-default').val();
		if ( autoplay_default == 'on' )
			autoplay_checked = ' checked';
		else
			autoplay_checked = '';
		
		var preload_default = jQuery('#videojs-preload-default').val();
		if ( preload_default == 'on' )
			preload_checked = ' checked';
		else
			preload_checked = 'checked';

		
		var form = jQuery('<div id="videoJSpopup">\
		<table id="videoJStable" class="form-table">\
			<tr>\
				<th><label for="videojs-mp4">MP4 Source SD</label></th>\
				<td><input type="text" name="videojs-mp4" id="videojs-mp4"><br>\
				<small>The location of the h.264/MP4 source for the video.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-mp4_hd">MP4 Source HD</label></th>\
				<td><input type="text" name="videojs-mp4_hd" id="videojs-mp4_hd"><br>\
				<small>The location of the h.264/MP4 source for the video.</small></td>\
			</tr>\
<!--			<tr>\
				<th><label for="videojs-mp4_shd">MP4 Source 1080p</label></th>\
				<td><input type="text" name="videojs-mp4_shd" id="videojs-mp4_shd"><br>\
				<small>The location of the h.264/MP4 source for the video.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-webm">WebM Source 480p</label></th>\
				<td><input type="text" name="videojs-webm" id="videojs-webm"><br>\
				<small>The location of the VP8/WebM source for the video.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-webm_hd">WebM Source 720p</label></th>\
				<td><input type="text" name="videojs-webm_hd" id="videojs-webm_hd"><br>\
				<small>The location of the VP8/WebM source for the video.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-webm_shd">WebM Source 1080p</label></th>\
				<td><input type="text" name="videojs-webm_shd" id="videojs-webm_shd"><br>\
				<small>The location of the VP8/WebM source for the video.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-ogg">OGG Source 480p</label></th>\
				<td><input type="text" name="videojs-ogg" id="videojs-ogg"><br>\
				<small>The location of the Theora/Ogg source for the video.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-ogg_hd">OGG Source 720p</label></th>\
				<td><input type="text" name="videojs-ogg_hd" id="videojs-ogg_hd"><br>\
				<small>The location of the Theora/Ogg source for the video.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-ogg_shd">OGG Source 1080p</label></th>\
				<td><input type="text" name="videojs-ogg_shd" id="videojs-ogg_shd"><br>\
				<small>The location of the Theora/Ogg source for the video.</small></td>\
			</tr>\
//-->			<tr>\
				<th><label for="videojs-advertisementvideo">Ad MP4 Source ONLY</label></th>\
				<td><input type="text" name="videojs-advertisementvideo" id="videojs-advertisementvideo"><br>\
				<small>The location of the advertisement video source for the ad.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-adlink">Ad url link</label></th>\
				<td><input type="text" name="videojs-adlink" id="videojs-adlink"><br>\
				<small>The location of the advertisement link.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-youtube">YouTube Url</label></th>\
				<td><input type="text" name="videojs-youtube" id="videojs-youtube"><br>\
				<small>The location of the YouTube source for the video.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-poster">Poster Image</label></th>\
				<td><input type="text" name="videojs-poster" id="videojs-poster"><br>\
				<small>The location of the poster frame for the video.</small></td>\
			</tr>\
<!--			<tr>\
				<th><label for="videojs-width">Width</label></th>\
				<td><input type="text" name="videojs-width" id="videojs-width"><br>\
				<small>The width of the video.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-height">Height</label></th>\
				<td><input type="text" name="videojs-height" id="videojs-height"><br>\
				<small>The height of the video.</small></td>\
//-->			</tr>\
<!--			<tr>\
			<th><label for="videojs-preload">Preload</label></th>\
//-->			<td><input id="videojs-preload" name="videojs-preload" type="hidden" checked /></td>\
<!--			</tr>\
//-->			<tr>\
				<th><label for="videojs-autoplay">Autoplay</label></th>\
				<td><input id="videojs-autoplay" name="videojs-autoplay" type="checkbox"'+autoplay_checked+' /></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-loop">Loop</label></th>\
				<td><input id="videojs-loop" name="videojs-loop" type="checkbox" />\
				<small>DO NOT enable loop if ads are enabled.</small></td>\
			</tr>\
<!--			<tr>\
				<th><label for="videojs-controls">Show Player Controls</label></th>\
				<td><input id="videojs-controls" name="videojs-controls" type="checkbox" checked /></td>\
			</tr>\
//-->				<tr>\
				<th><label for="videojs-id">ID</label></th>\
				<td><input type="text" name="videojs-id" id="videojs-id"><br>\
				<small>Add a custom ID to your video player.</small></td>\
			</tr>\
			<tr>\
				<th><label for="videojs-class">Class</label></th>\
				<td><input type="text" name="videojs-class" id="videojs-class"><br>\
				<small>Add a custom class to your player. Use full for floating the video player using \'alignleft\' or \'alignright\'.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
				<input type="button" id="videojs-submit" class="button-primary" value="Insert Video" name="submit" />\
		</p>\
		</div>');
		var table = form.find('table');
		form.appendTo('body').hide();

		
		form.find('#videojs-submit').click(function(){
			
			var shortcode = '[videojs';
			
			//text options
			var options = { 
				'mp4'		: '',
				'mp4_hd'	: '',
/*				'mp4_shd'	: '',
				'webm'		: '',
				'webm_hd'	: '',
				'webm_shd'	: '',
				'ogg'		: '',
				'ogg_hd'	: '',
				'ogg_shd'	: '',
*/
				'advertisementvideo'	: '',
				'adlink'	: '',
				'poster'	: '',
				'youtube'	: '',
/*
				'width'		: '',
				'height'	: '',
*/
				'id'		: '',
				'class'		: ''
			};
			
			for(var index in options) {
				var value = table.find('#videojs-' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			//checkbox options
			options = { 
				'autoplay' : autoplay_default,
				'preload'  : 'off',
				'loop'     : '',
				'controls' : ''
			};
			
			for(var index in options) {
				var value = table.find('#videojs-' + index).is(':checked');

				if(index == 'preload')
					value = true;
				
				if ( value == true )
					checked = 'on';
				else
					checked = '';

				// attaches the attribute to the shortcode only if it's different from the default value
				if ( checked !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			//close the shortcode
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();