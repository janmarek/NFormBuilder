<?php

namespace NFormBuilder\Test;

/**
 * @author Jan Marek
 */
class BaseTestCase extends \PHPUnit_Framework_TestCase
{

	private $__mocks = array();

	public function createMockista($class = NULL, $methods = NULL)
	{
		$mock = call_user_func_array('\Mockista\mock', func_get_args());
		$this->__mocks[] = $mock;
		return $mock;
	}

	public function assertMocks()
	{
		foreach ($this->__mocks as $mock) {
			$mock->assertExpectations();
		}
	}

}
