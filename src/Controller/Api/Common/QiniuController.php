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

    public function postCollbackAction()
    {

    }

    /**
     * 七牛通知
     */
    public function postCallbackFopAction(Request $request)
    {
        $data = $request->request->all();
        //根据官方文档，0是成功，其他情况不处理即可
        /*if ($data->get('code') === 0) {
            $key = $data->get('inputKey');
            $bucket = $data->get('inputBucket');
            if ($bucket == 'video') {
                $video = Video::where([
                    'source' => $key,
                    'bucket' => $bucket,
                    'store' => Video::STORE_QINIU,
                    //                    'status' => Video::STATUS_PENDING,
                ])->first();
                if (empty($video)) {
                    $video = new Video();
                    $video->source = $key;
                    $video->bucket = $bucket;
                    $video->store = Video::STORE_QINIU;
                }
                $items = $data->get('items');
                foreach ($items as $item) {
                    if ($item['code'] === 0) {
                        $cmd = $item['cmd'];
                        $newk = $item['key'];
                        if (strpos($cmd, '480')) {
                            $video->path_480p = $newk;
                        } elseif (strpos($cmd, '720')) {
                            $video->path_720p = $newk;
                        } elseif (strpos($cmd, 'gif') || strpos($cmd, 'jpg')) {
                            $video->cover_gif = $newk;
                        }
                    }
                }
                $video->status = Video::STATUS_DONE;
                $video->save();
            }
        }*/
        return ['name' => $request->request->get('inputKey')];
    }


}