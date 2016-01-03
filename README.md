# php-validator
Validator class helps validate associative arrays in php

This checked if the the key with actual data type is there or not

```php
$input_arr = array(
  "name"=>"Baligh",
  "city"=>"Karachi",
  "age"=>"25",
  "email"=>"abc@abc.com"
);
$validation_keys = array(
            "email":"required string"
            "name"=>"string",
            "age" => "numeric",
        );
  
  if(Validator::Validate($validation_keys, $input_arr)){
    // Logic goes here
  }else{
    var_dump(Validator::ValidationMessage());
  }

```
###### Validating nested arrays

You can also validate nested objects in an array

```php
$input_arr = array(
  "name"=>"Baligh",
  "email"=>"abc@abc.com",
  "friends"=>array(
                array(
                  "name"=>"Foo",
                  "id"=>1
                ),
                array(
                  "name"=>"Bar",
                  "id"=>2
                )
            )
);
$validation_keys = array(
            "email":"string",
            "friends.id"=>"required numeric"
        );
  
  if(Validator::Validate($validation_keys, $input_arr)){
    // Logic goes here
  }else{
    var_dump(Validator::ValidationMessage());
  }

```
