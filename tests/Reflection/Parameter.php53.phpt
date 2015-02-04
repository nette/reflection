<?php

/**
 * Test: Nette\Reflection\Parameter and closure tests.
 */

use Nette\Reflection,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


$reflect = new Reflection\GlobalFunction(function($x, $y) {});
$params = $reflect->getParameters();
Assert::same( 2, count($params) );
Assert::same( '{closure}()', (string) $params[0]->getDeclaringFunction() );
Assert::null( $params[0]->getClass() );
Assert::null( $params[0]->getDeclaringClass() );
Assert::same( '{closure}()', (string) $params[1]->getDeclaringFunction() );
Assert::null( $params[1]->getClass() );
Assert::null( $params[1]->getDeclaringClass() );
