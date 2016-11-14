<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');

$theme = $I->getCurrentTheme();
$tags = $I->getThemeTags( $theme );

var_dump( $tags );
