<?php

namespace Helper;

use Codeception\Lib\Console\Output;

class Acceptance extends \Codeception\Module
{
	/**
	 * Get the WordPress version.
	 *
	 * @param  none
	 * @return string The slug of the current theme.
	 */
	public function seeWpVersion()
	{
		$config = $this->config;

		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/" );
		$version = $wd->grabAttributeFrom( "meta[name=generator]", "content" );
		$this->assertTrue( !! $version, "Can't get WordPress version." );

		$version = preg_replace( "/WordPress /", "", $version );
		$version = trim( $version );
		$this->assertTrue( !! $version, "Can't get WordPress version." );

		$this->ok( sprintf(
			"WordPress version is %s.",
			$version
		) );

		$this->vars['version'] = $version;
	}

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
		$this->assertTrue( !! $theme );
		$this->ok( sprintf(
			"Current theme is \"%s\".",
			$theme
		) );

		$this->vars['current_theme'] = $theme;
	}

	/**
	 * Get the current theme.
	 *
	 * @return array        The array of the tags in style.css.
	 */
	public function seeTagsFor()
	{
		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/theme-tags/" );
		$source = $wd->_findElements( "body" );
		$this->assertTrue( !! $source );

		$tags = json_decode( $source[0]->getText() );
		$this->assertTrue( !! $tags );

		$tags_formatted = array_map( function( $tag ){
			return "* " . $tag;
		}, $tags );
		$this->ok( $tags_formatted );

		$this->vars['tags'] = $tags;
	}

	/**
	 * Check that does the theme support the specification as tag.
	 *
	 * @return none
	 */
	public function seeTheThemeSupports()
	{
		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/theme-features/" );
		$source = $wd->_findElements( "body" );
		$features = json_decode( $source[0]->getText(), true );

		$error = false;
		foreach ( $this->vars['tags'] as $feature ) {
			$func_name = preg_replace( "/\W/", "_", $feature );
			if ( method_exists( $this, $func_name ) ) {
				if ( $this->$func_name( $features ) ) {
					$this->passed( $feature );
				} else {
					$error = true;
				}
			} else {
				$this->pending( sprintf(
					"%s: No tests defined",
					$feature
				) );
			}
		}

		$this->assertFalse( $error, "Some feature is not working." );
	}

	private function flexible_header( $features )
	{
		if ( empty( $features['custom-header'] ) ) {
			$this->fail_not_supported( 'flexible-header' );
			return false;
		} else {
			$args = $features['custom-header'][0];
			if ( empty( $args['flex-height'] ) && empty( $args['flex-width'] ) ) {
				$this->fail_not_supported( 'flexible-header' );
				return false;
			}
		}
		return true;
	}

	private function custom_background( $features )
	{
		if ( empty( $features['custom-background'] ) ) {
			$this->fail_not_supported( 'custom-background' );
			return false;
		}
		return true;
	}

	private function custom_colors( $features )
	{
		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/wp-admin/customize.php" );
		$wd->waitForElement( '#customize-theme-controls', 30 );
		$elements = $wd->_findElements( "#accordion-section-colors" );
		if ( count( $elements ) ) {
			return true;
		} else {
			$this->fail_not_supported( 'custom-colors' );
			return false;
		}
	}

	private function custom_header( $features )
	{
		if ( empty( $features['custom-header'] ) ) {
			$this->fail_not_supported( 'custom-header' );
			return false;
		}
		return true;
	}

	private function custom_menu( $features )
	{
		if ( empty( $features['menus'] ) ) {
			$this->fail_not_supported( 'custom-menu' );
			return false;
		}
		return true;
	}

	private function custom_logo( $features )
	{
		if ( empty( $features['custom-logo'] ) ) {
			$this->fail_not_supported( 'custom-logo' );
			return false;
		}
		return true;
	}

	private function editor_style( $features )
	{
		if ( empty( $features['editor-style'] ) ) {
			$this->fail_not_supported( 'editor-style' );
			return false;
		}
		return true;
	}

	private function featured_image_header( $features )
	{
		if ( empty( $features['post-thumbnails'] ) || empty( $features['post-thumbnails'] ) ) {
			$this->fail_not_supported( 'featured-image-header' );
			return false;
		}
		return true;
	}

	private function featured_images( $features )
	{
		if ( empty( $features['post-thumbnails'] ) ) {
			$this->fail_not_supported( 'featured-images' );
			return false;
		}
		return true;
	}

	private function post_formats( $features )
	{
		if ( empty( $features['post-formats'] ) ) {
			$this->fail_not_supported( 'post-formats' );
			return false;
		}
		return true;
	}

	private function sticky_post( $features )
	{
		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/" );
		$elements = $wd->_findElements( ".post.type-post.sticky" );
		if ( count( $elements ) ) {
			return true;
		} else {
			$this->fail_not_supported( 'sticky-post' );
			return false;
		}
	}

	private function theme_options( $features )
	{
		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/wp-admin/customize.php" );
		$wd->waitForElement( '#customize-theme-controls', 30 );
		$elements = $wd->_findElements( ".control-section" );
		if ( count( $elements ) ) {
			return true;
		} else {
			$this->fail_not_supported( 'theme-options' );
			return false;
		}
	}

	private function threaded_comments( $features )
	{
		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/wp-admin/options-discussion.php" );
		$elements = $wd->_findElements( "#thread_comments" );
		if ( count( $elements ) ) {
			return true;
		} else {
			$this->fail_not_supported( 'custom-colors' );
			return false;
		}
	}

	private function translation_ready( $features )
	{
		$wd = $this->getModule('WebDriver');
		$wd->amOnPage( "/theme-meta/" );
		$source = $wd->_findElements( "body" );
		$metas = json_decode( $source[0]->getText(), true );
		if ( ! empty( $metas["textdomain"] ) && ! empty( $metas["is_textdomain_loaded"] ) ) {
			return true;
		} else {
			$this->fail_not_supported( 'translation-ready' );
			return false;
		}
	}

	private function fail_not_supported( $feature_name )
	{
		$this->error( sprintf(
			'%1$s: Theme does not support "%1$s".',
			$feature_name
		) );
	}

	private function passed( $feature_name )
	{
		$this->ok( sprintf(
			"%s: OK",
			$feature_name
		) );
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

	/**
	 * Print error message.
	 *
	 * @param  string | array $messages The message.
	 * @return none
	 */
	private function error( $messages )
	{
		$output = new Output( array() );
		if ( is_array( $messages ) ) {
			foreach ( $messages as $message ) {
				$output->writeln("<error>  $message</error>");
			}
		} else {
			$output->writeln("<error>  $messages</error>");
		}
	}
}
