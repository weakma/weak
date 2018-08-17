<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-7-20
 * Time: 下午2:50
 */

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FormUserProvider implements UserProviderInterface
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * 根据username获取user对象
     *
     * @param string $username
     *
     * @return object|User|null
     */
    public function loadUserByUsername($username)
    {
        $user = $this->repository->findOneBy(["username"=>$username]);
        if(!$user){
            throw new UsernameNotFoundException('用户名密码不匹配',400);
        }
        return $user;
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}