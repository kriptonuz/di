---
nav_order: 1
---

# Установка.

Установка используя [composer](https://getcomposer.org/){:target="_blank"}

```
composer require cekta/di
```

[Проверим установку минимальным примером](https://github.com/cekta/di/tests/Usage/CheckInstall.phpt)

## Почему используется [PHPT](http://www.phpinternalsbook.com/tests/phpt_file_structure.html) в документации

1. Все примеры кода гарантированно работают, так как выполняются в CI.
2. Формат файлов **PHPT** довольно прост и нагляден для демонстрации примеров.

В примерах классы объявляются внутри **PHPT** файлов для наглядности, в реальности лучше использовать автозагрузку 
классов, например [PSR4](https://www.php-fig.org/psr/psr-4/).

