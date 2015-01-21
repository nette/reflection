<?php

/**
 * Test: ReflectionExtension.
 */

use Nette\DI,
	Nette\Bridges\CacheDI\CacheExtension,
	Nette\Bridges\ReflectionDI\ReflectionExtension,
	Nette\Reflection\AnnotationsParser,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


test(function() {
	$compiler = new DI\Compiler;
	$compiler->addExtension('cache', new CacheExtension(__DIR__));
	$compiler->addExtension('reflection', new ReflectionExtension);
	eval($compiler->compile(array(), 'Container1'));

	$container = new Container1;
	$container->initialize();
	Assert::type('Nette\Caching\Storages\FileStorage', AnnotationsParser::getCacheStorage());
});
