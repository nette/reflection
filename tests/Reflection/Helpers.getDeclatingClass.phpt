<?php

/**
 * Test: Nette\Reflection\Helpers::getDeclaringClass.
 */

use Nette\Reflection,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


trait A
{
	protected $bar;
	protected function bar() {}
	protected function override() {}
}

trait B
{
	use A;
	protected $foo;
	protected function foo() {}
}

trait E
{
	protected $baz;
	protected function baz() {} 
}

class C
{
	use B;
	use E;
	protected $own;
	protected function own() {}
	protected function override() {}
}

class D extends C
{
}


test(function() { // Property in trait
	Assert::same('B', Reflection\Helpers::getDeclaringClass(new \ReflectionProperty('D', 'foo'))->getName());
});

test(function() { // Property in parent trait
	Assert::same('A', Reflection\Helpers::getDeclaringClass(new \ReflectionProperty('D', 'bar'))->getName());
});

test(function() { // Property in class itself
	Assert::same('C', Reflection\Helpers::getDeclaringClass(new \ReflectionProperty('D', 'own'))->getName());
});

test(function() { // Property in second trait
	Assert::same('E', Reflection\Helpers::getDeclaringClass(new \ReflectionProperty('D', 'baz'))->getName());
});

test(function() { // Method in trait
	Assert::same('B', Reflection\Helpers::getDeclaringClass(new \ReflectionMethod('D', 'foo'))->getName());
});

test(function() { // Method in parent trait
	Assert::same('A', Reflection\Helpers::getDeclaringClass(new \ReflectionMethod('D', 'bar'))->getName());
});

test(function() { // Method in class itself
	Assert::same('C', Reflection\Helpers::getDeclaringClass(new \ReflectionMethod('D', 'own'))->getName());
});

test(function() { // Method in second trait
	Assert::same('E', Reflection\Helpers::getDeclaringClass(new \ReflectionMethod('D', 'baz'))->getName());
});

test(function() { // Method in trait overridden by class
	Assert::same('C', Reflection\Helpers::getDeclaringClass(new \ReflectionMethod('D', 'override'))->getName());
});
