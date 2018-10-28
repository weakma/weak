<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-5-17
 * Time: 下午6:05
 */

namespace App\Business\Merchant;

use App\Business\AbstractPeer;
use App\Business\BussinesException;
use App\Entity\Merchant;
use OpenAlipaySDK\AlipayClient;
use OpenAlipaySDK\Api\AlipayTradeWapPayRequest;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BussinessMerchant extends AbstractPeer
{
    private $merchant;

    private $alipayClient;

    public function __construct(ContainerInterface $container,Merchant $merchant)
    {
        parent::__construct($container);
        $this->merchant = $merchant;
        $this->alipayClient = $this->_alipayClient();
    }

    public function getName()
    {
        return $this->merchant->getName();
    }

    public function alipayWapReceipt($amount)
    {
        if(!$this->alipayClient instanceof AlipayClient){
            throw new BussinesException('该商户暂不支持收款');
        }
        $amount = sprintf('%.2f',$amount);

        $content =[
            'subject'=>sprintf('转账给 %1$s',$this->merchant->getName()),
            'productCode'=>'QUICK_WAP_PAY',
            //'body'=>'商品描述',
            'timeout_express'=>'10m',
            'total_amount'=>$amount,
            'out_trade_no'=>Uuid::uuid4(),
            'seller_id'=>'',
            'extend_params'=>[
                'sys_service_provider_id'=>getenv('ISV_PID')
            ]
        ];

        $req = new AlipayTradeWapPayRequest();
        $req->setBizContent(json_encode($content,JSON_UNESCAPED_UNICODE));
        $req->setNotifyUrl($this->container->get('router')->generate('callbacks.notify.alipay',[],UrlGeneratorInterface::ABSOLUTE_URL));
        $form = $this->alipayClient->pageExecute($req);
        return $form;
    }

    public function isEnabled()
    {
        if(!$this->alipayClient instanceof AlipayClient){
            return false;
        }
        return true;
    }


    /**
     * 生成收款二维码
     *
     * @return $this
     */
    public function generatorReceiptCode()
    {
        $this->container->get('app.qrcode')->generate($this->merchant->getId());
        return $this;
    }

    public function getAlipayClient()
    {
        if(!$this->alipayClient instanceof AlipayClient)
        {
            $this->alipayClient = self::_alipayClient();
        }
        return $this->alipayClient;
    }

    /**
     * @return bool|AlipayClient
     */
    private function _alipayClient()
    {
        if(!$this->merchant->getAlipayAppid()
            ||!$this->merchant->getAlipayRsaPrivateKey()
            ||!$this->merchant->getAlipayRsaPublicKey()
            ||!$this->merchant->getAesKey()){
            return false;
        }

        return new AlipayClient(
            $this->merchant->getAlipayAppid(),
            $this->merchant->getAlipayRsaPrivateKey(),
            $this->merchant->getAlipayRsaPublicKey(),
            $this->merchant->getAesKey(),
            getenv('APP_ENV'),
            'RSA',
            $this->container->get('app.monolog.logger')
        );
    }

}