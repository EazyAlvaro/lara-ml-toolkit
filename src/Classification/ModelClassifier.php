<?php

namespace LaraMlToolkit\Classification;

use LaraMlToolkit\MlExportable;
use Phpml\ModelManager;
use Illuminate\Support\Collection;
use LaraMlToolkit\MlExportService;
use Phpml\Estimator;
use Phpml\Classification\Classifier;

/**
 * All shared methods and properties that can be used by other ModelClassifiers
 */
abstract class ModelClassifier
{
	/**
	 * Any of the PHP-ML classifiers namespaced under `Phpml\Classification`
	 * @var Classifier
	 */
	private $classifier;

	/** @var ModelManager */
	private $manager;

	/**
	 * @var \LaraMlToolkit\MlExportService
	 */
	private $service;

	public function __construct(Classifier $classifier)
	{
		$this->classifier = $classifier;
		$this->manager = new ModelManager();
	}

	public function save($filepath): void
	{

	}

	public function load($filepath): Estimator
	{
		// TODO https://php-ml.readthedocs.io/en/latest/machine-learning/model-manager/persistency/
	}


	public function predict(array $sample): array
	{
		return $this->classifier->predict($sample);
	}

	public function predictModel(MlExportable $model ): array
	{
		// TODO
	}

	/**
	 * @param Collection $data Model entities that MUST implement MlExportable
	 *
	 * @return Classifier Any extending class
	 */
	public function train(Collection $data ): Classifier
	{
		$dataSet = MlExportService::toArrayDataset($data);

		// we do this because Distance::Deltas of PHP-ML
		// is not compatible with PHP-ML's ArrayDataset structure
		// :man_facepalming:
		$samples = array_map(function($sample){
			return array_values($sample);
		}, $dataSet->getSamples());

		$this->classifier->train($samples, $dataSet->getTargets());

		return $this->classifier;
	}

}