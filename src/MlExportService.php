<?php

namespace LaraMlToolkit;

use Illuminate\Support\Collection;
use Phpml\Dataset\ArrayDataset;
use Phpml\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Storage;
use Exception;

class MlExportService
{
	/**
	 * @param Collection $data Model entities that MUST implement MlExportable
	 *
	 * @return null|ArrayDataset null in case of Exception
	 */
	public static function toArrayDataset(Collection $data): ?ArrayDataset
	{
		$samples = [];
		$labels = [];

		self::collectSamplesAndLabels($data, $samples, $labels);

		try {
			return new ArrayDataset($samples, $labels);
		} catch (InvalidArgumentException $argumentException) { // size mismatch
			return null;
		}
	}

	/**
	 * @param Collection $data Model entities that MUST implement MlExportable
	 * @param array      $samples By reference, intended to be empty
	 * @param array      $labels By reference, intended to be empty
	 */
	public static function collectSamplesAndLabels(Collection $data, array &$samples, array &$labels)
	{
		$data->each(function (MlExportable $record) use (&$samples, &$labels) {
			$labels[] = $record->getMlTarget();
			$samples[] = $record->toMlSample();
		});
	}

	public static function buildCsvFields(Collection $data): array
	{
		if ($data->isEmpty() || empty($data->first()->getMlFeatures())) {
			$errMsg = "Provided dataset is empty or Model has no features/labels defined";
			throw new InvalidArgumentException($errMsg);
		}

		$fields = [];
		$samples = [];
		$labels = [];
		$rows = [];

		// We are assuming here that that the Collection has uniform content.
		// If not: at the VERY LEAST the objects should have sensible values
		// for the headers they now fall under
		$headers = $data->first()->getMlFeatures();

		self::collectSamplesAndLabels($data, $samples, $labels);

		$fields[] = $headers;

		foreach ($samples as $key => $sample) {
			$sample['ml_label'] = $labels[$key];
			$rows[] = $sample;
		}

		return array_merge($fields, $rows);
	}

	public static function toCsvString(Collection $data): string
	{
		$fakeFile = fopen('php://memory', 'r+');
		$rows = self::buildCsvFields($data);

		foreach ($rows as $key => $row) {
			if (fputcsv($fakeFile, $row) === false) {
				// @codeCoverageIgnoreStart
				throw  new \Exception("Failed to write CSV line/row " . $key);
				// @codeCoverageIgnoreEnd
			}
		}
		rewind($fakeFile);
		$csv_line = stream_get_contents($fakeFile);

		return rtrim($csv_line);
	}

	/**
	 * @param string $filepath
	 *
	 * @codeCoverageIgnore only executes a framework function
	 *
	 * @return bool whether the file could be saved (exists)
	 */
	public static function storeCsv(string $filepath, string $contents): bool
	{
		return Storage::put($filepath, $contents);
	}
}