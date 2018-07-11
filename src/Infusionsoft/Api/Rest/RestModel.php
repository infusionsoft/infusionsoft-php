<?php namespace Infusionsoft\Api\Rest;

use ArrayAccess;
use Infusionsoft\InfusionsoftException;
use JsonSerializable;
use Infusionsoft\Infusionsoft;
use Infusionsoft\InfusionsoftCollection;

/*
*   This class is based on Jenssegers Model class, which is in turn based on the Laravel Eloquent Model.
*   Find more about Laravel's model: http://laravel.com/docs/eloquent
*   Give Jens some love: https://github.com/jenssegers/laravel-model
*/

abstract class RestModel implements ArrayAccess, JsonSerializable
{

    protected $client = null;

    protected $where = [];

    protected $updateVerb = 'put';

    protected $primaryKey = 'id';

    protected $optionalProperities = [];

    protected $return_key = null;

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = array();

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = array();

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = array();

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = array();

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @var bool
     */
    public static $snakeAttributes = true;

    /**
     * The array of booted models.
     *
     * @var array
     */
    protected static $booted = array();

    /**
     * The cache of the mutated attributes for each class.
     *
     * @var array
     */
    protected static $mutatorCache = array();

    /**
     * Create a new model instance.
     *
     * @param  array $attributes
     *
     * @return self
     */
    public function __construct(Infusionsoft $client)
    {
        $this->client = $client;

        $this->bootIfNotBooted();
    }

    /**
     * Returns the full URL for the query, optionally concatinated with additional URI elements
     *
     * @return string
     */
    public function getFullUrl($additional = null)
    {
        $url = $this->full_url;
        if (substr($url, -1) != '/') {
            $url .= '/';
        }

        if ($additional) {
            $additional = ltrim($additional, '/');
        }

        return $url . $additional;
    }

    /**
     * Returns the full URL for the index request, allowing for specific index endpoints
     *
     * @return string
     */
    public function getIndexUrl()
    {
        $url = $this->full_url;

        return $url;
    }

    /**
     * Mock this model from itself.
     *
     * @param  array $attributes
     *
     * @return self
     */
    public function mock(array $attributes = [])
    {
        $this->fill($attributes);

        return $this;
    }

    /**
     * Creates a new object and saves it in storage/API.
     *
     * @param  array $attributes
     *
     * @return self
     */
    public function create(array $attributes = [])
    {
        $this->mock($attributes);
        $this->save();

        return $this;
    }

    /**
     * Save this model to storage/api.
     *
     * @return self
     */
    public function save()
    {
        // well, is it a post or a put? we need to figure out if this thing exists or not
        // long story short, if the "id" is set, it's an update.
        if (isset($this->{$this->primaryKey})) {
            $data = $this->client->restfulRequest(strtolower($this->updateVerb),
                $this->getFullUrl($this->{$this->primaryKey}),
                (array)$this->toArray());
        } else {
            $data = $this->client->restfulRequest('post', $this->getFullUrl(), (array)$this->toArray());
        }

        $this->fill($data);

        return $this;
    }

    public function with($optional)
    {
        if (!is_array($optional) && is_string($optional)) {
            $this->optionalProperities[] = $optional;
        } else {
            $this->optionalProperities = $optional;
        }

        return $this;
    }

    public function find($id)
    {

        if (!empty($this->optionalProperities)) {
            $data = $this->client->restfulRequest('get',
                $this->getFullUrl($id), ['optional_properties' => implode(",", $this->optionalProperities)]);
        } else {
            $data = $this->client->restfulRequest('get', $this->getFullUrl($id));
        }

        $this->fill($data);

        return $this;
    }

    public function sync($syncToken)
    {
        $this->where['sync_token'] = $syncToken;
        $data = $this->client->restfulRequest('get', $this->getFullUrl());
        $this->fill($data);

        return $this;
    }

    public function where($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->where[$k] = $v;
            }

            return $this;
        }

        $this->where[$key] = $value;

        return $this;
    }

    public function delete()
    {
        $response = $this->client->restfulRequest('delete',
            $this->getFullUrl($this->{$this->primaryKey}));

        return true;
    }

    public function get()
    {
        if (!empty($this->where)) {
            $data = $this->client->restfulRequest('get', $this->getIndexUrl(), $this->where);
        } else {
            $data = $this->client->restfulRequest('get', $this->getIndexUrl());
        }

        $cursor = [];

        if (isset($data['sync_token'])) {
            $cursor = $data['sync_token'];
        }

        $collection = $this->collect($data, $cursor);

        return $collection;
    }

    public function first()
    {

        $this->where('limit', 1);

        $params = $this->where;
        if (!empty($this->optionalProperities)) {
          $params['optional_properties'] = implode(',', $this->optionalProperities);
        }

        if (!empty($params)) {
            $data = $this->client->restfulRequest('get', $this->getIndexUrl(), $params);
        } else {
            $data = $this->client->restfulRequest('get', $this->getIndexUrl());
        }

        $cursor = [];

        if (isset($data['sync_token'])) {
            $cursor = $data['sync_token'];
        }

        if ($data['count'] === 0) {
            throw new InfusionsoftException('No Results Found');
        }

        $collection = $this->collect($data, $cursor);

        return $collection[0];

    }

    public function count()
    {
        $this->where('limit', 1);

        $data = $this->client->restfulRequest('get', $this->getIndexUrl(), $this->where);

        return $data['count'];
    }

    public function all()
    {
        $data = $this->client->restfulRequest('get', $this->getIndexUrl());

        $cursor = [];

        if (isset($data['sync_token'])) {
            $cursor = $data['sync_token'];
        }

        $collection = $this->collect($data, $cursor);

        return $collection;
    }

	public function model()
	{
		$data = $this->client->restfulRequest('get', $this->getFullUrl('model'));
		$this->fill($data);

		return $this;
	}


    public function collect(array $array, $cursor = [])
    {
        $items = [];

        $base_object = $array;

        if (!empty($this->return_key)) {
            $base_object = $array[$this->return_key];
        }

        foreach ($base_object as $item) {
            $thing = clone $this;
            array_push($items, $thing->mock($item));
        }

        return new InfusionsoftCollection($items);
    }

    /**
     * Check if the model needs to be booted and if so, do it.
     *
     * @return void
     */
    protected function bootIfNotBooted()
    {
        $class = get_class($this);

        if (!isset(static::$booted[$class])) {
            static::$booted[$class] = true;

            static::boot();
        }
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        if (function_exists('class_uses_recursive')) {
            static::bootTraits();
        }
    }

    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected static function bootTraits()
    {
        foreach (class_uses_recursive(get_called_class()) as $trait) {
            if (method_exists(get_called_class(), $method = 'boot' . class_basename($trait))) {
                forward_static_call([get_called_class(), $method]);
            }
        }
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array $attributes
     *
     * @return self
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Create a new instance of the given model.
     *
     * @param  array $attributes
     * @param  bool $exists
     *
     * @return self
     */
    public function newInstance($attributes = array())
    {
        $model = new static((array)$attributes);

        return $model;
    }

    /**
     * Create a collection of models from plain arrays.
     *
     * @param  array $items
     *
     * @return array
     */
    public static function hydrate(array $items)
    {
        $instance = new static;

        $items = array_map(function ($item) use ($instance) {
            return $instance->newInstance($item);
        }, $items);

        return $items;
    }

    /**
     * Sets the HTTP verb used to update the service
     *
     * @return string
     */
    public function setUpdateVerb($verb = 'put')
    {
        $this->updateVerb = $verb;

        return $this->updateVerb;
    }

    /**
     * Sets the primary key on the object
     *
     * @return string
     */
    public function setPrimaryKey($key = 'id')
    {
        $this->primaryKey = $key;

        return $this->primaryKey;
    }

    /**
     * Retrieves the HTTP verb used to updated the service
     *
     * @return string
     */
    public function getUpdateVerb()
    {
        return $this->updateVerb;
    }

    /**
     * Get the hidden attributes for the model.
     *
     * @return array
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set the hidden attributes for the model.
     *
     * @param  array $hidden
     *
     * @return void
     */
    public function setHidden(array $hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Add hidden attributes for the model.
     *
     * @param  array|string|null $attributes
     *
     * @return void
     */
    public function addHidden($attributes = null)
    {
        $attributes = is_array($attributes) ? $attributes : func_get_args();

        $this->hidden = array_merge($this->hidden, $attributes);
    }

    /**
     * Get the visible attributes for the model.
     *
     * @return array
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set the visible attributes for the model.
     *
     * @param  array $visible
     *
     * @return void
     */
    public function setVisible(array $visible)
    {
        $this->visible = $visible;
    }

    /**
     * Add visible attributes for the model.
     *
     * @param  array|string|null $attributes
     *
     * @return void
     */
    public function addVisible($attributes = null)
    {
        $attributes = is_array($attributes) ? $attributes : func_get_args();

        $this->visible = array_merge($this->visible, $attributes);
    }

    /**
     * Set the accessors to append to model arrays.
     *
     * @param  array $appends
     *
     * @return void
     */
    public function setAppends(array $appends)
    {
        $this->appends = $appends;
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
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
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributesToArray();
    }

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = $this->getArrayableAttributes();

        $mutatedAttributes = $this->getMutatedAttributes();

        // We want to spin through all the mutated attributes for this model and call
        // the mutator for the attribute. We cache off every mutated attributes so
        // we don't have to constantly check on attributes that actually change.
        foreach ($mutatedAttributes as $key) {
            if (!array_key_exists($key, $attributes)) {
                continue;
            }

            $attributes[$key] = $this->mutateAttributeForArray($key, $attributes[$key]);
        }

        // Next we will handle any casts that have been setup for this model and cast
        // the values to their appropriate type. If the attribute has a mutator we
        // will not perform the cast on those attributes to avoid any confusion.
        foreach ($this->casts as $key => $value) {
            if (!array_key_exists($key, $attributes) || in_array($key, $mutatedAttributes)) {
                continue;
            }

            $attributes[$key] = $this->castAttribute($key, $attributes[$key]);
        }

        // Here we will grab all of the appended, calculated attributes to this model
        // as these attributes are not really in the attributes array, but are run
        // when we need to array or JSON the model for convenience to the coder.
        foreach ($this->getArrayableAppends() as $key) {
            $attributes[$key] = $this->mutateAttributeForArray($key, null);
        }

        return $attributes;
    }

    /**
     * Get an attribute array of all arrayable attributes.
     *
     * @return array
     */
    protected function getArrayableAttributes()
    {
        return $this->getArrayableItems($this->attributes);
    }

    /**
     * Get all of the appendable values that are arrayable.
     *
     * @return array
     */
    protected function getArrayableAppends()
    {
        if (!count($this->appends)) {
            return [];
        }

        return $this->getArrayableItems(array_combine($this->appends, $this->appends));
    }

    /**
     * Get an attribute array of all arrayable values.
     *
     * @param  array $values
     *
     * @return array
     */
    protected function getArrayableItems(array $values)
    {
        if (count($this->visible) > 0) {
            return array_intersect_key($values, array_flip($this->visible));
        }

        return array_diff_key($values, array_flip($this->hidden));
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        $inAttributes = array_key_exists($key, $this->attributes);

        // If the key references an attribute, we can just go ahead and return the
        // plain attribute value from the model. This allows every attribute to
        // be dynamically accessed through the _get method without accessors.
        if ($inAttributes or $this->hasGetMutator($key)) {
            return $this->getAttributeValue($key);
        }
    }

    /**
     * Get a plain attribute (not a relationship).
     *
     * @param  string $key
     *
     * @return mixed
     */
    protected function getAttributeValue($key)
    {
        $value = $this->getAttributeFromArray($key);

        // If the attribute has a get mutator, we will call that then return what
        // it returns as the value, which is useful for transforming values on
        // retrieval from the model to a form that is more useful for usage.
        if ($this->hasGetMutator($key)) {
            return $this->mutateAttribute($key, $value);
        }

        // If the attribute exists within the cast array, we will convert it to
        // an appropriate native PHP type dependant upon the associated value
        // given with the key in the pair. Dayle made this comment line up.
        if ($this->hasCast($key)) {
            $value = $this->castAttribute($key, $value);
        }

        return $value;
    }

    /**
     * Get an attribute from the $attributes array.
     *
     * @param  string $key
     *
     * @return mixed
     */
    protected function getAttributeFromArray($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function hasGetMutator($key)
    {
        return method_exists($this, 'get' . $this->studly($key) . 'Attribute');
    }

    /**
     * Get the value of an attribute using its mutator.
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @return mixed
     */
    protected function mutateAttribute($key, $value)
    {
        return $this->{'get' . $this->studly($key) . 'Attribute'}($value);
    }

    /**
     * Get the value of an attribute using its mutator for array conversion.
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @return mixed
     */
    protected function mutateAttributeForArray($key, $value)
    {
        $value = $this->mutateAttribute($key, $value);

        return $value instanceof ArrayableInterface ? $value->toArray() : $value;
    }

    /**
     * Determine whether an attribute should be casted to a native type.
     *
     * @param  string $key
     *
     * @return bool
     */
    protected function hasCast($key)
    {
        return array_key_exists($key, $this->casts);
    }

    /**
     * Determine whether a value is JSON castable for inbound manipulation.
     *
     * @param  string $key
     *
     * @return bool
     */
    protected function isJsonCastable($key)
    {
        if ($this->hasCast($key)) {
            return in_array($this->getCastType($key), ['array', 'json', 'object'], true);
        }

        return false;
    }

    /**
     * Get the type of cast for a model attribute.
     *
     * @param  string $key
     *
     * @return string
     */
    protected function getCastType($key)
    {
        return trim(strtolower($this->casts[$key]));
    }

    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        if (is_null($value)) {
            return $value;
        }

        switch ($this->getCastType($key)) {
            case 'int':
            case 'integer':
                return (int)$value;
            case 'real':
            case 'float':
            case 'double':
                return (float)$value;
            case 'string':
                return (string)$value;
            case 'bool':
            case 'boolean':
                return (bool)$value;
            case 'object':
                return json_decode($value);
            case 'array':
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @return void
     */
    public function setAttribute($key, $value)
    {
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) {
            $method = 'set' . $this->studly($key) . 'Attribute';

            return $this->{$method}($value);
        }

        if ($this->isJsonCastable($key)) {
            $value = json_encode($value);
        }

        $this->attributes[$key] = $value;
    }

    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set' . $this->studly($key) . 'Attribute');
    }

    /**
     * Clone the model into a new, non-existing instance.
     *
     * @return self
     */
    public function replicate()
    {
        with($instance = new static)->fill($this->attributes);

        return $instance;
    }

    /**
     * Get all of the current attributes on the model.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get the mutated attributes for a given instance.
     *
     * @return array
     */
    public function getMutatedAttributes()
    {
        $class = get_class($this);

        if (!isset(static::$mutatorCache[$class])) {
            static::cacheMutatedAttributes($class);
        }

        return static::$mutatorCache[$class];
    }

    /**
     * Extract and cache all the mutated attributes of a class.
     *
     * @param string $class
     *
     * @return void
     */
    public static function cacheMutatedAttributes($class)
    {
        $mutatedAttributes = array();

        // Here we will extract all of the mutated attributes so that we can quickly
        // spin through them after we export models to their array form, which we
        // need to be fast. This'll let us know the attributes that can mutate.
        foreach (get_class_methods($class) as $method) {
            if (strpos($method, 'Attribute') !== false && preg_match('/^get(.+)Attribute$/', $method, $matches)) {
                if (static::$snakeAttributes) {
                    $matches[1] = snake_case($matches[1]);
                }

                $mutatedAttributes[] = lcfirst($matches[1]);
            }
        }

        static::$mutatorCache[$class] = $mutatedAttributes;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed $offset
     * @param  mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    /**
     * Determine if an attribute exists on the model.
     *
     * @param  string $key
     *
     * @return void
     */
    public function __isset($key)
    {
        return ((isset($this->attributes[$key]) || isset($this->relations[$key])) || ($this->hasGetMutator($key) && !is_null($this->getAttributeValue($key))));
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string $key
     *
     * @return void
     */
    public function __unset($key)
    {
        unset($this->attributes[$key]);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new static;

        return call_user_func_array(array($instance, $method), $parameters);
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * When a model is being unserialized, check if it needs to be booted.
     *
     * @return void
     */
    public function __wakeup()
    {
        $this->bootIfNotBooted();
    }

    public function studly($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return str_replace(' ', '', $value);
    }

}
