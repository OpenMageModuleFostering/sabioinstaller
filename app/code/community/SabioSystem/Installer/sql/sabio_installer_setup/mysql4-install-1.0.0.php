<?php
$installer = $this;
$connection = $installer->getConnection();

$_table = $installer->getTable('sabio_installer/extension');

if(!$connection->isTableExists($_table)){
	$table = $connection->newTable($_table)
		->addColumn('id',Varien_Db_Ddl_Table::TYPE_INTEGER,10,array(
			'identity'	=> true,
			'unsigned'	=> true,
			'nullable'	=> false,
			'primary'		=> true
		),'ID')

		->addColumn('name',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
			'nullable'	=> false
		),'Name')

		->addColumn('key',Varien_Db_Ddl_Table::TYPE_CHAR,40,array(
			'nullable'	=> false
		),'Key')
		->addIndex('IDX_KEY',array(
				array(
					'name'	=> 'key',
					'size'	=> 40
				)),array(
					'type' => Varien_db_Adapter_Interface::INDEX_TYPE_UNIQUE
		))

		->addColumn('current_version',Varien_Db_Ddl_Table::TYPE_VARCHAR,15,array(
			'nullable'	=> true,
			'default'		=> null
		),'Current Version')

		->addColumn('newest_version',Varien_Db_Ddl_Table::TYPE_VARCHAR,15,array(
			'nullable'	=> true,
			'default'		=> null
		),'Newest Version')

		->addColumn('map',Varien_Db_Ddl_Table::TYPE_TEXT,null,array(
			'nullable'	=> true,
			'default'		=> null
		),'Extension Map');
	$connection->createTable($table);
}

$installer->endSetup();
?>
