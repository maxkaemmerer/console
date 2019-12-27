[![Travis branch](https://img.shields.io/travis/maxkaemmerer/console/master.svg?style=flat-square)](https://travis-ci.org/maxkaemmerer/console)
[![Coveralls github](https://img.shields.io/coveralls/maxkaemmerer/console/master.svg?style=flat-square&branch=master)](https://coveralls.io/github/maxkaemmerer/console?branch=master)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/maxkaemmerer/console.svg?style=flat-square)](https://packagist.org/packages/maxkaemmerer/console)
[![Packagist](https://img.shields.io/packagist/v/maxkaemmerer/console.svg?style=flat-square)](https://packagist.org/packages/maxkaemmerer/console)
[![Packagist](https://img.shields.io/packagist/l/maxkaemmerer/console.svg?style=flat-square)](https://packagist.org/packages/maxkaemmerer/console)
## WORK IN PROGRESS, CODE IS DUE TO CHANGE SO USE AT YOUR OWN RISK, NEITHER STABLE NOR BATTLE TESTED
### This is a Work in Progress library of code that should be useful for basic php console applications

####Example use with one Argument
```php
<?php declare(strict_types=1);

use MaxKaemmerer\Console\Argument\Argument;

require_once __DIR__ . '/../vendor/autoload.php';

$myValue = Argument::create('anArgumentName', null, 'This is a description of the Argument')->parse($argv);
var_dump($myValue);
```

```shell script
php oneArgument.php --anArgumentName=anArgumentValue
string(15) "anArgumentValue"
```
* This will produce a value of type string.
* The type of the value is determined by the default value.
* In cases where the default value is null the value will be of type string.
* In cases where the default value is an array the value will be an array of strings.

####Example use with multiple Arguments
```php
<?php declare(strict_types=1);

use MaxKaemmerer\Console\Argument\Argument;
use MaxKaemmerer\Console\Argument\FlagArgument;
use MaxKaemmerer\Console\Argument\InputArguments;

require_once __DIR__ . '/../vendor/autoload.php';

$arguments = InputArguments::fromArguments([
    Argument::create('aggregateIds', [], 'The aggregateId to be deleted from snapshots'),
    Argument::create('aggregateVersion', 5, 'The aggregateVersion to be deleted from snapshots'),
    Argument::create('since', 'now', 'The point in time since when created aggregates are included.'),
    FlagArgument::create('rebuild', 'Pass if you want snapshots to be rebuilt afterwards.')
])->parse($argv);

var_dump($arguments);
```

```shell script
php multipleArguments.php --aggregateIds="someId,someOtherId" --flagName --aggregateVersion="7"
array(4) {
  'aggregateIds' =>
  array(2) {
    [0] =>
    string(6) "someId"
    [1] =>
    string(11) "someOtherId"
  }
  'aggregateVersion' =>
  int(7)
  'since' =>
  string(3) "now"
  'rebuild' =>
  bool(true)
}
```
* This will produce an associative array of argumentName => argumentValue.
* In this case the value of aggregateIds is an array of strings.
* In this case the value of aggregateVersion is `7` and of type int.
* In this case the value of since is `now` and of type string.
* In this case the value of rebuild is `true` and of type boolean.
* Values of `MaxKaemmerer\Console\Argument\FlagArgument` are always of type boolean. Resulting in `true` if the flag is passed and `false` if it is not.
* When using `MaxKaemmerer\Console\Argument\InputArguments` and calling the script with --help a basic help message is displayed. This message can be overwritten by passing a `MaxKaemmerer\Console\Argument\HelpArgument` with the other arguments.

```shell script
php multipleArguments.php --help
The following arguments can be passed:
Name: aggregateIds
Description: The aggregateId to be deleted from snapshots
Default Value: array (
)
_________________________________________________
Name: aggregateVersion
Description: The aggregateVersion to be deleted from snapshots
Default Value: 5
_________________________________________________
Name: since
Description: The point in time since when created aggregates are included.
Default Value: 'now'
_________________________________________________
Name: rebuild
Description: Pass if you want snapshots to be rebuilt afterwards.
_________________________________________________
```