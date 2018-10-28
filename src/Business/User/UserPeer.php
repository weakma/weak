<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-5-5
 * Time: 下午7:01
 */

namespace App\Business\User;

use App\Business\AbstractPeer;
use App\Entity\User;
use App\Exception\ValidationException;
use App\Repository\UserRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserPeer
 * @package App\Business\User
 * @property UserRepository $repository
 */
class UserPeer extends AbstractPeer
{

    public function __construct(ContainerInterface $container,UserRepository $repository)
    {
        parent::__construct($container,$repository);

    }

    /**
     * @param $id
     * @return BusinessUser|bool
     */
    public function find($id)
    {
        /** @var User $user */
        $user = $this->repository->find($id);
        if(!$user) return false;
        return new BusinessUser($this->container, $user,$this->repository);
    }

    /**
     * @param array $criteria
     * @return BusinessUser|bool
     */
    public function findOneBy(array $criteria)
    {
        $user = $this->repository->findOneBy($criteria);
        if(!$user) return false;
        return new BusinessUser($this->container, $user,$this->repository);
    }

    /**
     * @param $data
     * @return BusinessUser
     * @throws ValidationException
     * @throws \App\Exception\EntityException
     */
    public function register($data)
    {
        $entity = new User();
        $this->repository->mapping($entity,$data,['filter'=>['roles','is_active','created_at','password']]);
        parent::validate($entity);
        if(is_string($entity->getPlainPassword())){
            $encode = $this->container->get('security.password_encoder');
            $entity->setPassword($encode->encodePassword($entity,$entity->getPlainPassword()));
        }
        $this->repository->save($entity);

        return new BusinessUser($this->container, $entity,$this->repository);
    }


}