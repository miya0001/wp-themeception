<?php

$I = new AcceptanceTester($scenario);
$I->wantTo( 'Check the theme specification from tags' );


$I->dontSeeNoticeOn( "/" );
$I->dontSeeNoticeOn( "/wp-admin/" );
$I->dontSeeNoticeOn( "/wp-admin/themes.php" );
$I->dontSeeNoticeOn( "/wp-admin/customize.php" );
$I->dontSeeNoticeOn( "/wp-admin/widgets.php" );
$I->dontSeeNoticeOn( "/wp-admin/nav-menus.php" );

$pages = array(
	"/?name=template-sticky",
	"/?name=sample-page",
	"/?s=hello",
	"/archives/date/" . date( "Y/m" ),
	"/archives/category/aciform",
	"/dsc20050604_133440_34211",
);

foreach ( $pages as $page ) {
	$I->cantSee404( $page );
	$I->cantSeeNoticeOn( $page );
}

$I->cantSeeNoticeOn( "/this-test-is-checking-on-404" );

$I->seeWpVersion();
$I->seeCurrentTheme();
$I->seeTagsFor();
$I->SeeTheThemeSupports();
