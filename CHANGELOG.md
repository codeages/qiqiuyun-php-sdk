# CHANGELOG

## [Unreleased]

## v0.2.0 (2018-01-27)

* 统一`Service`的构造函数。
* PHP5.3 下无法使用PHP内置的WebServer，导致在 PHP 5.3 下，MockServer 无法运行，所以去除了 MockServer，改用 PHPUnit 的 Mock，来 Mock HTTP Client。
* 去除 `DrpException`，服务端返回错误信息，统一使用 `ResponseException`。
* 云资源播放逻辑从 `RessourceService` 中抽离到 `PlayService`。
* 统一API鉴权签名逻辑到`Auth`。
* 分销API的签名逻辑，改用通用的签名逻辑，不再对BODY截取1024字节做签名。
* 错误码统一声明到 `ErrorCode`。