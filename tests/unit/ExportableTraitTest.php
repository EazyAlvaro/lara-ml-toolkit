<?php

use LaraMlToolkit\MockableModel;
use Codeception\Test\Unit;

/**
 * @group trait
 */
class ExportableTraitTest extends Unit
{

	public function testToMlSampleWithStrings()
	{
		$model = new MockableModel();
		$model->feature1 = 'foo';
		$model->feature2 = 'bar';

		$actual = $model->toMlSample();

		$expected = [
			'feature1' => 'foo',
			'feature2' => 'bar'
		];

		$this->assertEquals($expected, $actual);
	}

	public function testToMlSampleWithInts()
	{
		$model = new MockableModel();
		$model->feature1 = 1;
		$model->feature2 = 2;

		$actual = $model->toMlSample();

		$expected = [
			'feature1' => 1,
			'feature2' => 2
		];

		$this->assertEquals($expected, $actual);
	}

}