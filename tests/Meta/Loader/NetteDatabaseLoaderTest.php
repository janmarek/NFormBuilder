<?php

namespace NFormBuilder\Test\Meta\Loader;

use NFormBuilder\Meta\Field;

/**
 * @author Jan Marek
 */
class NetteDatabaseLoaderTest extends \PHPUnit_Framework_TestCase
{

	/** @var \NFormBuilder\Meta\Loader\NetteDatabaseLoader */
	private $object;

	/** @var \NFormBuilder\Meta\Metadata */
	private $metadata;

	protected function setUp()
	{
		$driverMeta = require __DIR__ . '/../../fixtures/ndbdata.php';
		$driverMock = \Mockista\mock(/*'Nette\Database\Drivers\MySqlDriver'*/);
		$driverMock->getColumns('blog')->once->andReturn($driverMeta);
		$driverMock->freeze();

		$this->metadata = new \NFormBuilder\Meta\Metadata();
		$this->object = new \NFormBuilder\Meta\Loader\NetteDatabaseLoader($driverMock);
		$this->object->load('blog', $this->metadata);
	}

	public function testMetadataLoaded()
	{
		$this->assertEquals(6, count($this->metadata->fields));
	}

	public function testInt()
	{
		$this->assertEquals(Field::TYPE_INTEGER, $this->metadata->fields['visits']->type);
	}

	public function testString()
	{
		$this->assertEquals(Field::TYPE_STRING, $this->metadata->fields['name']->type);
	}

	public function testText()
	{
		$this->assertEquals(Field::TYPE_TEXT, $this->metadata->fields['text']->type);
	}

	public function testBoolean()
	{
		$this->markTestIncomplete('todo test');
	}

	public function testDatetime()
	{
		$this->assertEquals(Field::TYPE_DATETIME, $this->metadata->fields['date']->type);
	}

	// loaded validation

	public function testMaxLength()
	{
		$rules = array(
			array(
				'type' => Field::VALIDATION_MAX_LENGTH,
				'value' => 30,
			),
		);

		$this->assertEquals($rules, $this->metadata->fields['name']->rules);
	}

	public function testRequired()
	{
		$rules = array(
			array(
				'type' => Field::VALIDATION_REQUIRED,
			),
		);

		$this->assertEquals($rules, $this->metadata->fields['visits']->rules);
	}

	public function testMultipleRules()
	{
		$this->assertEquals(2, count($this->metadata->fields['slug']->rules));
	}

}
