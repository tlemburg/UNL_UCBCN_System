<?php
namespace UNL\UCBCN;

use UNL\UCBCN\ActiveRecord\RecordList;

class Permissions extends RecordList
{
    public function getDefaultOptions()
    {
        return array(
            'listClass' =>  __CLASS__,
            'itemClass' => __NAMESPACE__ . '\\Permission',
        );
    }

    public function getSQL() 
    {
    	if (array_key_exists('user_uid', $this->options) && array_key_exists('calendar_id', $this->options)) {
    		$sql = 'SELECT permission_id FROM user_has_permission
    				WHERE user_uid = "' . self::escapeString($this->options['user_uid']) .
    				'" AND calendar_id = ' . (int)($this->options['calendar_id']) . ';';

    		return $sql;
    	}

    	return parent::getSQL();
    }

    public function getOrderByClause()
    {
        return 'ORDER BY description';
    }
}