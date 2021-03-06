<?php

use Anvil\Plugins\Plugin;
use Anvil\Plugins\Decorator;

class PluginsDecoratorTest extends PHPUnit_Framework_TestCase {

	public function testGetMagicMethod()
	{
		$plugin = new DecoratorPluginStub;
		$decorator = new Decorator($plugin);

		$plugin->key = 'value';

		$this->assertEquals($plugin->key, $decorator->key);
	}

	public function testSetMagicMethod()
	{
		$plugin = new DecoratorPluginStub;
		$decorator = new Decorator($plugin);

		$decorator->key = 'value';

		$this->assertEquals($decorator->key, $plugin->key);
	}

	public function testCallMethodWithNoParameters()
	{
		$expected = 'Expected';

		$plugin = $this->getMock('Anvil\Plugins\Plugin', array('resetAttributes', 'test'));
		$plugin->expects($this->once())
			->method('resetAttributes');
		$plugin->expects($this->once())
			->method('test')
			->will($this->returnValue($expected));

		$decorator = $this->getMock('Anvil\Plugins\Decorator', NULL, array($plugin));

		$this->assertEquals($expected, $decorator->test());
	}

	public function testCallMethodWithParameters()
	{
		$parameters = array('foo' => 'bar');
		$expected = 'Expected';

		$plugin = $this->getMock('Anvil\Plugins\Plugin', array('resetAttributes', 'test'));
		$plugin->expects($this->once())
			->method('resetAttributes');
		$plugin->expects($this->once())
			->method('test')
			->with($this->equalTo($parameters))
			->will($this->returnValue($expected));

		$decorator = $this->getMock('Anvil\Plugins\Decorator', NULL, array($plugin));

		$this->assertEquals($expected, $decorator->test($parameters));
	}

	public function testCallMethodWithNamedVariables()
	{
		$parameters = array('fake' => 'value', 'foo' => 'bar');
		$expected = 'bar default';

		$plugin = new PluginNamedVariableStub;
		$decorator = new Decorator($plugin);

		$this->assertEquals($expected, $decorator->test($parameters));
	}
}

class DecoratorPluginStub extends Plugin {}

class PluginNamedVariableStub extends Plugin {

	public function test($foo, $bar = 'default')
	{
		return $foo.' '.$bar;
	}
}