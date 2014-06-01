<?php

class databaseTest extends PHPUnit_Extensions_Database_TestCase
{

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        $db = Registry::getDb();
        $pdo = $db->pdo;

        return $this->createDefaultDBConnection($pdo, PHPUNIT_DBNAME);
    }

    /**
     * XML created using:
     *     mysqldump --xml -t -u [username] --password=[password] [database] > /path/to/file.xml
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(dirname(__FILE__).'/../database.xml');
    }

    public function testGetRowCount()
    {
        $this->assertEquals(1, $this->getConnection()->getRowCount('users'));
    }
}
