<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-10-28
 * Time: 下午4:21
 */
namespace App\Controller\Api\Common;

use App\Services\QiniuService;
use Symfony\Component\HttpFoundation\Request;

class QiniuController extends \App\Controller\AbstractController
{
    private $qiniu;

    public function __construct(QiniuService $qiniuService)
    {
        $this->qiniu = $qiniuService;
    }

    /**
     * 获取七牛上传Token
     */
    public function getTokenAction(Request $request)
    {

        $bucket = $request->query->get('type');

        if ($bucket == "mp3" || $bucket == "wav" || $bucket == "aac" || $bucket == "m4a" || $bucket == "mpeg" || $bucket == "audio" ){

            $bucket = "video";
        }elseif (null==$this->qiniu->config("bucket.$bucket.policy")){
            return $this->validateError(['bucket'=>'无效的 bucket']);
        }
        return [
            "bucket" => $bucket,
            "prefix" => $this->qiniu->config("bucket.{$bucket}.domain"),
            "token" => $this->qiniu->uploadToken($bucket),
        ];
    }



}