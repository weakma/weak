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
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

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
        $token = $this->tokenRegistry->findOneBy(['token'=>$apiKey]);
        return $token?$token->getUsername():null;
    }

}