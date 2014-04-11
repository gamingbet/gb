<section class="glowna_mecze_p">
<?php
if( !defined("__LOAD__") )
{
	exit();
	return false;
}
?>

<?php

require_once('files/template/menu.php');
$showAll = true;

if( !empty($_PAGES['type']) )

{

	$game = $db->prepare('SELECT *, DATE_FORMAT(`release`,"%d.%m.%Y") AS `release` FROM `games` WHERE `short` = :short LIMIT 1');

	$game->bindValue(':short', $_PAGES['type'], PDO::PARAM_STR);

	$game->execute();

	$result = $game->fetch();

	if( $result != false )
	{
		$showAll = false;
	}
	//var_dump($result); - jaka gra
}
if($showAll == false){



	echo '
	
	
	<div class="naglowek" style="background: url(../files/images/logos/'.$result['images'].') no-repeat center; background-size: cover;">
	<h1>
		'.$result['name'].'
 	</h1>
	</div>
	<p style="text-align: center;">
    <span>zobacz zakłady: </span>
	<a class="menu-g" href="/games/'.$result['short'].'/next">'.$_LANG['bets']['next'].'</a>
	<a class="menu-g" href="/games/'.$result['short'].'/live">'.$_LANG['bets']['live'].'</a>
	<a class="menu-g" href="/games/'.$result['short'].'/finished">'.$_LANG['bets']['finished'].'</a>
    </p>
	';

	echo('');
	$_GAMES['count'] = 0;
	// EVENTS
	$events = $db->prepare('SELECT * FROM `events` WHERE `gameId` = :gId ORDER BY `dataBegin` ASC');
	$events->bindValue(':gId', (int) $result['id'], PDO::PARAM_INT);
	$events->execute();
	if( $events->rowCount() > 0 )
	{
		while($event = $events->fetch())
		{
			if($_PAGES['more'] == 'live')
			{
				$matches = $db->prepare('SELECT *, DATE_FORMAT(`start`,"%d.%m.%Y %H:%i") AS `date-start` FROM `matches` WHERE `gameId` = :gId AND `eventsId` = :eId AND `finish` <> "true" AND `start` < NOW() ORDER BY `start` ASC');
			}
			else if($_PAGES['more'] == 'finished')
			{
				$matches = $db->prepare('SELECT *, DATE_FORMAT(`start`,"%d.%m.%Y %H:%i") AS `date-start` FROM `matches` WHERE `gameId` = :gId AND `eventsId` = :eId AND `finish` = "true" AND TIMESTAMPDIFF(DAY, `start`, NOW()) < 14 ORDER BY `start` DESC');
			}
			else
			{
				$matches = $db->prepare('SELECT *, DATE_FORMAT(`start`,"%d.%m.%Y %H:%i") AS `date-start` FROM `matches` WHERE `gameId` = :gId AND `eventsId` = :eId AND `finish` <> "true" AND `start` > NOW() ORDER BY `start` ASC');
			}
			$matches->bindValue(':gId', (int) $result['id'], PDO::PARAM_INT);
			$matches->bindValue(':eId', (int) $event['id'], PDO::PARAM_INT);
			$matches->execute();
			if( $matches->rowCount() > 0 )
			{
				echo('
				<h2>rozgrywki <a href="events/'.$event['id'].'">'.$event['name'].'</a></h2>
			');
				while( $match = $matches->fetch() )
				{
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
					echo '
					<div class="mecz_p">
			        	<div class="time"><time datetime="'.$match['start'].'">'.date('d.m.y H:i',strtotime($match['start'])).'</time></div>
			            <div class="team1"><a href="teams/'.$enemys[0]['tag'].'">'.$enemys[0]['fullname'].'</a>
						<a class="zaklad-1" href="'.$_PAGES['lang'].'/'.$bet['id'].'-1">'. getScore( $bet[ 'score-1' ] ) .'</a></div>
		                <div class="vs">vs</div>
		                <div class="team2"><a href="teams/'.$enemys[1]['tag'].'">'.$enemys[1]['fullname'].'</a>
						<a class="zaklad-2" href="'.$_PAGES['lang'].'/'.$bet['id'].'-2">'. getScore( $bet[ 'score-2' ] ) .'</a></div>
			        </div>';
				}
			}
			
		}
	}
	$matches = $db->prepare('SELECT *, DATE_FORMAT(`start`,"%d.%m.%Y %H:%i") AS `date-start` FROM `matches` WHERE `gameId` = :gId AND `eventsId` = 0 AND `finish` <> "true" AND `start` > NOW() ORDER BY `start` ASC');
	$matches->bindValue(':gId', (int) $result['id'], PDO::PARAM_INT);
	$matches->execute();
	if( $matches->rowCount() > 0 )
	{
		echo('<div class="wybor-gry">
				<span class="zaklad-txt">Inne mecze</span>
			</div>
			<div class="gra-mecze">
				<table>');
		while( $match = $matches->fetch() )
		{
			++$_GAMES['count'];
			$enemys = array(
				getGaming($match['teamId-1']),
				getGaming($match['teamId-2'])
			);
			$bets = $db->prepare('SELECT * FROM `bets` WHERE `matchId` = :mId AND `typeId` = 1 LIMIT 1');
			$bets->bindValue(':mId', (int) $match['id'], PDO::PARAM_INT);
			$bets->execute();
			$bet = $bets->fetch();
			$game = getGame($match['gameId']);
			echo '
			<tr>
	        	<td><time datetime="'.$match['start'].'">'.date('d.m.Y H:i',strtotime($match['start'])).'</time></td>
	            <td><a href="teams/'.$enemys[0]['tag'].'">'.$enemys[0]['fullname'].'</a><br /><a class="zaklad-1a" href="'.$_PAGES['lang'].'/'.$bet['id'].'-1">'. getScore( $bet[ 'score-1' ] ) .'</a></td>
                <td>vs</td>
                <td><a href="teams/'.$enemys[1]['tag'].'">'.$enemys[1]['fullname'].'</a><br /><a class="zaklad-2a" href="'.$_PAGES['lang'].'/'.$bet['id'].'-2">'. getScore( $bet[ 'score-2' ] ) .'</a></td>
                <td>
                    <a href="/bets/'.$match['0'].'">przejdź do zakładu</a>
                </td>
	        </tr>';

		}
		echo('</table>
		</div>');
	}
}



else{
	$games = $db->query('SELECT * FROM `games` ORDER BY `name` ASC');
	if( $games->rowCount() > 0 )
	{
		echo('<ul>');
		while($game = $games->fetch() )
		{
			echo('<li><a href="games/'.$game['short'].'">'.( (!empty($game['images'])) ? '<img src="files/images/logos/'.$game['images'].'" alt="'.$game['name'].'" class="small">' : $game['name']).'</a></li>');
		}
		echo('</ul>');
	}
	else
	{
		echo('<p>'.$_LANG['labels']['empty-gameList'].'</p>');
	}
}

?>
</section>