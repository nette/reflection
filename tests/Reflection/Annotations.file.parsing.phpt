<?php

/**
 * Test: Nette\Reflection\AnnotationsParser file parser.
 */

use Nette\Reflection\AnnotationsParser;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';

require __DIR__ . '/files/annotations.php';


AnnotationsParser::$useReflection = FALSE;


test(function () { // AnnotatedClass1
	$rc = new ReflectionClass('Test\AnnotatedClass1');
	Assert::same([
		'author' => ['john'],
	], AnnotationsParser::getAll($rc));

	Assert::same([
		'var' => ['a'],
	], AnnotationsParser::getAll($rc->getProperty('a')), '$a');

	Assert::same([
		'var' => ['b'],
	], AnnotationsParser::getAll($rc->getProperty('b')), '$b');

	Assert::same([
		'var' => ['c'],
	], AnnotationsParser::getAll($rc->getProperty('c')), '$c');

	Assert::same([
		'var' => ['d'],
	], AnnotationsParser::getAll($rc->getProperty('d')), '$d');

	Assert::same([
		'var' => ['e'],
	], AnnotationsParser::getAll($rc->getProperty('e')), '$e');

	Assert::same([], AnnotationsParser::getAll($rc->getProperty('f')));

	// Nette\Reflection\AnnotationsParser::getAll($rc->getProperty('g')), '$g'); // ignore due PHP bug #50174
	Assert::same([
		'return' => ['a'],
	], AnnotationsParser::getAll($rc->getMethod('a')), 'a()');

	Assert::same([
		'return' => ['b'],
	], AnnotationsParser::getAll($rc->getMethod('b')), 'b()');

	Assert::same([
		'return' => ['c'],
	], AnnotationsParser::getAll($rc->getMethod('c')), 'c()');

	Assert::same([
		'return' => ['d'],
	], AnnotationsParser::getAll($rc->getMethod('d')), 'd()');

	Assert::same([
		'return' => ['e'],
	], AnnotationsParser::getAll($rc->getMethod('e')), 'e()');

	Assert::same([], AnnotationsParser::getAll($rc->getMethod('f')));

	Assert::same([
		'return' => ['g'],
	], AnnotationsParser::getAll($rc->getMethod('g')), 'g()');
});


test(function () { // AnnotatedClass2
	$rc = new ReflectionClass('Test\AnnotatedClass2');
	Assert::same([
		'author' => ['jack'],
	], AnnotationsParser::getAll($rc));
});


test(function () { // AnnotatedClass3
	$rc = new ReflectionClass('Test\AnnotatedClass3');
	Assert::same([], AnnotationsParser::getAll($rc));
});
