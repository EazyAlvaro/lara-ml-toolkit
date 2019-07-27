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

	public function predictProvider()
	{
		return [
			'class A, K=3' => [

				[5, 3],
				'a',
				3

			],
			'class B, K=3' => [
				[7, 3],
				'b',
				3
			],
			'class A, K=2' => [

				[5, 3],
				'a',
				2

			],
			'class B, K=2' => [
				[7, 3],
				'b',
				2
			],
			'class A, K=1' => [

				[5, 3],
				'a',
				1

			],
			'class B, K=1' => [
				[7, 3],
				'b',
				1
			],
			'class B, K=default' => [
				[7, 3],
				'b',
				null
			],
		];
	}
}