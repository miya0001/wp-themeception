<?php
$I = new AcceptanceTester( $scenario );

$I->wantTo( 'log in' );
$I->loginAsAdmin();
