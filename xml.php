<?php 

 
require "IXR_Library.inc.php";

$rpc = new IXR_Client( "http://info.gamingbet.eu/xmlrpc.php" );
$status = $rpc->query(
    "wp.getComments",   // method name
    "1",                // blog id
    "hitch",   // username
    "noname!@#", // password
    array(
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	)
);

if( !$status ) {
    print "Error ( " . $rpc->getErrorCode( ) . " ) : ";
    print $rpc->getErrorMessage( ) . "\n";
    exit;
}

$post = $rpc->getResponse( );
print_r( $post );


$args = array( 'posts_per_page' => 5, 'offset'=> 1, 'category' => 1 );

foreach ( $post as $post ) ?>
	<li>
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</li>
<?php endforeach; 
