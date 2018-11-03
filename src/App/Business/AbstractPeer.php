<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-5-5
 * Time: 下午8:49
 */

namespace App\Business;


use App\Entity\AbstractEntity;
use App\Repository\AbstractRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Exception\ValidationException;

/**
 * Class AbstractPeer
 * @package App\Business
 * @property AbstractRepository $repository
 *
 */
abstract class AbstractPeer
{
    protected $container;

    protected $repository;


    public function __construct(ContainerInterface $container,AbstractRepository $repository)
    {
        $this->container = $container;
       $this->repository = $repository;
    }

    /**
     * @param $id
     * @return object
     */
    public function get($id)
    {
        return $this->container->get($id);
    }


    /**
     * 校检 Entity对象
     *
     * @param $entities
     * @throws ValidationException
     *
     */
    protected function validate($entities)
    {
        $errors = new ConstraintViolationList();
        switch (gettype($entities)) {
            case 'array':
                array_walk($entities, function (AbstractEntity $entity, $key) use (&$errors) {
                    $errors->addAll($this->container->get('validator')->validate($entity));
                });
                break;
            default:
                $errors = $this->container->get('validator')->validate($entities);
                break;
        }

        if ($errors->count()) {
            throw new ValidationException($errors);
        }
    }

}