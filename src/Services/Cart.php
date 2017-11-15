<?php

namespace Matthewbdaly\LaravelCart\Services;

use Matthewbdaly\LaravelCart\Contracts\Services\Cart as CartContract;
use Matthewbdaly\LaravelCart\Contracts\Services\UniqueId;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

/**
 * Cart class
 */
class Cart implements CartContract
{
    protected $session;

    protected $uniqid;

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

    public function all()
    {
        return $this->session->get('Matthewbdaly\LaravelCart\Services\Cart');
    }

    public function get(string $rowId)
    {
        return Collection::make($this->all())
            ->first(function ($item) use ($rowId) {
                return $item['row_id'] == $rowId;
            });
    }

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

    public function remove(string $rowId)
    {
        $content = Collection::make($this->all())
            ->filter(function ($item) use ($rowId) {
                return $item['row_id'] != $rowId;
            })->values()->toArray();
        return $this->session->put('Matthewbdaly\LaravelCart\Services\Cart', $content);
    }

    public function destroy()
    {
        return $this->session->forget('Matthewbdaly\LaravelCart\Services\Cart');
    }

    public function total()
    {
        return Collection::make($this->all())
            ->reduce(function ($total, $item) {
                return $total + ($item['price'] * $item['qty']);
            }, 0);
    }

    public function totalItems()
    {
        return count($this->all());
    }

    private function hasStringKeys(array $items)
    {
        return count(array_filter(array_keys($items), 'is_string')) > 0;
    }
}
