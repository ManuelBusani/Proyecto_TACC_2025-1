# Proyecto_TACC_2025-1

Proyecto para Tópicos Avanzados de Ciencias de la Computación.

### un titulo

Se necesita instalar composer en la raíz del proyecto.

[https://getcomposer.org/download/](https://getcomposer.org/download/)
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Luego en la raíz del proyecto:
```
composer require google/apiclient

```
> A lo mejor no necesario y se puede hacer de otra manera con el `composer.json` pero no sé.