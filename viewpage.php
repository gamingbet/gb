<?php

if( !defined("__LOAD__") )

{

	exit();

	return false;

}

?>

<div class="historia_p">

<?php

if( 

	  ($_CUSTOM[ 'access' ] == "all") || 

	  ( $_CUSTOM[ 'access' ] == "users"  && $_GLOBALS[ 'login' ][ 'login' ] == true && isset( $_GLOBALS[ 'login' ][ 'access' ]) )  || 

	  ( $_CUSTOM[ 'access' ] == "admins" && $_GLOBALS[ 'login' ][ 'login' ] == true && $_GLOBALS[ 'login' ][ 'access' ] != "user" ) 

  )

{

	if( $_CUSTOM[ 'type' ] == "html" )

	{

		echo( stripslashes( $_CUSTOM[ 'content' . '-' . $_GLOBALS[ 'lang' ] ] ) );

	}

	else

	{

		$bbcode = new BBCode;

		echo( $bbcode->parse( stripslashes( $_CUSTOM[ 'content' . '-' . $_GLOBALS[ 'lang' ] ] ) ) );

	}

}

else

{

	if( $_CUSTOM[ 'access' ] == "admins" && $_GLOBALS[ 'login' ][ 'login' ] == true )

	{

		echo( $_LANG[ 'auth' ][ 'only_admin' ] );

	}

	else

	{

		echo( $_LANG[ 'auth' ][ 'need_login' ] );

	}

}



?>
</div>