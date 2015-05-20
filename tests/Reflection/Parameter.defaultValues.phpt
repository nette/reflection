<?php

/**
 * Test: Nette\Reflection\Parameter default values test.
 */

use Nette\Reflection;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


function check($name, $args)
{
	$method = new Reflection\Method($name);
	foreach ($method->getParameters() as $param) {
		echo "$name(\${$param->getName()})\n";
		list($isOptional, $isDefaultValueAvailable, $defaultValue) = array_shift($args) + [NULL, NULL, NULL];
		Assert::same($isOptional, $param->isOptional());
		Assert::same($isDefaultValueAvailable, $param->isDefaultValueAvailable());

		if ($isDefaultValueAvailable) {
			Assert::same($defaultValue, $param->getDefaultValue());
		}
	}
}


class Test
{
	function func1($a, $b, $c) {}
	function func2($a, $b = NULL, $c) {}
	function func3($a, $b = NULL, $c = NULL) {}
	function func4($a, array $b = NULL, array $c) {}
	function func5($a, $b = NULL, array $c = NULL) {}
	function func6($a, Exception $b = NULL, Exception $c) {}
	function func7($a, $b = NULL, Exception $c = NULL) {}
}


check('Test::func1', [
	/* $a */ [FALSE, FALSE], // isOptional | isDefaultValueAvailable | [ getDefaultValue ]
	/* $b */ [FALSE, FALSE],
	/* $c */ [FALSE, FALSE],
]);
check('Test::func2', [
	/* $a */ [FALSE, FALSE],
	/* $b */ [FALSE, PHP_VERSION_ID >= 50407 || (PHP_VERSION_ID >= 50317 && PHP_VERSION_ID < 50400)],
	/* $c */ [FALSE, FALSE],
]);
check('Test::func3', [
	/* $a */ [FALSE, FALSE],
	/* $b */ [TRUE, TRUE, NULL],
	/* $c */ [TRUE, TRUE, NULL],
]);
check('Test::func4', [
	/* $a */ [FALSE, FALSE],
	/* $b */ [FALSE, PHP_VERSION_ID >= 50407 || (PHP_VERSION_ID >= 50317 && PHP_VERSION_ID < 50400)],
	/* $c */ [FALSE, FALSE],
]);
check('Test::func5', [
	/* $a */ [FALSE, FALSE],
	/* $b */ [TRUE, TRUE, NULL],
	/* $c */ [TRUE, TRUE, NULL],
]);
check('Test::func6', [
	/* $a */ [FALSE, FALSE],
	/* $b */ [FALSE, PHP_VERSION_ID >= 50407 || (PHP_VERSION_ID >= 50317 && PHP_VERSION_ID < 50400)],
	/* $c */ [FALSE, FALSE],
]);
check('Test::func7', [
	/* $a */ [FALSE, FALSE],
	/* $b */ [TRUE, TRUE, NULL],
	/* $c */ [TRUE, TRUE, NULL],
]);
check('Exception::__construct', [
	/* $message */ [TRUE, FALSE],
	/* $code */ [TRUE, FALSE],
	/* $previous */ [TRUE, FALSE],
]);
check('FilesystemIterator::__construct', [
	/* $path */ [FALSE, FALSE],
	/* $flags */ [TRUE, FALSE],
]);
/*
check('PDO::__construct', [
	/* $dsn * / [FALSE, FALSE],
	/* $username * / [PHP_VERSION_ID >= 50426 && (PHP_VERSION_ID < 50500 || PHP_VERSION_ID > 50509), FALSE],
	/* $passwd * / [PHP_VERSION_ID >= 50426 && (PHP_VERSION_ID < 50500 || PHP_VERSION_ID > 50509), FALSE],
	/* $options * / [TRUE, FALSE],
]);
check('mysqli::mysqli', [
	/* $host * / [TRUE, FALSE],
	/* $username * / [TRUE, FALSE],
	/* $passwd * / [TRUE, FALSE],
	/* $dbname * / [TRUE, FALSE],
	/* $port * / [TRUE, FALSE],
	/* $socket * / [TRUE, FALSE],
]);
*/
