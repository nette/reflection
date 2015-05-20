<?php

/**
 * This file is part of the Nette Framework (http://nette.org)
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 */

namespace Nette\Reflection;


class Helpers
{

	/**
	 * Returns declaring class or trait.
	 * @return \ReflectionClass
	 * @internal
	 */
	public static function getDeclaringClass(\ReflectionProperty $prop)
	{
		foreach ($prop->getDeclaringClass()->getTraits() as $trait) {
			if ($trait->hasProperty($prop->getName())) {
				return self::getDeclaringClass($trait->getProperty($prop->getName()));
			}
		}
		return $prop->getDeclaringClass();
	}

}
