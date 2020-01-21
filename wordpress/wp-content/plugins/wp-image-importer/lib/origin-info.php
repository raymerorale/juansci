<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*=================================================
=            Api setting values variables.         =
=================================================*/

$flickrLicense = array(
	"1,2,3,4,5,6,7" 	=> __( "For only Non-Commercial Use and Attribution Required", 'wp-image-importer' ),
	"4,5,6,7" 			=> __( "Only Commercial Use Allowed and Attribution Required", 'wp-image-importer' ),
	"7" 				=> __( "Commercial Use Allowed and No Attribution Required", 'wp-image-importer' ),
	"0,1,2,3,4,5,6,7" 	=> __( "All Licenses (Not recommended)", 'wp-image-importer' )
);

$flickrSort = array(
	"relevance" 			=> __( "Relevance", 'wp-image-importer' ),
	"date-posted-asc" 		=> __( "Date posted, ascending", 'wp-image-importer' ),
	"date-posted-desc" 		=> __( "Date posted, descending", 'wp-image-importer' ),
	"date-taken-asc" 		=> __( "Date taken, ascending", 'wp-image-importer' ),
	"date-taken-desc" 		=> __( "Date taken, descending", 'wp-image-importer' ),
	"interestingness-desc" 	=> __( "Interestingness, descending", 'wp-image-importer' ),
	"interestingness-asc"	=> __( "Interestingness, ascending", 'wp-image-importer' ) 
);

$pixabay_image_type = array(
	"all" 		=> __( "All", 'wp-image-importer' ),
	"photo" 	=> __( "Photos", 'wp-image-importer' ),
	"clipart" 	=> __( "Clipart", 'wp-image-importer' ) 
);

$pixabay_orientation = array(
	"all" 			=> __( "All", 'wp-image-importer' ),
	"horizontal" 	=> __( "Horizontal", 'wp-image-importer' ),
	"vertical" 		=> __( "Vertical", 'wp-image-importer' ) 
);

$pixabay_languages = array(
	'cs' => __( 'Čeština', 'wp-image-importer' ),
	'da' => __( 'Dansk', 'wp-image-importer' ),
	'de' => __( 'Deutsch', 'wp-image-importer' ),
	'en' => __( 'English', 'wp-image-importer' ),
	'es' => __( 'Español', 'wp-image-importer' ),
	'fr' => __( 'Français', 'wp-image-importer' ),
	'id' => __( 'Indonesia', 'wp-image-importer' ),
	'it' => __( 'Italiano', 'wp-image-importer' ),
	'hu' => __( 'Magyar', 'wp-image-importer' ),
	'nl' => __( 'Nederlands', 'wp-image-importer' ),
	'no' => __( 'Norsk', 'wp-image-importer' ),
	'pl' => __( 'Polski', 'wp-image-importer' ),
	'pt' => __( 'Português', 'wp-image-importer' ),
	'ro' => __( 'Română', 'wp-image-importer' ),
	'sk' => __( 'Slovenčina', 'wp-image-importer' ),
	'fi' => __( 'Suomi', 'wp-image-importer' ),
	'sv' => __( 'Svenska', 'wp-image-importer' ),
	'tr' => __( 'Türkçe', 'wp-image-importer' ),
	'vi' => __( 'Việt', 'wp-image-importer' ),
	'th' => __( 'ไทย', 'wp-image-importer' ),
	'bg' => __( 'Български', 'wp-image-importer' ),
	'ru' => __( 'Русский', 'wp-image-importer' ),
	'el' => __( 'Ελληνική', 'wp-image-importer' ),
	'ja' => __( '日本語', 'wp-image-importer' ),
	'ko' => __( '한국어', 'wp-image-importer' ),
	'zh' => __( '简体中文', 'wp-image-importer' ) 
);

/*=====  End of Api setting values variables.  ======*/

?>