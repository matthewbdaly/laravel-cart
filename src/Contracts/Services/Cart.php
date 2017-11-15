<?php

namespace Matthewbdaly\LaravelCart\Contracts\Services;

interface Cart
{
    public function insert(array $item);

    public function all();

    public function get(string $rowId);
    
    public function update(string $rowId, array $data);

    public function remove(string $rowId);

    public function destroy();
}
