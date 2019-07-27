<?php

namespace LaraMlToolkit\Classification;

use Illuminate\Support\Collection;
use LaraMlToolkit\MockableModel;

trait ClassifyTestModelsTrait
{
	public function getTestModels(): Collection
	{
		$model1 = new MockableModel([
			'feature1' => 5,
			'feature2' => 4,
		]);
		$model1->setMlTarget('a');

		$model2 = new MockableModel([
			'feature1' => 5,
			'feature2' => 3,
		]);
		$model2->setMlTarget('a');

		$model3 = new MockableModel([
			'feature1' => 5,
			'feature2' => 2,
		]);
		$model3->setMlTarget('a');

		// not a neighbor / second class

		$model4 = new MockableModel([
			'feature1' => 7,
			'feature2' => 4,
		]);
		$model4->setMlTarget('b');

		$model5 = new MockableModel([
			'feature1' => 7,
			'feature2' => 3,
		]);
		$model5->setMlTarget('b');

		$model6 = new MockableModel([
			'feature1' => 7,
			'feature2' => 2,
		]);
		$model6->setMlTarget('b');


		return new Collection([$model1, $model2, $model3, $model4, $model5, $model6]);

	}
}