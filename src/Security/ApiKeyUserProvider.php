<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-7-20
 * Time: 下午2:39
 */

namespace App\Security;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ApiKeyUserProvider extends FormUserProvider
{

    public function getUsernameForApiKey($apiKey)
    {
        //throw new UsernameNotFoundException('凭据已过期',401);
        return null;
    }

}