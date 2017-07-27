[![Smotret-Anime.ru](https://smotret-anime.ru/images/logo.png)](https://smotret-anime.ru)

[![Latest Stable Version](https://img.shields.io/packagist/v/anime-db/smotret-anime-browser-bundle.svg?maxAge=3600&label=stable)](https://packagist.org/packages/anime-db/smotret-anime-browser-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/anime-db/smotret-anime-browser-bundle.svg?maxAge=3600)](https://packagist.org/packages/anime-db/smotret-anime-browser-bundle)
[![Build Status](https://img.shields.io/travis/anime-db/smotret-anime-browser-bundle.svg?maxAge=3600)](https://travis-ci.org/anime-db/smotret-anime-browser-bundle)
[![Coverage Status](https://img.shields.io/coveralls/anime-db/smotret-anime-browser-bundle.svg?maxAge=3600)](https://coveralls.io/github/anime-db/smotret-anime-browser-bundle?branch=master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/anime-db/smotret-anime-browser-bundle.svg?maxAge=3600)](https://scrutinizer-ci.com/g/anime-db/smotret-anime-browser-bundle/?branch=master)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/2a347b13-5d26-4d06-a66d-e45c5f72606e.svg?maxAge=3600&label=SLInsight)](https://insight.sensiolabs.com/projects/2a347b13-5d26-4d06-a66d-e45c5f72606e)
[![StyleCI](https://styleci.io/repos/97733674/shield?branch=master)](https://styleci.io/repos/97733674)
[![License](https://img.shields.io/packagist/l/anime-db/smotret-anime-browser-bundle.svg?maxAge=3600)](https://github.com/anime-db/smotret-anime-browser-bundle)

Smotret-Anime.ru API browser
============================

Installation
------------

Pretty simple with [Composer](http://packagist.org), run:

```sh
composer require anime-db/smotret-anime-browser-bundle
```

Add AnimeDbSmotretAnimeBrowserBundle to your application kernel

```php
// app/appKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new AnimeDb\Bundle\SmotretAnimeBrowserBundle\AnimeDbSmotretAnimeBrowserBundle(),
    );
}
```

Configuration
-------------

```yml
anime_db_smotret_anime_browser:
    # Host name
    # As a default used 'http://smotret-anime.ru'
    host: 'http://smotret-anime.ru'

    # Host name
    # As a default used '/api/'
    prefix: '/api/'

    # HTTP User-Agent
    # No default value
    client: 'My Custom Bot 1.0'
```

Usage
-----

First get browser

```php
$browser = $this->get('anime_db.smotret_anime.browser');
```

### Translations

Last added translations:

```php
$content = $browser->get('translations');
```

Last translations for ongoings:

```php
$content = $browser->get('translations?feed=recent');
```

List of all translations (at the beginning of the oldest, convenient for a full scan):

```php
$content = $browser->get('translations?feed=id');
```

When scanning in full, do not use the `offset` parameter. Use `afterId` (offset works very slowly when the account goes
to hundreds of thousands of translations):

```php
$content = $browser->get('translations?feed=id&afterId=10000');
```

One translation:

```php
$content = $browser->get('translations/905760');
```

### Series

Anime List:

```php
$content = $browser->get('series');
```

You can select only specific fields:

```php
$content = $browser->get('series?fields=id,title,typeTitle,posterUrlSmall');
```

Advanced filter as on the [site](https://smotret-anime.ru/catalog/filter/genre@=8,35;genre_op=and):

```php
$content = $browser->get('series?chips=genre@=8,35;genre_op=and');
```

You can filter by parameters:

```php
$content = $browser->get('series?myAnimeListId=24133');
```

Search by name:

```php
$content = $browser->get('series?query=gate');
```

Information about a specific anime and a list of episodes:

```php
$content = $browser->get('series/9866');
```

### Episodes

Information about a specific episode and a list of translations:

```php
$content = $browser->get('episodes/102173');
```

### Limit and Offset

Through `limit` and `offset`, you can adjust the number of elements "on the page" and the offset from the beginning:

```php
$content = $browser->get('series?limit=1&offset=10');
```

### Request options

You can customize request options. See [Guzzle Documentation](http://docs.guzzlephp.org/en/stable/request-options.html).

License
-------

This bundle is under the [GPL v3 license](http://opensource.org/licenses/GPL-3.0).
See the complete license in the file: LICENSE
