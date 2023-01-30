# Somerset.sh

Named after the tiny bridge in Bermuda, this app is simple and headless URL shortening service.

See a working version live at: [somerset.sh](http://somerset.sh)

## Prod Requirements

- Postgres
- Redis
- PHP 8.2

## Dev Requirements

- Docker & Docker Compose ([colima](https://github.com/abiosoft/colima) is recommended for mac users)
- PHP 8.2
- [Composer](https://getcomposer.org/)

## Setup

1. First we need to install our PHP dependencies
    1. `composer install`
3. Next copy over the `.env.example` file and alter it as needed.
    1. `cp .env.example .env`
4. Generate a fresh app key
    1. `./vendor/bin/sail artisan key:generate`
5. Make sure you have Docker running, then we can run sail...
    1. `./vendor/bin/sail up -d`
    2. You may want to install this globally or create an alias. [Read more here](https://laravel.com/docs/9.x/sail)
6. Create the symlink to the storage directory
    1. `./vendor/bin/sail artisan storage:link`
7. Now lets prepare the DB
    1. Migrate: `./vendor/bin/sail artisan migrate`
    2. Seed: `./vendor/bin/sail artisan db:seed`
9. Lastly we need to run Laravel Horizon to consume any background events.
    1. `./vendor/bin/sail artisan queue:work`

## Decisions Made

1. Archiving Short URLs when altering or deleting.
    1. You could simply soft delete a record, in order to preserve the data for future possible uses
        but it's also helpful to keep the main table as small as possible. So as a way to retain the
        data for future possible uses, its now moved over to an archived table.
2. Using cookies to help provide a "unique hit" metric.
    1. During the redirect, a session will be created and send back a session cookie. This is then
        used to track if the session has seen a specific short url or not.
    2. Realistically this does actually slow down the request slightly. The response payload is slightly
        larger than it would be, and we do have to read/write session data. I think the tradeoff is
        likely worth it in this case to get the additional metric though.
3. What happened to the "5 characters in length" requirement?
    1. Well one thing that hit me is we want to have the shortest possible URL, and restricting to only 5 characters
        seems to go against that goal.
    2. Looking at the numbers, if we are to limit to only 5 characters then `64^5 - 62^4 = 901_356_496` is a LOT of short codes.
        So it would certainly scale for a long time. `62^4 = 14_776_336` which is still a lot of codes, and the people that get those
        would be really happy customers. Then once you get into the power of 6 and 7, you get to some really high scale.
    3. All that said, how could I have actually implemented that?
        1. Given my current implementation, it would be easy enough to have the UniqueIdGenerator start at the lower
            bound of the range for base62 conversion to make a 5 character code. In this case, I am just using
            the DBs auto-increment ID as the unique ID generator, so I could start the IDs at that lower bound.
        2. Then I would need to prevent it from going into 6 characters, which would be possible by checking the newly
            generated code, against the known upper bound and throwing an error at that point.
4. Why implement your own base62 encoder?
    1. If you use a typical encoder, like you can achieve with gmp, it could pose a security
        risk if an attacker can predict the next generated short url. You can check `config/generators.php`
        and notice that with this custom implementation, I am able to use a randomized ordering
        of the character set needed for base62 encoding. This would make it a lot harder
        to guess the next code in the sequence.

## API Documentation

Make sure to use the following headers:
- `Accept: application/json`
- `Content-Type: application/json`

### Short Url Resource
```json
{
    "data": {
        "short_code": "w",
        "long_url": "https://partners.thepennyhoarder.com/when-money-is-tight-desktop/?aff_id=342&utm_source=firefox&utm_medium=paidnative&aff_sub3=when-money-is-tight",
        "unique_hits": 1,
        "total_hits": 3,
        "created_at": "2023-01-30T02:03:38.000000Z",
        "updated_at": "2023-01-30T02:05:52.000000Z"
    }
}
```

### Archived Short Url Resource
```json
{
    "data": {
        "id": 1,
        "short_code": "0",
        "long_url": "http://www.mayer.org/quo-architecto-architecto-velit",
        "unique_hits": 52979,
        "total_hits": 185019,
        "original_created_at": "2023-01-28 22:04:51",
        "original_updated_at": "2023-01-28 22:05:36",
        "created_at": "2023-01-28T22:06:00.000000Z"
    }
}
```

### Cursor Paginated Resource
```json
{
    "data": [],
    "path": "",
    "per_page": 50,
    "next_cursor": null,
    "next_page_url": null,
    "prev_cursor": null,
    "prev_page_url": null
}
```

### Get all short urls

`GET /api/short-urls`

**Response**: Cursor paginated resource, with a list of short url resources.

### Get a specific short url

`GET /api/short-urls/{shortCode}`

**Response**: Short Url Resource

### Create a short url

`POST /api/short-urls`

Raw JSON Body:
```json
{
    "long_url": "<your_long_url>"
}
```

**Response**: is a short url resource of the newly created short url.

**Note:** If the provided `long_url` has already been shorted, this will simply return
the existing resource.

### Update a short url

`PUT /api/short-urls/{shortCode}`

Raw JSON Body:
```json
{
    "long_url": "<your_long_url>"
}
```

**Response**: is the short url resource of the updated short url.

### Delete a short url

`DELETE /api/short-urls/{shortCode}`

**Response**: `204 No Content` will be returned if successful.

### Get all archived short urls

`GET /api/archived-short-urls`

**Response**: Cursor paginated resource, with a list of archived short url resources.

### Get a specific archived short url

`GET /api/archived-short-urls/{id}`

**Response**: Archived Short Url Resource
