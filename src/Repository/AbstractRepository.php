<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-7-20
 * Time: 下午12:22
 */

namespace App\Repository;

use App\Entity\AbstractEntity;
use App\Exception\EntityException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AbstractRepository
 *
 * @package App\Repository
 *
 *
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->paginator = $container->get('knp_paginator');
        parent::__construct($container->get('doctrine'),static::getEntityClass());
    }

    /**
     * @param int $page
     * @param int $limit
     * @param null $target
     * @param array $options
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function paginate($page = 1, $limit = 10, $target=null, array $options = array())
    {
        if(!$target){
            $target = parent::createQueryBuilder('m');
        }
        return $this->container->get('knp_paginator')->paginate($target, $page, $limit, $options);
    }
    /**
     * @param array $properties
     * @param array $options
     * @throws EntityException
     * @throws \Exception
     *
     * @return AbstractEntity
     */
    public function create(array $properties=[],$options=[])
    {
        $properties = $properties??$this->container->get('request_stack')->getCurrentRequest()->request->all();
        /** @var AbstractEntity $entity */
        $entityClass = static::getEntityClass();
        $entity = new $entityClass();
        self::mapping($entity,$properties,$options);

        return $entity;

    }

    /**
     * @param $entity
     * @return bool
     * @throws EntityException
     */
    public function save($entity)
    {
        try{
            $this->getEntityManager()->beginTransaction();

            if($entity instanceof AbstractEntity){
                $this->getEntityManager()->persist($entity);
            }elseif (is_array($entity)){
                array_walk($entity, function ($item, $key) {
                    $this->getEntityManager()->persist($item);
                });
            }

            $this->getEntityManager()->flush();

            $this->getEntityManager()->commit();
            return true;
        }catch (ORMInvalidArgumentException $e){
            $this->getEntityManager()->rollback();
            throw new EntityException($e->getMessage(),$e->getCode());
        }catch (ORMException $e){
            $this->getEntityManager()->rollback();
            throw new EntityException($e->getMessage(),$e->getCode());
        }catch (\Exception $e){
            $this->getEntityManager()->rollback();
            throw new EntityException($e->getMessage(),$e->getCode());
        }
    }


    /**
     * @return string
     */
    public static function getEntityClass()
    {
        return str_replace(['\\Repository','Repository'],['\\Entity',''],static::class);
    }

    /**
     * @param AbstractEntity|array $entity
     * @param array $data
     * @param array $options
     * exp:
     * $this->mapping($entity, $postData, ['filter'=['排除的'],'only'=['仅需要的属性']])
     *
     */
    public function mapping($entity,array $data, array $options = [])
    {
        array_walk($data, function ($val, $key) use ($options,$entity) {
            if ((key_exists('only', $options) && !in_array($key, $options['only'])) || (key_exists('filter', $options) && in_array($key, $options['filter']))) {
                return;
            }
            $method = 'set' . self::underline2camel($key);
            if (method_exists($entity, $method)) {
                $entity->{$method}($val);
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