<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-8-17
 * Time: 下午7:49
 */

namespace App\Controller\Security;

use App\Controller\AbstractController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    public function authorization(Request $request,UserRepository $registry)
    {
        $user = $registry->findOneBy([]);
    }
}