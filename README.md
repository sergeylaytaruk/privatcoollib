# privatcoollib
Бібліотека являє собою конвертер валют за курсом приватбанку

приклад використання:
```
use PrivatCoolLib\Exchange;

require __DIR__ . '/vendor/autoload.php';

$exchange = new Exchange('USD', 'UAH', 200);
echo $exchange->toDecimal();
```
