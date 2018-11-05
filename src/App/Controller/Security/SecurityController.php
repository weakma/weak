<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-8-17
 * Time: 下午7:49
 */

namespace App\Controller\Security;

use App\Business\User\BusinessUser;
use App\Business\User\UserPeer;
use App\Controller\AbstractController;
use App\Exception\EntityException;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    private $userPeer;

    public function __construct(UserPeer $userPeer)
    {
        $this->userPeer = $userPeer;
    }

    public function signin()
    {
        return $this->render('security/signin.twig');
    }

    /**
     * 登入
     *
     * @param Request $request
     * @return array|bool|\FOS\RestBundle\View\View
     */
    public function postAuthenticateAction(Request $request)
    {
        try{

            $businessUser = $this->userPeer->findOneBy(['username'=>$request->request->get('username')]);

            if($businessUser instanceof BusinessUser && $token = $businessUser->authenticate($request->request->get('password'))) {

                return $token;
            }
            return $this->validateError(['password'=>'用户名密码不匹配']);
        }catch (EntityException $e){
            return $this->error(['message'=>'服务器出错了','success'=>false],500);
        }

    }

    /**
     * 注册
     *
     * @param Request $request
     *
     * @return array|bool|\FOS\RestBundle\View\View
     */
    public function postEnrolAction(Request $request)
    {
        try{
            $businessUser = $this->userPeer->register($request->request->all());

            return $businessUser->authenticate($businessUser->getUser()->getPlainPassword());

        }catch (ValidationException $e){
            return $this->errorValidate($e);
        }catch (EntityException $e){
            return $this->error('服务器出错了',500);
        }


    }
}