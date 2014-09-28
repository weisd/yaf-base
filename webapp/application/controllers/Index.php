<?php
/**
 * @name IndexController
 * @author weisd
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends \Yaf\Controller_Abstract {

	/**
	 * 默认动作
	 * Yaf支持直接把\Yaf\Request_Abstract::getParam()得到的同名参数作为Action的形参
	 * 对于如下的例子, 当访问http://yourhost/webapp/index/index/index/name/weisd 的时候, 你就会发现不同
	 */
	public function indexAction($name = "Stranger") {
		return TRUE;
	}
}