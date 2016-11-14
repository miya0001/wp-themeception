<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
	public function getCurrentTheme()
	{
		$config = $this->config;

		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/wp-admin/" );
		$wd->fillField( "#user_login", $config['admin_user'] );
		$wd->fillField( "#user_pass", $config['admin_pass'] );
		$wd->click( "Log In" );

		$wd->amOnPage( "/wp-admin/themes.php" );

		return $wd->grabAttributeFrom( ".theme.active:first-child", "data-slug" );
	}

	public function getThemeTags( $slug )
	{
		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/wp-content/themes/" . $slug ."/style.css" );
		$source = $wd->webDriver->getPageSource();

		$tag_line = "";
		foreach ( preg_split( "/\n/", $source ) as $line ) {
			if ( preg_match( "/^( *\* *)?Tags:/", $line ) ) {
				$tag_line = $line;
				break;
			}
		}

		$tag_line = trim( preg_replace( "/^( *\* *)?Tags:/", "", $tag_line ) );
		$tags = array_map('trim', preg_split( "/,/", $tag_line ) );

		return $tags;
	}
}
