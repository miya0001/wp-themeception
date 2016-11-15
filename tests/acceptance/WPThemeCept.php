<?php

$I = new AcceptanceTester($scenario);
$I->wantTo( 'Check the theme specification from tags' );

$theme = $I->seeCurrentTheme();
$tags = $I->seeTagsFor( $theme );
$I->SeeTheThemeSupports( $tags );
