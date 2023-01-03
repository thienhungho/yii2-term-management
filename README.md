Yii2 Term Management System
====================
Term Management System for Yii2

Installation
------------

This is just an example, memorible moment. The source code may not work for known reasons. This source code include against loss license feature.

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist thienhungho/yii2-term-management "*"
```

or add

```
"thienhungho/yii2-term-management": "*"
```

to the require section of your `composer.json` file.

### Migration

Run the following command in Terminal for database migration:

```
yii migrate/up --migrationPath=@vendor/thienhungho/TermManagement/migrations
```

Or use the [namespaced migration](http://www.yiiframework.com/doc-2.0/guide-db-migrations.html#namespaced-migrations) (requires at least Yii 2.0.10):

```php
// Add namespace to console config:
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationNamespaces' => [
            'thienhungho\TermManagement\migrations\namespaced',
        ],
    ],
],
```

Then run:
```
yii migrate/up
```

Config
------------

Add module TermManage to your `AppConfig` file.

```php
...
'modules'          => [
    ...
    /**
     * Term Manage
     */
    'term-manage' => [
        'class' => 'thienhungho\TermManagement\modules\TermManage\TermManage',
    ],
    ...
],
...
```

Modules
------------

[TermBase](https://github.com/thienhungho/yii2-term-management/tree/master/src/modules/TermBase), [TermManage](https://github.com/thienhungho/yii2-term-management/tree/master/src/modules/TermManage)

Functions
------------

[Core](https://github.com/thienhungho/yii2-term-management/tree/master/src/functions/core.php)

Models
------------

[Term](https://github.com/thienhungho/yii2-term-management/tree/master/src/models/Term.php), [TermRelationships](https://github.com/thienhungho/yii2-term-management/tree/master/src/models/TermRelationships.php), [TermType](https://github.com/thienhungho/yii2-term-management/tree/master/src/models/TermType.php),

Constant
------------

[Core](https://github.com/thienhungho/yii2-term-management/tree/master/src/const/core.php)
