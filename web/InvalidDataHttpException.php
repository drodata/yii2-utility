<?php
namespace drodata\web;

use yii\web\HttpException;

/**
 * InvalidDataHttpException 主要用在 API 中，当模型数据未通过验证时，
 * 直接此异常，小程序收到响应后，根据状态码（444）判断是用户输入的数据不合法，
 * 并给出相应的提示信息。
 */
class InvalidDataHttpException extends HttpException
{
    /**
     * 找一个没被占用的 status code 444
     * @param string $message error message
     * @param int $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(444, $message, $code, $previous);
    }
    
    public function getName()
    {
        return '输入信息不合法';
    }
}
