<?php

namespace Map;

use \Beneficio;
use \BeneficioQuery;
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
 * This class defines the structure of the 'beneficios' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BeneficioTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.BeneficioTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'my_cine_mania';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'beneficios';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Beneficio';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Beneficio';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = 'beneficios.id';

    /**
     * the column name for the rede_cinema_id field
     */
    const COL_REDE_CINEMA_ID = 'beneficios.rede_cinema_id';

    /**
     * the column name for the titulo field
     */
    const COL_TITULO = 'beneficios.titulo';

    /**
     * the column name for the inicio_validade field
     */
    const COL_INICIO_VALIDADE = 'beneficios.inicio_validade';

    /**
     * the column name for the fim_validade field
     */
    const COL_FIM_VALIDADE = 'beneficios.fim_validade';

    /**
     * the column name for the descricao field
     */
    const COL_DESCRICAO = 'beneficios.descricao';

    /**
     * the column name for the condicoes field
     */
    const COL_CONDICOES = 'beneficios.condicoes';

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
        self::TYPE_PHPNAME       => array('Id', 'RedeCinemaId', 'Titulo', 'InicioValidade', 'FimValidade', 'Descricao', 'Condicoes', ),
        self::TYPE_CAMELNAME     => array('id', 'redeCinemaId', 'titulo', 'inicioValidade', 'fimValidade', 'descricao', 'condicoes', ),
        self::TYPE_COLNAME       => array(BeneficioTableMap::COL_ID, BeneficioTableMap::COL_REDE_CINEMA_ID, BeneficioTableMap::COL_TITULO, BeneficioTableMap::COL_INICIO_VALIDADE, BeneficioTableMap::COL_FIM_VALIDADE, BeneficioTableMap::COL_DESCRICAO, BeneficioTableMap::COL_CONDICOES, ),
        self::TYPE_FIELDNAME     => array('id', 'rede_cinema_id', 'titulo', 'inicio_validade', 'fim_validade', 'descricao', 'condicoes', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'RedeCinemaId' => 1, 'Titulo' => 2, 'InicioValidade' => 3, 'FimValidade' => 4, 'Descricao' => 5, 'Condicoes' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'redeCinemaId' => 1, 'titulo' => 2, 'inicioValidade' => 3, 'fimValidade' => 4, 'descricao' => 5, 'condicoes' => 6, ),
        self::TYPE_COLNAME       => array(BeneficioTableMap::COL_ID => 0, BeneficioTableMap::COL_REDE_CINEMA_ID => 1, BeneficioTableMap::COL_TITULO => 2, BeneficioTableMap::COL_INICIO_VALIDADE => 3, BeneficioTableMap::COL_FIM_VALIDADE => 4, BeneficioTableMap::COL_DESCRICAO => 5, BeneficioTableMap::COL_CONDICOES => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'rede_cinema_id' => 1, 'titulo' => 2, 'inicio_validade' => 3, 'fim_validade' => 4, 'descricao' => 5, 'condicoes' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('beneficios');
        $this->setPhpName('Beneficio');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Beneficio');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('beneficios_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('rede_cinema_id', 'RedeCinemaId', 'INTEGER', 'redes_cinema', 'id', true, null, null);
        $this->addColumn('titulo', 'Titulo', 'VARCHAR', true, 255, null);
        $this->addColumn('inicio_validade', 'InicioValidade', 'DATE', true, null, null);
        $this->addColumn('fim_validade', 'FimValidade', 'DATE', true, null, null);
        $this->addColumn('descricao', 'Descricao', 'LONGVARCHAR', true, null, null);
        $this->addColumn('condicoes', 'Condicoes', 'LONGVARCHAR', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('RedeCinema', '\\RedeCinema', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':rede_cinema_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('BeneficiosPreferencias', '\\BeneficiosPreferencias', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':beneficio_id',
    1 => ':id',
  ),
), null, null, 'BeneficiosPreferenciass', false);
        $this->addRelation('ParticipantesPreferencias', '\\ParticipantesPreferencias', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':beneficio_id',
    1 => ':id',
  ),
), null, null, 'ParticipantesPreferenciass', false);
        $this->addRelation('Voucher', '\\Voucher', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':beneficio_id',
    1 => ':id',
  ),
), null, null, 'Vouchers', false);
        $this->addRelation('Preferencia', '\\Preferencia', RelationMap::MANY_TO_MANY, array(), null, null, 'Preferencias');
        $this->addRelation('Participante', '\\Participante', RelationMap::MANY_TO_MANY, array(), null, null, 'Participantes');
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
        return $withPrefix ? BeneficioTableMap::CLASS_DEFAULT : BeneficioTableMap::OM_CLASS;
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
     * @return array           (Beneficio object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BeneficioTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BeneficioTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BeneficioTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BeneficioTableMap::OM_CLASS;
            /** @var Beneficio $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BeneficioTableMap::addInstanceToPool($obj, $key);
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
            $key = BeneficioTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BeneficioTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Beneficio $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BeneficioTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BeneficioTableMap::COL_ID);
            $criteria->addSelectColumn(BeneficioTableMap::COL_REDE_CINEMA_ID);
            $criteria->addSelectColumn(BeneficioTableMap::COL_TITULO);
            $criteria->addSelectColumn(BeneficioTableMap::COL_INICIO_VALIDADE);
            $criteria->addSelectColumn(BeneficioTableMap::COL_FIM_VALIDADE);
            $criteria->addSelectColumn(BeneficioTableMap::COL_DESCRICAO);
            $criteria->addSelectColumn(BeneficioTableMap::COL_CONDICOES);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.rede_cinema_id');
            $criteria->addSelectColumn($alias . '.titulo');
            $criteria->addSelectColumn($alias . '.inicio_validade');
            $criteria->addSelectColumn($alias . '.fim_validade');
            $criteria->addSelectColumn($alias . '.descricao');
            $criteria->addSelectColumn($alias . '.condicoes');
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
        return Propel::getServiceContainer()->getDatabaseMap(BeneficioTableMap::DATABASE_NAME)->getTable(BeneficioTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BeneficioTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BeneficioTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BeneficioTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Beneficio or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Beneficio object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BeneficioTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Beneficio) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BeneficioTableMap::DATABASE_NAME);
            $criteria->add(BeneficioTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = BeneficioQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BeneficioTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BeneficioTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the beneficios table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BeneficioQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Beneficio or Criteria object.
     *
     * @param mixed               $criteria Criteria or Beneficio object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BeneficioTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Beneficio object
        }

        if ($criteria->containsKey(BeneficioTableMap::COL_ID) && $criteria->keyContainsValue(BeneficioTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BeneficioTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = BeneficioQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BeneficioTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BeneficioTableMap::buildTableMap();
