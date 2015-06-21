<?php

/**
 * Test: ReflectionExtension.
 */

use Nette\DI;
use Nette\Bridges\ReflectionDI\ReflectionExtension;
use Nette\Reflection\AnnotationsParser;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


test(function () {
	$loader = new DI\Config\Loader;
	$config = $loader->load(Tester\FileMock::create('
	services:
		cache: Nette\Caching\Storages\DevNullStorage
	', 'neon'));

	$compiler = new DI\Compiler;
	$compiler->addExtension('reflection', new ReflectionExtension);
	eval($compiler->compile($config, 'Container1'));

	$container = new Container1;
	$container->initialize();
	Assert::type('Nette\Caching\Storages\DevNullStorage', AnnotationsParser::getCacheStorage());
});
