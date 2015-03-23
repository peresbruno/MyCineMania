<?php

namespace Map;

use \RedeCinema;
use \RedeCinemaQuery;
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
 * This class defines the structure of the 'redes_cinema' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class RedeCinemaTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.RedeCinemaTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'my_cine_mania';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'redes_cinema';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\RedeCinema';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'RedeCinema';

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
    const COL_ID = 'redes_cinema.id';

    /**
     * the column name for the cnpj field
     */
    const COL_CNPJ = 'redes_cinema.cnpj';

    /**
     * the column name for the usuario_id field
     */
    const COL_USUARIO_ID = 'redes_cinema.usuario_id';

    /**
     * the column name for the nome_fantasia field
     */
    const COL_NOME_FANTASIA = 'redes_cinema.nome_fantasia';

    /**
     * the column name for the razao_social field
     */
    const COL_RAZAO_SOCIAL = 'redes_cinema.razao_social';

    /**
     * the column name for the endereco field
     */
    const COL_ENDERECO = 'redes_cinema.endereco';

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
        self::TYPE_PHPNAME       => array('Id', 'Cnpj', 'UsuarioId', 'NomeFantasia', 'RazaoSocial', 'Endereco', ),
        self::TYPE_CAMELNAME     => array('id', 'cnpj', 'usuarioId', 'nomeFantasia', 'razaoSocial', 'endereco', ),
        self::TYPE_COLNAME       => array(RedeCinemaTableMap::COL_ID, RedeCinemaTableMap::COL_CNPJ, RedeCinemaTableMap::COL_USUARIO_ID, RedeCinemaTableMap::COL_NOME_FANTASIA, RedeCinemaTableMap::COL_RAZAO_SOCIAL, RedeCinemaTableMap::COL_ENDERECO, ),
        self::TYPE_FIELDNAME     => array('id', 'cnpj', 'usuario_id', 'nome_fantasia', 'razao_social', 'endereco', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Cnpj' => 1, 'UsuarioId' => 2, 'NomeFantasia' => 3, 'RazaoSocial' => 4, 'Endereco' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'cnpj' => 1, 'usuarioId' => 2, 'nomeFantasia' => 3, 'razaoSocial' => 4, 'endereco' => 5, ),
        self::TYPE_COLNAME       => array(RedeCinemaTableMap::COL_ID => 0, RedeCinemaTableMap::COL_CNPJ => 1, RedeCinemaTableMap::COL_USUARIO_ID => 2, RedeCinemaTableMap::COL_NOME_FANTASIA => 3, RedeCinemaTableMap::COL_RAZAO_SOCIAL => 4, RedeCinemaTableMap::COL_ENDERECO => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'cnpj' => 1, 'usuario_id' => 2, 'nome_fantasia' => 3, 'razao_social' => 4, 'endereco' => 5, ),
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
        $this->setName('redes_cinema');
        $this->setPhpName('RedeCinema');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\RedeCinema');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('redes_cinema_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('cnpj', 'Cnpj', 'VARCHAR', true, 50, null);
        $this->addForeignKey('usuario_id', 'UsuarioId', 'INTEGER', 'usuarios', 'id', true, null, null);
        $this->addColumn('nome_fantasia', 'NomeFantasia', 'VARCHAR', true, 255, null);
        $this->addColumn('razao_social', 'RazaoSocial', 'VARCHAR', true, 255, null);
        $this->addColumn('endereco', 'Endereco', 'LONGVARCHAR', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Usuario', '\\Usuario', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':usuario_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Beneficio', '\\Beneficio', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':rede_cinema_id',
    1 => ':id',
  ),
), null, null, 'Beneficios', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'delegate' => array('to' => 'usuarios', ),
        );
    } // getBehaviors()

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
        return $withPrefix ? RedeCinemaTableMap::CLASS_DEFAULT : RedeCinemaTableMap::OM_CLASS;
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
     * @return array           (RedeCinema object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RedeCinemaTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RedeCinemaTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RedeCinemaTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RedeCinemaTableMap::OM_CLASS;
            /** @var RedeCinema $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RedeCinemaTableMap::addInstanceToPool($obj, $key);
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
            $key = RedeCinemaTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RedeCinemaTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var RedeCinema $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RedeCinemaTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(RedeCinemaTableMap::COL_ID);
            $criteria->addSelectColumn(RedeCinemaTableMap::COL_CNPJ);
            $criteria->addSelectColumn(RedeCinemaTableMap::COL_USUARIO_ID);
            $criteria->addSelectColumn(RedeCinemaTableMap::COL_NOME_FANTASIA);
            $criteria->addSelectColumn(RedeCinemaTableMap::COL_RAZAO_SOCIAL);
            $criteria->addSelectColumn(RedeCinemaTableMap::COL_ENDERECO);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.cnpj');
            $criteria->addSelectColumn($alias . '.usuario_id');
            $criteria->addSelectColumn($alias . '.nome_fantasia');
            $criteria->addSelectColumn($alias . '.razao_social');
            $criteria->addSelectColumn($alias . '.endereco');
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
        return Propel::getServiceContainer()->getDatabaseMap(RedeCinemaTableMap::DATABASE_NAME)->getTable(RedeCinemaTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RedeCinemaTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RedeCinemaTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RedeCinemaTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a RedeCinema or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or RedeCinema object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(RedeCinemaTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \RedeCinema) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RedeCinemaTableMap::DATABASE_NAME);
            $criteria->add(RedeCinemaTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = RedeCinemaQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RedeCinemaTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RedeCinemaTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the redes_cinema table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RedeCinemaQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a RedeCinema or Criteria object.
     *
     * @param mixed               $criteria Criteria or RedeCinema object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RedeCinemaTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from RedeCinema object
        }

        if ($criteria->containsKey(RedeCinemaTableMap::COL_ID) && $criteria->keyContainsValue(RedeCinemaTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RedeCinemaTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = RedeCinemaQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RedeCinemaTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RedeCinemaTableMap::buildTableMap();
