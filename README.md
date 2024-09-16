Aquí tienes un ejemplo de un README en español para tu paquete de Composer, Eloquent Criteria Package. Puedes adaptarlo según tus necesidades específicas:

---

# Eloquent Criteria Package

_Eloquent Criteria Package_ es un paquete diseñado para facilitar el uso de filtros y criterios complejos en tus consultas Eloquent dentro de aplicaciones Laravel. Este paquete te permite aplicar diferentes condiciones y ordenaciones de manera fluida y reutilizable, ayudando a mantener tus controladores y repositorios limpios y fáciles de mantener.

## Instalación

Puedes instalar el paquete a través de Composer:

```bash
composer require mariodevv/eloquent-criteria-package
```

## Estructura del Paquete

El paquete sigue una estructura organizada para facilitar su integración y uso:

- `src/Shared/Domain/Criteria`
  - `Criteria.php`
  - `FilterField.php`
  - `FilterOperator.php`
  - `Filter.php`
  - `Filters.php`
  - `FilterValue.php`
  - `OrderBy.php`
  - `Order.php`
  - `OrderType.php`
  
- `src/Shared/Infrastructure/Criteria`
  - `CriteriaBuilder.php`

## Uso

### Criterios básicos

Para utilizar el paquete en tu aplicación Laravel, deberás construir instancias de los criterios que desees aplicar en tus consultas. A continuación te mostramos un ejemplo básico de cómo usar `Criteria` y `Filters` para agregar condiciones a una consulta.

```php
use App\Models\User;
use Shared\Domain\Criteria\Filters;
use Shared\Domain\Criteria\Order;
use Shared\Domain\Criteria\FilterField;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterValue;
use Shared\Infrastructure\Criteria\CriteriaBuilder;

// Crear filtros
$filters = new Filters([
    new FilterField('age', FilterOperator::greaterThan(), new FilterValue(18)),
    new FilterField('status', FilterOperator::equal(), new FilterValue('active')),
]);

// Aplicar filtros a la consulta
$criteria = CriteriaBuilder::create($filters)
    ->orderBy(new Order('created_at', 'desc'))
    ->build();

$users = User::applyCriteria($criteria)->get();
```

### Filtrado

El paquete permite aplicar filtros personalizados a las consultas. Puedes definir el campo, el operador y el valor que deseas filtrar:

```php
$filters = new Filters([
    new FilterField('name', FilterOperator::like(), new FilterValue('%Mario%')),
]);
```

### Ordenación

Además de los filtros, puedes definir criterios de ordenación para tus consultas utilizando `Order` y `OrderType`:

```php
$order = new Order('name', OrderType::asc());
```

### Constructor de Criterios (CriteriaBuilder)

Utiliza `CriteriaBuilder` para construir dinámicamente tus consultas según los filtros y ordenaciones especificados:

```php
$criteria = CriteriaBuilder::create($filters)
    ->orderBy(new Order('created_at', 'desc'))
    ->build();
```

### Repositorios

Este paquete está diseñado para integrarse fácilmente en un patrón de repositorios. Aquí un ejemplo de uso dentro de un repositorio:

```php
class UserRepository
{
    public function searchByCriteria(Criteria $criteria)
    {
        return User::applyCriteria($criteria)->paginate();
    }
}
```

## Contribuciones

Si deseas contribuir a este proyecto, por favor crea un _fork_, realiza tus cambios y abre un _pull request_.

## Licencia

Este paquete está licenciado bajo la licencia MIT. Para más información, revisa el archivo [LICENSE](./LICENSE).

---

Espero que te sea útil para el repositorio. Puedes modificar cualquier detalle para ajustarlo mejor a tu proyecto o preferencias.
