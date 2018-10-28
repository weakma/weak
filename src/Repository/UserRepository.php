<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-7-20
 * Time: 下午12:21
 */

namespace App\Repository;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class UserRepository
 * @package App\Repository
 *
 * @method User findOneBy(array $criteria, array $orderBy = null)
 *
 * @inheritdoc
 */
class UserRepository extends AbstractRepository
{
    const TYPE_GENERAL = 1;

    public function formLogin(User $user)
    {
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
        $this->container->get('security.token_storage')->setToken($token);
        $request = $this->container->get('request_stack');
        $event = new InteractiveLoginEvent($request->getMasterRequest(), $token);
        $this->container->get('event_dispatcher')->dispatch('security.interactive_login', $event);

    }


}