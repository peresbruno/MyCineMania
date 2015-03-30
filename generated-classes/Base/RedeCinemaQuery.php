<?php

namespace Base;

use \RedeCinema as ChildRedeCinema;
use \RedeCinemaQuery as ChildRedeCinemaQuery;
use \Exception;
use \PDO;
use Map\RedeCinemaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'redes_cinema' table.
 *
 *
 *
 * @method     ChildRedeCinemaQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRedeCinemaQuery orderByCnpj($order = Criteria::ASC) Order by the cnpj column
 * @method     ChildRedeCinemaQuery orderByUsuarioId($order = Criteria::ASC) Order by the usuario_id column
 * @method     ChildRedeCinemaQuery orderByNomeFantasia($order = Criteria::ASC) Order by the nome_fantasia column
 * @method     ChildRedeCinemaQuery orderByRazaoSocial($order = Criteria::ASC) Order by the razao_social column
 * @method     ChildRedeCinemaQuery orderByEndereco($order = Criteria::ASC) Order by the endereco column
 *
 * @method     ChildRedeCinemaQuery groupById() Group by the id column
 * @method     ChildRedeCinemaQuery groupByCnpj() Group by the cnpj column
 * @method     ChildRedeCinemaQuery groupByUsuarioId() Group by the usuario_id column
 * @method     ChildRedeCinemaQuery groupByNomeFantasia() Group by the nome_fantasia column
 * @method     ChildRedeCinemaQuery groupByRazaoSocial() Group by the razao_social column
 * @method     ChildRedeCinemaQuery groupByEndereco() Group by the endereco column
 *
 * @method     ChildRedeCinemaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRedeCinemaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRedeCinemaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRedeCinemaQuery leftJoinUsuario($relationAlias = null) Adds a LEFT JOIN clause to the query using the Usuario relation
 * @method     ChildRedeCinemaQuery rightJoinUsuario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Usuario relation
 * @method     ChildRedeCinemaQuery innerJoinUsuario($relationAlias = null) Adds a INNER JOIN clause to the query using the Usuario relation
 *
 * @method     ChildRedeCinemaQuery leftJoinBeneficio($relationAlias = null) Adds a LEFT JOIN clause to the query using the Beneficio relation
 * @method     ChildRedeCinemaQuery rightJoinBeneficio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Beneficio relation
 * @method     ChildRedeCinemaQuery innerJoinBeneficio($relationAlias = null) Adds a INNER JOIN clause to the query using the Beneficio relation
 *
 * @method     \UsuarioQuery|\BeneficioQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRedeCinema findOne(ConnectionInterface $con = null) Return the first ChildRedeCinema matching the query
 * @method     ChildRedeCinema findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRedeCinema matching the query, or a new ChildRedeCinema object populated from the query conditions when no match is found
 *
 * @method     ChildRedeCinema findOneById(int $id) Return the first ChildRedeCinema filtered by the id column
 * @method     ChildRedeCinema findOneByCnpj(string $cnpj) Return the first ChildRedeCinema filtered by the cnpj column
 * @method     ChildRedeCinema findOneByUsuarioId(int $usuario_id) Return the first ChildRedeCinema filtered by the usuario_id column
 * @method     ChildRedeCinema findOneByNomeFantasia(string $nome_fantasia) Return the first ChildRedeCinema filtered by the nome_fantasia column
 * @method     ChildRedeCinema findOneByRazaoSocial(string $razao_social) Return the first ChildRedeCinema filtered by the razao_social column
 * @method     ChildRedeCinema findOneByEndereco(string $endereco) Return the first ChildRedeCinema filtered by the endereco column *

 * @method     ChildRedeCinema requirePk($key, ConnectionInterface $con = null) Return the ChildRedeCinema by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRedeCinema requireOne(ConnectionInterface $con = null) Return the first ChildRedeCinema matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRedeCinema requireOneById(int $id) Return the first ChildRedeCinema filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRedeCinema requireOneByCnpj(string $cnpj) Return the first ChildRedeCinema filtered by the cnpj column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRedeCinema requireOneByUsuarioId(int $usuario_id) Return the first ChildRedeCinema filtered by the usuario_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRedeCinema requireOneByNomeFantasia(string $nome_fantasia) Return the first ChildRedeCinema filtered by the nome_fantasia column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRedeCinema requireOneByRazaoSocial(string $razao_social) Return the first ChildRedeCinema filtered by the razao_social column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRedeCinema requireOneByEndereco(string $endereco) Return the first ChildRedeCinema filtered by the endereco column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRedeCinema[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRedeCinema objects based on current ModelCriteria
 * @method     ChildRedeCinema[]|ObjectCollection findById(int $id) Return ChildRedeCinema objects filtered by the id column
 * @method     ChildRedeCinema[]|ObjectCollection findByCnpj(string $cnpj) Return ChildRedeCinema objects filtered by the cnpj column
 * @method     ChildRedeCinema[]|ObjectCollection findByUsuarioId(int $usuario_id) Return ChildRedeCinema objects filtered by the usuario_id column
 * @method     ChildRedeCinema[]|ObjectCollection findByNomeFantasia(string $nome_fantasia) Return ChildRedeCinema objects filtered by the nome_fantasia column
 * @method     ChildRedeCinema[]|ObjectCollection findByRazaoSocial(string $razao_social) Return ChildRedeCinema objects filtered by the razao_social column
 * @method     ChildRedeCinema[]|ObjectCollection findByEndereco(string $endereco) Return ChildRedeCinema objects filtered by the endereco column
 * @method     ChildRedeCinema[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RedeCinemaQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RedeCinemaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'my_cine_mania', $modelName = '\\RedeCinema', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRedeCinemaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRedeCinemaQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRedeCinemaQuery) {
            return $criteria;
        }
        $query = new ChildRedeCinemaQuery();
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
     * @return ChildRedeCinema|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RedeCinemaTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RedeCinemaTableMap::DATABASE_NAME);
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
     * @return ChildRedeCinema A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, cnpj, usuario_id, nome_fantasia, razao_social, endereco FROM redes_cinema WHERE id = :p0';
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
            /** @var ChildRedeCinema $obj */
            $obj = new ChildRedeCinema();
            $obj->hydrate($row);
            RedeCinemaTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRedeCinema|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RedeCinemaTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RedeCinemaTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RedeCinemaTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RedeCinemaTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RedeCinemaTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the cnpj column
     *
     * Example usage:
     * <code>
     * $query->filterByCnpj('fooValue');   // WHERE cnpj = 'fooValue'
     * $query->filterByCnpj('%fooValue%'); // WHERE cnpj LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cnpj The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function filterByCnpj($cnpj = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cnpj)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cnpj)) {
                $cnpj = str_replace('*', '%', $cnpj);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RedeCinemaTableMap::COL_CNPJ, $cnpj, $comparison);
    }

    /**
     * Filter the query on the usuario_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUsuarioId(1234); // WHERE usuario_id = 1234
     * $query->filterByUsuarioId(array(12, 34)); // WHERE usuario_id IN (12, 34)
     * $query->filterByUsuarioId(array('min' => 12)); // WHERE usuario_id > 12
     * </code>
     *
     * @see       filterByUsuario()
     *
     * @param     mixed $usuarioId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function filterByUsuarioId($usuarioId = null, $comparison = null)
    {
        if (is_array($usuarioId)) {
            $useMinMax = false;
            if (isset($usuarioId['min'])) {
                $this->addUsingAlias(RedeCinemaTableMap::COL_USUARIO_ID, $usuarioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($usuarioId['max'])) {
                $this->addUsingAlias(RedeCinemaTableMap::COL_USUARIO_ID, $usuarioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RedeCinemaTableMap::COL_USUARIO_ID, $usuarioId, $comparison);
    }

    /**
     * Filter the query on the nome_fantasia column
     *
     * Example usage:
     * <code>
     * $query->filterByNomeFantasia('fooValue');   // WHERE nome_fantasia = 'fooValue'
     * $query->filterByNomeFantasia('%fooValue%'); // WHERE nome_fantasia LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nomeFantasia The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function filterByNomeFantasia($nomeFantasia = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nomeFantasia)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nomeFantasia)) {
                $nomeFantasia = str_replace('*', '%', $nomeFantasia);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RedeCinemaTableMap::COL_NOME_FANTASIA, $nomeFantasia, $comparison);
    }

    /**
     * Filter the query on the razao_social column
     *
     * Example usage:
     * <code>
     * $query->filterByRazaoSocial('fooValue');   // WHERE razao_social = 'fooValue'
     * $query->filterByRazaoSocial('%fooValue%'); // WHERE razao_social LIKE '%fooValue%'
     * </code>
     *
     * @param     string $razaoSocial The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function filterByRazaoSocial($razaoSocial = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($razaoSocial)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $razaoSocial)) {
                $razaoSocial = str_replace('*', '%', $razaoSocial);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RedeCinemaTableMap::COL_RAZAO_SOCIAL, $razaoSocial, $comparison);
    }

    /**
     * Filter the query on the endereco column
     *
     * Example usage:
     * <code>
     * $query->filterByEndereco('fooValue');   // WHERE endereco = 'fooValue'
     * $query->filterByEndereco('%fooValue%'); // WHERE endereco LIKE '%fooValue%'
     * </code>
     *
     * @param     string $endereco The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function filterByEndereco($endereco = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($endereco)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $endereco)) {
                $endereco = str_replace('*', '%', $endereco);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RedeCinemaTableMap::COL_ENDERECO, $endereco, $comparison);
    }

    /**
     * Filter the query by a related \Usuario object
     *
     * @param \Usuario|ObjectCollection $usuario The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function filterByUsuario($usuario, $comparison = null)
    {
        if ($usuario instanceof \Usuario) {
            return $this
                ->addUsingAlias(RedeCinemaTableMap::COL_USUARIO_ID, $usuario->getId(), $comparison);
        } elseif ($usuario instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RedeCinemaTableMap::COL_USUARIO_ID, $usuario->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUsuario() only accepts arguments of type \Usuario or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Usuario relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function joinUsuario($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Usuario');

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
            $this->addJoinObject($join, 'Usuario');
        }

        return $this;
    }

    /**
     * Use the Usuario relation Usuario object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsuarioQuery A secondary query class using the current class as primary query
     */
    public function useUsuarioQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsuario($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Usuario', '\UsuarioQuery');
    }

    /**
     * Filter the query by a related \Beneficio object
     *
     * @param \Beneficio|ObjectCollection $beneficio the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function filterByBeneficio($beneficio, $comparison = null)
    {
        if ($beneficio instanceof \Beneficio) {
            return $this
                ->addUsingAlias(RedeCinemaTableMap::COL_ID, $beneficio->getRedeCinemaId(), $comparison);
        } elseif ($beneficio instanceof ObjectCollection) {
            return $this
                ->useBeneficioQuery()
                ->filterByPrimaryKeys($beneficio->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBeneficio() only accepts arguments of type \Beneficio or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Beneficio relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function joinBeneficio($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Beneficio');

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
            $this->addJoinObject($join, 'Beneficio');
        }

        return $this;
    }

    /**
     * Use the Beneficio relation Beneficio object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BeneficioQuery A secondary query class using the current class as primary query
     */
    public function useBeneficioQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBeneficio($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Beneficio', '\BeneficioQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRedeCinema $redeCinema Object to remove from the list of results
     *
     * @return $this|ChildRedeCinemaQuery The current query, for fluid interface
     */
    public function prune($redeCinema = null)
    {
        if ($redeCinema) {
            $this->addUsingAlias(RedeCinemaTableMap::COL_ID, $redeCinema->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the redes_cinema table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RedeCinemaTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RedeCinemaTableMap::clearInstancePool();
            RedeCinemaTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RedeCinemaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RedeCinemaTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RedeCinemaTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RedeCinemaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RedeCinemaQuery
