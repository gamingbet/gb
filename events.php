<?php
if( !defined("__LOAD__") )
{
	exit();
	return false;
}
$events = $db->prepare('SELECT *, (SELECT `name-pl` FROM `countries` WHERE `countries`.`id` = `events`.`countryId`) AS `country-pl`, 
(SELECT `name-en` FROM `countries` WHERE `countries`.`id` = `events`.`countryId`) AS `country-en`,
DATE_FORMAT(`dataBegin`,"%d.%m.%Y %H:%i") AS `dataBegin`, DATE_FORMAT(`dataEnd`,"%d.%m.%Y %H:%i") AS `dataEnd` FROM `events` WHERE `id` = :id LIMIT 1');
$events->bindValue(":id", $_PAGES['type'], PDO::PARAM_STR);
$events->execute();


if( $events->rowCount() ){
	$event = $events->fetch();
	$game = getGame($event['gameId']);
	$bbcode = new BBCode;
	$content = $bbcode->parse($event['description-'.$_GLOBALS['lang']]);
	//var_dump($event);
	
	if(!empty($event['images'])) echo 'style="background: url(files/images/events/'.$event['images'].'" alt="'.$game['name'].') no-repeat center; background-size: cover;'; // obrazek tła
		
	// nazwa eventu
	echo $event['name'].
		$_LANG['labels']['www'].'<a href="'.$event['url'].'">'.$event['name'].'</a>'; // link do strony www
	
	//zapytanie wyciaga liste meczy
	$matches = $db->prepare('SELECT *, DATE_FORMAT(`start`,"%d.%m.%Y %H:%i") AS `date-start` FROM `matches` WHERE `eventsId` = :eId ORDER BY `start` DESC');
	$matches->bindValue(':eId', (int) $event['id'], PDO::PARAM_INT);
	$matches->execute();
	$_GAMES['count'] = 0;	
	
	echo('<table>');	
	if( $matches->rowCount() > 0 ) // lista meczy
	{
		while( $match = $matches->fetch() )
		{
			++$_GAMES['count'];
			$enemys = array(
				getGaming($match['teamId-1']),
				getGaming($match['teamId-2'])
			);
			$game = getGame($match['gameId']);
			$bets = $db->prepare('SELECT * FROM `bets` WHERE `matchId` = :mId AND `typeId` = 1 LIMIT 1');
			$bets->bindValue(':mId', (int) $match['0'], PDO::PARAM_INT);
			$bets->execute();
			$bet = $bets->fetch();
			echo '<tr>
			<td><time datetime="'.$match['start'].'">'.date('d.m.y', strtotime($match['start'])).'<br />'.date('H:i', strtotime($match['start'])).'</time><br /><img src="files/images/icons/'.$game['logo'].'" alt="'.$game['short'].'"></td>

	            <td><a href="teams/'.$enemys[0]['tag'].'">'.$enemys[0]['fullname'].'</a><br />';

	            echo (($match['teamWinId'] == '0')?'<a class="zaklad-1a" href="'.$_PAGES['lang'].'/'.$bet['id'].'-1">':'<span class="label label-default">').getScore( $bet[ 'score-1' ] )

				. (($match['teamWinId'] == '0')?'</a>':'</span>');

	            echo '</td>
	            <td>vs</td>
	            <td><a href="teams/'.$enemys[1]['tag'].'">'.$enemys[1]['fullname'].'</a><br />';
	            echo (($match['teamWinId'] == '0')?'<a class="zaklad-2a" href="'.$_PAGES['lang'].'/'.$bet['id'].'-2">':'<span class="label label-default">').getScore( $bet[ 'score-2' ] )
				. (($match['teamWinId'] == '0')?'</a>':'</span>');
				if($match['stream'] == 'http://'){
					$match['stream'] = '#';
				}
	            echo '</td>
	            <td>
	                    			
	                                   <a style="color:#525252;" href="/bets/'.$match['0'].'">przejdź do zakładu</a>
	            </td>
	        </tr>';
			}
			echo('</table>');
	}
}

// a tu nie wiem co się dzieje.
else{
	
	echo('<h1>Trunieje</h1><ul class="links noleft">
	<li class="first"><a href="events/'.( (isset($showGame) && $showGame == true)?$_PAGES['type'].'/':'').'next">'.$_LANG['bets']['next'].'</a></li>
	<li><a href="events/'.( (isset($showGame) && $showGame == true)?$_PAGES['type'].'/':'').'live">'.$_LANG['bets']['live'].'</a></li>
	<li class="last"><a href="events/'.( (isset($showGame) && $showGame == true)?$_PAGES['type'].'/':'').'finished">'.$_LANG['bets']['finished'].'</a></li>
	</ul>');
	if( isset($showGame) && $showGame == true )
	{
		if($_PAGES['more'] == 'live')
		{
			$events = $db->query('SELECT *, DATE_FORMAT(`dataBegin`,"%d.%m.%Y %H:%i") AS `dataBegin1`, DATE_FORMAT(`dataEnd`,"%d.%m.%Y %H:%i") AS `dataEnd1` FROM `events` WHERE (`dataBegin`) < NOW() AND (`dataEnd`) > NOW() AND `gameId` = '.$_GLOBALS['game']['id'].' ORDER BY `dataEnd` ASC');
		}
		else if($_PAGES['more'] == 'finished')
		{
			$events = $db->query('SELECT *, DATE_FORMAT(`dataBegin`,"%d.%m.%Y %H:%i") AS `dataBegin1`, DATE_FORMAT(`dataEnd`,"%d.%m.%Y %H:%i") AS `dataEnd1` FROM `events` WHERE (`dataBegin`) < NOW() AND (`dataEnd`) < NOW() AND `gameId` = '.$_GLOBALS['game']['id'].' ORDER BY `dataEnd` DESC');
		}
		else
		{
			$events = $db->query('SELECT *, DATE_FORMAT(`dataBegin`,"%d.%m.%Y %H:%i") AS `dataBegin1`, DATE_FORMAT(`dataEnd`,"%d.%m.%Y %H:%i") AS `dataEnd1` FROM `events` WHERE (`dataBegin`) > NOW() AND (`dataEnd`) > NOW() AND `gameId` = '.$_GLOBALS['game']['id'].' ORDER BY `dataBegin` ASC');
		}
	}
	else
	{
		if($_PAGES['type'] == 'live')
		{
			$events = $db->query('SELECT *, DATE_FORMAT(`dataBegin`,"%d.%m.%Y %H:%i") AS `dataBegin1`, DATE_FORMAT(`dataEnd`,"%d.%m.%Y %H:%i") AS `dataEnd1` FROM `events` WHERE (`dataBegin`) < NOW() AND (`dataEnd`) > NOW() ORDER BY `dataEnd` ASC');
		}
		else if($_PAGES['type'] == 'finished')
		{
			$events = $db->query('SELECT *, DATE_FORMAT(`dataBegin`,"%d.%m.%Y %H:%i") AS `dataBegin1`, DATE_FORMAT(`dataEnd`,"%d.%m.%Y %H:%i") AS `dataEnd1` FROM `events` WHERE (`dataBegin`) < NOW() AND (`dataEnd`) < NOW() ORDER BY `dataEnd` DESC');
		}
		else
		{
			$events = $db->query('SELECT *, DATE_FORMAT(`dataBegin`,"%d.%m.%Y %H:%i") AS `dataBegin1`, DATE_FORMAT(`dataEnd`,"%d.%m.%Y %H:%i") AS `dataEnd1` FROM `events` WHERE (`dataBegin`) > NOW() AND (`dataEnd`) > NOW() ORDER BY `dataBegin` ASC');
		}
	}
	if( $events->rowCount() )
	{
		echo('<table class="history">');
		echo('<tr>
		<td class="short">'.$_LANG['events']['game'].'</td>
		<td class="w100">'.$_LANG['events']['dataBegin'].'</td>
		<td class="w100">'.$_LANG['events']['dataEnd'].'</td>
		<td class="w100">'.$_LANG['events']['bets'].'</td>
		<td>'.$_LANG['events']['name'].'</td>
		</tr>');
		while($event = $events->fetch())
		{
			$game = getGame($event['gameId']);
			$matches = $db->query('SELECT COUNT(`id`) FROM `matches` WHERE `eventsId` = '.$event['id']);
			$match = $matches->fetch();
			echo('<tr>');
			echo('<td class="game"><img src="files/images/icons/'. $game[ 'logo' ].'" alt="'. $game[ 'name' ].'"></td>');
			//echo('<td>'.$event['dataBegin1'].'</td>');
			echo('<td>'.date('d.m.y H:i',strtotime($event['dataBegin'])).'</td>');
			//echo('<td>'.$event['dataEnd1'].'</td>');
			echo('<td>'.date('d.m.y H:i',strtotime($event['dataEnd'])).'</td>');
			echo('<td style="text-align: center;">'.$match[0].'</td>');
			echo('<td><a href="events/'.$event['id'].'">'.$event['name'].'</a></td>');
			echo('</tr>');
		}
		echo('</table>');
	}
	else
	{
		echo('<p>'.$_LANG['labels']['empty-box'].'</p>');
	}
}
?>