<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-7-20
 * Time: 下午4:22
 */

namespace App\Controller\Api;


use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    public function getUsersAction(Request $request)
    {}

    public function getUserAction($id)
    {
        return $id;
    }
}