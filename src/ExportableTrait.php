<?php

namespace LaraMlToolkit;

use Illuminate\Support\Collection;

/**
 * Intended for use on an Eloquent Model.
 * Please see the `README.md` for implementation details needed on the models.
 */
trait ExportableTrait
{

	public function toMlSample(): array
	{
		// we might need to get more creative if people want to be more flexible with hidden fields
		return (new Collection($this->toArray()))
			->map(function ($attribute, $key) {
				return in_array($key, $this->getMlFeatures()) ? $attribute : null;
			})
			//->filter() debatable whether we want this
			->toArray();
	}

}

