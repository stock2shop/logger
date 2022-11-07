# Logger

Stock2Shop logging package for use with [Monolog](https://github.com/Seldaek/monolog).

The logger is able to handle multiple writers which can be found in the `src/Handler` directory.

-----

## Usage

### Instantiation

- The base logger type does not need to be explicitly instantiated,
  instead it gets created whenever a Stock2Shop Log is to be written

```php
Logger\Custom::log($params);
```

### Setting Handlers

- Handlers are set based off of your environment.
- To enable writing to file set the `LOG_FS_ENABLED` .env variable

```dotenv
LOG_FS_ENABLED=true
```

- To enable writing to CloudWatchLogs set the `LOG_CW_ENABLED` .env variable

```dotenv
LOG_CW_ENABLED=true
```

- Any handler can be disabled by setting the `LOG_*_ENABLED` key to `false`

### Writing a log

```php
$log = new Domain\Log([...]);
Logger\Custom::log($log);
```

### Writing an exception

```php
Logger\Exception::log(new Exception(self::MESSAGE));
```

-----

## Tests

- All unit tests can be run with the following command:

```bash
./vendor/bin/phpunit
```

- Or you can run a specific test file:

```bash
./vendor/bin/phpunit tests/LoggerTest.php
```