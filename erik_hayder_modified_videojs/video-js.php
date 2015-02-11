<?php

if ( !(wp_is_mobile()) ) {

/**

 * @package Video.js

 * @version 4.11.2

 */

/*

Plugin Name: Modified version of Video.js - HTML5 Video Player for WordPress

Plugin URI: http://sivarmunchies.com/

Description: Self-hosted responsive HTML5 video for WordPress, built on the widely used Video.js HTML5 video player library. Allows you to embed video in your post or page using HTML5 with Flash fallback support for non-HTML5 browsers. Original authors: Steve Heffernan & Dustin Lammiman.

Author: <a href="http://www.hshar.org">Hayder Sharhan</a>, <a href="http://sivarmunchies.com">Erik Arfvidson</a>

Version: 1.0

*/




$plugin_dir = plugin_dir_path( __FILE__ );





/* The options page */

include_once($plugin_dir . 'admin.php');





/* Useful Functions */

include_once($plugin_dir . 'lib.php');





/* Register the scripts and enqueue css files */

function register_videojs(){

	$options = get_option('videojs_options');

	

	wp_register_style( 'videojs-plugin', plugins_url( 'plugin-styles.css' , __FILE__ ) );

	wp_enqueue_style( 'videojs-plugin' );

	

	/* if($options['videojs_cdn'] == 'on') { //use the cdn hosted version

		wp_register_script( 'videojs', '//vjs.zencdn.net/4.11/video.js' );

		wp_register_style( 'videojs', '//vjs.zencdn.net/4.11/video-js.css' );

		wp_enqueue_style( 'videojs' );

	} else { */

		wp_register_script( 'videojs', plugins_url( 'video-js/video.js' , __FILE__ ) );

		wp_register_style( 'videojs', plugins_url( 'video-js/video-js.css' , __FILE__ ) );

		wp_enqueue_style( 'videojs' );

	// }

	

	wp_register_script( 'videojs-youtube', plugins_url( 'video-js/vjs.youtube.js' , __FILE__ ) );

}

add_action( 'wp_enqueue_scripts', 'register_videojs' );





/* Include the scripts before </body> */

function add_videojs_header(){

/*

	wp_enqueue_script( 'videojs' );

	wp_enqueue_script( 'videojs-youtube' );

	wp_enqueue_script( 'video-js.ads' );

	wp_enqueue_script( 'video-js.preroll' );*/

}





/* Include custom color styles in the site header */

function videojs_custom_colors() {

	$options = get_option('videojs_options');

	

	if($options['videojs_color_one'] != "#ccc" || $options['videojs_color_two'] != "#66A8CC" || $options['videojs_color_three'] != "#000") { //If custom colors are used

		$color3 = vjs_hex2RGB($options['videojs_color_three'], true); //Background color is rgba

		echo "

	<style type='text/css'>

		.vjs-default-skin { color: " . $options['videojs_color_one'] . " }

		.vjs-default-skin .vjs-play-progress, .vjs-default-skin .vjs-volume-level { background-color: " . $options['videojs_color_two'] . " }

		.vjs-default-skin .vjs-control-bar, .vjs-default-skin .vjs-big-play-button { background: rgba(" . $color3 . ",0.7) }

		.vjs-default-skin .vjs-slider { background: rgba(" . $color3 . ",0.2333333333333333) }

	</style>

		";

	}

}

add_action( 'wp_head', 'videojs_custom_colors' );





/* Prevent mixed content warnings for the self-hosted version */

function add_videojs_swf(){

	$options = get_option('videojs_options');

	if($options['videojs_cdn'] != 'on') {

		echo '

		<script type="text/javascript">

			if(typeof videojs != "undefined") {

				videojs.options.flash.swf = "'. plugins_url( 'videojs/video-js.swf' , __FILE__ ) .'";

			}

			document.createElement("video");document.createElement("audio");document.createElement("track");

		</script>

		';

	} else {

		echo '

		<script type="text/javascript"> document.createElement("video");document.createElement("audio");document.createElement("track"); </script>

		';

	}

}

add_action('wp_head','add_videojs_swf');





/* The [video] or [videojs] shortcode */

function video_shortcode($atts, $content=null){

	add_videojs_header();

	

	$options = get_option('videojs_options'); //load the defaults

	

	extract(shortcode_atts(array(

		'mp4' => '',

		'mp4_hd' => '',

		'mp4_shd' => '',

		'webm' => '',

		'webm_hd' => '',

		'webm_shd' => '',

		'ogg' => '',

		'ogg_hd' => '',

		'ogg_shd' => '',

		'advertisementvideo' => '',

		'adlink' => '',

		'youtube' => '',

		'poster' => '',

		'width' => $options['videojs_width'],

		'height' => $options['videojs_height'],

		'preload' => $options['videojs_preload'],

		'autoplay' => $options['videojs_autoplay'],

		'loop' => '',

		'controls' => '',

		'id' => '',

		'class' => '',

		'muted' => ''

	), $atts));



	$dataSetup = array();

	// ID is required for multiple videos to work

	if ($id == '')

		$id = 'example_video_id_'.rand();

	// MP4 Source Supplied

	if ($mp4){

		$mp4_source_sd = '<source src="'.$mp4.'" type=\'video/mp4\' data-res="SD"/>';

	}

	else	{

		$mp4_source_sd = '';

		}

	if ($mp4_hd) 

		$mp4_source_720hd = '<source src="'.$mp4_hd.'" type=\'video/mp4\' data-res="HD"/>';

	else

		$mp4_source_720hd = '';

	if ($mp4_shd) 

		$mp4_source_1080hd = '<source src="'.$mp4_shd.'" type=\'video/mp4\' data-res="1080"/>';

	else

		$mp4_source_1080hd = '';



	// WebM Source Supplied add data res

	if ($webm)

		$webm_source_sd = '<source src="'.$webm.'" type=\'video/webm; codecs="vp8, vorbis"\' />';

	else

		$webm_source_sd = '';

	if ($webm_hd)

		$webm_source_720hd = '<source src="'.$webm_hd.'" type=\'video/webm; codecs="vp8, vorbis"\' />';

	else

		$webm_source_720hd = '';

	if ($webm_shd)

		$webm_source_1080hd = '<source src="'.$webm_shd.'" type=\'video/webm; codecs="vp8, vorbis"\' />';

	else

		$webm_source_1080hd = '';

	// Ogg source supplied

	if ($ogg)

		$ogg_source_sd = '<source src="'.$ogg.'" type=\'video/ogg; codecs="theora, vorbis"\' />';

	else

		$ogg_source_sd = '';

	if ($ogg_hd)

		$ogg_source_720hd = '<source src="'.$ogg_hd.'" type=\'video/ogg; codecs="theora, vorbis"\' />';

	else

		$ogg_source_720hd = '';

	if ($ogg_shd)

		$ogg_source_1080hd = '<source src="'.$ogg_shd.'" type=\'video/ogg; codecs="theora, vorbis"\' />';

	else

		$ogg_source_1080hd = '';

		

	if ($youtube) {

		$dataSetup['forceSSL'] = 'true';

		$dataSetup['techOrder'] = array("youtube");

		$dataSetup['src'] = $youtube;

	}

	// Poster image supplied

	if ($poster)

		$poster_attribute = ' poster="'.$poster.'"';

	else

		$poster_attribute = '';

	

	// Preload the video?

	if ($preload == "auto" || $preload == "true" || $preload == "on")

		$preload_attribute = ' preload="auto"';

	elseif ($preload == "metadata")

		$preload_attribute = ' preload="metadata"';

	else 

		$preload_attribute = ' preload="none"';



	// Autoplay the video?

	if ($autoplay == "true" || $autoplay == "on")

		$autoplay_attribute = " autoplay";

	else

		$autoplay_attribute = "";

	

	// Loop the video?

	if ($loop == "true")

		$loop_attribute = " loop";

	else

		$loop_attribute = "";

	

	// Controls?

	if ($controls == "false")

		$controls_attribute = "";

	else

		$controls_attribute = " controls";

	

	// Is there a custom class?

	if ($class)

		$class = ' ' . $class;

	

	// Muted?

	if ($muted == "true")

		$muted_attribute = " muted";

	else

		$muted_attribute = "";

	

	// Tracks

	if(!is_null( $content ))

		$track = do_shortcode($content);

	else

		$track = "";

	

	$dataSetup['customControlsOnMobile'] = true;

	$jsonDataSetup = str_replace('\\/', '/', json_encode($dataSetup));


	//Output the <video> tag

	$videojs = <<<_end_



	<!-- Begin Video.js -->

 	<div id="videocontent" class="videocontent">

	<video id="{$id}" class="video-js vjs-default-skin {$class}" width="640" height="360" {$poster_attribute}{$controls_attribute}{$preload_attribute}{$autoplay_attribute}{$loop_attribute}{$muted_attribute} data-setup='{$jsonDataSetup}'>

		{$mp4_source_720hd}

		{$mp4_source_sd}

		{$mp4_source_1080hd}

		{$webm_source_sd}

		{$webm_source_720hd}

		{$webm_source_1080hd}

		{$ogg_source_sd}

		{$ogg_source_720hd}

		{$ogg_source_1080hd}

		{$track}

	</video>

	<!-- End Video.js -->

 	</div>





  <script>
    // Add resolutions

      videojs('$id', {
        plugins: {        	
        	socialOverlay: {onScreen: true},
	  		ads:{},
	  		preroll:{src:"$advertisementvideo", href:"$adlink"},
	  		resolutionSelector : {default_res : '480'},
	  		watermark: { file: "http://sivarmunchies.com/preroll/video/oogee_resi.png", xpos: "0", ypos: "0" }
        }}, function() {
			// "this" will be a reference to the player object
			var player = this;
			// Listen for the changeRes event
			player.on( 'changeRes', function() {
				// player.getCurrentRes() can be used to get the currently selected resolution
				console.log( 'Current Res is: ' + player.getCurrentRes() );
			});
      });

    // Add watermark

  </script>



_end_;

	

	if($options['videojs_responsive'] == 'on') { //add the responsive wrapper

		

		$ratio = ($height && $width) ? $height/$width*100 : 56.25; //Set the aspect ratio (default 16:9)

		

		$maxwidth = ($width) ? "max-width:{$width}px" : ""; //Set the max-width

		

		$videojs = <<<_end_

		

		<!-- Begin Video.js Responsive Wrapper -->

		<div style='{$maxwidth}'>

			<div class='video-wrapper' style='padding-bottom:{$ratio}%;'>

				{$videojs}

			</div>

		</div>

		<!-- End Video.js Responsive Wrapper -->

		

_end_;

	}

	if (!file_exists("videos"))
		mkdir("videos", 0755);

	$output_content = "<html><head>
	<link rel='stylesheet' id='videojs-css'  href='../wp-content/plugins/erik_hayder_videojs_oogee/video-js/video-js.css?ver=4.1' type='text/css' media='all' />
	<link rel='stylesheet' id='videojs-plugin-css'  href='../wp-content/plugins/erik_hayder_videojs_oogee/plugin-styles.css?ver=4.1' type='text/css' media='all' />
	<link rel='stylesheet' id='video-js.ads-css'  href='../wp-content/plugins/erik_hayder_videojs_oogee/preroll/videojs.ads.css?ver=4.1' type='text/css' media='all' />
	<link rel='stylesheet' id='video-js.preroll-css'  href='../wp-content/plugins/erik_hayder_videojs_oogee/preroll/videojs-preroll.css?ver=4.1' type='text/css' media='all' />
	<link rel='stylesheet' id='video-js.watermark-css'  href='../wp-content/plugins/erik_hayder_videojs_oogee/watermark/videojs.watermark.css?ver=4.1' type='text/css' media='all' />
	<link rel='stylesheet' id='video-js.resolution-css'  href='../wp-content/plugins/erik_hayder_videojs_oogee/resolution/video-js-resolutions.css?ver=4.1' type='text/css' media='all' />
	<link rel='stylesheet' id='video-js.width-fix-css'  href='../wp-content/plugins/erik_hayder_videojs_oogee/video-js/width-fix.css?ver=4.1' type='text/css' media='all' />
	<link rel='stylesheet' id='video-js.share-css'  href='../wp-content/plugins/erik_hayder_videojs_oogee/share/socialOverlay.css?ver=4.1' type='text/css' media='all' />
	<script type='text/javascript' src='../wp-content/plugins/erik_hayder_videojs_oogee/video-js/video.js?ver=4.1'></script>
	<script type='text/javascript' src='../wp-content/plugins/erik_hayder_videojs_oogee/video-js/video.dev.js?ver=4.1'></script>
	<script type='text/javascript' src='../wp-content/plugins/erik_hayder_videojs_oogee/video-js/vjs.youtube.js?ver=4.1'></script>
	<script type='text/javascript' src='../wp-content/plugins/erik_hayder_videojs_oogee/preroll/videojs.ads.js?ver=4.1'></script>
	<script type='text/javascript' src='../wp-content/plugins/erik_hayder_videojs_oogee/preroll/videojs-preroll.js?ver=4.1'></script>
	<script type='text/javascript' src='../wp-content/plugins/erik_hayder_videojs_oogee/watermark/videojs.watermark.js?ver=4.1'></script>
	<script type='text/javascript' src='../wp-content/plugins/erik_hayder_videojs_oogee/resolution/video-js-resolutions.js?ver=4.1'></script>
	<script type='text/javascript' src='../wp-content/plugins/erik_hayder_videojs_oogee/share/socialOverlay.js?ver=4.1'></script>
	<script type='text/javascript' src='../wp-includes/js/jquery/jquery.js?ver=1.11.1'></script>
	<script type='text/javascript' src='../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>

	<style>
	#videocontent {
	    height:250px;
	    width:100px;
	}
	</style>
	</head>
	<body bgcolor=\"black\">";

	$output_content .= $videojs;

	$output_content .= "</body>
	</html>";

	$file_name = "videos/video_" . $id . ".html";

	if (!file_exists($file_name))
		file_put_contents($file_name, $output_content);

	return $videojs;
}

add_shortcode('videojs', 'video_shortcode');

//Only use the [video] shortcode if the correct option is set

$options = get_option('videojs_options');

if( !array_key_exists('videojs_video_shortcode', $options) || $options['videojs_video_shortcode'] ){

	add_shortcode('video', 'video_shortcode');

}





/* The [track] shortcode */

function track_shortcode($atts, $content=null){

	extract(shortcode_atts(array(

		'kind' => '',

		'src' => '',

		'srclang' => '',

		'label' => '',

		'default' => ''

	), $atts));

	

	if($kind)

		$kind = " kind='" . $kind . "'";

	

	if($src)

		$src = " src='" . $src . "'";

	

	if($srclang)

		$srclang = " srclang='" . $srclang . "'";

	

	if($label)

		$label = " label='" . $label . "'";

	

	if($default == "true" || $default == "default")

		$default = " default";

	else

		$default = "";

	

	$track = "

		<track" . $kind . $src . $srclang . $label . $default . " />

	";

	

	return $track;

}

add_shortcode('track', 'track_shortcode');





/* TinyMCE Shortcode Generator */

function video_js_button() {

	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )

		return;

	if ( get_user_option('rich_editing') == 'true' ) {

		add_filter('mce_external_plugins', 'video_js_mce_plugin');

		add_filter('mce_buttons', 'register_video_js_button');

	}

}

add_action('init', 'video_js_button');



function register_video_js_button($buttons) {

	array_push($buttons, "|", "videojs");

	$options = get_option('videojs_options');

	echo('<div style="display:none"><input type="hidden" id="videojs-autoplay-default" value="' . $options['videojs_autoplay'] . '"><input type="hidden" id="videojs-preload-default" value="' . $options['videojs_preload'] . '"></div>'); //the default values from the admin screen, to be used by our javascript

	return $buttons;

}



function video_js_mce_plugin($plugin_array) {

	$plugin_array['videojs'] = plugins_url( 'mce-button.js' , __FILE__ );

	return $plugin_array;

}



function videojs_preroll() {

	wp_register_script( 'video-js.ads', plugins_url( 'preroll/videojs.ads.js' , __FILE__ ) );

	wp_register_script( 'video-js.dev', plugins_url( 'video-js/video.dev.js' , __FILE__ ) );

	wp_register_style( 'video-js.ads', plugins_url( 'preroll/videojs.ads.css' , __FILE__ ) );

	wp_enqueue_style( 'video-js.ads' );

	wp_register_script( 'video-js.preroll', plugins_url( 'preroll/videojs-preroll.js' , __FILE__ ) );

	wp_register_style( 'video-js.preroll', plugins_url( 'preroll/videojs-preroll.css' , __FILE__ ) );

	wp_enqueue_style( 'video-js.preroll' );

	wp_register_script( 'video-js.watermark', plugins_url( 'watermark/videojs.watermark.js' , __FILE__ ) );

	wp_register_style( 'video-js.watermark', plugins_url( 'watermark/videojs.watermark.css' , __FILE__ ) );

	wp_enqueue_style( 'video-js.watermark' );

	wp_register_script( 'video-js.resolution', plugins_url( 'resolution/video-js-resolutions.js' , __FILE__ ));

	wp_register_style( 'video-js.resolution', plugins_url( 'resolution/video-js-resolutions.css' , __FILE__ ));

	wp_enqueue_style( 'video-js.resolution' );

	wp_register_style( 'video-js.width-fix', plugins_url( 'video-js/width-fix.css' , __FILE__ ) );

	wp_enqueue_style( 'video-js.width-fix' );

	wp_register_script( 'video-js.share', plugins_url( 'share/socialOverlay.js' , __FILE__ ));

	wp_register_style( 'video-js.share', plugins_url( 'share/socialOverlay.css' , __FILE__ ) );

	wp_enqueue_style( 'video-js.share' );



	wp_enqueue_script( 'videojs' );

	wp_enqueue_script( 'video-js.dev' );

	wp_enqueue_script( 'videojs-youtube' );

	wp_enqueue_script( 'video-js.ads' );

	wp_enqueue_script( 'video-js.preroll' );

	wp_enqueue_script( 'video-js.watermark' );

	wp_enqueue_script( 'video-js.resolution' );

	wp_enqueue_script( 'video-js.share' );

}

add_action('wp_enqueue_scripts', 'videojs_preroll');

}



else {

/**

 * @package Video.js

 * @version 4.5.0

 */

/*

Plugin Name: Video.js - HTML5 Video Player for WordPress

Plugin URI: http://videojs.com/

Description: Self-hosted responsive HTML5 video for WordPress, built on the widely used Video.js HTML5 video player library. Allows you to embed video in your post or page using HTML5 with Flash fallback support for non-HTML5 browsers.

Author: <a href="http://www.nosecreekweb.ca">Dustin Lammiman</a>, <a href="http://steveheffernan.com">Steve Heffernan</a>

Version: 4.5.0

*/





$plugin_dir = plugin_dir_path( __FILE__ );





/* The options page */

include_once($plugin_dir . 'admin.php');





/* Useful Functions */

include_once($plugin_dir . 'lib.php');





/* Register the scripts and enqueue css files */

function register_videojs(){

	$options = get_option('videojs_options');

	

	wp_register_style( 'videojs-plugin', plugins_url( 'plugin-styles.css' , __FILE__ ) );

	wp_enqueue_style( 'videojs-plugin' );

	

	if($options['videojs_cdn'] == 'on') { //use the cdn hosted version

		wp_register_script( 'videojs', '//vjs.zencdn.net/4.5/video.js' );

		wp_register_style( 'videojs', '//vjs.zencdn.net/4.5/video-js.css' );

		wp_enqueue_style( 'videojs' );

	} else { //use the self hosted version

		wp_register_script( 'videojs', plugins_url( 'videojs/video.js' , __FILE__ ) );

		wp_register_style( 'videojs', plugins_url( 'videojs/video-js.css' , __FILE__ ) );

		wp_enqueue_style( 'videojs' );

	}

	

	wp_register_script( 'videojs-youtube', plugins_url( 'video-js/vjs.youtube.js' , __FILE__ ) );

}

add_action( 'wp_enqueue_scripts', 'register_videojs' );





/* Include the scripts before </body> */

function add_videojs_header(){

	wp_enqueue_script( 'videojs' );

	wp_enqueue_script( 'videojs-youtube' );

}





/* Include custom color styles in the site header */

function videojs_custom_colors() {

	$options = get_option('videojs_options');

	

	if($options['videojs_color_one'] != "#ccc" || $options['videojs_color_two'] != "#66A8CC" || $options['videojs_color_three'] != "#000") { //If custom colors are used

		$color3 = vjs_hex2RGB($options['videojs_color_three'], true); //Background color is rgba

		echo "

	<style type='text/css'>

		.vjs-default-skin { color: " . $options['videojs_color_one'] . " }

		.vjs-default-skin .vjs-play-progress, .vjs-default-skin .vjs-volume-level { background-color: " . $options['videojs_color_two'] . " }

		.vjs-default-skin .vjs-control-bar, .vjs-default-skin .vjs-big-play-button { background: rgba(" . $color3 . ",0.7) }

		.vjs-default-skin .vjs-slider { background: rgba(" . $color3 . ",0.2333333333333333) }

	</style>

		";

	}

}

add_action( 'wp_head', 'videojs_custom_colors' );





/* Prevent mixed content warnings for the self-hosted version */

function add_videojs_swf(){

	$options = get_option('videojs_options');

	if($options['videojs_cdn'] != 'on') {

		echo '

		<script type="text/javascript">

			if(typeof videojs != "undefined") {

				videojs.options.flash.swf = "'. plugins_url( 'videojs/video-js.swf' , __FILE__ ) .'";

			}

			document.createElement("video");document.createElement("audio");document.createElement("track");

		</script>

		';

	} else {

		echo '

		<script type="text/javascript"> document.createElement("video");document.createElement("audio");document.createElement("track"); </script>

		';

	}

}

add_action('wp_head','add_videojs_swf');





/* The [video] or [videojs] shortcode */

function video_shortcode($atts, $content=null){

	add_videojs_header();

	

	$options = get_option('videojs_options'); //load the defaults

	

	extract(shortcode_atts(array(

		'mp4' => '',

		'webm' => '',

		'ogg' => '',

		'youtube' => '',

		'poster' => '',

		'width' => $options['videojs_width'],

		'height' => $options['videojs_height'],

		'preload' => $options['videojs_preload'],

		'autoplay' => $options['videojs_autoplay'],

		'loop' => '',

		'controls' => '',

		'id' => '',

		'class' => '',

		'muted' => ''

	), $atts));



	$dataSetup = array();

	

	// ID is required for multiple videos to work

	if ($id == '')

		$id = 'example_video_id_'.rand();



	// MP4 Source Supplied

	if ($mp4)

		$mp4_source = '<source src="'.$mp4.'" type=\'video/mp4\' />';

	else

		$mp4_source = '';



	// WebM Source Supplied

	if ($webm)

		$webm_source = '<source src="'.$webm.'" type=\'video/webm; codecs="vp8, vorbis"\' />';

	else

		$webm_source = '';



	// Ogg source supplied

	if ($ogg)

		$ogg_source = '<source src="'.$ogg.'" type=\'video/ogg; codecs="theora, vorbis"\' />';

	else

		$ogg_source = '';

		

	if ($youtube) {

		$dataSetup['forceSSL'] = 'true';

		$dataSetup['techOrder'] = array("youtube");

		$dataSetup['src'] = $youtube;

	}

	// Poster image supplied

	if ($poster)

		$poster_attribute = ' poster="'.$poster.'"';

	else

		$poster_attribute = '';

	

	// Preload the video?

	if ($preload == "auto" || $preload == "true" || $preload == "on")

		$preload_attribute = ' preload="auto"';

	elseif ($preload == "metadata")

		$preload_attribute = ' preload="metadata"';

	else 

		$preload_attribute = ' preload="none"';



	// Autoplay the video?

	if ($autoplay == "true" || $autoplay == "on")

		$autoplay_attribute = " autoplay";

	else

		$autoplay_attribute = "";

	

	// Loop the video?

	if ($loop == "true")

		$loop_attribute = " loop";

	else

		$loop_attribute = "";

	

	// Controls?

	if ($controls == "false")

		$controls_attribute = "";

	else

		$controls_attribute = " controls";

	

	// Is there a custom class?

	if ($class)

		$class = ' ' . $class;

	

	// Muted?

	if ($muted == "true")

		$muted_attribute = " muted";

	else

		$muted_attribute = "";

	

	// Tracks

	if(!is_null( $content ))

		$track = do_shortcode($content);

	else

		$track = "";



	$jsonDataSetup = str_replace('\\/', '/', json_encode($dataSetup));



	//Output the <video> tag

	$videojs = <<<_end_



	<!-- Begin Video.js -->



 	<div class="videocontent">

	<video id="{$id}" class="video-js vjs-default-skin{$class}" width="auto" height="auto"{$poster_attribute}{$controls_attribute}{$preload_attribute}{$autoplay_attribute}{$loop_attribute}{$muted_attribute} data-setup='{$jsonDataSetup}'>

		{$mp4_source}

		{$webm_source}

		{$ogg_source}{$track}

	</video>

	<!-- End Video.js -->

	</div>



_end_;

	

	if($options['videojs_responsive'] == 'on') { //add the responsive wrapper

		

		$ratio = ($height && $width) ? $height/$width*100 : 56.25; //Set the aspect ratio (default 16:9)

		

		$maxwidth = ($width) ? "max-width:{$width}px" : ""; //Set the max-width

		

		$videojs = <<<_end_

		

		<!-- Begin Video.js Responsive Wrapper -->

		<div style='{$maxwidth}'>

			<div class='video-wrapper' style='padding-bottom:{$ratio}%;'>

				{$videojs}

			</div>

		</div>

		<!-- End Video.js Responsive Wrapper -->

		

_end_;

	}


	return $videojs;



}

add_shortcode('videojs', 'video_shortcode');

//Only use the [video] shortcode if the correct option is set

$options = get_option('videojs_options');

if( !array_key_exists('videojs_video_shortcode', $options) || $options['videojs_video_shortcode'] ){

	add_shortcode('video', 'video_shortcode');

}





/* The [track] shortcode */

function track_shortcode($atts, $content=null){

	extract(shortcode_atts(array(

		'kind' => '',

		'src' => '',

		'srclang' => '',

		'label' => '',

		'default' => ''

	), $atts));

	

	if($kind)

		$kind = " kind='" . $kind . "'";

	

	if($src)

		$src = " src='" . $src . "'";

	

	if($srclang)

		$srclang = " srclang='" . $srclang . "'";

	

	if($label)

		$label = " label='" . $label . "'";

	

	if($default == "true" || $default == "default")

		$default = " default";

	else

		$default = "";

	

	$track = "

		<track" . $kind . $src . $srclang . $label . $default . " />

	";

	

	return $track;

}

add_shortcode('track', 'track_shortcode');





/* TinyMCE Shortcode Generator */

function video_js_button() {

	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )

		return;

	if ( get_user_option('rich_editing') == 'true' ) {

		add_filter('mce_external_plugins', 'video_js_mce_plugin');

		add_filter('mce_buttons', 'register_video_js_button');

	}

}

add_action('init', 'video_js_button');



function register_video_js_button($buttons) {

	array_push($buttons, "|", "videojs");

	$options = get_option('videojs_options');

	echo('<div style="display:none"><input type="hidden" id="videojs-autoplay-default" value="' . $options['videojs_autoplay'] . '"><input type="hidden" id="videojs-preload-default" value="' . $options['videojs_preload'] . '"></div>'); //the default values from the admin screen, to be used by our javascript

	return $buttons;

}



function video_js_mce_plugin($plugin_array) {

	$plugin_array['videojs'] = plugins_url( 'mce-button.js' , __FILE__ );

	return $plugin_array;

}



function videojs_preroll() {

	wp_register_style( 'video-js.width-fix', plugins_url( 'video-js/width-fix.css' , __FILE__ ) );

	wp_enqueue_style( 'video-js.width-fix' );



}

add_action('wp_enqueue_scripts', 'videojs_preroll');



}

?>