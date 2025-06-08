<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    /**
     * Получить все записи.
     *
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*']): mixed;

    /**
     * Найти запись по ID.
     *
     * @param int|string $id
     * @param array $columns
     * @return mixed
     */
    public function find(int|string $id, array $columns = ['*']): mixed;

    /**
     * Создать новую запись.
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes): mixed;

    /**
     * Обновить запись по ID.
     *
     * @param int|string $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update(int|string $id, array $attributes): mixed;

    /**
     * Удалить запись по ID.
     *
     * @param int|string $id
     * @return void
     */
    public function delete(int|string $id): void;

    /**
     * Найти запись по условию.
     *
     * @param array $conditions
     * @param array $columns
     * @return mixed
     */
    public function findBy(array $conditions, array $columns = ['*']);
}
