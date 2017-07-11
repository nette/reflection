<?php

/**
 * Test: Nette\Reflection\AnnotationsParser comment parser II.
 */

use Nette\Reflection;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


/**
 * This is my favorite class.
 * @one( value ), out
 * @two (value)
 * @three(
 * @4th
 * @five
 * @brackets( single = '()@\'"', double = "()@'\"")
 * @line1() @line2 @line3 value @line4
 */
class TestClass1
{
}

/** @one(value)*/
class TestClass2
{
}

/** @one*/
class TestClass3
{
}


$rc = new Reflection\ClassType('TestClass1');
Assert::equal([
	'description' => ['This is my favorite class.'],
	'one' => ['value'],
	'two' => ['value'],
	'three' => [true],
	'five' => [true],
	'brackets' => [
		Nette\Utils\ArrayHash::from([
			'single' => "()@\\'\"",
			'double' => "()@'\\\"",
		]),
	],
	'line1' => [true],
	'line2' => [true],
	'line3' => ['value'],
	'line4' => [true],
], $rc->getAnnotations());


$rc = new Reflection\ClassType('TestClass2');
Assert::same([
	'one' => ['value'],
], $rc->getAnnotations());


$rc = new Reflection\ClassType('TestClass3');
Assert::same([
	'one' => [true],
], $rc->getAnnotations());
