# lara-ml-toolkit
Export Eloquent entities to arrays and CSV's for use in Classification ML 
(KNearestNeigbors, Naive Bayes, etc)

Intended for use with PHP-ML Dataset classes OR raw CSV output for any ML library 
that can accept the following format: 

```
sepal_length,sepal_width,petal_length,petal_width,CLASS
5.1,3.5,1.4,0.2,setosa
4.9,3,1.4,0.2,setosa
4.7,3.2,1.3,0.2,setosa
4.6,3.1,1.5,0.2,setosa
```
(Example from the famous Iris dataset)