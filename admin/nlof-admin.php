<?php
defined( 'ABSPATH' ) || exit;

add_action( 'admin_bar_menu','eos_fnlof_incognito_admin_menu',40 );
// Add button to swtich to incognito
function eos_fnlof_incognito_admin_menu( $wp_admin_bar ){
	if( !current_user_can( 'manage_options' ) ) return $wp_admin_bar;
	wp_nonce_field( 'eos_fnlof_setts_nonce','eos_fnlof_setts_nonce' );
	$activation = !isset( $_COOKIE['fnlof_incognito'] ) ? true : $_COOKIE['fnlof_incognito'];
	if( $activation && 'false' !== $activation ){
		$class = 'eos-fnlof-active';
		$title = __( 'Incognito enabled','fnlof' );
	}
	else{
		$class = 'eos-fnlof-not-active';
		$title = __( 'Incognito disabled','fnlof' );
	}
	$wp_admin_bar->add_menu( array(
		'id'    => 'eos-fnlof',
		'title' => '<span id="eos-fnlof-wrp" class="'.esc_attr( $class ).'" data-active-msg="'.esc_attr__( 'Incognito enabled','fnlof' ).'" data-disabled-msg="'.esc_attr__( 'Incognito disabled','fnlof' ).'"></span>',
		'href' => '#',
		'meta' => array( 'class' => 'eos-fnlof-link','title' => esc_attr( $title ) )
	));		
	return $wp_admin_bar;
}

add_action( 'admin_head','eos_fnlof_admin_style' );
//Add admin inline style
function eos_fnlof_admin_style(){
?>	
	<style id="fnlof-admin-style" type="text/css">
		#eos-fnlof-wrp:before{
			content:url(<?php echo EOS_FNLOF_URL.'/admin/assets/images/incognito.png'; ?>);
			position:relative;
			padding:6px;
			bottom:-4px
		}
		#eos-fnlof-wrp:hover{
			opacity:0.7
		}
		#eos-fnlof-wrp.eos-fnlof-not-active{
			opacity:0.3
		}
		#eos-fnlof-wrp.eos-fnlof-active,
		#eos-fnlof-wrp.fnlof-progress{
			opacity:1
		}
		#eos-fnlof-wrp.fnlof-progress:before{
			content:url(<?php echo EOS_FNLOF_URL.'/admin/assets/images/ajax-loader.gif'; ?>);
		}
	</style>
<?php
}
//Enque scripts and styles
add_action( 'admin_footer','eos_fnlof_admin_script' );
function eos_fnlof_admin_script(){
	?>
	<script>
	document.getElementById('eos-fnlof-wrp').addEventListener('click',function(){
		var button = document.getElementById('eos-fnlof-wrp');
		if(button.className.indexOf('eos-fnlof-active') > -1){
			button.className = button.className.replace('eos-fnlof-active','eos-fnlof-not-active');
			button.parentNode.setAttribute('title',button.getAttribute('data-disabled-msg'));
			fnlof_set_cookie("fnlof_incognito","false",99999);
		}
		else{
			button.className = button.className.replace('eos-fnlof-not-active','eos-fnlof-active');
			button.parentNode.setAttribute('title',button.getAttribute('data-active-msg'));
			fnlof_set_cookie("fnlof_incognito","true",99999);
		}
		return false;
	});
	function fnlof_set_cookie(e,s,o){
		var t, n;
		o ? ((t = new Date).setTime(t.getTime() + 24 * o * 60 * 60 * 1e3),
		n = "; expires=" + t.toGMTString()) : n = "",
		document.cookie = e + "=" + s + n + "; path=/"
	}
	</script>
	<?php
}