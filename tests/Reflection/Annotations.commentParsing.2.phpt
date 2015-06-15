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
	'three' => [TRUE],
	'five' => [TRUE],
	'brackets' => [
		Nette\Utils\ArrayHash::from([
			'single' => "()@\\'\"",
			'double' => "()@'\\\"",
		]),
	],
	'line1' => [TRUE],
	'line2' => [TRUE],
	'line3' => ['value'],
	'line4' => [TRUE],
], $rc->getAnnotations());


$rc = new Reflection\ClassType('TestClass2');
Assert::same([
	'one' => ['value'],
], $rc->getAnnotations());


$rc = new Reflection\ClassType('TestClass3');
Assert::same([
	'one' => [TRUE],
], $rc->getAnnotations());
