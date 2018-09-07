<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-8-17
 * Time: 下午7:49
 */

namespace App\Controller\Security;

use App\Controller\AbstractController;
use App\Entity\Token;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    public function authorization(Request $request,UserRepository $registry)
    {
        /** @var User $user */
        $user = $registry->findOneBy(['username'=>$request->request->get('username')]);


        $res = $this->get('security.password_encoder')->isPasswordValid($user,$request->request->get('password'));

        if($res){
            $token = new Token();
            $token->setUsername($user->getUsername());
            $registry->save($token);
            return ['success'=>$res,'message'=>'认证成功','token'=>$token->getToken()];
        }

        return $this->error(['message'=>'用户名密码不匹配','success'=>$res]);
    }
}