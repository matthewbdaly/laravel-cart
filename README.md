# laravel-cart

[![Build Status](https://travis-ci.org/matthewbdaly/laravel-cart.svg?branch=master)](https://travis-ci.org/matthewbdaly/laravel-cart)
[![Coverage Status](https://coveralls.io/repos/github/matthewbdaly/laravel-cart/badge.svg?branch=master)](https://coveralls.io/github/matthewbdaly/laravel-cart?branch=master)

Simple shopping cart implementation for Laravel. Loosely inspired by CodeIgniter's cart class.

Installation
------------

```
composer require matthewbdaly/laravel-cart
```

Usage
-----

The cart implements the interface `Matthewbdaly\LaravelCart\Contracts\Services\Cart`, so you can use that to type-hint it. Alternatively you can use the `Cart` facade.

Add item
--------

To add an item, call `$cart->insert($data)`. In this case `$data` must be an array with the following fields:

* `qty`
* `price`
* `name`
* `options`

OR an array of items, each with the same fields. You can also add any additional data you wish.

Get all items
-------------

Call `$cart->all()` to retrieve the contents.

Get single item
---------------

Call `$cart->get($rowId)` to retrieve an item by its row ID.

Update single item
------------------

Call `$cart->update($rowId, $data)` to update an item with the provided data.

Remove item
-----------

Call `$cart->remove($rowId)` to remove an item.

Get total price
---------------

Call `$cart->total()` to get the total price.

Get total items
---------------

Call `$cart->totalItems()` to get a count of the items. Note that this does not allow for the quantity - if you have item X with a quantity of 2, that will be 1 item in the count.

Destroy cart
------------

Call `$cart->destroy()` to destroy the cart.
