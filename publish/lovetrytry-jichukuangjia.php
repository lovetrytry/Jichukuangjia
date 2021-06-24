<?php

declare(strict_types=1);
/**
 * 基础框架配置文件
 *
 * @author lovetrytry@yeah.net
 */

use Lovetrytry\Jichukuangjia\Format\ClassEnum;

return [
    // 本配置中所有文件默认目录，留空或只填 DIRECTORY_SEPARATOR 则为项目根目录
    "baseDir" => DIRECTORY_SEPARATOR . 'storage',
    "password" => [
        "rsa" => [
            // 读取时会拼接上 $baseDir，🌰：项目根目录/storage/keys/password_rsa_1024_pub.pem
            "public" => DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . 'password_rsa_1024_pub.pem',
            "private" => DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . 'password_rsa_1024.pem',
        ]
    ],
    "format" => [
        // 响应格式化类枚举
        "default" => ClassEnum::CMD
    ],
    "exception" => [
        // 错误码类
        "ErrorCode" => Lovetrytry\Jichukuangjia\Exception\ErrorCode::class,
    ]
];
