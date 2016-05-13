<?php
/*
 * A PHP Library to handle a JSON API body in an OOP way.
 * Copyright (C) 2015-2016  Artur Weigandt  https://wlabs.de/kontakt

 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Art4\JsonApiClient\Utils;

final class Manager implements ManagerInterface, FactoryManagerInterface
{
	/**
	 * @var FactoryInterface
	 */
	public $factory = null;

	/**
	 * @param  FactoryInterface $factory
	 * @return object
	 */
	public function __construct($factory = null)
	{
		if ( ! is_null($factory) )
		{
			$this->setFactory($factory);
		}
	}

	/**
	 * Set a factory into the manager
	 *
	 * @param  FactoryInterface $factory
	 * @return object
	 */
	public function setFactory(FactoryInterface $factory)
	{
		$this->factory = $factory;

		return $this;
	}

	/**
	 * Get a factory from the manager
	 *
	 * @return FactoryInterface
	 */
	public function getFactory()
	{
		if ( is_null($this->factory) )
		{
			$this->setFactory(new Factory);
		}

		return $this->factory;
	}

	/**
	 * Parse a JSON API string into an object
	 *
	 * @param   string $string The JSON API string
	 * @return  Art4\JsonApiClient\AccessInterface
	 *
	 * @throws  Art4\JsonApiClient\Exception\ValidationException If $string is not valid JSON API
	 */
	public function parse($string)
	{
		$object = Helper::decodeJson($string);

		return $this->getFactory()->make('Document', [
			$object,
			$this,
		]);
	}
}
