<?php

namespace GitHubAPI;

abstract class AbstractEntity
{
    protected $updatedProperties = array();

    public static function createEntity($data)
    {
        $type = get_called_class();
        $entity = new $type;
        static::synchronizeEntity($entity, $data);
        return $entity;
    }

    protected static function synchronizeEntity(AbstractEntity $entity, array $data)
    {
        $ro = new \ReflectionObject($entity);

        if ($ro->hasProperty('propertyEntityMap')) {
            $rMapProp = $ro->getProperty('propertyEntityMap');
            $rMapProp->setAccessible(true);
            $entityMap = $rMapProp->getValue($entity);
        } else {
            $entityMap = array();
        }

        foreach ($data as $dName => $dValue) {
            $dName = lcfirst(str_replace(' ' , '', ucwords(str_replace('_', ' ', $dName))));

            if ($ro->hasProperty($dName)) {
                $prop = $ro->getProperty($dName);
                $prop->setAccessible(true);

                if (isset($entityMap[$dName]) && is_array($dValue)) {
                    $subEntityClass = $entityMap[$dName];
                    $subEntity = new $subEntityClass;
                    static::synchronizeEntity($subEntity, $dValue);
                    $prop->setValue($entity, $subEntity);
                } else {
                    $prop->setValue($entity, $dValue);
                }
            }
        }
    }

    public function getUpdatedPropertyValues()
    {
        $values = array();
        foreach (array_keys($this->updatedProperties) as $prop) {
            $values[$prop] = $this->{$prop};
        }
        return $values;
    }

    public function isUpdateable()
    {
        // does it have a set method?
        foreach (get_meta_tags(get_called_class()) as $methodName) {
            if (strpos($methodName, 'set') === 0) {
                return true;
            }
        }
        return false;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new \InvalidArgumentException($name . ' is not a valid property.');
    }
}