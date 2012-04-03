<?php

namespace NFormBuilder;

use NFormBuilder\Meta\Field;

/**
 * @author Jan Marek
 */
class Builder
{

	/** @var \Nette\Forms\Container */
	private $form;

	/** @var \NFormBuilder\Meta\Metadata */
	private $metadata;

	public function __construct(/*\Nette\Forms\Container*/ $form, Meta\Metadata $metadata)
	{
		$this->form = $form;
		$this->metadata = $metadata;
	}

	public function add($name)
	{
		$names = func_get_args();

		foreach ($names as $n) {
			if (empty($this->metadata->fields[$n])) {
				throw new \Nette\InvalidArgumentException("Unknown field '$n'.'");
			}

			$this->addField($this->form, $this->metadata->fields[$n]);
		}
	}

	protected function addField(/*\Nette\Forms\Container*/ $form, Field $field)
	{
		// todo vymyslet lepsi customizovatelnost

		switch ($field->type) {
			case Field::TYPE_BOOLEAN:
				$input = $form->addCheckbox($field->name, $field->label);
				break;
			case Field::TYPE_INTEGER:
				$input = $form->addText($field->name, $field->label);
				$input->setType('number');
				break;
			case Field::TYPE_STRING:
				$maxLength = NULL;

				foreach ($field->rules as $rule) {
					if ($rule['type'] === Field::VALIDATION_MAX_LENGTH) {
						$maxLength = $rule['value'];
						break;
					}
				}

				$input = $form->addText($field->name, $field->label, NULL, $maxLength);
				break;
			case Field::TYPE_DATE:
			case Field::TYPE_DATETIME:
				$input = $form->addText($field->name, $field->label);
				break;
			case Field::TYPE_TEXT:
				$input = $form->addTextArea($field->name, $field->label);
				break;
			default:
				throw new \Nette\InvalidArgumentException("Unsupported type '$field->type'");
		}

		$this->addValidationRules($input, $field);
	}

	protected function addValidationRules($input, Field $field)
	{
		foreach ($field->rules as $rule) {
			switch ($rule['type']) {
				case Field::VALIDATION_REQUIRED:
					$input->setRequired();
					break;
				default:
					throw new \Nette\InvalidArgumentException("Unsupported validation type '$rule[type]'.");
			}
		}
	}

}
