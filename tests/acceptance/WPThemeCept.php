<?php

$I = new AcceptanceTester($scenario);
$I->wantTo( 'Check the theme specification from tags' );

$I->seeWpVersion();
$I->seeCurrentTheme();
$I->seeTagsFor();
$I->SeeTheThemeSupports();
