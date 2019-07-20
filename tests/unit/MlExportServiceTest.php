<?php

use LaraMlToolkit\MockableModel;
use Codeception\Test\Unit;
use Illuminate\Support\Collection;
use LaraMlToolkit\MlExportService;
use Illuminate\Database\Eloquent\Model;
use Phpml\Exception\InvalidArgumentException;

/**
 * @group service
 * @covers \LaraMlToolkit\MlExportService
 */
class MlExportServiceTest extends Unit
{

	public function testToArrayDataset()
	{
		$model = new MockableModel();
		$model->feature1 = 'foo';
		$model->feature2 = 'bar';

		$model2 = new MockableModel();
		$model2->feature1 = 'moo';
		$model2->feature2 = 'far';
		$model2->setMlTarget('testtarget2');

		$collection = new Collection([$model, $model2]);

		$actual = MlExportService::toArrayDataset($collection);

		$expectedTargets = [
			'testtarget',
			'testtarget2',
		];

		$expectedSamples = [
			[
				'feature1' => 'foo',
				'feature2' => 'bar',
			],
			[
				'feature1' => 'moo',
				'feature2' => 'far',
			]
		];

		$this->assertEquals($expectedTargets, $actual->getTargets());
		$this->assertEquals($expectedSamples, $actual->getSamples());

	}

	public function testCollectSamplesAndLabelsWithWrongClass()
	{
		$wrongClass = Mockery::mock(Model::class)->makePartial();

		$collection = new Collection([$wrongClass, $wrongClass]);
		$samples = [];
		$labels = [];

		// we are passing the model to a closure that is typehinted for the interface
		$this->expectException(TypeError::class);

		MlExportService::collectSamplesAndLabels($collection, $samples, $labels);
	}

	public function testBuildCsvFieldsWithoutFeaturesExpectingException()
	{
		$model = new MockableModel();
		$model->setMlFeatures([]);
		$collection = new Collection([$model]);

		$this->expectException(InvalidArgumentException::class);
		MlExportService::buildCsvFields($collection);
	}

	public function testBuildCsvFieldsWithEmptyCollectionExpectingException()
	{
		$this->expectException(InvalidArgumentException::class);
		MlExportService::buildCsvFields(new Collection([]));
	}

	/**
	 * @param $expected array
	 *
	 * @dataProvider csvFields
	 *
	 * @throws InvalidArgumentException
	 */
	public function testBuildCsvFields($expected)
	{
		$collection = new Collection($this->getTestModels());
		$this->assertEquals($expected, MlExportService::buildCsvFields($collection));
	}

	/**
	 * @throws InvalidArgumentException
	 *
	 * @dataProvider csvFields
	 */
	public function testBuildCsvFields2($expected)
	{
		$model = new MockableModel();
		$model->feature1 = null;
		$model->feature2 = null;

		$model2 = new MockableModel();
		$model2->feature1 = 'moo';
		$model2->feature2 = 'far';
		$model2->setMlTarget('testtarget2');
		$collection = new Collection([$model, $model2]);

		$actual = MlExportService::buildCsvFields($collection);

		$expected[1]['feature1'] = null;
		$expected[1]['feature2'] = null;

		$this->assertEquals($expected, $actual);
	}

	public function testToCsvString()
	{
		$collection = new Collection($this->getTestModels());

		$actual = MlExportService::toCsvString($collection);
		$expected = "feature1,feature2\nfoo,bar,testtarget\nmoo,far,testtarget2";

		$this->assertEquals($expected, $actual);
	}

	private function getTestModels()
	{
		$model = new MockableModel();
		$model->feature1 = 'foo';
		$model->feature2 = 'bar';

		$model2 = new MockableModel();
		$model2->feature1 = 'moo';
		$model2->feature2 = 'far';
		$model2->setMlTarget('testtarget2');

		return [$model, $model2];
	}

	public function csvFields()
	{
		return [
			[
				[
					[
						'feature1',
						'feature2',
					],
					[
						'feature1' => 'foo',
						'feature2' => 'bar',
						'ml_label' => 'testtarget'
					],
					[
						'feature1' => 'moo',
						'feature2' => 'far',
						'ml_label' => 'testtarget2'
					]
				]
			]
		];
	}
}