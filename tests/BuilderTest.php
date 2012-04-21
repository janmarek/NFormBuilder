<?php

namespace NFormBuilder\Test;

use NFormBuilder\Meta\Field;

/**
 * @author Jan Marek
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{

	/** @var \NFormBuilder\Builder */
	private $object;

	private $form;

	protected function setUp()
	{
		$this->form = \Mockista\mock('Nette\Forms\Container');

		$meta = new \NFormBuilder\Meta\Metadata();

		$allowed = new Field();
		$allowed->name = 'allowed';
		$allowed->type = Field::TYPE_BOOLEAN;
		$meta->fields['allowed'] = $allowed;

		$name = new Field();
		$name->name = 'name';
		$name->type = Field::TYPE_STRING;
		$name->rules[] = array('type' => Field::VALIDATION_REQUIRED);
		$meta->fields['name'] = $name;

		$text = new Field();
		$text->name = 'text';
		$text->type = Field::TYPE_TEXT;
		$text->label = 'Text:';
		$meta->fields['text'] = $text;

		$this->object = new \NFormBuilder\Builder($this->form, $meta);
	}

	public function testAdd()
	{
		$nameMock = \Mockista\mock();
		$nameMock->setRequired();
		$nameMock->freeze();

		$this->form->addText('name', NULL, NULL, NULL)->once->andReturn($nameMock);
		$this->form->addCheckbox('allowed', NULL)->once;
		$this->form->freeze();

		$this->object->add('name', 'allowed');

		$nameMock->assertExpectations();
		$this->form->assertExpectations();
	}

	public function testText()
	{
		$this->form->addTextArea('text', 'Text:');
		$this->form->freeze();

		$this->object->add('text');

		$this->form->assertExpectations();
	}

	/**
	 * @expectedException \Nette\InvalidArgumentException
	 */
	public function testUnknownField()
	{
		$this->object->add('nesmysl');
	}

	// todo

}
