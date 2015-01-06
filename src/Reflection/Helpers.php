<?php

/**
 * This file is part of the Nette Framework (http://nette.org)
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 */

namespace Nette\Reflection;

use Nette;


/**
 * @author Jáchym Toušek
 */
class Helpers
{

	/**
	 * Returns declaring class or trait.
	 * @return \ReflectionClass
	 * @internal
	 */
	public static function getDeclaringClass(\ReflectionProperty $property)
	{
		if (PHP_VERSION_ID >= 50400) {
			foreach ($property->getDeclaringClass()->getTraits() as $trait) {
				if ($trait->hasProperty($property->getName())) {
					return self::getDeclaringClass($trait->getProperty($property->getName()));
				}
			}
		}
		return $property->getDeclaringClass();
	}

}
