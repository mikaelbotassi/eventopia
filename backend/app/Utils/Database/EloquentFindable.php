<?php

declare(strict_types=1);

namespace App\Utils\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @mixin Model
 */
trait EloquentFindable
{
    /**
     * @param string $column
     * @param string|int $value
     * @param string $operator
     *
     * @return self|Model|null
     */
    public static function findBy(string $column, $value, string $operator = '=')
    {
        return self::query()->firstWhere($column, $operator, $value);
    }

    /**
     * @param string $column
     * @param string|int $value
     * @param string $operator
     * @param string|null $failMessage
     *
     * @return self|Model|null
     * @throws ModelNotFoundException
     */
    public static function findByOrFail(
        mixed $value,
        string $column = 'id',
        string $operator = '=',
        string $failMessage = null
    ) {
        $failMessage = $failMessage ?: "No query results for [$column $operator $value].";

        $model = self::findBy($column, $value, $operator);
        if (! $model) {
            throw new ModelNotFoundException($failMessage);
        }
        return $model;
    }
}
