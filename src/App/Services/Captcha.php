<?php
/**
 * Created by PhpStorm.
 * User: makai
 * Date: 17-5-16
 * Time: 上午2:54
 */

namespace App\Services;

use Gregwar\Captcha\CaptchaBuilder;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class Captcha
{
    const PARSE_LENGTH = 4;
    const PARSE_EXPRIE_TIME  = 600;

    protected $_captchaBuilder;
    protected $_adapter;

    public function __construct(CaptchaBuilder $captchaBuilder, AdapterInterface $adapter)
    {
        $this->_captchaBuilder = $captchaBuilder;
        $this->_adapter = $adapter;
    }

    public function isCaptchaVaild($key, $phrase)
    {
        $item = $this->_adapter->getItem($key);
        
        self::removeCaptcha($key);
        return $phrase === $item->get();
    }
    public function removeCaptcha($key)
    {
        try{
            $this->_adapter->deleteItem($key);
        }catch (\Psr\Cache\InvalidArgumentException $e){

        }

        return true;
    }
    /**
     * 创建一个图形验证码，并返回图片二进制流
     *
     * @param  string $key  此验证码的缓存key
     * @return string
     */
    public function generateImageCaptcha($key)
    {
        $captchaBuilder = $this->_initCaptchaBuilder($key);
        return $captchaBuilder->get();
    }

    /**
     * 创建一个图形验证码，并返回图片data:image格式文本
     *
     * @param  string $key  此验证码的缓存key
     * @return string
     */
    public function generateSourceCaptcha($key)
    {
        $captchaBuilder = $this->_initCaptchaBuilder($key);
        return $captchaBuilder->inline();
    }

    /**
     * 初始化验证码对象
     *
     * @param string $key   验证码缓存key
     * @return \Gregwar\Captcha\CaptchaBuilder
     */
    protected function _initCaptchaBuilder($key)
    {
        $phrase = $this->_randomPhrase(self::PARSE_LENGTH);
        $this->_captchaBuilder->setPhrase($phrase);
        $this->_captchaBuilder->setIgnoreAllEffects(true);
        $this->_captchaBuilder->setBackgroundColor(240,240,240);
        $this->_captchaBuilder->build(80, 30);
        $item = $this->_adapter->getItem($key);
        $item->set($phrase)->expiresAfter(self::PARSE_EXPRIE_TIME);
        $this->_adapter->save($item);
        return $this->_captchaBuilder;
    }

    /**
     * 创建随机验证码
     *
     * @param int $length   验证码长度
     * @return string
     */
    protected function _randomPhrase($length)
    {
        $list = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','p','q','r','s','t','u','v','w','x','y','z','1','2','3','4','5','6','7','8','9'];
        return implode('', array_rand(array_flip($list), $length));
    }
}