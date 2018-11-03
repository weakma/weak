<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-5-17
 * Time: 下午6:00
 */

namespace App\Business\Merchant;

use App\Business\AbstractPeer;
use App\Entity\Merchant;
use App\Exception\ValidationException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Repository\MerchantRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MerchantPeer
 * @package App\Business\Merchant
 *
 * @property MerchantRepository $repository
 *
 */
class MerchantPeer extends AbstractPeer
{
    public function __construct(ContainerInterface $container,MerchantRepository $repository)
    {
        parent::__construct($container,$repository);
    }

    /**
     * @param $id
     * @return BussinessMerchant|bool
     */
    public function find($id)
    {
        /** @var Merchant $merchant */
        $merchant = $this->repository->find($id);
        if(!$merchant) return false;

        return new BussinessMerchant($this->container,$merchant);
    }

    /**
     * @param array $data
     * @return Merchant
     *
     * @throws ValidationException
     * @throws \App\Exception\EntityException
     * @throws \Exception
     */
    public function create(array $data)
    {
        $merchant = new Merchant();
        $this->repository->mapping($merchant,$data);
        parent::validate($merchant);
        $this->repository->save($merchant);
        return $merchant;
    }

    /**
     * @param $merchant
     * @param array $data
     * @return Merchant
     *
     * @throws ValidationException
     * @throws \App\Exception\EntityException
     * @throws \Exception
     */
    public function update($merchant,array $data)
    {
        if(!$merchant instanceof Merchant){

            $merchant = $this->repository->find($merchant);
            if(!$merchant) throw new NotFoundHttpException('Not Found');
        }

        $this->repository->mapping($merchant,$data);
        parent::validate($merchant);
        $this->repository->save($merchant);

        return $merchant;
    }


}