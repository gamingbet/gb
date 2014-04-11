<?php

if( !defined("__LOAD__") )

{

	exit();

	return false;

}

?>
<div class="historia_p">
<h2>Obstawione mecze</h2>
<p class="info">W tym miejscu znajdziesz wszystkie kupony, które obstawiłeś</p>
<?php
if( $_GLOBALS[ 'login' ][ 'login' ] == false )

{
	echo( $_LANG[ 'auth' ][ 'need_login' ] );
	return false;
}

$sql = $db->prepare('SELECT *, DATE_FORMAT(`date`,"%d.%m.%Y %H:%i") AS `date-format` FROM `betusers` WHERE `userId` = :uid AND `active` = "true" ORDER BY `date` DESC, `id` DESC ');
$sql->bindValue(':uid', $_USER['id'], PDO::PARAM_STR);
$sql->execute();

if($sql->rowCount() > 0 )
{
	echo('<table>');
	echo('<tr>');
	echo('<th class="bid">'.$_LANG['history']['bid'].'</th>');
	echo('<th class="data-zakladu">'.$_LANG['history']['date'].'</th>');
	echo('<th class="wartosc">'.$_LANG['history']['credits'].'</th>');
	echo('<th class="jaki-mecz">Mecz</th>');
	echo('<th class="typ-kuponu">'.$_LANG['history']['type'].'</th>');
	echo('<th class="wynik-zakladu">'.$_LANG['history']['result'].'</th>');
	echo('</tr>
	</table>');
	$i = 1; // variable for coupon border bottom
	$j = 0; // variable for delete border bottom
	$all = $sql->rowCount();
	$last_coupon_id = NULL;
	$first = true;
	while( $result = $sql->fetch() ){
		$coupon_id = $result['couponId'];	
		if($result['couponId'] == "0" || $last_coupon_id != $coupon_id) {
        if(!$first) {
            echo '</table>';
        }
        $first = false;
        echo '<table>';
    	}
		++$j;
		
		$count_coupon = $db->prepare('SELECT COUNT(*) AS `count` FROM `betusers` WHERE `couponId` = :bid');
		$count_coupon->bindValue(':bid', $coupon_id, PDO::PARAM_STR);
		$count_coupon->execute();
		$count_coupon = $count_coupon->fetch();
		$count = $count_coupon['count']-1;
		if($coupon_id == $last_coupon_id)
		{
			++$i;
		}
		else
		{
			$i = 1;
		}
		$bet = getBet($result['betId']);
		$match = getMatch($bet['matchId']);
		$game = getGame($match['gameId']);
		$enemys = array(
			getGaming($match['teamId-1']),
			getGaming($match['teamId-2'])
			);
		$type = getTypes($bet['typeId']);
		$last_coupon_id = $coupon_id;	
		echo('<tr>');
		echo('<td class="bid">');
		if ($result['couponId'] != "0") echo ('<a href="coupon/'.$result['couponId'].'">'.$result['couponId'].'</a></td>');
		echo('<td class="data-zakladu"><time datetime="'.$result['date'].'">'.date('d.m.y', strtotime($result['date'])).'</time></td>');
		echo('<td class="wartosc">'.$result['credits'].'</td>');
		echo ('<td class="jaki-mecz"><a href="bets/'.$bet['matchId'].'">'.$enemys[0]['tag'].' vs '.$enemys[1]['tag'].'</a></td>');
		echo('<td class="typ-kuponu">'.strtolower( ($result['couponId'] == "0") ? $_LANG['labels']['once'] : '<a href="coupon/'.$result['couponId'].'">'.$_LANG['labels']['multiply'].'</a><br />'.$count.' '.$_LANG['labels']['other-bets']).'</td>');
		echo('<td class="wynik-zakladu">');
			if($match['teamWinId'] == "-1")
			{
				echo('<span class="gray">'.$_LANG['labels']['canceled'].'</span>');
			}
			else if($bet['optionWin'] == "0")
			{
				echo($_LANG['labels']['notyet']);
			}
			else if($bet['optionWin'] == "1")

			{
				if( $result['type'] == "1" )
					echo('<span class="green">'.$_LANG['labels']['win'].'</span>');
				else
					echo('<span class="red">'.$_LANG['labels']['lose'].'</span>');
			}
			else if($bet['optionWin'] == "2")
			{
				if( $result['type'] == "2" )
					echo('<span class="green">'.$_LANG['labels']['win'].'</span>');
				else
					echo('<span class="red">'.$_LANG['labels']['lose'].'</span>');
			}
			else
			{
				if( $bet['type'] == "3" )
					echo('<span class="green">'.$_LANG['labels']['draw'].'</span>');
				else
					echo('<span class="red">'.$_LANG['labels']['draw'].'</span>');
			}
		echo('</td>');
		echo('</tr>');
		
	}
if(!$first){
		    echo '</table>';
		}
}
else
{
	echo($_LANG['history']['empty']);
}



?>
</div>