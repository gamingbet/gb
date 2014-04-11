</main>

<div class="powiadomienia">
	<h3>Twój kupon</h3>
	<div class="typy">
<?php
  	require('panels/bets.php'); // zakłady
?>
	</div>

</div>

<div class="ranking">
	<h3>Ranking użytkowników</h3>
	<?php 
//------------ranking użytkowników, 10 pierwszych-------------------------
    $i = 1;
    $konkurs = $db->query('SELECT `nick`, `credits` FROM `users` WHERE `credits` > 0 ORDER BY `credits` DESC LIMIT 10');
    echo('<ul>');
	while($user = $konkurs->fetch()){
		echo('<li>'.$i.' . '.$user['nick'].' <span>kredyty '.$user['credits'].'</span></li>');
		++$i;
    }
	echo('</ul>');
	?>
	
	<?php
        if( $_GLOBALS['login']['login'] == "true" ){
    ?>
	<!-- --------------------powiadomienia ---------------------- -->
	<h3>zakończone mecze</h3>
	<ul>
			<?php
				$_NOTICES = array(); // AND `finishTime` > "'.addslashes($_SESSION['auth']['last_visit']).'" 
				$matches = $db->query('SELECT * FROM `matches` WHERE `finish` = "true" AND `finishTime` <> "0000-00-00 00:00:00" AND DATEDIFF(`finishTime`, NOW()) < 14 ORDER BY `finishTime` DESC');
				$empty = false;
				if($matches->rowCount() != 0)
				{
					while($match = $matches->fetch())
					{
						// pobierz zaklady z zakonczonych meczow
						$bets = $db->query('SELECT * FROM `bets` WHERE `matchId` = "'.$match['id'].'"');
						if( $bets->rowCount() != 0 )
						{
							while( $bet = $bets->fetch() )
							{
								//  i sprawdz, czy user jakis obstawil
								$our = $db->query('SELECT * FROM `betusers` WHERE `betId` = "'.$bet['id'].'" AND `userId` = "'.$_USER['id'].'"');
								if($our->rowCount() != 0)
								{
									if( !@in_array( $match['id'], array_values($_NOTICES) ) )
										$_NOTICES[] = $match['id'];
								}
							}
						}
					}
				}
				if( empty($_NOTICES) )
				{
					echo('<li>'.$_LANG['notices']['empty'].'</li>');
				}
				else
				{
					foreach($_NOTICES as $matches)
					{
						$match = getMatch($matches);
						$game = getGame($match['gameId']);
						$enemys = array(
							getGaming($match['teamId-1']),
							getGaming($match['teamId-2'])
							);
						if($match['teamIdWin'] == '-1')
						{ //<img src="files/images/icons/'. $game[ 'logo' ].'" alt="'. $game[ 'name' ].'" style="vertical-align: middle;">
							// echo('<li> '.$match['finishTime'].' - '.$_LANG['notices']['cancel'].' <a href="bets/'.$match['id'].'">'.$enemys[0]['fullname'].' vs '.$enemys[1]['fullname'].'</a></li>');
						}
						else
						{ //<img src="files/images/icons/'. $game[ 'logo' ].'" alt="'. $game[ 'name' ].'" style="vertical-align: middle;">'.$_LANG['notices']['finish'].'
							echo('<li>'./*.$match['finishTime'].*/' <a href="bets/'.$match['id'].'"><span class="mecz1">'.$enemys[0]['fullname'].'</span> vs <span class="mecz2">'.$enemys[1]['fullname'].'</span></a></li>');
						}
					}
				}
				?>
	</ul>
    <?php } ?>
	
</div>

	<script src="https://code.jquery.com/jquery.js"></script>
	<script src="js/jquery.bpopup.min.js"></script>
    <script>
$(function() {

            // Binding a click event
            // From jQuery v.1.7.0 use .on() instead of .bind()
            $('#my-button').bind('click', function(e) {

                // Prevents the default action to be triggered. 
                e.preventDefault();

                // Triggering bPopup when click event is fired
                $('#element_to_pop_up').bPopup();

            });

        });


</script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-41050639-1', 'gamingbet.eu');
      ga('send', 'pageview');
    
    </script>
</body>
</html>



