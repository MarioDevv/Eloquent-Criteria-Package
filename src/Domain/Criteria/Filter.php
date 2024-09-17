<?php

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria;

use Carbon\Carbon;

class Filter
{
    public function __construct(
        public readonly FilterField $field,
        public readonly FilterOperator $operator,
        public readonly FilterValue $value,
        public readonly array $relations = []
    ) {
        $this->validateValueForOperator();
    }

    /**
     * Método para validar el valor basado en el operador.
     * 
     * @throws \InvalidArgumentException
     */
    private function validateValueForOperator(): void
    {
        $validators = [
            Operator::BETWEEN->value => fn() => $this->validateBetween(),
            Operator::LIKE->value => fn() => $this->validateString(),
            Operator::NOT_LIKE->value => fn() => $this->validateString(),
            Operator::IS_NULL->value => fn() => $this->validateNull(),
            Operator::IS_NOT_NULL->value => fn() => $this->validateNull(),
            Operator::WHERE_DATE->value => fn() => $this->validateDate(),
            Operator::EQUAL->value => fn() => $this->validateNotNull(),
        ];


        $validator = $validators[$this->operator->value->value] ?? null;

        if ($validator !== null) {
            $validator();
        }
    }

    private function validateBetween(): void
    {
        if (!is_array($this->value->value) || count($this->value->value) !== 2) {
            throw new \InvalidArgumentException('The value for BETWEEN operator must be an array with exactly two elements.');
        }
    }

    private function validateString(): void
    {
        if (!is_string($this->value->value)) {
            throw new \InvalidArgumentException('The value for LIKE/NOT LIKE operator must be a string.');
        }
    }

    private function validateNull(): void
    {
        if (!is_null($this->value->value)) {
            throw new \InvalidArgumentException('The value for IS NULL/IS NOT NULL operator must be null.');
        }
    }

    private function validateDate(): void
    {
        try {
            Carbon::parse($this->value->value)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('The value for WHERE DATE operator must be a valid date string.');
        }
    }

    private function validateNotNull(): void
    {
        if (is_null($this->value->value)) {
            throw new \InvalidArgumentException('The value for EQUAL operator must not be null.');
        }
    }

    public static function fromValues(string $field, string $operator, mixed $value, array $relations = []): self
    {
        return new self(
            new FilterField($field),
            new FilterOperator(Operator::from($operator)),
            new FilterValue($value),
            $relations
        );
    }

    public function hasRelations(): bool
    {
        return !empty($this->relations);
    }
}
