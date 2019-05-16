<?php

namespace drodata\wechat;

use Yii;
use EasyWeChat\Factory;

/**
 * 微信公众号组件
 * 
 * 使用举例，在配置文件中 `components` option 内配置:
 * 
 * ```php
 * 'components' => [
 *     'wechat' => [
 *         'class' => 'drodata\wechat\OfficialAccount',
 *         'appId' => 'xx',
 *         'appSecret' => 'xx',
 *     ],
 * ],
 * ```
 *
 * @author Kui Chen <drodata@foxmail.com>
 */
class OfficialAccount extends EasyWechat
{
    private $_app;
    public $appId;
    public $appSecret;
    public $token;
    public $debug = true;
    public $logOptions = [];

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

        $app = Factory::officialAccount([
            'app_id' => $this->appId,
            'secret' => $this->appSecret,
            'token'  => $this->token,
            'log' => $this->logOptions,
            'debug'  => $this->debug,
            'oauth' => $this->oauthOptions,
        ]);

        $this->_app = $app;
    }

    public function getApp()
    {
        return $this->_app;
    }
    public function getTemplateMessage()
    {
        return $this->_app->template_message;
    }
    public function getMenu()
    {
        return $this->_app->menu;
    }
    public function getOauth()
    {
        return $this->_app->oauth;
    }
    public function getUser()
    {
        return $this->_app->user;
    }
    public function userList()
    {
        $lists = $this->_app->user->lists();
        return $lists;
    }
}
