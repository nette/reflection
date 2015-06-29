<?php

/**
 * This file is part of the Nette Framework (http://nette.org)
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 */

namespace Nette\Bridges\ReflectionDI;

use Nette;


/**
 * Extension for Nette DI.
 */
class ReflectionExtension extends Nette\DI\CompilerExtension
{
	/** @var bool */
	private $debugMode;


	public function __construct($debugMode = FALSE)
	{
		$this->debugMode = $debugMode;
	}


	public function afterCompile(Nette\PhpGenerator\ClassType $class)
	{
		$class->getMethod('initialize')
			->addBody('Nette\Reflection\AnnotationsParser::setCacheStorage($this->getByType("Nette\Caching\IStorage"));')
			->addBody('Nette\Reflection\AnnotationsParser::$autoRefresh = ?;', array($this->debugMode));
	}

}
