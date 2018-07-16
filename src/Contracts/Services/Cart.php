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
  
    /**
     * Update a single object from cart
     *
     * @param string $rowId The row ID.
     * @param array  $data  The data to update.
     * @return array
     */
    public function update(string $rowId, array $data);

    /**
     * Increment quantity of an object
     *
     * @param string $rowId The row ID.
     * @return array
     */
    public function increment(string $rowId);

    /**
     * Decrement quantity of an object
     *
     * @param string $rowId The row ID.
     * @return array
     */
    public function decrement(string $rowId);

    /**
     * Remove a single object from cart
     *
     * @param string $rowId The row ID.
     * @return array
     */
    public function remove(string $rowId);

    /**
     * Return total price
     *
     * @return float
     */
    public function total();

    /**
     * Return total number of items
     *
     * @return integer
     */
    public function totalItems();
 
    /**
     * Destroy cart
     *
     * @return null
     */
    public function destroy();
}
