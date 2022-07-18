# Add tags and taggable behaviour to a Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/websystem/tags.svg?style=flat-square)](https://packagist.org/packages/websystem/tags)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/websystem/tags.svg?style=flat-square)](https://packagist.org/packages/websystem/tags)

## Installation

Install the package through [Composer](http://getcomposer.org/).

Run the Composer require command from the Terminal:

    composer require websystem/tags

## Usage
Here are some code examples:

```php
// apply HasTags trait to a model
use Illuminate\Database\Eloquent\Model;
use Websystem\Tags\HasTags;
class Lesson extends Model
{
    use HasTags;

    // ...
}
```

```php
use Illuminate\Support\Str;
// create a model with some tags
$tags = Tag::create([
 'name' => 'Tag Name',
 'slug' => Str::slug('Tag Name')
]);

```
You just need to pass the data that working with the models
```
$model = new YourEloquentModel;
$model->title = 'Test';
$model->save();
```
## Set a new tags
You can set a new tags like this:
```
$model->tag(['your_tag_name']);
````
## Untag existing tags
You can untag existing tag
```
$model->untag(['your_tag_name']);
````

## Untag all tags

```
$model->untag();
````

## Retag existing tag
```
$model->retag(['your_tag_name']);
````
