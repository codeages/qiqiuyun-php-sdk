<?php
/**
 * 当前代码复制自 guzzlehttp/psr7 软件包, 由于需要兼容 PHP 5.3，所以无法通过 Composer 安装，只能复制。
 * 
 * 版权归原作者所有。
 * 
 * Copyright (c) 2015 Michael Dowling, https://github.com/mtdowling <mtdowling@gmail.com>
 */

namespace QiQiuYun\SDK\HttpClient\Psr7;

use Psr\Http\Message\UriInterface;

/**
 * Returns a UriInterface for the given value.
 *
 * This function accepts a string or {@see Psr\Http\Message\UriInterface} and
 * returns a UriInterface for the given value. If the value is already a
 * `UriInterface`, it is returned as-is.
 *
 * @param string|UriInterface $uri
 *
 * @return UriInterface
 * @throws \InvalidArgumentException
 */
function uri_for($uri)
{
    if ($uri instanceof UriInterface) {
        return $uri;
    } elseif (is_string($uri)) {
        return new Uri($uri);
    }

    throw new \InvalidArgumentException('URI must be a string or UriInterface');
}