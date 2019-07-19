# lara-ml-toolkit
Export Eloquent entities to arrays and CSV's for use in basic Classification ML 
(KNearestNeigbors, Naive Bayes, etc) where a single classification label suffices.



## Intended use
Meant for use with 
* [PHP-ML](https://github.com/php-ai/php-ml) Dataset classes 
* CSV output for any ML library (mostly Python / [TensorFlow](https://www.tensorflow.org/)) 
that can accept the following CSV format: 

```
sepal_length,sepal_width,petal_length,petal_width,CLASS
5.1,3.5,1.4,0.2,setosa
4.9,3,1.4,0.2,setosa
4.7,3.2,1.3,0.2,setosa
4.6,3.1,1.5,0.2,setosa
```
(Example from the famous Iris dataset)

### What this package does NOT do
* We don't separate test set from learning sets, that's your ML framework's job.

## Getting Started

1) Require this project in Composer
2) make sure the class(es) that you want to perform classification on implements and conforms to the 
[MlExportable interface](src/MlExportable.php) and uses the [Exportable Trait](src/ExportableTrait.php)

3) Use  [MlExportService](src/MlExportService.php) to store the exported CSV in your storage folder (storage/app/test.csv)
```
$csvString = MlExportService::toCsvString($this->data);
MlExportService::storeCsv('test.csv',  $csvString);
```

You should now have a CSV file that is ready for use in ML frameworks

<br>
---
<br>

## To-do / goals
* (more) extensive testing
* Implement PHP-ML as part of this package so we can do basic classification easily from inside Laravel.