<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-5-5
 * Time: 下午7:05
 */

namespace App\Business\User;

use App\Entity\Token;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Business\AbstractPeer;

class BusinessUser extends AbstractPeer implements \Serializable
{
    const GENDER_MALE = 1; //性别 男
    const GENDER_FAMLE = 2; //性别 女
    const GENDER_UNKNOWN = 3; //性别 未知

    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_MERCHANT = 'ROLE_MERCHANT';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    private $user;

    
    public function __construct(ContainerInterface $container,User $user,UserRepository $repository)
    {
        parent::__construct($container,$repository);
        $this->user = $user;
    }
    
    
    public function login()
    {
        $token = new UsernamePasswordToken($this->user, $this->user->getPassword(), 'main', $this->user->getRoles());
        $this->container->get('security.token_storage')->setToken($token);
        $request = $this->container->get('request_stack');
        $event = new InteractiveLoginEvent($request->getMasterRequest(), $token);
        $this->container->get('event_dispatcher')->dispatch('security.interactive_login', $event);

    }

    /**
     * @param $credential
     * @return bool|array
     * @throws \App\Exception\EntityException
     */
    public function authenticate($credential)
    {
        if(null==$credential) return false;

        $res = $this->get('security.password_encoder')->isPasswordValid($this->user,$credential);
        if($res)
        {
            $token = new Token();
            $token->setUsername($this->user->getUsername());
            $this->repository->save($token);

            return ['user'=>$this->getUser(),'token'=>$token];
        }
        return false;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->user->getId();
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function serialize()
    {
        return $this->user->serialize();
    }

    public function unserialize($serialized)
    {
        $this->user->unserialize($serialized);
    }

}