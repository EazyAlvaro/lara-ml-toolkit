<?php

namespace LaraMlToolkit\Classification;

class NaiveBayes extends ModelClassifier
{
	public function __construct()
	{
		parent::__construct(new \Phpml\Classification\NaiveBayes());
	}
}