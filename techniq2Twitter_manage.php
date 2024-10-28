<?php 
	//update_option('twitterInitialised', '0');
	//SETS DEFAULT OPTIONS
	if(get_option('twitterInitialised') != '1'){

		update_option('newpost-published-update', '1');
		update_option('newpost-published-text', 'Nuevo artículo: #title#');
		update_option('newpost-published-showlink', '1');


		update_option('twitterInitialised', '1');
	}
	

	if($_POST['submit-type'] == 'options'){
		//UPDATE OPTIONS

		update_option('newpost-published-update', $_POST['newpost-published-update']);
		update_option('newpost-published-text', $_POST['newpost-published-text']);
		update_option('newpost-published-showlink', $_POST['newpost-published-showlink']);


	}else if ($_POST['submit-type'] == 'login'){
		//UPDATE LOGIN
		if(($_POST['twitterlogin'] != '') AND ($_POST['twitterpw'] != '')){
			update_option('twitterlogin', $_POST['twitterlogin']);
			update_option('twitterlogin_encrypted', base64_encode($_POST['twitterlogin'].':'.$_POST['twitterpw']));

		}else{
			echo("<div style='border:1px solid red; padding:20px; margin:20px; color:red;'>Debes escribir usuario y contraseña de twitter!</div>");
		}
	}

	// FUNCTION to see if checkboxes should be checked
	function vc_checkCheckbox($theFieldname){
		if( get_option($theFieldname) == '1'){
			echo('checked="true"');
		}
	}
?>
<style type="text/css">
	fieldset{margin:20px 0; 
	border:1px solid #cecece;
	padding:15px;
	}
</style>
<div class="wrap">
	<h2>Opciones</h2>

	<form method="post">
	<div>
			<legend>
				Lanza un twitt automático cuando publicas un post. El enlace lo acorta a través de <a href="http://niq.mx">niq.mx</a>
			</legend>
			<p style="display:none">
				<input type="checkbox" name="newpost-published-update" id="newpost-published-update" value="1" checked="true" />
				<label for="newpost-published-update">Update Twitter when the new post is published</label>
			</p>
			<p>
				<label for="newpost-published-text">Texto para el twitt automático ( usa #title# para colocar el título del post )</label><br />
				<input type="text" name="newpost-published-text" id="newpost-published-text" size="60" maxlength="146" value="<?php echo(get_option('newpost-published-text')) ?>" />
				&nbsp;&nbsp;
				<input type="checkbox" name="newpost-published-showlink" id="newpost-published-showlink" value="1" <?php vc_checkCheckbox('newpost-published-showlink')?> />
				<label for="newpost-published-showlink">incluir título?</label>
			</p>
		</fieldset>
		

		<input type="hidden" name="submit-type" value="options">
		<input type="submit" name="submit" value="guardar cambios" />
	</div>
	</form>
</div>

<div class="wrap">
	<h2>Detalles de tu cuenta de twitter</h2>
	
	<form method="post" >
	<div>
		<p>
		<label for="twitterlogin">Email o usuario de twitter:</label>
		<input type="text" name="twitterlogin" id="twitterlogin" value="<?php echo(get_option('twitterlogin')) ?>" />
		</p>
		<p>
		<label for="twitterpw">Tu password de twitter:</label>
		<input type="password" name="twitterpw" id="twitterpw" value="" />
		</p>
		<input type="hidden" name="submit-type" value="login">
		<input type="submit" name="submit" value="guardar login" />
		
	</div>
	</form>
	
</div>

<div class="wrap">
	<h2>ayuda?</h2>
	<p>Visit the <a href="http://techniq.mx/plugins/">Página del plugin</a>.</p>
</div>