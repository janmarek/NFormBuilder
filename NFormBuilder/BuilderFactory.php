<?php

namespace NFormBuilder;

/**
 * @author Jan Marek
 */
class BuilderFactory
{

	/** @var \NFormBuilder\Meta\Loader\ILoader */
	private $metadataFactory;

	public function __construct(Meta\MetadataFactory $metadataFactory)
	{
		$this->metadataFactory = $metadataFactory;
	}

	public function createBuilder($metaName, $form = NULL)
	{
		if ($form === NULL) {
			$form = new \Nette\Application\UI\Form();
		}

		$meta = $this->metadataFactory->getMetadata($metaName);

		return new Builder($form, $meta);
	}

}
