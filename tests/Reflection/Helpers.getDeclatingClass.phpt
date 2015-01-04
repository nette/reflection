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
}

trait B
{
	use A;
	protected $foo;
}

trait E
{
	protected $baz;
}

class C
{
	use B;
	use E;
	protected $own;
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
