<?php

namespace LaraMlToolkit\Classification;

use Phpml\Math\Distance;
use Phpml\Classification\KNearestNeighbors as KNNClassifier;

class KNearestNeighbor extends ModelClassifier
{
	public function __construct(int $k = 3, Distance $distance = null )
	{
		$classifier = new KNNClassifier($k, $distance);
		parent::__construct($classifier);
	}
}