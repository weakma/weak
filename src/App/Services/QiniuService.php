<?php
/**
 * Created by PhpStorm.
 * User: kkma
 * Date: 18-10-28
 * Time: 下午4:51
 */

namespace App\Services;

use Qiniu\Storage\UploadManager;
use Qiniu\Auth;


/**
 * Class QiniuService
 * @package App\Services
 *
 * @property string $access_key
 * @property string $secret_key
 * @property string $qiniu.domain
 *
 */
class QiniuService
{
    const UPLOAD_POLICY_EXPIRE =7200;
    private $_config;

    public function __construct(array $config)
    {
     $this->_config = $config;
    }

    /**
     * @return Auth
     */
    protected  function auth()
    {
        return new Auth($this->_config['access_key'], $this->_config['secret_key']);
    }

    /**
     * 获取文件信息
     *
     * @param $bucket
     * @param $filename
     * @return string
     */
    public function stat($bucket,$filename)
    {
        $auth          = $this->auth();
        $config        = new \Qiniu\Config();
        $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
        list($fileInfo, $err) = $bucketManager->stat($bucket, $filename);
        if ($err) {
            return '';
        } else {
            return $fileInfo;
        }
    }

    /**
     * 生成上传Token
     *
     * @param $bucket
     *
     * @return string
     */
    public function uploadToken($bucket)
    {

        $options = array_merge($this->_config['default']['policy'], $this->_config['bucket'][$bucket]['policy']);
        $options['saveKey'] = sprintf('%s/%s.$(ext)',date('Ymd'),uniqid());

        return $this->auth()->uploadToken($bucket, null, self::UPLOAD_POLICY_EXPIRE, $options);
    }

    /**
     * 上传文件
     *
     * @param $filename
     * @param $data
     * @param $bucket
     * @return array
     */
    public function put($filename, $data,$bucket)
    {
        $upManager = new UploadManager();
        $auth      = $this->auth();
        $token     = $auth->uploadToken($bucket);
        $res       = $upManager->put($token, $filename, $data);

        return $res;
    }

    /**
     * 删除一个文件
     *
     * @param $key
     * @param $bucket
     */
    public function delete($key,$bucket)
    {
        $bucketManager = new \Qiniu\Storage\BucketManager(self::auth(), new \Qiniu\Config());
        $bucketManager->delete($bucket,$key);
    }

    public function config($key=null)
    {
        if(null==$key) return $key;

        $val = $this->_config;
        $keys = explode('.',$key);

        foreach ($keys as $item){
            $val = key_exists($item,$val)?$val[$item]:null;
        }
        return $val;
    }
}