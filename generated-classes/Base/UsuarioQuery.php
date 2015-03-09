<?php

namespace Base;

use \Usuario as ChildUsuario;
use \UsuarioQuery as ChildUsuarioQuery;
use \Exception;
use \PDO;
use Map\UsuarioTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'usuarios' table.
 *
 *
 *
 * @method     ChildUsuarioQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUsuarioQuery orderByDataInscricao($order = Criteria::ASC) Order by the data_inscricao column
 * @method     ChildUsuarioQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUsuarioQuery orderByLiberado($order = Criteria::ASC) Order by the liberado column
 * @method     ChildUsuarioQuery orderByNomeUsuario($order = Criteria::ASC) Order by the nome_usuario column
 * @method     ChildUsuarioQuery orderBySenha($order = Criteria::ASC) Order by the senha column
 *
 * @method     ChildUsuarioQuery groupById() Group by the id column
 * @method     ChildUsuarioQuery groupByDataInscricao() Group by the data_inscricao column
 * @method     ChildUsuarioQuery groupByEmail() Group by the email column
 * @method     ChildUsuarioQuery groupByLiberado() Group by the liberado column
 * @method     ChildUsuarioQuery groupByNomeUsuario() Group by the nome_usuario column
 * @method     ChildUsuarioQuery groupBySenha() Group by the senha column
 *
 * @method     ChildUsuarioQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUsuarioQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUsuarioQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUsuarioQuery leftJoinParticipante($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participante relation
 * @method     ChildUsuarioQuery rightJoinParticipante($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participante relation
 * @method     ChildUsuarioQuery innerJoinParticipante($relationAlias = null) Adds a INNER JOIN clause to the query using the Participante relation
 *
 * @method     ChildUsuarioQuery leftJoinUsuarioRedeCinema($relationAlias = null) Adds a LEFT JOIN clause to the query using the UsuarioRedeCinema relation
 * @method     ChildUsuarioQuery rightJoinUsuarioRedeCinema($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UsuarioRedeCinema relation
 * @method     ChildUsuarioQuery innerJoinUsuarioRedeCinema($relationAlias = null) Adds a INNER JOIN clause to the query using the UsuarioRedeCinema relation
 *
 * @method     \ParticipanteQuery|\UsuarioRedeCinemaQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUsuario findOne(ConnectionInterface $con = null) Return the first ChildUsuario matching the query
 * @method     ChildUsuario findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUsuario matching the query, or a new ChildUsuario object populated from the query conditions when no match is found
 *
 * @method     ChildUsuario findOneById(int $id) Return the first ChildUsuario filtered by the id column
 * @method     ChildUsuario findOneByDataInscricao(string $data_inscricao) Return the first ChildUsuario filtered by the data_inscricao column
 * @method     ChildUsuario findOneByEmail(string $email) Return the first ChildUsuario filtered by the email column
 * @method     ChildUsuario findOneByLiberado(boolean $liberado) Return the first ChildUsuario filtered by the liberado column
 * @method     ChildUsuario findOneByNomeUsuario(string $nome_usuario) Return the first ChildUsuario filtered by the nome_usuario column
 * @method     ChildUsuario findOneBySenha(string $senha) Return the first ChildUsuario filtered by the senha column *

 * @method     ChildUsuario requirePk($key, ConnectionInterface $con = null) Return the ChildUsuario by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsuario requireOne(ConnectionInterface $con = null) Return the first ChildUsuario matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUsuario requireOneById(int $id) Return the first ChildUsuario filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsuario requireOneByDataInscricao(string $data_inscricao) Return the first ChildUsuario filtered by the data_inscricao column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsuario requireOneByEmail(string $email) Return the first ChildUsuario filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsuario requireOneByLiberado(boolean $liberado) Return the first ChildUsuario filtered by the liberado column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsuario requireOneByNomeUsuario(string $nome_usuario) Return the first ChildUsuario filtered by the nome_usuario column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsuario requireOneBySenha(string $senha) Return the first ChildUsuario filtered by the senha column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUsuario[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUsuario objects based on current ModelCriteria
 * @method     ChildUsuario[]|ObjectCollection findById(int $id) Return ChildUsuario objects filtered by the id column
 * @method     ChildUsuario[]|ObjectCollection findByDataInscricao(string $data_inscricao) Return ChildUsuario objects filtered by the data_inscricao column
 * @method     ChildUsuario[]|ObjectCollection findByEmail(string $email) Return ChildUsuario objects filtered by the email column
 * @method     ChildUsuario[]|ObjectCollection findByLiberado(boolean $liberado) Return ChildUsuario objects filtered by the liberado column
 * @method     ChildUsuario[]|ObjectCollection findByNomeUsuario(string $nome_usuario) Return ChildUsuario objects filtered by the nome_usuario column
 * @method     ChildUsuario[]|ObjectCollection findBySenha(string $senha) Return ChildUsuario objects filtered by the senha column
 * @method     ChildUsuario[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UsuarioQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UsuarioQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'my_cine_mania', $modelName = '\\Usuario', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUsuarioQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUsuarioQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUsuarioQuery) {
            return $criteria;
        }
        $query = new ChildUsuarioQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildUsuario|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UsuarioTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UsuarioTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUsuario A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, data_inscricao, email, liberado, nome_usuario, senha FROM usuarios WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildUsuario $obj */
            $obj = new ChildUsuario();
            $obj->hydrate($row);
            UsuarioTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildUsuario|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UsuarioTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UsuarioTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UsuarioTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UsuarioTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsuarioTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the data_inscricao column
     *
     * Example usage:
     * <code>
     * $query->filterByDataInscricao('2011-03-14'); // WHERE data_inscricao = '2011-03-14'
     * $query->filterByDataInscricao('now'); // WHERE data_inscricao = '2011-03-14'
     * $query->filterByDataInscricao(array('max' => 'yesterday')); // WHERE data_inscricao > '2011-03-13'
     * </code>
     *
     * @param     mixed $dataInscricao The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function filterByDataInscricao($dataInscricao = null, $comparison = null)
    {
        if (is_array($dataInscricao)) {
            $useMinMax = false;
            if (isset($dataInscricao['min'])) {
                $this->addUsingAlias(UsuarioTableMap::COL_DATA_INSCRICAO, $dataInscricao['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataInscricao['max'])) {
                $this->addUsingAlias(UsuarioTableMap::COL_DATA_INSCRICAO, $dataInscricao['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsuarioTableMap::COL_DATA_INSCRICAO, $dataInscricao, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UsuarioTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the liberado column
     *
     * Example usage:
     * <code>
     * $query->filterByLiberado(true); // WHERE liberado = true
     * $query->filterByLiberado('yes'); // WHERE liberado = true
     * </code>
     *
     * @param     boolean|string $liberado The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function filterByLiberado($liberado = null, $comparison = null)
    {
        if (is_string($liberado)) {
            $liberado = in_array(strtolower($liberado), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UsuarioTableMap::COL_LIBERADO, $liberado, $comparison);
    }

    /**
     * Filter the query on the nome_usuario column
     *
     * Example usage:
     * <code>
     * $query->filterByNomeUsuario('fooValue');   // WHERE nome_usuario = 'fooValue'
     * $query->filterByNomeUsuario('%fooValue%'); // WHERE nome_usuario LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nomeUsuario The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function filterByNomeUsuario($nomeUsuario = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nomeUsuario)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nomeUsuario)) {
                $nomeUsuario = str_replace('*', '%', $nomeUsuario);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UsuarioTableMap::COL_NOME_USUARIO, $nomeUsuario, $comparison);
    }

    /**
     * Filter the query on the senha column
     *
     * Example usage:
     * <code>
     * $query->filterBySenha('fooValue');   // WHERE senha = 'fooValue'
     * $query->filterBySenha('%fooValue%'); // WHERE senha LIKE '%fooValue%'
     * </code>
     *
     * @param     string $senha The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function filterBySenha($senha = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($senha)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $senha)) {
                $senha = str_replace('*', '%', $senha);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UsuarioTableMap::COL_SENHA, $senha, $comparison);
    }

    /**
     * Filter the query by a related \Participante object
     *
     * @param \Participante|ObjectCollection $participante the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsuarioQuery The current query, for fluid interface
     */
    public function filterByParticipante($participante, $comparison = null)
    {
        if ($participante instanceof \Participante) {
            return $this
                ->addUsingAlias(UsuarioTableMap::COL_ID, $participante->getUsuarioId(), $comparison);
        } elseif ($participante instanceof ObjectCollection) {
            return $this
                ->useParticipanteQuery()
                ->filterByPrimaryKeys($participante->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByParticipante() only accepts arguments of type \Participante or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Participante relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function joinParticipante($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Participante');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Participante');
        }

        return $this;
    }

    /**
     * Use the Participante relation Participante object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ParticipanteQuery A secondary query class using the current class as primary query
     */
    public function useParticipanteQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinParticipante($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Participante', '\ParticipanteQuery');
    }

    /**
     * Filter the query by a related \UsuarioRedeCinema object
     *
     * @param \UsuarioRedeCinema|ObjectCollection $usuarioRedeCinema the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsuarioQuery The current query, for fluid interface
     */
    public function filterByUsuarioRedeCinema($usuarioRedeCinema, $comparison = null)
    {
        if ($usuarioRedeCinema instanceof \UsuarioRedeCinema) {
            return $this
                ->addUsingAlias(UsuarioTableMap::COL_ID, $usuarioRedeCinema->getUsuarioId(), $comparison);
        } elseif ($usuarioRedeCinema instanceof ObjectCollection) {
            return $this
                ->useUsuarioRedeCinemaQuery()
                ->filterByPrimaryKeys($usuarioRedeCinema->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUsuarioRedeCinema() only accepts arguments of type \UsuarioRedeCinema or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UsuarioRedeCinema relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function joinUsuarioRedeCinema($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UsuarioRedeCinema');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UsuarioRedeCinema');
        }

        return $this;
    }

    /**
     * Use the UsuarioRedeCinema relation UsuarioRedeCinema object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsuarioRedeCinemaQuery A secondary query class using the current class as primary query
     */
    public function useUsuarioRedeCinemaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsuarioRedeCinema($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UsuarioRedeCinema', '\UsuarioRedeCinemaQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUsuario $usuario Object to remove from the list of results
     *
     * @return $this|ChildUsuarioQuery The current query, for fluid interface
     */
    public function prune($usuario = null)
    {
        if ($usuario) {
            $this->addUsingAlias(UsuarioTableMap::COL_ID, $usuario->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the usuarios table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsuarioTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UsuarioTableMap::clearInstancePool();
            UsuarioTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsuarioTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UsuarioTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UsuarioTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UsuarioTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UsuarioQuery
