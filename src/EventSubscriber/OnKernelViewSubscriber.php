<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-8-11
 * Time: 上午4:08
 */

namespace App\EventSubscriber;
use FOS\RestBundle\View\View;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class OnKernelViewSubscriber implements EventSubscriberInterface
{

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();
        $request = $event->getRequest();

        if(!$result instanceof View && !$result instanceof Response && 'html'==$request->getRequestFormat()){
            $request->setRequestFormat('json');
        }
    }

    public static function getSubscribedEvents()
    {
        // Must be executed before FOS\RestBundle\EventListener\ViewResponseListener's listener
        return array(
            KernelEvents::VIEW => array('onKernelView', 60),
        );
    }


}