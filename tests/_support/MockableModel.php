<?php

namespace LaraMlToolkit;

use Illuminate\Database\Eloquent\Model;

class MockableModel extends Model implements MlExportable
{
	use ExportableTrait;

	private $target = 'testtarget';

	protected $fillable = [
		'feature1',
		'feature2',
		'target'
	];

	protected $hidden = [
		'target'
	];

	/**
	 * reminder: these are the headers for the features
	 */
	private $features = [
		'feature1',
		'feature2'
	];

	public function getMlFeatures(): array
	{
		return $this->features;
	}

	public function getMlTarget(): string
	{
		return $this->target;
	}

	/**
	 * This is for convenience only, and not expected to be a part of the real model.
	 *
	 * @param string $target
	 */
	public function setMlTarget(string $target)
	{
		$this->target = $target;
	}

	public function setMlFeatures(array $features)
	{
		$this->features = $features;
	}
}