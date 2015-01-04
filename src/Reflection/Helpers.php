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
	 * @param \ReflectionProperty|\ReflectionMethod	 
	 * @return Nette\Reflection\ClassType
	 * @throws Nette\InvalidArgumentException	 
	 */
	public static function getDeclaringClass(\Reflector $reflection)
	{
		if (!$reflection instanceof \ReflectionProperty && !$reflection instanceof \ReflectionMethod) {
			throw new \Nette\InvalidArgumentException('Expected argument of type \ReflectionProperty or \ReflectionMethod, ' . get_class($reflection) . ' given.');
		}
	
		$class = $reflection->getDeclaringClass();

		if ($reflection instanceof \ReflectionProperty) {
			$trait = self::searchTraitsForProperty($class, $reflection->getName());

		} else {
			$methodFile = $reflection->getFileName();
			$methodStartLine = $reflection->getStartLine();
			$methodEndLine = $reflection->getEndLine();
			$trait = self::searchTraitsForMethod($class, $methodFile, $methodStartLine, $methodEndLine);
		}

		if ($trait !== NULL) {
			$class = $trait;
		}

		return new ClassType($class->getName());
	}


	/**
	 * Recursive method called to find a property in traits.
	 */
	private static function searchTraitsForProperty(\ReflectionClass $class, $name)
	{
		foreach ($class->getTraits() as $trait) {
			$result = self::searchTraitsForProperty($trait, $name);
			if ($result !== NULL) {
				return $result;

			} elseif ($trait->hasProperty($name)) {
				return $trait;
			}
		}
	}


	/**
	 * Recursive method called to find a method in traits.
	 */
	private static function searchTraitsForMethod(\ReflectionClass $class, $methodFile, $methodStartLine, $methodEndLine)
	{
		foreach ($class->getTraits() as $trait) {
			if ($trait->getFileName() === $methodFile && $trait->getStartLine() <= $methodStartLine && $trait->getEndLine() >= $methodEndLine) {
				return $trait;
			}

			$result = self::searchTraitsForMethod($trait, $methodFile, $methodStartLine, $methodEndLine);
			if ($result !== NULL) {
				return $result;
			}
		}
	}

}
