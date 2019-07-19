<?php

namespace LaraMlToolkit;

interface MlExportable
{
	/**
 	 * The class label, for use in classification.
	 *
	 * @return string examples: 'setosa', 'versicolor', 'virginica', '1', 'b'
	 */
	public function getMlTarget(): string;

	/**
	 * The values (AKA features) of the samples.
	 *
	 * @return array examples: [5, 1, 1] , [1, 5, 1], [1, 1, 5]
	 */
	public function toMlSample(): array;

	/**
	 * The table headers matching the values of the samples.
	 *
	 * The suggested implementation is to return a local $ml_features property array
	 * but you are free to implement this as desired.
	 *
	 * @return array example: ['sepal_length', 'sepal_width', 'petal_length', 'petal_width']
	 */
	public function getMlFeatures(): array;
}