<?php
/**
 * @name BaseModel
 * @desc Base use medoo
 * @author weisd
 */
class BaseModel {
	protected static $db = null;

	protected $_table = '';

	public function getDB() {
		if (self::$db === null) {
			$config = \Yaf\Registry::get('config')->sqlite->toArray();
			self::$db = new medoo($config);
		}
		return self::$db;
	}

	public function __call($name = '', $parameters = array()) {
		// 查询时自动添加表名
		$query_methods = ['delete', 'where', 'select', 'insert', 'update', 'replace', 'get', 'has', 'count', 'max', 'min', 'avg', 'sum'];
		if (in_array($name, $query_methods)) {
			// 类名=表名
			if (empty($this->_table)) {
				$className = get_class($this);
				$this->_table = strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', substr($className, 0, -5)));
			}

			array_unshift($parameters, $this->_table);
		}
		$res = call_user_func_array(array($this->getDB(), $name), $parameters);

		if ($res === false || ($name == 'insert' && $res == 0)) {
			// 抛出异常
			throw new MedooException($this->error());
		}

		return $res;
	}
}

/**
 * model exception
 */
class MedooException extends Exception {
	function __construct($errorInfo) {
		parent::__construct($errorInfo[2], $errorInfo[1]);
	}
}
