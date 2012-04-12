<?php

namespace NFormBuilder\Meta;

/**
 * @author Jan Marek
 */
class MetadataFactory
{

	/** @var \NFormBuilder\Meta\Loader\ILoader[] */
	private $metadataLoaders;

	/** @var array */
	private $metadata = array();

	public function addLoader(Loader\ILoader $metadataLoader)
	{
		$this->metadataLoaders[] = $metadataLoader;
	}

	public function getMetadata($name)
	{
		if (!isset($this->metadata[$name])) {
			$meta = new Metadata();

			foreach ($this->metadataLoaders as $loader) {
				$loader->load($name, $meta);
			}

			$this->metadata[$name] = $meta;
		}

		return $this->metadata[$name];
	}

}
