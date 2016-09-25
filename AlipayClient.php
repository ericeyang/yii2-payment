<?php
/**
 * @link      http://www.youfangfa.me/
 * @copyright Copyright (c) 2016  YouFang Inc.
 * @license   http://www.youfangfa.me/license/
 */

namespace ericeyang\payment;

use ericeyang\payment\alipay\AlipayBusinessParamsTrait;
use ericeyang\payment\alipay\AlipayCommonParamsTrait;
use ericeyang\payment\alipay\AlipayInterface;
use ericeyang\payment\alipay\AlipayNotifyInterface;
use ericeyang\payment\alipay\AlipayTrait;
use Yii;

/**
 * Class AlipayClient
 *
 * @author ericeyang <ericeyany@gmail.com>
 * @since 1.0.0
 */
class AlipayClient extends Payment implements AlipayInterface, AlipayNotifyInterface
{
    use AlipayTrait, AlipayCommonParamsTrait, AlipayBusinessParamsTrait;

    public function init()
    {
        parent::init();
        $this->config = Yii::$app->params['payment']['alipay'];
        $this->rsaPrivateKeyFilePath = Yii::getAlias($this->config['rsaPrivateKeyFilePath']);
        $this->rsaAlipayPublicKeyFilePath = Yii::getAlias($this->config['rsaAlipayPublicKeyFilePath']);
        $this->appId = $this->config['appId'];
        $this->format = 'JSON';
        $this->charset = 'utf-8';
        $this->signType = 'RSA';
        $this->timestamp = date('Y-m-d H:i:s');
        $this->version = $this->config['version'];
        $this->notifyUrl = $this->config['appGateway'];

        $this->initSellerId();
    }

    /**
     * 加签
     * @param string $signContent 未签名原始字符串
     * @param string $signType 签名方式
     * @return string 签名结果
     */
    public function sign($signContent, $signType = 'RSA')
    {
        $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
        $res = openssl_get_privatekey($priKey);
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

        if ("RSA2" == $signType) {
            openssl_sign($signContent, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($signContent, $sign, $res);
        }
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * 验签
     * @param string $signContent 未签名原始字符串
     * @param string $sign 需要验证的签名字符串
     * @param string $signType 签名方式
     * @return bool
     */
    public function verify($signContent, $sign, $signType = 'RSA')
    {
        // 读取公钥文件
        $pubKey = file_get_contents($this->rsaAlipayPublicKeyFilePath);

        // 转换为openssl格式密钥
        $res = openssl_get_publickey($pubKey);
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');

        // 调用openssl内置方法验签，返回bool值
        if ("RSA2" == $signType) {
            $result = (bool)openssl_verify($signContent, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        } else {
            $result = (bool)openssl_verify($signContent, base64_decode($sign), $res);
        }

        // 释放资源
        openssl_free_key($res);

        return $result;
    }

    public function verifyClientNotify($signSource, $sign, $signType)
    {
        $signContent = $this->buildSignContent($signSource);
        return $this->verify($signContent, $sign, $signType);
    }

    /**
     * 验证支付宝服务器异步返回支付结果信息
     * @param $params
     * @return string
     */
    public function verifyServerNotify($params)
    {
        $signType = $params['sign_type'];
        $sign = $params['sign'];
        $params['sign_type'] = null;
        $params['sign'] = null;

        foreach ($params as $key => $param) {
            $params[$key] = urldecode($param);
        }

        ksort($params);
        reset($params);

        $sign = base64_decode($sign);
        $signContent = $this->buildSignContent($params);
        return $this->verify($signContent, $sign, $signType);
    }

    public function verifyFromAliPayServer($notifyId)
    {
        // TODO： 拼接请求的完整链接
        // 示例：https://mapi.alipay.com/gateway.do?service=notify_verify&partner=2088002396712354&notify_id=RqPnCoPT3K9%252Fvwbh3I%252BFioE227%252BPfNMl8jwyZqMIiXQWxhOCmQ5MQO%252FWd93rvCB%252BaiGg

        // TODO：发送验证请求
    }

    /**
     * 获取未签名原始字符串
     * @return string
     */
    public function getSignContent()
    {
        $commonParams = $this->getCommonParams();
        $businessParams = $this->getBusinessParams();
        $params = array_merge($commonParams, $businessParams);

        ksort($params);
        reset($params);

        return $this->buildSignContent($params);
    }

    /**
     * 拼接签名字符串
     * @param $params
     * @return string
     */
    public function buildSignContent ($params)
    {
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 转换成目标字符集
                $v = $this->convertEncoding($v, $this->charset);

                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }

        unset ($k, $v);
        return $stringToBeSigned;
    }

    protected function getCommonParams()
    {
        return [
            'app_id' => $this->appId,
            'method' => $this->method,
            'format' => $this->format,
            'charset' => $this->charset,
            'sign_type' => $this->signType,
            'sign' => $this->sign,
            'timestamp' => $this->timestamp,
            'version' => $this->version,
            'notify_url' => $this->notifyUrl,
            'biz_content' => $this->bizContent,
        ];
    }

    protected function getBusinessParams()
    {
        return [
            'body' => $this->body,
            'subject' => $this->subject,
            'out_trade_no' => $this->outTradeNo,
            'timeout_express' => $this->timeoutExpress,
            'seller_id' => $this->sellerId,
            'product_code' => $this->productCode,
        ];
    }

    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    protected function checkEmpty($value)
    {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }

    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    protected function convertEncoding($data, $targetCharset)
    {
        if (!empty($data)) {
            $fileType = $this->charset;
            if (strcasecmp($fileType, $targetCharset) != 0) {

                $data = mb_convert_encoding($data, $targetCharset);
                // $data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }

        return $data;
    }

    /**
     * 初始化收款支付宝账号对应的支付宝唯一用户号
     */
    protected function initSellerId ()
    {
        $sellerId = $this->config['sellerId'];
        if (!$this->sellerId) {
            if (is_string($sellerId)) {
                $this->setSellerId($sellerId);
            } elseif (is_array($sellerId) && count($sellerId) > 0) {
                $this->setSellerId($sellerId[0]);
            }
        }
    }
}