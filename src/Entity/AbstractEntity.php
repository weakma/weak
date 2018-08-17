<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-7-20
 * Time: 下午12:08
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;

abstract class AbstractEntity
{
    public function createdAtHandle()
    {
        if(property_exists($this, 'createdAt')){
            $this->setCreatedAt(new \DateTime());
        }
    }

    public function updatedAtHandle()
    {
        if(property_exists($this, 'updatedAt')){
            $this->setUpdatedAt(new \DateTime());
        }
    }

    public function toArray()
    {
        //反射下将当前的entity对象转换成对应的数组格式 属性名对应键名 属性值对应数组值
        $ref = new \ReflectionClass($this);
        $props = $ref->getProperties();
        $tmpArr = [];
        array_walk($props,function($val,$key)use (&$tmpArr){
            $func = 'get'. self::underline2camel($val->name);
            $tmpArr[$val->name] = call_user_func(array($this,$func));
        });

        return $tmpArr;
    }

    /**
     * @param array $data
     * @param array $options
     * exp:
     * $this->mapping($entity, $postData, ['filter'=['排除的'],'only'=['仅需要的属性']])
     *
     */
    public function mapping(array $data, array $options = [])
    {
        array_walk($data, function ($val, $key) use ($options) {
            if ((key_exists('only', $options) && !in_array($key, $options['only'])) || (key_exists('filter', $options) && in_array($key, $options['filter']))) {
                return;
            }
            $method = 'set' . self::underline2camel($key);
            if (method_exists($this, $method)) {
                $this->$method($val);
            }

        });

        return $this;
    }

    /**
     * 下划线转驼峰
     * @param $haystack
     * @return string
     */
    public static function underline2camel($haystack)
    {
        $haystackArray = explode('_', $haystack);
        $dist = '';
        array_walk($haystackArray, function ($val, $key) use (&$dist) {
            $dist .= $key ? ucfirst($val) : $val;
        });
        return $dist;
    }
}