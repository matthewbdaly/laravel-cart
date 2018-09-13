<?php

namespace Matthewbdaly\LaravelCart\Services;

use Matthewbdaly\LaravelCart\Contracts\Services\Cart as CartContract;
use Matthewbdaly\LaravelCart\Contracts\Services\UniqueId;
use Matthewbdaly\LaravelCart\Exceptions\CartItemIncomplete;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

/**
 * Cart class
 */
class Cart implements CartContract
{
    protected $session;

    protected $uniqid;

    /**
     * Constructor
     *
     * @param Session  $session The session instance.
     * @param UniqueId $uniqid  The unique ID instance.
     */
    public function __construct(Session $session, UniqueId $uniqid)
    {
        $this->session = $session;
        $this->uniqid = $uniqid;
    }

    /**
     * Add object to cart
     *
     * @param array $item The item to add.
     * @return null
     */
    public function insert(array $item)
    {
        $this->validate($item);
        $content = new Collection($this->session->get('Matthewbdaly\LaravelCart\Services\Cart'));
        if ($this->hasStringKeys($item)) {
            if (!array_key_exists('row_id', $item)) {
                $item['row_id'] = $this->uniqid->get();
            }
            $content->push($item);
        } else {
            foreach ($item as $subitem) {
                if (!array_key_exists('row_id', $subitem)) {
                    $subitem['row_id'] = $this->uniqid->get();
                }
                $content->push($subitem);
            }
        }
        return $this->session->put('Matthewbdaly\LaravelCart\Services\Cart', $content->toArray());
    }

    /**
     * Get all objects from cart
     *
     * @return null
     */
    public function all()
    {
        return $this->session->get('Matthewbdaly\LaravelCart\Services\Cart');
    }

    /**
     * Get a single object from cart
     *
     * @param string $rowId The row ID.
     * @return array
     */
    public function get(string $rowId)
    {
        return Collection::make($this->all())
            ->first(function ($item) use ($rowId) {
                return $item['row_id'] == $rowId;
            });
    }
 
    /**
     * Update a single object from cart
     *
     * @param string $rowId The row ID.
     * @param array  $data  The data to update.
     * @return array
     */
    public function update(string $rowId, array $data)
    {
        $content = Collection::make($this->all())
            ->map(function ($item) use ($rowId, $data) {
                if ($item['row_id'] == $rowId) {
                    foreach ($data as $k => $v) {
                        $item[$k] = $v;
                    }
                }
                return $item;
            })->toArray();
        return $this->session->put('Matthewbdaly\LaravelCart\Services\Cart', $content);
    }

    /**
     * Increment quantity of an object
     *
     * @param string $rowId The row ID.
     * @return array
     */
    public function increment(string $rowId)
    {
        $content = Collection::make($this->all())
            ->map(function ($item) use ($rowId) {
                if ($item['row_id'] == $rowId) {
                    $item['qty'] += 1;
                }
                return $item;
            })->toArray();
        return $this->session->put('Matthewbdaly\LaravelCart\Services\Cart', $content);
    }

    /**
     * Decrement quantity of an object
     *
     * @param string $rowId The row ID.
     * @return array
     */
    public function decrement(string $rowId)
    {
        $content = Collection::make($this->all())
            ->map(function ($item) use ($rowId) {
                if ($item['row_id'] == $rowId) {
                    if ($item['qty'] > 0) {
                        $item['qty'] -= 1;
                    }
                }
                return $item;
            })->toArray();
        return $this->session->put('Matthewbdaly\LaravelCart\Services\Cart', $content);
    }

    /**
     * Remove a single object from cart
     *
     * @param string $rowId The row ID.
     * @return array
     */
    public function remove(string $rowId)
    {
        $content = Collection::make($this->all())
            ->filter(function ($item) use ($rowId) {
                return $item['row_id'] != $rowId;
            })->values()->toArray();
        return $this->session->put('Matthewbdaly\LaravelCart\Services\Cart', $content);
    }

    /**
     * Destroy cart
     *
     * @return null
     */
    public function destroy()
    {
        return $this->session->forget('Matthewbdaly\LaravelCart\Services\Cart');
    }

    /**
     * Return total price
     *
     * @return float
     */
    public function total()
    {
        return Collection::make($this->all())
            ->reduce(function ($total, $item) {
                return $total + ($item['price'] * $item['qty']);
            }, 0);
    }

    /**
     * Return total number of items
     *
     * @return integer
     */
    public function totalItems()
    {
        return count($this->all());
    }

    /**
     * Verify if array has string keys
     *
     * @param array $items The array to check.
     * @return integer
     */
    private function hasStringKeys(array $items)
    {
        return count(array_filter(array_keys($items), 'is_string'));
    }

    /**
     * Validate input
     *
     * @param array $item The array to check.
     * @return void
     * @throws CartItemIncomplete A cart item was incomplete.
     */
    private function validate(array $item)
    {
        if (!$this->hasStringKeys($item)) {
            foreach ($item as $subitem) {
                $this->validate($subitem);
            }
        } else {
            $required = ['qty', 'price', 'name', 'options'];
            foreach ($required as $key) {
                if (!array_key_exists($key, $item)) {
                    throw new CartItemIncomplete;
                }
            }
        }
    }
}
