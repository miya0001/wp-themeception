<?php

namespace Helper;

use Codeception\Lib\Console\Output;

class Acceptance extends \Codeception\Module
{
	/**
	 * Get the current theme.
	 *
	 * @param  none
	 * @return string The slug of the current theme.
	 */
	public function seeCurrentTheme()
	{
		$config = $this->config;

		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/wp-admin/" );
		$wd->fillField( "#user_login", $config['admin_user'] );
		$wd->fillField( "#user_pass", $config['admin_pass'] );
		$wd->click( "Log In" );

		$wd->amOnPage( "/wp-admin/themes.php" );

		$theme = $wd->grabAttributeFrom( ".theme.active:first-child", "data-slug" );
		$this->ok( sprintf(
			"Current theme is \"%s\".",
			$theme
		) );

		return $theme;
	}

	/**
	 * Get the current theme.
	 *
	 * @param  string $slug The $slug of the theme.
	 * @return array        The array of the tags in style.css.
	 */
	public function seeTagsFor( $slug )
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

		$this->assertTrue( !! $tag_line, "Style.css doesn't have tags in the file header." );

		$tag_line = trim( preg_replace( "/^( *\* *)?Tags:/", "", $tag_line ) );
		$tags = array_map('trim', preg_split( "/,/", $tag_line ) );
		$this->assertTrue( !! $tag_line, "Style.css doesn't have tags in the file header." );

		$tags_formatted = array_map( function( $tag ){
			return "* " . $tag;
		}, $tags );
		$this->ok( $tags_formatted );

		return $tags;
	}

	/**
	 * Check that does the theme support the specification as tag.
	 *
	 * @param  string $tag The $tag of the theme.
	 * @return none
	 */
	public function seeTheThemeSupports( $tag )
	{
		$method = preg_replace( "/\W/", "_", $tag );
		if ( method_exists( $this, $method ) ) {
			return $this->$method();
		} else {
			$this->pending( "No tests defined" );
		}
	}

	private function flexible_header()
	{
		$this->ok( "OK" );
	}

	private function custom_background()
	{
		$this->have_feature( '#accordion-section-background_image' );
		$this->ok( "OK" );
	}

	/**
	 * Check theme customizer has the feature
	 *
	 * @param  string $element The css selector of the customizer feature.
	 * @return none
	 */
	private function have_feature( $element )
	{
		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/wp-admin/customize.php" );
		$wd->waitForElement( '#customize-theme-controls', 30 );
		$wd->seeElementInDOM( $element );
	}

	/**
	 * Print message.
	 *
	 * @param  string | array $messages The message.
	 * @return none
	 */
	private function ok( $messages )
	{
		$output = new Output( array() );
		if ( is_array( $messages ) ) {
			foreach ( $messages as $message ) {
				$output->writeln("<ok>  $message</ok>");
			}
		} else {
			$output->writeln("<ok>  $messages</ok>");
		}
	}

	/**
	 * Print pending message.
	 *
	 * @param  string | array $messages The message.
	 * @return none
	 */
	private function pending( $messages )
	{
		$output = new Output( array() );
		if ( is_array( $messages ) ) {
			foreach ( $messages as $message ) {
				$output->writeln("<pending>  $message</pending>");
			}
		} else {
			$output->writeln("<pending>  $messages</pending>");
		}
	}
}
