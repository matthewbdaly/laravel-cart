<?php

namespace Matthewbdaly\LaravelCart\Contracts\Services;

interface Cart
{
    /**
     * Add object to cart
     *
     * @param array $item The item to add.
     * @return null
     */
    public function insert(array $item);

    /**
     * Get all objects from cart
     *
     * @return null
     */
    public function all();

    /**
     * Get a single object from cart
     *
     * @param string $rowId The row ID.
     * @return array
     */
    public function get(string $rowId);
    
    public function update(string $rowId, array $data);

    public function remove(string $rowId);

    public function total();

    public function totalItems();
    
    public function destroy();
}
