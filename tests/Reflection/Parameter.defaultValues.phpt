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
		list($isOptional, $isDefaultValueAvailable, $defaultValue) = array_shift($args) + [null, null, null];
		Assert::same($isOptional, $param->isOptional());
		Assert::same($isDefaultValueAvailable, $param->isDefaultValueAvailable());

		if ($isDefaultValueAvailable) {
			Assert::same($defaultValue, $param->getDefaultValue());
		}
	}
}


class Test
{
	function func1($a, $b, $c)
	{
	}
	function func2($a, $b = null, $c)
	{
	}
	function func3($a, $b = null, $c = null)
	{
	}
	function func4($a, array $b = null, array $c)
	{
	}
	function func5($a, $b = null, array $c = null)
	{
	}
	function func6($a, Exception $b = null, Exception $c)
	{
	}
	function func7($a, $b = null, Exception $c = null)
	{
	}
}


check('Test::func1', [
	/* $a */ [false, false], // isOptional | isDefaultValueAvailable | [ getDefaultValue ]
	/* $b */ [false, false],
	/* $c */ [false, false],
]);
check('Test::func2', [
	/* $a */ [false, false],
	/* $b */ [false, true],
	/* $c */ [false, false],
]);
check('Test::func3', [
	/* $a */ [false, false],
	/* $b */ [true, true, null],
	/* $c */ [true, true, null],
]);
check('Test::func4', [
	/* $a */ [false, false],
	/* $b */ [false, true],
	/* $c */ [false, false],
]);
check('Test::func5', [
	/* $a */ [false, false],
	/* $b */ [true, true, null],
	/* $c */ [true, true, null],
]);
check('Test::func6', [
	/* $a */ [false, false],
	/* $b */ [false, true],
	/* $c */ [false, false],
]);
check('Test::func7', [
	/* $a */ [false, false],
	/* $b */ [true, true, null],
	/* $c */ [true, true, null],
]);
check('Exception::__construct', [
	/* $message */ [true, false],
	/* $code */ [true, false],
	/* $previous */ [true, false],
]);
check('FilesystemIterator::__construct', [
	/* $path */ [false, false],
	/* $flags */ [true, false],
]);
/*
check('PDO::__construct', [
	/* $dsn * / [false, false],
	/* $username * / [true, false],
	/* $passwd * / [true, false],
	/* $options * / [true, false],
]);
check('mysqli::mysqli', [
	/* $host * / [true, false],
	/* $username * / [true, false],
	/* $passwd * / [true, false],
	/* $dbname * / [true, false],
	/* $port * / [true, false],
	/* $socket * / [true, false],
]);
*/
