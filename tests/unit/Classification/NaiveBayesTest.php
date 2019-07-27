<?php

namespace LaraMlToolkit\Classification;

use Codeception\Test\Unit;

/**
 * @group classifiers
 */
class NaiveBayesTest extends Unit
{
	use ClassifyTestModelsTrait;

	/**
	 * @param $sample [5,3]
	 * @param $expected string a|b
	 * @param $unused int  aka $k for naive Bayes testdata, ignore.
	 *
	 * @dataProvider predictProvider
	 */
	public function testPredict($sample, $expected, $unused)
	{
		$bayes = new NaiveBayes();

		$collection = $this->getTestModels();

		$bayes->train($collection);
		$actual = $bayes->predict([$sample]);
		$this->assertEquals($expected, $actual[0]);
	}
}