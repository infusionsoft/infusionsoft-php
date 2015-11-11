<?php

namespace Infusionsoft;

use Countable;
use ArrayAccess;
use JsonSerializable;

class InfusionsoftCollection implements ArrayAccess, Countable, JsonSerializable
{
	/**
	 * The items contained in the collection.
	 *
	 * @var array
	 */
	protected $items = [];

	/**
	 * Create a new collection.
	 *
	 * @param  mixed  $items
	 * @return void
	 */
	public function __construct($items = [])
	{
		$this->items = is_array($items) ? $items : $this->getArrayableItems($items);
	}

	/**
	 * Create a new collection instance if the value isn't one already.
	 *
	 * @param  mixed  $items
	 * @return static
	 */
	public static function make($items = [])
	{
		return new static($items);
	}

	/**
	 * Get all of the items in the collection.
	 *
	 * @return array
	 */
	public function all()
	{
		return $this->items;
	}

	/**
	 * Get an item from the collection by key.
	 *
	 * @param  mixed  $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		if ($this->offsetExists($key)) {
			return $this->items[$key];
		}

		return value($default);
	}

	/**
	 * Determine if an item exists in the collection by key.
	 *
	 * @param  mixed  $key
	 * @return bool
	 */
	public function has($key)
	{
		return $this->offsetExists($key);
	}

	/**
	 * Determine if the collection is empty or not.
	 *
	 * @return bool
	 */
	public function isEmpty()
	{
		return empty($this->items);
	}

	/**
	 * Get the keys of the collection items.
	 *
	 * @return static
	 */
	public function keys()
	{
		return new static(array_keys($this->items));
	}

	/**
	 * Get the collection of items as a plain array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return array_map(function ($value) {
			return $value instanceof Arrayable ? $value->toArray() : $value;

		}, $this->items);
	}

	/**
	 * Convert the object into something JSON serializable.
	 *
	 * @return array
	 */
	public function jsonSerialize()
	{
		return $this->toArray();
	}

	/**
	 * Get the collection of items as JSON.
	 *
	 * @param  int  $options
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return json_encode($this->toArray(), $options);
	}

	/**
	 * Count the number of items in the collection.
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->items);
	}

	/**
	 * Determine if an item exists at an offset.
	 *
	 * @param  mixed  $key
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return array_key_exists($key, $this->items);
	}

	/**
	 * Get an item at a given offset.
	 *
	 * @param  mixed  $key
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->items[$key];
	}

	/**
	 * Set the item at a given offset.
	 *
	 * @param  mixed  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet($key, $value)
	{
		if (is_null($key)) {
			$this->items[] = $value;
		} else {
			$this->items[$key] = $value;
		}
	}

	/**
	 * Unset the item at a given offset.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function offsetUnset($key)
	{
		unset($this->items[$key]);
	}

	/**
	 * Convert the collection to its string representation.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->toJson();
	}

	/**
	 * Results array of items from Collection or Arrayable.
	 *
	 * @param  mixed  $items
	 * @return array
	 */
	protected function getArrayableItems($items)
	{
		if ($items instanceof self) {
			return $items->all();
		} elseif ($items instanceof Arrayable) {
			return $items->toArray();
		} elseif ($items instanceof Jsonable) {
			return json_decode($items->toJson(), true);
		}

		return (array) $items;
	}

}