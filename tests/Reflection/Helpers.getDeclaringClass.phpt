<?php

/**
 * Test: Nette\Reflection\Helpers::getDeclaringClass
 * @phpversion 5.4
 */

use Nette\Reflection\Helpers;
use Tester\Assert;


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


// Property in trait
Assert::same('B', Helpers::getDeclaringClass(new \ReflectionProperty('D', 'foo'))->getName());

// Property in parent trait
Assert::same('A', Helpers::getDeclaringClass(new \ReflectionProperty('D', 'bar'))->getName());

// Property in class itself
Assert::same('C', Helpers::getDeclaringClass(new \ReflectionProperty('D', 'own'))->getName());

// Property in second trait
Assert::same('E', Helpers::getDeclaringClass(new \ReflectionProperty('D', 'baz'))->getName());
