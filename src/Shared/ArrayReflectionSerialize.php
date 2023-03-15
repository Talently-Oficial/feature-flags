<?php
declare(strict_types=1);

namespace Talently\FeatureFlags\Shared;


/**
 * serialize object to array
 */
trait ArrayReflectionSerialize
{
    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->toArray());
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->toArray()[$offset];
    }

    /**
     * @param $offset
     * @param $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $k = "set".ucfirst($offset);
        if (method_exists($this, $k)) {
            $this->{$k}($value);
        }
    }

    /**
     * @param $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        $k = "set".ucfirst($offset);
        if (method_exists($this, $k)) {
            $this->{$k}(null);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $rf = (new \ReflectionClass($this))->getProperties();
        $props = [];
        foreach ($rf as $value) {

            $k = strtolower(ucwords(($value->getName())));
            $getMethod = "get".ucfirst($value->getName());
            if (method_exists($this, $getMethod)) {
                $v = $this->{$value->getName()};
                if (is_object($v) && method_exists($v, 'toArray')) {
                    $v = $v->toArray();
                }
                $props[$k] = $v;

            }

        }
        return $props;
    }

}