<?php

namespace NFormBuilder\Meta\Loader;

use NFormBuilder\Meta\Metadata;
use NFormBuilder\Meta\Field;

/**
 * @author Jan Marek
 */
class NetteDatabaseLoader implements ILoader
{

	/** @var \Nette\Database\ISupplementalDriver */
	private $driver;

	public function __construct(/*\Nette\Database\ISupplementalDriver*/ $driver)
	{
		$this->driver = $driver;
	}

	/**
	 * @param string $name
	 * @param \NFormBuilder\Meta\Metadata $meta
	 */
	public function load($name, Metadata $meta)
	{
		$data = $this->driver->getColumns($name);

		foreach ($data as $column) {
			$this->addField($column, $meta);
		}
	}

	/**
	 * @param array $name
	 * @param \NFormBuilder\Meta\Metadata $meta
	 */
	public function addField($column, Metadata $meta)
	{
		$name = $column['name'];

		/* @var \NFormBuilder\Meta\Field $field */
		$field = $meta->fields[$name] = isset($meta->fields[$name]) ? $meta->fields[$name] : new Field();

		$field->type = $this->guessType($column);
		$this->addRules($field, $column);

		if ($field->label === NULL) {
			$field->label = ucfirst($name);
		}
	}

	protected function guessType($column)
	{
		$dbtype = strtolower($column['nativetype']);

		$types = array(
			'timestamp' => Field::TYPE_DATETIME,
			'date' => Field::TYPE_DATE,
			'varchar' => Field::TYPE_STRING,
			'longtext' => Field::TYPE_TEXT,
			'text' => Field::TYPE_TEXT,
			'int' => Field::TYPE_INTEGER,
			'tinyint' => Field::TYPE_INTEGER,
		);

		if ($dbtype === 'tinyint' && $column['size'] === 1) {
			return Field::TYPE_BOOLEAN;
		} elseif (isset($types[$dbtype])) {
			return $types[$dbtype];
		} else {
			return NULL;
		}
	}

	protected function addRules(Field $field, $column)
	{
		if ($column['nullable'] === FALSE) {
			$field->rules[] = array(
				'type' => Field::VALIDATION_REQUIRED,
			);
		}

		if ($field->type === 'string' && $column['size'] !== NULL) {
			$field->rules[] = array(
				'type' => Field::VALIDATION_MAX_LENGTH,
				'value' => $column['size'],
			);
		}
	}

}
