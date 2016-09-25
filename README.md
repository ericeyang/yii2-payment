# yii2-payment
Alipay and WeChat payment for [Yii2](http://www.yiiframework.com/).

## Installation

#### Install With Composer
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run
```
php composer.phar require ericeyang/yii2-payment "dev-master"
```
Or, you may add
```php
"ericeyang/yii2-payment": "dev-master"
```
to the require section of your ``composer.json`` file and execute ``php composer.phar update``.

#### Add the path alias
In your application config, add the path alias for this extension.
```php
return [
    ...
    'aliases' => [
        '@ericeyang/payment' => 'path/to/your/extracted',
        // for example: '@ericeyang/payment' => '@vendor/ericeyang/yii2-payment',
        ...
    ]
];
```

