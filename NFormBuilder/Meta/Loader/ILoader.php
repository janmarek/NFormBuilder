<?php

namespace NFormBuilder\Meta\Loader;

/**
 * @author Jan Marek
 */
interface ILoader
{

	/**
	 * @param string $name
	 * @param \NFormBuilder\Meta\Metadata $meta
	 */
	public function load($name, \NFormBuilder\Meta\Metadata $meta);

}
