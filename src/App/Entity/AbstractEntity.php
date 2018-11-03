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
use App\Repository\AbstractRepository;

/**
 * Class AbstractEntity
 * @package App\Entity
 *
 * @method setCreatedAt($date)
 * @method setUpdatedAt($date)
 */
abstract class AbstractEntity
{
    public function createdAtHandle()
    {
        if(property_exists($this, 'createdAt')){
            $this->setCreatedAt(new \DateTime());
        }
    }

    /**
     *
     */
    public function updatedAtHandle()
    {
        if(property_exists($this, 'updatedAt')){
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function toArray()
    {
        //反射下将当前的entity对象转换成对应的数组格式 属性名对应键名 属性值对应数组值
        $ref = new \ReflectionClass($this);
        $props = $ref->getProperties();
        $tmpArr = [];
        array_walk($props,function($val,$key)use (&$tmpArr){
            $func = 'get'. AbstractRepository::underline2camel($val->name);
            $tmpArr[$val->name] = call_user_func(array($this,$func));
        });

        return $tmpArr;
    }

}