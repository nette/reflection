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
	 * Unlike the PHP's getDeclaringClass method, this can return a trait reflection.
	 * Results from this method should be cached.
	 * @return Nette\Reflection\ClassType
	 */
	public static function getDeclaringClass(\ReflectionProperty $reflection)
	{	
		$class = self::searchTraitsForProperty($reflection->getDeclaringClass(), $reflection->getName());

		return new ClassType($class->getName());
	}


	/**
	 * Recursive method called to find a property in traits.
	 */
	private static function searchTraitsForProperty(\ReflectionClass $class, $name)
	{
		foreach ($class->getTraits() as $trait) {
			if ($result = self::searchTraitsForProperty($trait, $name)) {
				return $result;
			}
		}

		if ($class->hasProperty($name)) {
			return $class;
		}
	}

}
