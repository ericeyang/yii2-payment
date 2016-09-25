<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace ericeyang\payment\helpers;

use yii\base\Exception;

/**
 * PaymentException represents an exception caused by payment.
 *
 * @author ericeyang <ericeyany@gmail.com>
 * @since 1.0.0
 */
class PaymentException extends Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Payment Failed';
    }
}
