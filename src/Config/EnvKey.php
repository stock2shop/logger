<?php

declare(strict_types=1);

namespace Stock2Shop\Logger\Config;

/**
 * Allowed Environment Keys
 */
enum EnvKey: string
{
    case DB_HOST = 'DB_HOST';
    case DB_PORT = 'DB_PORT';
    case DB_USERNAME = 'DB_USERNAME';
    case DB_PASSWORD = 'DB_PASSWORD';
    case DB_DBNAME = 'DB_DBNAME';
    case AWS_ACCESS_KEY_ID = 'AWS_ACCESS_KEY_ID';
    case AWS_SECRET_ACCESS_KEY = 'AWS_SECRET_ACCESS_KEY';
    case AWS_VERSION = 'AWS_VERSION';
    case AWS_REGION = 'AWS_REGION';
    case AWS_ENDPOINT = 'AWS_ENDPOINT';
    case AWS_BUCKET_AUDIT = 'AWS_BUCKET_AUDIT';
    case LOG_CHANNEL = 'LOG_CHANNEL';
    case LOG_CW_KEY = 'LOG_CW_KEY';
    case LOG_CW_SECRET = 'LOG_CW_SECRET';
    case LOG_CW_VERSION = 'LOG_CW_VERSION';
    case LOG_CW_REGION = 'LOG_CW_REGION';
    case LOG_CW_GROUP_NAME = 'LOG_CW_GROUP_NAME';
    case LOG_CW_RETENTION_DAYS = 'LOG_CW_RETENTION_DAYS';
    case LOG_CW_BATCH_SIZE = 'LOG_CW_BATCH_SIZE';
    case LOG_FS_DIR = 'LOG_FS_DIR';
    case LOG_FS_FILE_NAME = 'LOG_FS_FILE_NAME';
}
