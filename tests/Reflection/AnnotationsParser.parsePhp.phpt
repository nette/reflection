<?php

/**
 * Test: Nette\Reflection\AnnotationsParser::parsePhp.
 */

use Nette\Reflection\AnnotationsParser;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


Assert::same([
	'Test\AnnotatedClass1' => [
		'class' => '/** @author john */',
		'$a' => '/** @var a */',
		'$b' => '/** @var b */',
		'$c' => '/** @var c */',
		'$d' => '/** @var d */',
		'$e' => '/** @var e */',
		'a' => '/** @return a */',
		'b' => '/** @return b */',
		'c' => '/** @return c */',
		'd' => '/** @return d */',
		'e' => '/** @return e */',
		'g' => '/** @return g */',
	],
	'Test\AnnotatedClass2' => ['class' => '/** @author jack */'],
], AnnotationsParser::parsePhp(file_get_contents(__DIR__ . '/files/annotations.php')));


Assert::same([
	'Test\TestClass1' => ['use' => ['C' => 'A\B']],
	'Test\TestClass2' => ['use' => ['C' => 'A\B', 'D' => 'D', 'E' => 'E', 'H' => 'F\G']],
	'Test2\TestClass4' => ['use' => ['C' => 'A\B\C']],
], AnnotationsParser::parsePhp(file_get_contents(__DIR__ . '/files/uses.php')));
