<?php
/*
Plugin Name: Donation Thermometer
Plugin URI: http://henrypatton.org/donation-thermometer
Description: Displays custom thermometers charting the amount of donations raised using the shortcode <code>[thermometer raised=?? target=??]</code>. Shortcodes for raised and target text values are also available for posts/pages/text widgets: <code>[therm_r]</code> and <code>[therm_t]</code>.
Version: 1.3.1
Author: Henry Patton
Author URI: http://henrypatton.org
License: GPL3

Copyright 2012  Henry Patton  (email : henry@henrypatton.org)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

define('THERMFOLDER', basename( dirname(__FILE__) ) );
define('THERM_ABSPATH', trailingslashit( str_replace("\\","/", WP_PLUGIN_DIR . '/' . THERMFOLDER ) ) );

// Specify Hooks/Filters
add_action('admin_init', 'thermometer_init_fn' );
add_action('admin_menu', 'thermometer_add_page_fn');



function set_plugin_meta_dt($links, $file) {
    $plugin = plugin_basename(__FILE__);
    // create link
    if ($file == $plugin) {
    return array_merge(
    $links,
    array( (sprintf( '<a href="options-general.php?page=%s">%s</a>', $plugin, __('Settings') ) ),
	  sprintf('<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8NVX34E692T34">%s</a>', __('Donate') ) )
    );
    }
    return $links;
    }
    add_filter( 'plugin_row_meta', 'set_plugin_meta_dt', 10, 2 );
    
// Register settings
function thermometer_init_fn(){
	wp_register_style( 'thermStylesheet', plugins_url('style.css', __FILE__) );
	register_setting('plugin_options', 'plugin_options', 'thermometer_options_validate' );
	add_settings_section('main_section', '', 'section_text_fn', __FILE__);
	add_settings_field('colour_picker1', 'Fill colour', 'fill_colour_fn', __FILE__, 'main_section');
	add_settings_field('plugin_chk1', 'Show percentage?', 'setting_chk1_fn', __FILE__, 'main_section');
	add_settings_field('colour_picker2', 'Percentage text colour', 'text_colour_fn', __FILE__, 'main_section');
	add_settings_field('plugin_chk2', 'Show target?', 'setting_chk2_fn', __FILE__, 'main_section');
	add_settings_field('colour_picker3', 'Target text colour', 'target_colour_fn', __FILE__, 'main_section');
	add_settings_field('plugin_chk3', 'Show amount raised?', 'setting_chk3_fn', __FILE__, 'main_section');
	add_settings_field('colour_picker4', 'Raised text colour', 'raised_colour_fn', __FILE__, 'main_section');
	add_settings_field('currency', 'Currency', 'setting_dropdown_fn', __FILE__, 'main_section');
	add_settings_field('target_string', 'Target value', 'target_string_fn', __FILE__, 'main_section');
	add_settings_field('raised_string', 'Raised value', 'raised_string_fn', __FILE__, 'main_section');
}

// Add sub page to the Settings Menu
function thermometer_add_page_fn() {
	$page = add_options_page('Thermometer Settings', 'Thermometer', 'administrator', __FILE__, 'options_page_fn');
	add_action( 'admin_print_styles-' . $page, 'my_admin_scripts' );
}

register_activation_hook(__FILE__, 'add_defaults_fn');
// Define default option settings when activate
function add_defaults_fn() {
    $arr = array("colour_picker1"=>"#FF0000", "chkbox1"=>1, "colour_picker2"=>"#000000", "chkbox2"=>1, "colour_picker3"=>"#000000", "chkbox3"=>1, "colour_picker4"=>"#000000", "currency"=>"£","target_string"=>"", "raised_string"=>"",);
    update_option('plugin_options', $arr);
}
function my_admin_scripts() {
    wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );
    $coloursjs = plugins_url('donation-thermometer/colours.js');
    wp_enqueue_script( 'options_page_fn', $coloursjs , array( 'farbtastic', 'jquery' ) );
    wp_enqueue_style( 'thermStylesheet' );
}


// ************************************************************************************************************
 
// Callback functions

// Section HTML, displayed before the first option
function  section_text_fn() {
	// preview thermometer
	/*if (file_exists(THERM_ABSPATH.'preview.png')){
	    echo '<img src="'.plugins_url("/donation-thermometer/preview.png").'" title="What your thermometer will look like" width="180" height="458" style="border: 0pt none; float: right; position: absolute; left:800px;">';
	}*/ 
	echo "<p>To place a thermometer on a post or page, type the shortcode [thermometer]. Values for your amount raised and target will need to be set here or in the shortcode:</p>
	<p>e.g. <code>[thermometer raised=1523 target=5000]</code>.</p>
	<p>The shortcode has 5 additional parameters which can be used independently:</p>
	<p><code>[thermometer raised=1523 target=5000 width=200 height=567 align=left currency=$ alt=off]</code>.</p>
	<p>The size of the individual thermometer can be altered using width or height (in pixels). Currency symbols preceed the amounts. <br>The alt and title attributes of the image can also be modified, or toggled off. Use apostrophes to input a custom string, e.g. <code>[thermometer alt='Raised £1523']</code></p>
	<h2>Default plugin values:</h2>";
	
}


// TEXTBOX - Name: plugin_options[fill_colour]
function fill_colour_fn() {
	$options = get_option('plugin_options');
	echo "<div class='form-item'><label for='color1'></label><input type='text' id='color1' name='plugin_options[colour_picker1]' value='{$options['colour_picker1']}' class='colorwell' />";
	echo "  e.g. red hex value = <code>#FF0000</code>";
	echo '<div id="picker" style="float: right; position: absolute; left:600px;"></div>';
}

// DROP-DOWN-BOX - Name: plugin_options[currency]
function  setting_dropdown_fn() {
	$options = get_option('plugin_options');
	$items = array("","£","$","€","¥");
	echo "<select id='drop_down1' name='plugin_options[currency]'>";
	foreach($items as $item) {
		$selected = ($options['currency']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
	echo '  select the empty option to remove the currency symbol (also works by entering <code>currency=null</code> in the shortcode).';
    }
// CHECKBOX - Name: plugin_options[chkbox1] percentage
function setting_chk1_fn() {
	$options = get_option('plugin_options');
	if($options['chkbox1']) { $checked1 = ' checked="checked" '; }
	echo "<input ".$checked1." id='plugin_chk1' value='1' name='plugin_options[chkbox1]' type='checkbox' />";
    }
// TEXTBOX - Name: plugin_options[text_colour] 
function text_colour_fn() {
	$options = get_option('plugin_options');
	echo "<div class='form-item'><label for='color2'></label><input type='text' id='color2' name='plugin_options[colour_picker2]' value='{$options['colour_picker2']}' class='colorwell' />";
	echo "  e.g. black hex value = <code>#000000</code>";
    }

// CHECKBOX - Name: plugin_options[chkbox2] target
function setting_chk2_fn() {
	$options = get_option('plugin_options');
	if($options['chkbox2']) { $checked2 = ' checked="checked" '; }
	echo "<input ".$checked2." id='plugin_chk2' value='1' name='plugin_options[chkbox2]' type='checkbox' />";
    }

// CHECKBOX - Name: plugin_options[chkbox3] raised
function setting_chk3_fn() {
	$options = get_option('plugin_options');
	if($options['chkbox3']) { $checked3 = ' checked="checked" '; }
	echo "<input ".$checked3." id='plugin_chk3' value='1' name='plugin_options[chkbox3]' type='checkbox' />";
    }
    
// TEXTBOX - Name: plugin_options[target_colour] 
function target_colour_fn() {
	$options = get_option('plugin_options');
	echo "<div class='form-item'><label for='color3'></label><input type='text' id='color3' name='plugin_options[colour_picker3]' value='{$options['colour_picker3']}' class='colorwell' />";
	echo "  e.g. black hex value = <code>#000000</code>";
    }

// TEXTBOX - Name: plugin_options[raised_colour] 
function raised_colour_fn() {
	$options = get_option('plugin_options');
	echo "<div class='form-item'><label for='color4'></label><input type='text' id='color4' name='plugin_options[colour_picker4]' value='{$options['colour_picker4']}' class='colorwell' />";
	echo "  e.g. black hex value = <code>#000000</code>";
    }
    
// TEXTBOX - Name: plugin_options[target_string]
function target_string_fn() {
	$options = get_option('plugin_options');
	echo "<input id='target_string' name='plugin_options[target_string]' size='15' type='number' value='{$options['target_string']}' />";
	echo '  (also <code>[therm_t]</code> value)';
}
// TEXTBOX - Name: plugin_options[raised_string]
function raised_string_fn() {
	$options = get_option('plugin_options');
	echo "<input id='raised_string' name='plugin_options[raised_string]' size='15' type='number' value='{$options['raised_string']}' />";
	echo '  (also <code>[therm_r]</code> value)';

}
// Display the admin options page
function options_page_fn() {
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Donation Thermometer Settings</h2>
		<form action="options.php" method="post">
		<?php settings_fields('plugin_options'); ?>
		<?php do_settings_sections(__FILE__); ?>
		<p>E.g. So far we have raised £<code>[therm_r]</code> towards our £<code>[therm_t]</code> target! Thank you for your support.</p>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Update'); ?>" />
		</p>
		</form>
	</div>
<?php
}

// Validate user data for some/all of your input fields
function thermometer_options_validate($input) {
	// Check for missed entries - input default
	if ($input['colour_picker1'] ==  '' || strlen($input['colour_picker1']) !=  7){
	   $input['colour_picker1'] = ('#FF0000');
	}
	if ($input['colour_picker2'] ==  '' || strlen($input['colour_picker2']) !=  7){
	    $input['colour_picker2'] = ('#000000');
	}
	if ($input['colour_picker3'] ==  '' || strlen($input['colour_picker3']) !=  7){
	    if ($input['colour_picker4'] == ''){
		$input['colour_picker3'] = ('#000000');
	    }
	    else{
		$input['colour_picker3'] = ($input['colour_picker4']); // if 4 not empty make the same
	    }
	}
	if ($input['colour_picker4'] ==  '' || strlen($input['colour_picker4']) !=  7){
	    $input['colour_picker4'] = ($input['colour_picker3']);
	}
	if (!is_numeric($input['target_string'])){
	    $input['target_string'] = '';
	    }
	if (!is_numeric($input['raised_string'])){
	    $input['raised_string'] = '';
	    }
	return $input; // return validated input
}

if( isset($_GET['settings-updated']) ) {
    foreach(glob(THERM_ABSPATH.'*.png*') as $v){
    unlink($v);}
    // createtherm(500,1000,'preview'); create preview
}


/////////////////////// Where the magic happens ;)...

function createtherm($raised,$target,$currency,$therm_name){
    $options = get_option('plugin_options');
    $colour_input = $options['colour_picker1'];
    $text_input = $options['colour_picker2'];
    $text2_input = $options['colour_picker3'];
    if ($options['colour_picker4'] == ''){
	$text3_input = $options['colour_picker3']; //if db empty after updating plugin
    }
    else{
	$text3_input = $options['colour_picker4'];
    }
    $raisedck = $options['chkbox3'];
    if($raisedck =='1'){
	$raised_cnt = (((strlen($raised) + strlen(utf8_decode($currency)))*25)+205+28); //pixel width with raised string
    }
    else{
	$raised_cnt = 240;
    }
    
    $targetck = $options['chkbox2'];
    $percentck = $options['chkbox1'];
    $font = THERM_ABSPATH."fonts/Arial.ttf";
    
    // calculte percentage value
    if ($target > 0){
	    $percent_raised  = ($raised/$target * 100); // avoid division by zero
	}
	else{
	    $percent_raised == 0;
	}
    
    $nodp = number_format($percent_raised, 0,'.',',');
    $filled = 639.2 / 100 * $percent_raised; // pixels to fill	
    $x = 162; // marker file width
    $y = 889; //height of thermometer template (pixels)
    $image_1 = THERM_ABSPATH.'images/thermometer_wide.png'; // base image file
    $draft_img = imagecreatefrompng($image_1) or die("Failed in call to imagecreate()\n");
    
    //fill thermometer
	
    $circle = imagecreatetruecolor(151, 149); //image resource identifier
    $rectangle = imagecreate(103, 22.56);
    imagealphablending($circle,false);
    
    $col=imagecolorallocatealpha($circle,255,255,255,127);
    imagefilledrectangle($circle,0,0,151,149,$col);
    $colour_fill = HextoRGB($colour_input);
    $user_colour = imagecolorallocate($circle, $colour_fill['r'], $colour_fill['g'], $colour_fill['b']);
    $user_colour2 = imagecolorallocate($rectangle, $colour_fill['r'], $colour_fill['g'], $colour_fill['b']);
    
    imagefilledrectangle($rectangle,0,0,284,40,$user_color2);
    imagefilledarc($circle, 74.5, 74.5, 155, 148, 0, 0, $user_colour, IMG_ARC_PIE); //draw circle
    imagealphablending($circle,true);
    imagecopy($draft_img, $circle, 43, 737, 0, 0, 151, 149); // add to final image
    
    
    if ($percent_raised <= 100){ // if less or equal to 100%
	imagecopy($draft_img, $rectangle,67.3,734-$filled,0,0,103,70+$filled); // vertical bar	
    }
    else{
	imagecopy($draft_img, $rectangle,67.3,94,0,0,103,666);
    }
    $image_2 = imagecreatefrompng(THERM_ABSPATH.'images/outline.png');
    $image_3 = imagecreatefrompng(THERM_ABSPATH.'images/markers.png');
    imagecopy($draft_img, $image_2, 0, 0, 0, 0, 460, $y ); // draw outline
    imagecopy($draft_img, $image_3, 38, 57, 0, 0, $x, $y); // draw markers
    imagedestroy($image_2);
    imagedestroy($image_3);
    
    // percentage bottom
    if ($percentck =='1'){
	if ($percent_raised > 999){ // variable percent size
	    $fontsize = 24;}
	elseif($percent_raised > 99){
	    $fontsize = 33;
	}
	else{
	    $fontsize = 40;
	    }
	$width_perc = 117;
	$height_perc = 42;
	$im = imagecreatetruecolor($width_perc, $height_perc);
	$background = imagecolorallocate($im,$colour_fill['r'], $colour_fill['g'], $colour_fill['b']);
	imagefilledrectangle($im, 0, 0, $width_perc, $height_perc, $background);
	$colour_text = HextoRGB($text_input);		
	$text_color = ImageColorAllocate($im, $colour_text['r'], $colour_text['g'], $colour_text['b']);
	$box = imagettfbbox($fontsize,0,$font,$nodp.'%');
	$perc_x = ceil(($width_perc - $box[2]) / 2); //centre of box
	ImageTTFText($im, $fontsize, 0, $perc_x, 38, $text_color, $font, $nodp.'%');
	imagecopy($draft_img, $im, 57, 790, 0,0, $width_perc,$height_perc);
	imagedestroy($im);
    }
	    
    // raised
    
    $colour_text3 = HextoRGB($text3_input); 
    $text_color3 = ImageColorAllocate($draft_img, $colour_text3['r'], $colour_text3['g'], $colour_text3['b']); 
    if ($raisedck =='1'){
	if ($percent_raised <= 100){ // if less than 100%
		$triangle_start = (722 - $filled);
	}
	else{
		$triangle_start = (83);
	}
	$triangle = imagecreatetruecolor(24, 27); // draw triangle
	imagealphablending($triangle,false);
	$col2=imagecolorallocatealpha($triangle,255,255,255,127);
	imagefilledrectangle($triangle,0,0,24,27,$col2);
	$black = imagecolorallocate($triangle, 0, 0, 0);
	$vertices = array(0,12,23.5,0,23.5,27); // triangle points
	imagefilledpolygon($triangle,$vertices,3,$black);
	imagealphablending($triangle,true);
	imagecopy($draft_img, $triangle, 173, $triangle_start, 0, 0, 23, 26); // draw triangle
	$raised_comma = number_format($raised,0,'.',',');
	ImageTTFText($draft_img, 30, 0, 205, ($triangle_start + 26), $text_color3, $font, $currency.$raised_comma);
	imagedestroy($triangle);
	    
    }
    
    // target
    $colour_text2 = HextoRGB($text2_input);
    $text_color2 = ImageColorAllocate($draft_img, $colour_text2['r'], $colour_text2['g'], $colour_text2['b']);
    if ($targetck =='1'){
	$target_comma = number_format($target,0,'.',',');
	if ((strlen(utf8_decode($target_comma)) + strlen(utf8_decode($currency))) < 8){ // variable percent size
	    $t_fontsize = 43;}
	else{
	    $t_fontsize = 30;
	    }
	$width_targ = 230;
	$height_targ = 48;
	$im_target = imagecreatetruecolor($width_targ, $height_targ);
	$clear = imagecolorallocate($im_target, 255, 0, 0);
	imagefilledrectangle($im_target,0,0,$width_targ,$height_targ, $clear);
	
	$tb = imagettfbbox($t_fontsize,0,$font,$currency.$target_comma);
	if ($currency =='') {
	    $tb = imagettfbbox($t_fontsize,0,$font,$target_comma);
	}
	$text_x = ceil(($width_targ - $tb[2]) / 2); //centre of box
	Imagettftext($draft_img, $t_fontsize, 0, $text_x, $height_targ, $text_color2, $font, $currency.$target_comma);
	imagedestroy($im_target);
    
    
	    
    }
    //output therm image
    $thermpath = THERM_ABSPATH.$therm_name.'.png';
    
    
    //crop image
    $final_img = imagecreatetruecolor($raised_cnt,889);
    imagealphablending($final_img, false);
    imagesavealpha($final_img, true);
    $white = imagecolorallocatealpha($final_img,255,255,255,127);
    imagefill($final_img, 0, 0, $white);
    imagecopy($final_img,$draft_img,0,0,0,0,$raised_cnt,889);
 
    
    imagepng($final_img,$thermpath,9,PNG_ALL_FILTERS);
    
    // destroy temporary files
    imagedestroy($circle);
    imagedestroy($rectangle);
    imagedestroy($draft_img);
    imagedestroy($final_img);
    
}
    	
// get RGB colour
	
function HextoRGB($hex){ 
    $hex = str_replace("#", "", $hex);
    $colour_rgb = array();
     
    if(strlen($hex) == 3) {
	$colour_rgb['r'] = hexdec(substr($hex, 0, 1) . $r);
	$colour_rgb['g'] = hexdec(substr($hex, 1, 1) . $g);
	$colour_rgb['b'] = hexdec(substr($hex, 2, 1) . $b);
    }
    else if(strlen($hex) == 6) {
	$colour_rgb['r'] = hexdec(substr($hex, 0, 2));
	$colour_rgb['g'] = hexdec(substr($hex, 2, 2));
	$colour_rgb['b'] = hexdec(substr($hex, 4, 2));
	}
    return $colour_rgb;
}


/////////////////////////////// shortcode stuff...

add_shortcode( 'thermometer','thermometer_graphic');	
		
function thermometer_graphic($atts){
	
	$atts = (shortcode_atts(
		array(
			'width' => '',
			'height' => '',
			'align' => '',
			'target' => '',
			'raised' => '',
			'alt' =>'',
			'currency' =>'',
		), $atts));
	$options = get_option('plugin_options');
	
	//currency value to use
	if ($atts['currency'] == ''){
	    $currency = $options['currency'];
	    }
	elseif($atts['currency'] == 'null' || $atts['currency'] == 'NULL'){ //get user to enter null for no value
	    $currency ='';
	}
	else{
	    $currency = $atts['currency']; //set currency to default or shortcode value
	}
	
	//target value
	if ($atts['target'] == '' && $options['target_string'] == ''){
	    echo '<p>Your target is missing. Set a value on the settings page or in the shortcode.</p>';
	}
	elseif ($atts['target'] == '' && $options['target_string'] != ''){
	    $target = $options['target_string'];
	    }
	else{
	    $target = $atts['target'];
	}
	
	//raised value
	if ($atts['raised'] == '' && $options['raised_string'] == ''){
	    echo '<p>The amount raised is missing. Set a value on the settings page or in the shortcode.</p>';
	}
	elseif ($atts['raised'] == '' && $options['raised_string'] != ''){
	    $raised = $options['raised_string'];
	    }
	else{
	    $raised = $atts['raised'];
	}
	
	//align position
	if ($atts['align'] == 'center' || $atts['align'] == 'centre'){
	    $align = 'display:block; margin-left:auto; margin-right:auto;';
	}
	elseif ($atts['align'] == 'left'){
	    $align = 'display:block; float:left;';
	}
	elseif ($atts['align'] != ''){
	    $align = 'display:block; float:'.$atts['align'].';';
	}
	
	//width value
	if($atts['width'] != '' && $atts['height'] != ''){
	    echo 'Use only the width OR height parameters';
	}
	
	//title text
	if ($atts['alt'] == 'off' || $atts['alt'] == 'OFF' || $atts['alt'] == 'Off'){
	    $title = '';
	}
	elseif($atts['alt'] != ''){
	    $title = $atts['alt'];
	    }
	else{
	    $title = 'Raised '.$currency.$raised.' towards the '.$currency.$target.' target.';
	}
	
	global $post;
	$postID = $post->ID; // get post/page ID
	$custom_thermname = 'therm_'.$postID.'_'.$raised.'_'.$target.'_'.$currency; //filename is related to post
	$urlpath = plugins_url('donation-thermometer/'.$custom_thermname.'.png');
	$cache_life = '6048000'; // seconds in 1 week
	
	
    //clear cache if necessary first
    foreach(glob(THERM_ABSPATH.'*.png*') as $f){
	if(time() - filemtime($f) >= $cache_life){
	unlink($f);
	}
    }
    
    // create a custom thermometer from shortcode parameters
    
    
    if(file_exists(THERM_ABSPATH.$custom_thermname.'.png')){ // if thermometer exists
	return thermhtml($atts['width'],$atts['height'],$raised,$target,$atts['align'],$align,$currency,$title,$urlpath,$custom_thermname);
	}
    else{
	createtherm($raised,$target,$currency,$custom_thermname); // use shortcode attributes to create thermometer
	return thermhtml($atts['width'],$atts['height'],$raised,$target,$atts['align'],$align,$currency,$title,$urlpath,$custom_thermname);
	
	}
}

function thermhtml($code_w,$code_h,$code_r,$code_t,$code_a,$align,$currency,$title,$urlpath,$custom_thermname,$content = null){ //new function to get width/height ratio from created file
    list($width,$height) = getimagesize(THERM_ABSPATH.$custom_thermname.'.png');
    $ratio = $height/$width;
    
    // use default width of 300 pixels if no parameters given
	if ($code_w == '' && $code_h == '' && $code_a == ''){
		return $therm_output = '<img src="'.$urlpath.'" title="'.$title.'" alt="'.$title.'" width="200" height="'.($ratio*200).'" style="border: 0pt none; float: left; margin: 10px 20px;">';
	}
	// if just align given
	elseif($code_w == '' && $code_h == '' && $code_a != ''){
		return $therm_output = '<img src="'.$urlpath.'" title="'.$title.'" alt="'.$title.'" width="200" height="'.($ratio*200).'" style="border: 0pt none;'.$align.' margin: 10px 20px;">';
	}
	// if width/height and/or align given
	else{
	    if ($code_w != '' && $code_a != ''){
		return $therm_output = '<img src="'.$urlpath.'" title="'.$title.'" alt="'.$title.'" width="'.$code_w.'" height="'.($code_w*$ratio).'" style="border: 0pt none;'.$align.' margin: 10px 20px;">';
	    }
	    elseif ($code_h != '' && $code_a != ''){
		return $therm_output = '<img src="'.$urlpath.'" title="'.$title.'" alt="'.$title.'" width="'.($code_h/$ratio).'" height="'.$code_h.'" style="border: 0pt none;'.$align.' margin: 10px 20px;">';
	    }
	    elseif ($code_h != '' && $code_a == ''){
		return $therm_output = '<img src="'.$urlpath.'" title="'.$title.'" alt="'.$title.'" width="'.($code_h/$ratio).'" height="'.$code_h.'" style="border: 0pt none; float: left; margin: 10px 20px;">';
	    }
	    elseif($code_w != '' && $code_a == ''){
		return $therm_output = '<img src="'.$urlpath.'" title="'.$title.'" alt="'.$title.'" width="'.$code_w.'" height="'.($code_w*$ratio).'" style="border: 0pt none; float: left; margin: 10px 20px;">';
	    }
	}
}

add_shortcode( 'therm_r','therm_raised');

function therm_raised(){
    $options = get_option('plugin_options');
    $raised = $options['raised_string'];
    if ($raised != ''){
	return number_format($raised, 0,'.',',');
    }
    else{
	return '<b>[Value missing on settings page]</b>';
    }
}

add_shortcode( 'therm_t','therm_target');

function therm_target(){
    $options = get_option('plugin_options');
    $target = $options['target_string'];
    if ($target != ''){
	return number_format($target, 0,'.',',');
	}
    else{
	return '<b>[Value missing on settings page]</b>';
    }
}

/* Display a notice that can be dismissed */
/*add_action('admin_notices', 'therm_shortcode_notice');
function therm_shortcode_notice() {
    global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
    /*if ( ! get_user_meta($user_id, 'therm_ignore_notice') ) {
        echo '<div class="updated"><p>';
        printf(__('<p>Required parameters for the "Donation Thermometer" shortcode have changed with this version...please update them so that they keep working!</p>
		  The change has been made so that thermometers with different targets/raised amounts can be placed around your site. Check the plugin settings page for more advice. (<a href="%1$s">Hide Notice</a>)'), '?therm_nag_ignore=0');
        echo "</p></div>";
    }
}
add_action('admin_init', 'therm_nag_ignore');
function therm_nag_ignore() {
    global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        /*if ( isset($_GET['therm_nag_ignore']) && '0' == $_GET['therm_nag_ignore'] ) {
             add_user_meta($user_id, 'therm_ignore_notice', 'true', true);
    }
}
*/
?>