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
	 */
	public function thisOneFails()
	{
		$this->assertTrue(false);
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