<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-10-28
 * Time: 下午11:07
 */

namespace App\Controller\Api\Merchant;


use App\Business\Merchant\MerchantPeer;
use App\Controller\AbstractController;

class MerchantController extends AbstractController
{
    private $peer;

    public function __construct(MerchantPeer $peer)
    {
        $this->peer = $peer;
    }

    public function getOwnerAction()
    {
        return $this->peer->find($id=1);
    }
}