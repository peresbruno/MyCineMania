<?php

namespace Map;

use \Usuario;
use \UsuarioQuery;
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
 * This class defines the structure of the 'usuarios' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UsuarioTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.UsuarioTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'my_cine_mania';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'usuarios';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Usuario';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Usuario';

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
    const COL_ID = 'usuarios.id';

    /**
     * the column name for the data_inscricao field
     */
    const COL_DATA_INSCRICAO = 'usuarios.data_inscricao';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'usuarios.email';

    /**
     * the column name for the liberado field
     */
    const COL_LIBERADO = 'usuarios.liberado';

    /**
     * the column name for the nome_usuario field
     */
    const COL_NOME_USUARIO = 'usuarios.nome_usuario';

    /**
     * the column name for the senha field
     */
    const COL_SENHA = 'usuarios.senha';

    /**
     * the column name for the tipo field
     */
    const COL_TIPO = 'usuarios.tipo';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the tipo field */
    const COL_TIPO_PARTICIPANTE = 'participante';
    const COL_TIPO_REDE_CINEMA = 'rede_cinema';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'DataInscricao', 'Email', 'Liberado', 'NomeUsuario', 'Senha', 'Tipo', ),
        self::TYPE_CAMELNAME     => array('id', 'dataInscricao', 'email', 'liberado', 'nomeUsuario', 'senha', 'tipo', ),
        self::TYPE_COLNAME       => array(UsuarioTableMap::COL_ID, UsuarioTableMap::COL_DATA_INSCRICAO, UsuarioTableMap::COL_EMAIL, UsuarioTableMap::COL_LIBERADO, UsuarioTableMap::COL_NOME_USUARIO, UsuarioTableMap::COL_SENHA, UsuarioTableMap::COL_TIPO, ),
        self::TYPE_FIELDNAME     => array('id', 'data_inscricao', 'email', 'liberado', 'nome_usuario', 'senha', 'tipo', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'DataInscricao' => 1, 'Email' => 2, 'Liberado' => 3, 'NomeUsuario' => 4, 'Senha' => 5, 'Tipo' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'dataInscricao' => 1, 'email' => 2, 'liberado' => 3, 'nomeUsuario' => 4, 'senha' => 5, 'tipo' => 6, ),
        self::TYPE_COLNAME       => array(UsuarioTableMap::COL_ID => 0, UsuarioTableMap::COL_DATA_INSCRICAO => 1, UsuarioTableMap::COL_EMAIL => 2, UsuarioTableMap::COL_LIBERADO => 3, UsuarioTableMap::COL_NOME_USUARIO => 4, UsuarioTableMap::COL_SENHA => 5, UsuarioTableMap::COL_TIPO => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'data_inscricao' => 1, 'email' => 2, 'liberado' => 3, 'nome_usuario' => 4, 'senha' => 5, 'tipo' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                UsuarioTableMap::COL_TIPO => array(
                            self::COL_TIPO_PARTICIPANTE,
            self::COL_TIPO_REDE_CINEMA,
        ),
    );

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return static::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM column
     * @param string $colname
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = self::getValueSets();

        return $valueSets[$colname];
    }

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
        $this->setName('usuarios');
        $this->setPhpName('Usuario');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Usuario');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('usuarios_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('data_inscricao', 'DataInscricao', 'DATE', true, null, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 255, null);
        $this->addColumn('liberado', 'Liberado', 'BOOLEAN', true, null, false);
        $this->addColumn('nome_usuario', 'NomeUsuario', 'VARCHAR', true, 255, null);
        $this->addColumn('senha', 'Senha', 'VARCHAR', true, 255, null);
        $this->addColumn('tipo', 'Tipo', 'ENUM', true, null, null);
        $this->getColumn('tipo')->setValueSet(array (
  0 => 'participante',
  1 => 'rede_cinema',
));
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Participante', '\\Participante', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':usuario_id',
    1 => ':id',
  ),
), null, null, 'Participantes', false);
        $this->addRelation('RedeCinema', '\\RedeCinema', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':usuario_id',
    1 => ':id',
  ),
), null, null, 'RedeCinemas', false);
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
            'validate' => array('rule1' => array ('column' => 'email','validator' => 'Unique',), 'rule2' => array ('column' => 'nome_usuario','validator' => 'Unique',), ),
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
        return $withPrefix ? UsuarioTableMap::CLASS_DEFAULT : UsuarioTableMap::OM_CLASS;
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
     * @return array           (Usuario object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UsuarioTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UsuarioTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UsuarioTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UsuarioTableMap::OM_CLASS;
            /** @var Usuario $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UsuarioTableMap::addInstanceToPool($obj, $key);
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
            $key = UsuarioTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UsuarioTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Usuario $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UsuarioTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UsuarioTableMap::COL_ID);
            $criteria->addSelectColumn(UsuarioTableMap::COL_DATA_INSCRICAO);
            $criteria->addSelectColumn(UsuarioTableMap::COL_EMAIL);
            $criteria->addSelectColumn(UsuarioTableMap::COL_LIBERADO);
            $criteria->addSelectColumn(UsuarioTableMap::COL_NOME_USUARIO);
            $criteria->addSelectColumn(UsuarioTableMap::COL_SENHA);
            $criteria->addSelectColumn(UsuarioTableMap::COL_TIPO);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.data_inscricao');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.liberado');
            $criteria->addSelectColumn($alias . '.nome_usuario');
            $criteria->addSelectColumn($alias . '.senha');
            $criteria->addSelectColumn($alias . '.tipo');
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
        return Propel::getServiceContainer()->getDatabaseMap(UsuarioTableMap::DATABASE_NAME)->getTable(UsuarioTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UsuarioTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UsuarioTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UsuarioTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Usuario or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Usuario object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UsuarioTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Usuario) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UsuarioTableMap::DATABASE_NAME);
            $criteria->add(UsuarioTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = UsuarioQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UsuarioTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UsuarioTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the usuarios table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UsuarioQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Usuario or Criteria object.
     *
     * @param mixed               $criteria Criteria or Usuario object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsuarioTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Usuario object
        }

        if ($criteria->containsKey(UsuarioTableMap::COL_ID) && $criteria->keyContainsValue(UsuarioTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UsuarioTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = UsuarioQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UsuarioTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UsuarioTableMap::buildTableMap();
