<?php 
$enabled = osc_get_preference('minify_enabled', 'minify');
$is_outdated = ( (float)OSCLASS_VERSION < 3.3 );
?>
<style>
	#minify {
		width: 720px;
		float: left;
	}
	#minify .float-left {
		float: left;
		width: 250px;
		padding: 0;
	}
	#minify .float-left form {
		display: block;
		float: left;
		padding: 20px;
		background: #eaeaea;
	}
	#minify .float-right {
		float: right;
		width: 450px;
	}
	#minify .float-left {
		float: left;
	}
	#minify .switch {
		width: 60px;
		height: 34px;
		float: left;
		background: #fff;
		position: relative;
		border: 1px solid #ccc;
	}
	#minify .switch .bg {
		height: 24px;
		margin: 5px;
		background: #333;
		z-index: 1;
	}
	#minify .switch .bg span {
		display: block;
		float: left;
		width: 25px;
		height: 24px;
	}
	#minify .switch .bg span.enabled {
		background: #00BED6;
	}
	#minify .switch .bg span.disabled {
		background: #D90000;
	}
	#minify .switch .handle {
		height: 28px;
		width: 25px;
		background: #333;
		position: absolute;
		left: 5px;
		bottom: 3px;
		-webkit-transition: left 200ms linear;
	    -moz-transition: left 200ms linear;
	    -o-transition: left 200ms linear;
	    -ms-transition: left 200ms linear;
	    transition: left 200ms linear;
	}
	#minify .switch .loader {
		position: absolute;
		top: 0;
		left: 0;
		width: 60px;
		height: 35px;
		background: #fff;
		opacity: 0;
		z-index: 0;
		-webkit-transition: left 200ms linear;
	    -moz-transition: left 200ms linear;
	    -o-transition: left 200ms linear;
	    -ms-transition: left 200ms linear;
	    transition: left 200ms linear;
	}
	#minify .switch.enabled .bg {
		background: #FF4000;
	}
	#minify .switch.enabled .bg {
		background: #FF4000;
	}
	#minify .switch.enabled .handle {
		left: 30px;
	}
	#minify .switch.loading .loader {
		opacity: .6;
		z-index: 2;
	}
	#minify .switch.loading .loader img {
		display: block;
		margin: 7px auto;
	}
	#minify form label {
		display: block;
		float: left;
		line-height: 35px;
		font-weight: bold;
		width: 130px;
		margin-right: 15px;
	}
	pre {
		width: 450px;                          /* specify width  */
		white-space: pre-wrap;                 /* CSS3 browsers  */
		white-space: -moz-pre-wrap !important; /* 1999+ Mozilla  */
		white-space: -pre-wrap;                /* Opera 4 thru 6 */
		white-space: -o-pre-wrap;              /* Opera 7 and up */
		word-wrap: break-word;                 /* IE 5.5+ and up */
	}
	pre:hover {
		position: relative;
		width: 700px;
		z-index: 99;
	
</style>
<div id="minify" class="plugin-configuration form-horizontal">
	<div class="float-left">
		<h1><?=_e('Minifyer', 'minify') ?></h1>
		<form id="plugin-form" action="<?php echo osc_admin_base_url(true); ?>?page=plugins" method="post">
			<label><?=_e('Enabled?', 'minify')?></label>
			<div class="switch <?=( (!$enabled )? '' : 'enabled' )?>">
				<div class="bg">
					<span class="enabled"></span>
					<span class="disabled"></span>
				</div>
				<div class="handle"></div>
				<div class="loader">
					<img src="<?=osc_plugin_url('minifyer/img').'img/loader32.gif'?>" width="20" align="center"/>
				</div>
			</div>
		</form>	
	</div>
	<div class="float-right">
		<h1>About</h1>
		<div class="description">
			<h3><?_e('Load you ad\'s site faster than ever before!','minify')?></h3>
			<p><?_e('This plugin is a wrapper for the php Minify library created by <a target="_blak" href="https://github.com/mrclay">Steve Clay</a>.','minify')?></p>
			<h3><?_e('What it does?','minify')?></h3>
			<p><?_e('It compresses sources of content 
(usually files), combines the result and serves it with appropriate 
HTTP headers. These headers can allow clients to perform conditional 
GETs (serving content only when clients do not have a valid cache) 
and tell clients to cache the file for a period of time.','minify')?></p>
			<span class="creator"><?=sprintf( _m('Copied from %s','minify'), '<a target="_blak" href="https://github.com/mrclay/minify">https://github.com/mrclay/minify</a>' )?></span>
			<h3><?_e('Instructions','minify')?></h3>
			<p><?_e('In order for this plugin to do it\'s job, the scripts need to be in the 
			queue to be loaded, that means you you have to register and queue your 
			scripts and styles ( obs: styles don\'t need to be registered ).','minify');?></p>
			<h4><?_e('For scripts:', 'minify')?></h4>
			<pre>osc_register_script('my_theme', osc_plugin_url(__FILE__).'js/my_theme.js')<br/>osc_enqueue_script('my_theme');</pre>
			<h4><?_e('For styles:', 'minify')?></h4>
			<pre>osc_enqueue_style('my_theme', osc_plugin_url(__FILE__).'js/my_theme.js' );</pre>
			<p><?_e('Once you have this, all you have to do is enable the plugin and voalÃ¡, all 
			your css and js are minified and cached.','minify');?></p>
			<p><?=sprintf( _m('If you want to know more about the Minify library go to it\'s page at Github - %s','minify'), '<a target="_blak" href="https://github.com/mrclay/minify">https://github.com/mrclay/minify</a>')?></p>
			<br/>
			<br/>
			<p><?_e('Created by','minify')?> Jair Milanes Junior</p>
			<p><?_e('More OsClass plugins at <a href="http://blog.layoutz.com.br" target="_blak">blog.layoutz.com.br</a>','minify')?></p>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#minify .switch').on('click', function(){
		minify_loading(true);
		<? if( !$is_outdated ){ ?>
		var value = '';
		if( $(this).hasClass('enabled') ){
			value = 0;} else {
		value = 1; }
		var url = "<?=osc_ajax_plugin_url('minifyer/ajax.php');?>";
		var self = $(this);
		$.post( url, { minify_enabled: value }, function(json){
			if( true == json.status ){
				self.toggleClass('enabled'); }
			else { alert('<?_e('Problems during update!', 'minify')?>'); }
			minify_loading(false);
		},'json');	
		
		<? } else { ?>
			if( confirm('Incompatible OsClass version, you need to upgrade to 3.3 or higher.<br/>Go to update page?') ){
				window.location = "<?=osc_admin_base_url(true) . "?page=tools&action=upgrade";?>";
			}
			minify_loading(false);
		<?php } ?>
	});
	
	function minify_loading( load ){
		if( !load ){
			$('#minify .switch').removeClass('loading'); }
		else { $('#minify .switch').addClass('loading'); }
	}

	<? if( $is_outdated ){ ?>
		$('.jsMessage')
			.removeClass('flashmessage-info flashmessage-error flashmessage-ok')
			.addClass('flashmessage-error')
			.fadeIn('fast')
			.find('p')
			.html('Incompatible OsClass version (<?=OSCLASS_VERSION?>), this plugin it is only compatible with versions 3.3 and up! <a href="<?=osc_admin_base_url(true) . "?page=tools&action=upgrade"?>">Go to the update page >></a>');
	<?php } ?>
});
</script>