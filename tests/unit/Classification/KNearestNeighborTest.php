<?php

namespace LaraMlToolkit\Classification;

use Codeception\Test\Unit;

/**
 * @group classifiers
 *
 * This test actually also tests ModelClassifier the lazy way,
 * will probably rewrite once proven to work
 */
class KNearestNeighborTest extends Unit
{
	use ClassifyTestModelsTrait;

	/**
	 * @param $sample
	 * @param $expected
	 * @param $k number of neighbors
	 *
	 * @dataProvider predictProvider
	 */
	public function testPredict($sample, $expected, $k)
	{
		if ($k) {
			$knn = new KNearestNeighbor($k);
		} else {
			$knn = new KNearestNeighbor();
		}

		$collection = $this->getTestModels();

		$knn->train($collection);
		$actual = $knn->predict([$sample]);

		$this->assertEquals($expected, $actual[0]);
	}

}