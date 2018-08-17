<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use App\Exception\ValidationException;

abstract class AbstractController extends FOSRestController
{
    /**
     * 抛出验证器异常
     *
     * @param ValidationException $e
     * @param array $map
     *
     * @return \FOS\RestBundle\View\View
     */
    protected function errorValidate($e, array $map = [])
    {
        $errors = $e->getErrors();
        $data = [];
        foreach ($errors as $error) {
            $key = $error->getPropertyPath();
            if (isset($map[$key])) {
                $data[$map[$key]] = $error->getMessage();
            } else {
                $data[$key] = $error->getMessage();
            }

        }
        return $this->view(['message'=>'数据验证错误','validate' => $data], 400);
    }

    /**
     * @param null $data
     * @param int $code
     * @return \FOS\RestBundle\View\View
     */
    protected function error($data = null, $code = 400)
    {
        return $this->view($data, $code);
    }
}
