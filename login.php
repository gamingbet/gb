<?php
if( !defined("__LOAD__") )
{
    exit();
    return false;
}
?>        
<div class="historia_p">

<div style="width: 50%; margin: 0 auto;">
<?php
	if( $_GLOBALS[ 'login' ][ 'login' ] == true ){        
      echo "Jesteś już zalogowany";
}

else
{
	echo('
		<h2>Zaloguj się</h2>
		<form action="/" method="post">
		');
	if( isset( $_GLOBALS[ 'login' ][ 'errors' ] ) && !empty( $_GLOBALS[ 'login' ][ 'errors' ] ) )
	{
		echo('<ul class="errors">');
		foreach( $_GLOBALS[ 'login' ][ 'errors' ] as $error )
		{
			echo('<li>'. $error. '</li>');
		}
		echo('</ul>');
	}
	echo('<fieldset>
	
		<input type="text" class="login" name="auth_nick" id="auth_01" placeholder="'. $_LANG[ 'labels' ][ 'nick' ] .'" value="'. @$auth_nick .'" required>	
		<input type="password" class="login" name="auth_pass"  placeholder="'. $_LANG[ 'labels' ][ 'pw' ] .'" id="auth_02" required>
		');
		echo('
			<div class="center-button">
				<input class="przycisk-login submit" type="submit" name="auth_submit" value="'. $_LANG[ 'labels' ][ 'login' ] .'">
				<a href="register" class="zaloz-konto">'. $_LANG[ 'labels' ][ 'register' ] .'</a>
				<div class="links"><a href="forgot" >'. $_LANG[ 'labels' ][ 'forgot' ] .'</a></div>
			</div>
	</fieldset>');
	echo('</form>');
}
?>    
</div>

</div>