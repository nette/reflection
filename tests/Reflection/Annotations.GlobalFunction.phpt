<?php

/**
 * Test: Nette\Reflection\Annotations.GlobalFunction tests.
 */

use Nette\Reflection,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


function foo($a, $b) {
	return $a + $b;
}


/**
 * Lorem ipsum.
 *
 * @param int
 * @param int
 * @return int
 */
function boo($a, $b) {
	return $a + $b;
}



/**
 * Build-in function without Doc comments.
 */
test(function() {
	$function = new Reflection\GlobalFunction('sort');
	Assert::same(array(),  $function->getAnnotations());
	Assert::null($function->getDescription());
});



/**
 * Function without Doc comments.
 */
test(function() {
	$function = new Reflection\GlobalFunction('foo');
	$ans = $function->getAnnotations();
	Assert::same(array('Test: Nette\Reflection\Annotations.GlobalFunction tests.'), $ans['description']);
});



/**
 * Function with any Doc comments.
 */
test(function() {
	$function = new Reflection\GlobalFunction('boo');
	Assert::same(array(
			'description' => array('Lorem ipsum.'),
			'param' => array('int', 'int'),
			'return' => array('int'),
		),
		$function->getAnnotations()
	);
	Assert::same('Lorem ipsum.', $function->getDescription());
	Assert::true($function->hasAnnotation('param'));
	Assert::false($function->hasAnnotation('author'));
});
