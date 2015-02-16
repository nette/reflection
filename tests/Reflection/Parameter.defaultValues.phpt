<?php

/**
 * Test: Nette\Reflection\Parameter default values test.
 */

use Nette\Reflection,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


function check($name, $args)
{
	$method = new Reflection\Method($name);
	foreach ($method->getParameters() as $param) {
		echo "$name(\${$param->getName()})\n";
		list($isOptional, $isDefaultValueAvailable, $defaultValue) = array_shift($args) + array(NULL, NULL, NULL);
		Assert::same( $isOptional, $param->isOptional() );
		Assert::same( $isDefaultValueAvailable, $param->isDefaultValueAvailable() );

		if ($isDefaultValueAvailable) {
			Assert::same( $defaultValue, $param->getDefaultValue() );
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


check( 'Test::func1', array(
	/* $a */ array(FALSE, FALSE), // isOptional | isDefaultValueAvailable | [ getDefaultValue ]
	/* $b */ array(FALSE, FALSE),
	/* $c */ array(FALSE, FALSE)
));
check( 'Test::func2', array(
	/* $a */ array(FALSE, FALSE),
	/* $b */ array(FALSE, PHP_VERSION_ID >= 50407 || (PHP_VERSION_ID >= 50317 && PHP_VERSION_ID < 50400)),
	/* $c */ array(FALSE, FALSE)
));
check( 'Test::func3', array(
	/* $a */ array(FALSE, FALSE),
	/* $b */ array(TRUE, TRUE, NULL),
	/* $c */ array(TRUE, TRUE, NULL)
));
check( 'Test::func4', array(
	/* $a */ array(FALSE, FALSE),
	/* $b */ array(FALSE, PHP_VERSION_ID >= 50407 || (PHP_VERSION_ID >= 50317 && PHP_VERSION_ID < 50400)),
	/* $c */ array(FALSE, FALSE)
));
check( 'Test::func5', array(
	/* $a */ array(FALSE, FALSE),
	/* $b */ array(TRUE, TRUE, NULL),
	/* $c */ array(TRUE, TRUE, NULL)
));
check( 'Test::func6', array(
	/* $a */ array(FALSE, FALSE),
	/* $b */ array(FALSE, PHP_VERSION_ID >= 50407 || (PHP_VERSION_ID >= 50317 && PHP_VERSION_ID < 50400)),
	/* $c */ array(FALSE, FALSE)
));
check( 'Test::func7', array(
	/* $a */ array(FALSE, FALSE),
	/* $b */ array(TRUE, TRUE, NULL),
	/* $c */ array(TRUE, TRUE, NULL)
));
check( 'Exception::__construct', array(
	/* $message */ array(TRUE, FALSE),
	/* $code */ array(TRUE, FALSE),
	/* $previous */ array(TRUE, FALSE),
));
check( 'FilesystemIterator::__construct', array(
	/* $path */ array(FALSE, FALSE),
	/* $flags */ array(TRUE, FALSE),
));
/*
check( 'PDO::__construct', array(
	/* $dsn * / array(FALSE, FALSE),
	/* $username * / array(PHP_VERSION_ID >= 50426 && (PHP_VERSION_ID < 50500 || PHP_VERSION_ID > 50509), FALSE),
	/* $passwd * / array(PHP_VERSION_ID >= 50426 && (PHP_VERSION_ID < 50500 || PHP_VERSION_ID > 50509), FALSE),
	/* $options * / array(TRUE, FALSE),
));
check( 'mysqli::mysqli', array(
	/* $host * / array(TRUE, FALSE),
	/* $username * / array(TRUE, FALSE),
	/* $passwd * / array(TRUE, FALSE),
	/* $dbname * / array(TRUE, FALSE),
	/* $port * / array(TRUE, FALSE),
	/* $socket * / array(TRUE, FALSE),
));
*/
