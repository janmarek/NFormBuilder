<?php

namespace NFormBuilder\Meta;

/**
 * @author Jan Marek
 */
class Field
{

	const TYPE_TEXT = 'text';
	const TYPE_INTEGER = 'int';
	const TYPE_STRING = 'string';
	const TYPE_DATE = 'date';
	const TYPE_DATETIME = 'datetime';
	const TYPE_BOOLEAN = 'boolean';

	const VALIDATION_REQUIRED = 'required';
	const VALIDATION_MAX_LENGTH = 'maxlength';
	const VALIDATION_MIN_LENGTH = 'minlength';
	const VALIDATION_EMAIL = 'email';

	/** @var string */
	public $name;

	/** @var string */
	public $type;

	/** @var string */
	public $label;

	/** @var array */
	public $rules = array();

	/** @var array */
	public $extra = array();

}