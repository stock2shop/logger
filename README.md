# Stock2Shop Logger

Logging utility to write logs for Stock2Shop applications.

Logs are written as a JSON string and can be configured to write to multiple locations. 

Currently, we support Cloudwatch and File system logs.
Whilst developing your application, set the logger to write to the file system.

Configure the logger by creating the [appropriate Environment](src/EnvKey.php) variables.

-----

## Usage

### Custom Log

Logging with bare minimum fields.

```php
Logger\Custom::log([
    'level' => LogLevel::INFO,
    'message' => 'Hi',
    'origin' => 'MyApp'
]);
```

A more detailed example

```php
Logger\Custom::log([
    'level' => LogLevel::INFO,
    'message' => 'Hi',
    'origin' => 'MyApp',
    'client_id' => 21,
    'tags' => ['a']
]);
```

### Exception Log

```php
try {
    throw new \Exception('BooHoo')
} catch(\Exception $e) {
    Logger\Exception::log($e);
}
```

Adding in some more detail for the exception

```php
try {
    throw new \Exception('BooHoo')
} catch(\Exception $e) {
    Logger\Exception::log($e, ['client_id' => 21]);
}
```

### Action Specific Log

Example logging successful product sync to a channel

```php
$dtoArray = DTO\ChannelProduct::createArray([
    [
        'client_id'  => 1,
        'channel_id' => 2,
    ]
]);
Logger\ChannelProductsSuccess::log($dtoArray);
```

## Configuration

See `.env.sample` or [EnvKey](src/EnvKey.php) for a list of options

To enable file based logging, set environment variables before calling logger.

```php
$loader = new LoaderArray([
    'LOG_CHANNEL'      => 'Logger',
    'LOG_FS_DIR'       => 'output/dir',
    'LOG_FS_ENABLED'   => 'true',
    'LOG_FS_FILE_NAME' => 'my.log'
]);
Env::set($loader);
```

You could enable multiple handlers, (you would need to include all their required config)

```php
$loader = new LoaderArray([
    'LOG_FS_ENABLED' => 'true',
    'LOG_CW_ENABLED' => 'true'
]);
Env::set($loader);
```

## Running Tests

```bash
./vendor/bin/phpunit
```