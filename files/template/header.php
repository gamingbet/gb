<?php
/* Detects some common web bots
	function detectBot($USER_AGENT) {
    $crawlers_agents = strtolower('Bloglines subscriber|Dumbot|Sosoimagespider|QihooBot|FAST-WebCrawler|Superdownloads Spiderman|LinkWalker|msnbot|ASPSeek|WebAlta Crawler|Lycos|FeedFetcher-Google|Yahoo|YoudaoBot|AdsBot-Google|Googlebot|Scooter|Gigabot|Charlotte|eStyle|AcioRobot|GeonaBot|msnbot-media|Baidu|CocoCrawler|Google|Charlotte t|Yahoo! Slurp China|Sogou web spider|YodaoBot|MSRBOT|AbachoBOT|Sogou head spider|AltaVista|IDBot|Sosospider|Yahoo! Slurp|Java VM|DotBot|LiteFinder|Yeti|Rambler|Scrubby|Baiduspider|accoona');
    $crawlers = explode("|", $crawlers_agents);
    if(is_array($crawlers)){
        foreach($crawlers as $crawler) {
            if (strpos(strtolower($USER_AGENT), trim($crawler)) !== false) {
                return true;
            }
        }
    }
    return false;
}
 


	$result = $db->query("SELECT * FROM `ad` WHERE id = 0");
	$ad = $result->fetch();
	$ad_endabled = (bool) $ad['ad_endabled'];
	if($ad_endabled) {
		if($_COOKIE['ad_watched'] == 1) {
			$ad_endabled = FALSE;
		} else {
			//Usage:
			if(detectBot($_SERVER['HTTP_USER_AGENT']) && $_GLOBALS[ 'login' ][ 'login' ] == true) {
				 
			}
			else{
				header("Location: http://gamingbet.eu/start/index.html");
				}
			setcookie('ad_watched', 1, time() + 3600*6);
		}
	}
	*/
?>
<!DOCTYPE html>
<html lang="pl">  
<head>  
	<meta charset="UTF-8">
	<meta name="keywords" content="<?php echo($_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'keywords' ]); ?>">
	<meta name="description" content="<?php echo($_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'description' ]); ?>">
	<title><?php echo($_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'title' ] . ' // ' . $_SETTINGS [ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'sitename' ] ); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="/css/style.css" rel="stylesheet" media="screen">

	<base href="<?php echo($_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'url' ]); ?>/">
	<meta property="og:title" content="<?php echo($_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'title' ] . ' // ' . $_SETTINGS [ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'sitename' ] ); ?>">
	<meta property="og:url" content="<?php echo($_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'url' ]); ?>">
	<meta property="og:site_name" content="<?php echo($_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'sitename' ]); ?>">
	<meta property="og:type" content="website">
	<meta property="og:description" content="<?php echo($_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'description' ]); ?>">
</head>

<body>

<?php // pelnoekranowa reklama
/* if( $_GLOBALS[ 'login' ][ 'login' ] == false ){
	if($ad_endabled)
	{
		echo '<div id="rekl_overlay"><div id="rekl_wrapper">';
			echo '<header class="group">';
				echo '<div id="rekl_logo"><a href="'.$_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'url' ].'">'.$_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'sitename' ].'</a></div>';
				echo '<div id="rekl_exit"><a href="'.$_SERVER['REQUEST_URI'].'">Przejdź do '.$_SETTINGS[ $_GLOBALS[ 'lang' ] ][ 'general' ][ 'sitename' ].'</a></div>';
			echo '</header>';
			echo '<section>'.$ad['ad_html'].'</section>';
		echo '</div></div>';
	}
}
*/
?>

