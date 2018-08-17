<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-7-20
 * Time: 下午2:39
 */

namespace App\Security;

use App\Entity\User;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ApiKeyUserProvider extends FormUserProvider
{
    /** @var TokenRepository */
    private $tokenRegistry;

    public function __construct(TokenRepository $tokenRepository,UserRepository $repository)
    {
        parent::__construct($repository);
        $this->tokenRegistry = $tokenRepository;
    }

    public function getUsernameForApiKey($apiKey)
    {
        $token = $this->tokenRegistry->createQueryBuilder('t')
            ->select('u')
            ->where('token',$apiKey)
            ->leftJoin(User::class,'u',Join::ON,['u.id','t.user_id']);

        return $token;
    }

}