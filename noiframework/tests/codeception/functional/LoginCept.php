<?php

use tests\codeception\_pages\LoginPage;

$I = new FunctionalTester($scenario);
$I->wantTo('how work login page');
$I->amOnPage('/user/login/index.html'); 

$loginPage = LoginPage::openBy($I);

 
$loginPage->login('', '');
 
