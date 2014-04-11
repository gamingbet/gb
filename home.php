<?php
	if( !(__LOAD__) ){
		exit();
		return false;
	}

/* Short and sweet */
//	define('WP_USE_THEMES', false);
//	require('../info/wp-blog-header.php');


// Navigation menu section
	require_once('files/template/menu.php');
	
	
// ------------- mecze --------------
	$games = $db->prepare('SELECT *, DATE_FORMAT(`release`,"%d.%m.%Y") AS `release` FROM `games`');
	$games ->execute();
	$games_result = $games->fetchAll();
	foreach ($games_result as $games_value) {
		$game = $db->prepare('SELECT *, DATE_FORMAT(`release`,"%d.%m.%Y") AS `release` FROM `games` WHERE `short` = :short LIMIT 1');
		$game->bindValue(':short', $games_value['short'], PDO::PARAM_STR);
		$game->execute();
		$result = $game->fetch();
		if( $result != false ){
			$showAll = false;
		}
		$_GAMES['count'] = 0;
		$matches = $db->prepare('SELECT *, DATE_FORMAT(`start`,"%d.%m.%Y %H:%i") AS `date-start` FROM `matches`
		JOIN `bets` ON `bets`.`matchId` = `matches`.`id` AND `bets`.`typeId` = 1 AND `bets`.`active` = "true" AND `matches`.`finish` <> "true"
		WHERE `gameId` = :gId AND `finish` <> "true" AND `start` > NOW() ORDER BY `start` ASC LIMIT 10');
		$matches->bindValue(':gId', (int) $result['id'], PDO::PARAM_INT);
		$matches->execute();
		if( $matches->rowCount() > 0 ){
			echo('
				<section class="glowna_mecze">
				<div class="naglowek" style="background-image: url(files/images/logos/'.$result['images'].')">
				<h1>'.$result['name'].'</h1>
				</div>
				<table>
			');
			for($i=1;  $i<= 10; $i++){
				while( $match = $matches->fetch() ){
					++$_GAMES['count'];
					$enemys = array(
						getGaming($match['teamId-1']),
						getGaming($match['teamId-2'])
					);
					$bets = $db->prepare('SELECT * FROM `bets` WHERE `matchId` = :mId AND `typeId` = 1 LIMIT 1');
					$bets->bindValue(':mId', (int) $match['0'], PDO::PARAM_INT);
					$bets->execute();
					$bet = $bets->fetch();
					$game = getGame($match['gameId']);
					if($match['stream'] == 'http://') {
						$match['stream'] = '#';
					}
					echo '<div class="mecz">
						
						<div class="time">'.date('d.m.y H:i',strtotime($match['start'])).'</div>
						<div class="team1"><a href="teams/'.$enemys[0]['tag'].'">'.$enemys[0]['fullname'].'</a>'; 
						echo (($match['teamWinId'] == '0')?'<a class="zaklad-1" href="'.$_PAGES['lang'].'/'.$bet['id'].'-1">':'').getScore( $bet[ 'score-1' ] )
						.(($match['teamWinId'] == '0')?'</a></div>':'</div>');
						echo'
						<div class="vs"><a href="/bets/'.$match['0'].'">vs</a></div>
						<div class="team2"><a href="teams/'.$enemys[1]['tag'].'">'.$enemys[1]['fullname'].'</a>';
						echo (($match['teamWinId'] == '0')?'<a class="zaklad-2" href="'.$_PAGES['lang'].'/'.$bet['id'].'-2">':'').getScore( $bet[ 'score-2' ] )
						. (($match['teamWinId'] == '0')?'</a></div>':'</div>');
						echo '</div>';
				}
			}
			echo ('
				</table>
				</section>
			');
		} 
	}
?> 


