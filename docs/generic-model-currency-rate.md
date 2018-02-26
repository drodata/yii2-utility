# 货币和汇率

货币编码参考 [ISO 4217][wiki-currency-code].

## Rate Info Box

```php
echo \drodata\widgets\RateInfoBox::widget([
    'currencyCode' => 'USD',
]);
```
属性 `currencyCode` 作为系统配置选项存储在数据库内。

[wiki-currency-code]: https://en.wikipedia.org/wiki/ISO_4217
