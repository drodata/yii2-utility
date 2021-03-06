<?php

namespace drodata\wechat;

use Yii;
use EasyWeChat\Factory;

/**
 * 小程序组件
 * 
 * 使用举例，在配置文件中 `components` option 内配置:
 * 
 * ```php
 * 'components' => [
 *     'wechat' => [
 *         'class' => 'drodata\wechat\MiniProgram',
 *         'appId' => 'xx',
 *         'appSecret' => 'xx',
 *     ],
 * ],
 * ```
 *
 * @author Kui Chen <drodata@foxmail.com>
 */
class MiniProgram extends EasyWechat
{
    private $_app;
    public $appId;
    public $appSecret;
    public $token;
    public $debug = true;
    public $logOptions = [];

    public $codeToSessionUrl = 'https://api.weixin.qq.com/sns/jscode2session';

    /**
     *  'scopes'   => ['snsapi_userinfo'],
     *  'callback' => '/oauth_callback',
     * @var array 
     */
    public $oauthOptions;

    /**
     * @inhericdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->logOptions)) {
            return;
        }

        $app = Factory::miniProgram([
            'app_id' => $this->appId,
            'secret' => $this->appSecret,
            'log' => $this->logOptions,
            'debug'  => $this->debug,
        ]);

        $this->_app = $app;
    }

    public function getApp()
    {
        return $this->_app;
    }
    public function getAuth()
    {
        return $this->_app->auth;
    }

    /**
     * fetch open id and session key of a user using code generated by 
     * `wx.login()`
     *
     * @param string $code js code generated by `wx.login()`
     * @return array, 具体参考 wx.login 返回参数
     *
     */
    function code2session($code)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->codeToSessionUrl,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'appid' => $this->appId,
                'secret' => $this->appSecret,
                'js_code' => $code,
                'grant_type' => 'authorization_code',
            ],
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        // 返回关系数组而非 stdClass 对象
        return json_decode($response, true);
    }
}
