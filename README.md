# MarsPress PostType
### Installation
Require the composer package in your composer.json with `marspress/graphql-fields` with minimum `dev-main` OR run `composer require marspress/graphql-fields`

### References
* https://www.wpgraphql.com/2020/03/11/registering-graphql-fields-with-arguments/

### Usage
`new \MarsPress\GraphQL\Field()` takes 6 parameters.
* Type Name (required)(string)
* Field Name (required)(string)
* Field Type (required)(string)
* Field Description (required)(string)
* Field Arguments (required)(array)
* Field Resolve (required)(callable)
    * A callable method. This can be a Closure function or an array with a class method passed as such: `[ $this, '<method name>' ]`(non-static) OR `[ __CLASS__, '<method name>' ]`(static)
    * If the callback is not callable, a message will be outputted to admins in the WordPress Admin area.
    * IMPORTANT: your callback will be passed 4 parameters:
        * Source (unknown, update type here please)
        * Arguments (unknown, update type here please)
        * Context (unknown, update type here please)
        * Info (object)