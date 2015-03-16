<?php

namespace Map;

use \Pagamento;
use \PagamentoQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'pagamentos' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PagamentoTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PagamentoTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'my_cine_mania';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'pagamentos';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Pagamento';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Pagamento';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'pagamentos.id';

    /**
     * the column name for the participante_id field
     */
    const COL_PARTICIPANTE_ID = 'pagamentos.participante_id';

    /**
     * the column name for the data_pagamento field
     */
    const COL_DATA_PAGAMENTO = 'pagamentos.data_pagamento';

    /**
     * the column name for the data_vencimento field
     */
    const COL_DATA_VENCIMENTO = 'pagamentos.data_vencimento';

    /**
     * the column name for the numero_boleto field
     */
    const COL_NUMERO_BOLETO = 'pagamentos.numero_boleto';

    /**
     * the column name for the valor field
     */
    const COL_VALOR = 'pagamentos.valor';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'ParticipanteId', 'DataPagamento', 'DataVencimento', 'NumeroBoleto', 'Valor', ),
        self::TYPE_CAMELNAME     => array('id', 'participanteId', 'dataPagamento', 'dataVencimento', 'numeroBoleto', 'valor', ),
        self::TYPE_COLNAME       => array(PagamentoTableMap::COL_ID, PagamentoTableMap::COL_PARTICIPANTE_ID, PagamentoTableMap::COL_DATA_PAGAMENTO, PagamentoTableMap::COL_DATA_VENCIMENTO, PagamentoTableMap::COL_NUMERO_BOLETO, PagamentoTableMap::COL_VALOR, ),
        self::TYPE_FIELDNAME     => array('id', 'participante_id', 'data_pagamento', 'data_vencimento', 'numero_boleto', 'valor', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ParticipanteId' => 1, 'DataPagamento' => 2, 'DataVencimento' => 3, 'NumeroBoleto' => 4, 'Valor' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'participanteId' => 1, 'dataPagamento' => 2, 'dataVencimento' => 3, 'numeroBoleto' => 4, 'valor' => 5, ),
        self::TYPE_COLNAME       => array(PagamentoTableMap::COL_ID => 0, PagamentoTableMap::COL_PARTICIPANTE_ID => 1, PagamentoTableMap::COL_DATA_PAGAMENTO => 2, PagamentoTableMap::COL_DATA_VENCIMENTO => 3, PagamentoTableMap::COL_NUMERO_BOLETO => 4, PagamentoTableMap::COL_VALOR => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'participante_id' => 1, 'data_pagamento' => 2, 'data_vencimento' => 3, 'numero_boleto' => 4, 'valor' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('pagamentos');
        $this->setPhpName('Pagamento');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Pagamento');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('pagamentos_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('participante_id', 'ParticipanteId', 'INTEGER', 'participantes', 'usuario_id', true, null, null);
        $this->addColumn('data_pagamento', 'DataPagamento', 'DATE', false, null, null);
        $this->addColumn('data_vencimento', 'DataVencimento', 'DATE', true, null, null);
        $this->addColumn('numero_boleto', 'NumeroBoleto', 'VARCHAR', false, 50, null);
        $this->addColumn('valor', 'Valor', 'DOUBLE', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Participante', '\\Participante', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':participante_id',
    1 => ':usuario_id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PagamentoTableMap::CLASS_DEFAULT : PagamentoTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Pagamento object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PagamentoTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PagamentoTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PagamentoTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PagamentoTableMap::OM_CLASS;
            /** @var Pagamento $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PagamentoTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PagamentoTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PagamentoTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Pagamento $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PagamentoTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PagamentoTableMap::COL_ID);
            $criteria->addSelectColumn(PagamentoTableMap::COL_PARTICIPANTE_ID);
            $criteria->addSelectColumn(PagamentoTableMap::COL_DATA_PAGAMENTO);
            $criteria->addSelectColumn(PagamentoTableMap::COL_DATA_VENCIMENTO);
            $criteria->addSelectColumn(PagamentoTableMap::COL_NUMERO_BOLETO);
            $criteria->addSelectColumn(PagamentoTableMap::COL_VALOR);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.participante_id');
            $criteria->addSelectColumn($alias . '.data_pagamento');
            $criteria->addSelectColumn($alias . '.data_vencimento');
            $criteria->addSelectColumn($alias . '.numero_boleto');
            $criteria->addSelectColumn($alias . '.valor');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PagamentoTableMap::DATABASE_NAME)->getTable(PagamentoTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PagamentoTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PagamentoTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PagamentoTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Pagamento or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Pagamento object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PagamentoTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Pagamento) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PagamentoTableMap::DATABASE_NAME);
            $criteria->add(PagamentoTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PagamentoQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PagamentoTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PagamentoTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the pagamentos table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PagamentoQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Pagamento or Criteria object.
     *
     * @param mixed               $criteria Criteria or Pagamento object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PagamentoTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Pagamento object
        }

        if ($criteria->containsKey(PagamentoTableMap::COL_ID) && $criteria->keyContainsValue(PagamentoTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PagamentoTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PagamentoQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PagamentoTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PagamentoTableMap::buildTableMap();
