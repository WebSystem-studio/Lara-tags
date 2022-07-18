# Add tags and taggable behaviour to a Laravel app

[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

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
// create a model tag
use Illuminate\Support\Str;
$tags = Tag::create([
 'name' => 'Tag Name',
 'slug' => Str::slug('Tag Name')
]);
```
```php
// create a model lesson ex.
$lesson = Lesson::create([
 'title' => 'Lesson Title',
]);
```
## Set a new tags
Attaching tags
```php
$lesson->tag(['your_tag_name', '...']);
```
## Untag
Detaching tags
```php
// detach a tag
$lesson->untag(['your_tag_name', '...']);

// detach all tags
$lesson->untag();
```

## Retag
Retaging tags
```php
$model->retag(['your_tag_name', '...']);
````
