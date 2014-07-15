<?php


class SampleTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @test
	 */
	public function itPasses()
	{
		$this->assertTrue(true);
	}


	/**
	 * @test
	 * @group slow
	 */
	public function itShouldBeIgnoredWithoutCallingItExplicitly()
	{
		$this->assertTrue(true);
	}
}