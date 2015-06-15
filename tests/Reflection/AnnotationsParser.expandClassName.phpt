<?php

/**
 * Test: Expanding class alias to FQN.
 */

use Nette\Reflection\AnnotationsParser;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


require __DIR__ . '/files/expandClass.noNamespace.php';
require __DIR__ . '/files/expandClass.inNamespace.php';

$rcTest = new \ReflectionClass('Test');
$rcFoo = new \ReflectionClass('Test\Space\Foo');
$rcBar = new \ReflectionClass('Test\Space\Bar');


Assert::exception(function () use ($rcTest) {
	AnnotationsParser::expandClassName('', $rcTest);
}, 'Nette\InvalidArgumentException', 'Class name must not be empty.');


Assert::same('A', AnnotationsParser::expandClassName('A', $rcTest));
Assert::same('A\B', AnnotationsParser::expandClassName('C', $rcTest));

Assert::same('Test\Space\Foo', AnnotationsParser::expandClassName('self', $rcFoo));


/*
alias to expand => array(
	FQN for $rcFoo,
	FQN for $rcBar
)
*/
$cases = [
	'\Absolute' => [
		'Absolute',
		'Absolute',
	],
	'\Absolute\Foo' => [
		'Absolute\Foo',
		'Absolute\Foo',
	],

	'AAA' => [
		'Test\Space\AAA',
		'AAA',
	],
	'AAA\Foo' => [
		'Test\Space\AAA\Foo',
		'AAA\Foo',
	],

	'B' => [
		'Test\Space\B',
		'BBB',
	],
	'B\Foo' => [
		'Test\Space\B\Foo',
		'BBB\Foo',
	],

	'DDD' => [
		'Test\Space\DDD',
		'CCC\DDD',
	],
	'DDD\Foo' => [
		'Test\Space\DDD\Foo',
		'CCC\DDD\Foo',
	],

	'F' => [
		'Test\Space\F',
		'EEE\FFF',
	],
	'F\Foo' => [
		'Test\Space\F\Foo',
		'EEE\FFF\Foo',
	],

	'HHH' => [
		'Test\Space\HHH',
		'Test\Space\HHH',
	],

	'Notdef' => [
		'Test\Space\Notdef',
		'Test\Space\Notdef',
	],
	'Notdef\Foo' => [
		'Test\Space\Notdef\Foo',
		'Test\Space\Notdef\Foo',
	],

	// case insensivity
	'aAa' => [
		'Test\Space\aAa',
		'AAA',
	],
	'AaA\Foo' => [
		'Test\Space\AaA\Foo',
		'AAA\Foo',
	],

	// trim leading backslash
	'G' => [
		'Test\Space\G',
		'GGG',
	],
	'G\Foo' => [
		'Test\Space\G\Foo',
		'GGG\Foo',
	],
];
foreach ($cases as $alias => $fqn) {
	Assert::same($fqn[0], AnnotationsParser::expandClassName($alias, $rcFoo));
	Assert::same($fqn[1], AnnotationsParser::expandClassName($alias, $rcBar));
}
