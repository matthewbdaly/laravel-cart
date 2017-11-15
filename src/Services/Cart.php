<?php

namespace Matthewbdaly\LaravelCart\Services;

use Matthewbdaly\LaravelCart\Contracts\Services\Cart as CartContract;
use Matthewbdaly\LaravelCart\Contracts\Services\UniqueId;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

class Cart implements CartContract
{
    protected $session;

    protected $uniqid;

    public function __construct(Session $session, UniqueId $uniqid)
    {
        $this->session = $session;
        $this->uniqid = $uniqid;
    }

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

    public function destroy()
    {
        return $this->session->forget('Matthewbdaly\LaravelCart\Services\Cart');
    }

    private function hasStringKeys(array $items) {
        return count(array_filter(array_keys($items), 'is_string')) > 0;
    }
}
