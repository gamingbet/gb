<?php /*
					// Menu before game-lists, poostałości, nie umiem inaczej ustawić tego :P
					$menu[ 'before' ] = $db->query( 'SELECT * FROM `menu` WHERE `position` = "before" ORDER BY `lp` ASC' );
					while( $menu[ 'left' ] = $menu[ 'before' ]->fetch() )
					{
						echo('<li><a class="news" href="'. stripslashes($menu[ 'left' ][ 'link' ]) .'">'. $_LANG[ 'menu' ][ $menu[ 'left' ][ 'name' ] ] .'</a></li>');
					}
                	// Menu after game-lists
					$menu[ 'after' ] = $db->query( 'SELECT * FROM `menu` WHERE `position` = "after" ORDER BY `lp` ASC' );
					while( $menu[ 'right' ] = $menu[ 'after' ]->fetch() )
					{
						echo('<li><a href="'. stripslashes($menu[ 'right' ][ 'link' ]) .'">'. $_LANG[ 'menu' ][ $menu[ 'right' ][ 'name' ] ] .'</a></li>');
			
					}
					if( $_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'change-lang' ] == "true" )
					echo('
					<li>'.$_LANG[ 'labels' ][ 'jezykzmiana' ].'
						<ul>
						<li><a href="'.$_PAGES[ 'lang' ].'/pl">'.$_LANG[ 'labels' ][ 'jezykpolski' ].' <img src="files/images/pl.png" alt="Polska wersja"></a></li>
						<li><a href="'.$_PAGES[ 'lang' ].'/en">'.$_LANG[ 'labels' ][ 'jezykang' ].' <img src="files/images/en.png" alt="English version"></a></li>
						</ul>
					</li>
					');


	require_once( 'modules.php' ); // ładowanie modułów


	
	
//---------------stopka---------------------------
	if(!empty($_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'ads' ][ 'ads_footer' ]))	echo(stripslashes($_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'ads' ][ 'ads_footer' ]));

	// Menu before game-lists, stopka linki
	$menu[ 'footer' ] = $db->query( 'SELECT * FROM `menu` WHERE `position` = "footer" ORDER BY `lp` ASC' );
	$menu[' footer' ][ 'count' ] = $menu[ 'footer' ]->rowCount();
	echo('<ul>');
	while( $menu[ 'bottom' ] = $menu[ 'footer' ]->fetch() )
	{
		echo('<li><a href="'. stripslashes($menu[ 'bottom' ][ 'link' ]) .'">'. $_LANG[ 'footer' ][ $menu[ 'bottom' ][ 'name' ] ] .'</a></li>');
		$menu[' footer' ][ 'count' ]--;
	}
	echo ('</ul>');
	echo($_LANG[ 'footer' ][ 'about-us-txt' ]);  // text w stopce
	?>	


				*/
			?>
			