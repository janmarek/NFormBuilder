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
		$this->form = new \Nette\Forms\Container();

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
		$this->object->add('name', 'allowed');
		$this->assertEquals(2, count($this->form->getComponents()));
	}

	public function testBoolean()
	{
		$this->object->add('allowed');
		$this->assertInstanceOf('Nette\Forms\Controls\Checkbox', $this->form['allowed']);
	}

	public function testString()
	{
		$this->object->add('name');
		$this->assertInstanceOf('Nette\Forms\Controls\TextInput', $this->form['name']);
	}

	public function testText()
	{
		$this->object->add('text');
		$this->assertInstanceOf('Nette\Forms\Controls\TextArea', $this->form['text']);
	}

	public function testRequired()
	{
		$this->object->add('name');
		$this->assertTrue($this->form['name']->isRequired());
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
