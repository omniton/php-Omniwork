<?php
/**
 *
 * Table metadata for the Mock_Solar_Model_Nodes model class.
 *
 * This class is auto-generated by make-model; any changes you make will be
 * overwritten the next time you use make-model.  Modify the Mock_Solar_Model_Nodes
 * class instead of this one.
 *
 */
class Mock_Solar_Model_Nodes_Metadata extends Solar_Sql_Model_Metadata
{
    public $table_name = 'test_solar_nodes';

    public $table_cols = array (
      'id' => array (
        'name' => 'id',
        'type' => 'int',
        'size' => NULL,
        'scope' => NULL,
        'default' => NULL,
        'require' => true,
        'primary' => true,
        'autoinc' => true,
    ),
      'created' => array (
        'name' => 'created',
        'type' => 'timestamp',
        'size' => NULL,
        'scope' => NULL,
        'default' => NULL,
        'require' => false,
        'primary' => false,
        'autoinc' => false,
    ),
      'updated' => array (
        'name' => 'updated',
        'type' => 'timestamp',
        'size' => NULL,
        'scope' => NULL,
        'default' => NULL,
        'require' => false,
        'primary' => false,
        'autoinc' => false,
    ),
      'area_id' => array (
        'name' => 'area_id',
        'type' => 'int',
        'size' => NULL,
        'scope' => NULL,
        'default' => NULL,
        'require' => true,
        'primary' => false,
        'autoinc' => false,
    ),
      'user_id' => array (
        'name' => 'user_id',
        'type' => 'int',
        'size' => NULL,
        'scope' => NULL,
        'default' => NULL,
        'require' => false,
        'primary' => false,
        'autoinc' => false,
    ),
      'node_id' => array (
        'name' => 'node_id',
        'type' => 'int',
        'size' => NULL,
        'scope' => NULL,
        'default' => NULL,
        'require' => false,
        'primary' => false,
        'autoinc' => false,
    ),
      'inherit' => array (
        'name' => 'inherit',
        'type' => 'varchar',
        'size' => 32,
        'scope' => NULL,
        'default' => NULL,
        'require' => false,
        'primary' => false,
        'autoinc' => false,
    ),
      'subj' => array (
        'name' => 'subj',
        'type' => 'varchar',
        'size' => 255,
        'scope' => NULL,
        'default' => NULL,
        'require' => false,
        'primary' => false,
        'autoinc' => false,
    ),
      'body' => array (
        'name' => 'body',
        'type' => 'clob',
        'size' => NULL,
        'scope' => NULL,
        'default' => NULL,
        'require' => false,
        'primary' => false,
        'autoinc' => false,
    ),
    );

    public $index_info = array (
      'created' => array (
        'type' => 'normal',
        'cols' => array (
    0 => 'created',
    ),
    ),
      'updated' => array (
        'type' => 'normal',
        'cols' => array (
    0 => 'updated',
    ),
    ),
      'area_id' => array (
        'type' => 'normal',
        'cols' => array (
    0 => 'area_id',
    ),
    ),
      'user_id' => array (
        'type' => 'normal',
        'cols' => array (
    0 => 'user_id',
    ),
    ),
      'node_id' => array (
        'type' => 'normal',
        'cols' => array (
    0 => 'node_id',
    ),
    ),
      'inherit' => array (
        'type' => 'normal',
        'cols' => array (
    0 => 'inherit',
    ),
    ),
    );
}
