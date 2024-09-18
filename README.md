# PHP Criteria Package

**PHP Criteria Package** es una librería diseñada para aplicar el patrón de Especificación respetando los principios de DDD (Diseño Orientado a Dominios). Este paquete proporciona una serie de clases de dominio y adaptadores que facilitan la implementación de filtros y criterios complejos en consultas utilizando Eloquent, y en un futuro con Doctrine.

## Características

- **Filtros dinámicos**: Aplica filtros flexibles y reutilizables a las consultas.
- **Ordenamiento**: Soporte para definir y aplicar ordenamientos sobre cualquier campo.
- **Paginación**: Facilita la paginación de resultados con criterios aplicados.
- **Extensible**: Pensado para integrar no solo con Eloquent, sino también con Doctrine a futuro.

## Instalación

Para instalar este paquete en tu proyecto, ejecuta el siguiente comando:

```bash
composer require mariodevv/php-criteria-package
```

## Uso

Este paquete permite crear consultas flexibles utilizando filtros y órdenes definidos de manera dinámica. A continuación, un ejemplo básico de uso:

```php
use Mariodevv\phpcriteriapackage\Domain\Criteria\Criteria;
use Mariodevv\phpcriteriapackage\Infrastructure\Criteria\EloquentQueryAdapter;
use App\Models\YourModel;

$query = YourModel::query();
$adapter = new EloquentQueryAdapter($query);

$criteria = Criteria::fromValues('created_at', 'desc', 1, 10, [
    ['field' => 'status', 'operator' => '=', 'value' => 'active']
]);

$results = $adapter->paginate($criteria);
```

## Contribución

Si deseas contribuir al desarrollo de este paquete o reportar errores, siéntete libre de crear un issue o enviar un pull request.

## Licencia

Este paquete está licenciado bajo la [Licencia MIT](LICENSE).
