<?php

namespace Base;

use \Beneficio as ChildBeneficio;
use \BeneficioQuery as ChildBeneficioQuery;
use \Exception;
use \PDO;
use Map\BeneficioTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'beneficios' table.
 *
 *
 *
 * @method     ChildBeneficioQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBeneficioQuery orderByRedeCinemaId($order = Criteria::ASC) Order by the rede_cinema_id column
 * @method     ChildBeneficioQuery orderByTitulo($order = Criteria::ASC) Order by the titulo column
 * @method     ChildBeneficioQuery orderByInicioValidade($order = Criteria::ASC) Order by the inicio_validade column
 * @method     ChildBeneficioQuery orderByFimValidade($order = Criteria::ASC) Order by the fim_validade column
 * @method     ChildBeneficioQuery orderByDescricao($order = Criteria::ASC) Order by the descricao column
 * @method     ChildBeneficioQuery orderByCondicoes($order = Criteria::ASC) Order by the condicoes column
 *
 * @method     ChildBeneficioQuery groupById() Group by the id column
 * @method     ChildBeneficioQuery groupByRedeCinemaId() Group by the rede_cinema_id column
 * @method     ChildBeneficioQuery groupByTitulo() Group by the titulo column
 * @method     ChildBeneficioQuery groupByInicioValidade() Group by the inicio_validade column
 * @method     ChildBeneficioQuery groupByFimValidade() Group by the fim_validade column
 * @method     ChildBeneficioQuery groupByDescricao() Group by the descricao column
 * @method     ChildBeneficioQuery groupByCondicoes() Group by the condicoes column
 *
 * @method     ChildBeneficioQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBeneficioQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBeneficioQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBeneficioQuery leftJoinRedeCinema($relationAlias = null) Adds a LEFT JOIN clause to the query using the RedeCinema relation
 * @method     ChildBeneficioQuery rightJoinRedeCinema($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RedeCinema relation
 * @method     ChildBeneficioQuery innerJoinRedeCinema($relationAlias = null) Adds a INNER JOIN clause to the query using the RedeCinema relation
 *
 * @method     ChildBeneficioQuery leftJoinBeneficiosPreferencias($relationAlias = null) Adds a LEFT JOIN clause to the query using the BeneficiosPreferencias relation
 * @method     ChildBeneficioQuery rightJoinBeneficiosPreferencias($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BeneficiosPreferencias relation
 * @method     ChildBeneficioQuery innerJoinBeneficiosPreferencias($relationAlias = null) Adds a INNER JOIN clause to the query using the BeneficiosPreferencias relation
 *
 * @method     ChildBeneficioQuery leftJoinParticipantesPreferencias($relationAlias = null) Adds a LEFT JOIN clause to the query using the ParticipantesPreferencias relation
 * @method     ChildBeneficioQuery rightJoinParticipantesPreferencias($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ParticipantesPreferencias relation
 * @method     ChildBeneficioQuery innerJoinParticipantesPreferencias($relationAlias = null) Adds a INNER JOIN clause to the query using the ParticipantesPreferencias relation
 *
 * @method     ChildBeneficioQuery leftJoinVoucher($relationAlias = null) Adds a LEFT JOIN clause to the query using the Voucher relation
 * @method     ChildBeneficioQuery rightJoinVoucher($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Voucher relation
 * @method     ChildBeneficioQuery innerJoinVoucher($relationAlias = null) Adds a INNER JOIN clause to the query using the Voucher relation
 *
 * @method     \RedeCinemaQuery|\BeneficiosPreferenciasQuery|\ParticipantesPreferenciasQuery|\VoucherQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBeneficio findOne(ConnectionInterface $con = null) Return the first ChildBeneficio matching the query
 * @method     ChildBeneficio findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBeneficio matching the query, or a new ChildBeneficio object populated from the query conditions when no match is found
 *
 * @method     ChildBeneficio findOneById(int $id) Return the first ChildBeneficio filtered by the id column
 * @method     ChildBeneficio findOneByRedeCinemaId(int $rede_cinema_id) Return the first ChildBeneficio filtered by the rede_cinema_id column
 * @method     ChildBeneficio findOneByTitulo(string $titulo) Return the first ChildBeneficio filtered by the titulo column
 * @method     ChildBeneficio findOneByInicioValidade(string $inicio_validade) Return the first ChildBeneficio filtered by the inicio_validade column
 * @method     ChildBeneficio findOneByFimValidade(string $fim_validade) Return the first ChildBeneficio filtered by the fim_validade column
 * @method     ChildBeneficio findOneByDescricao(string $descricao) Return the first ChildBeneficio filtered by the descricao column
 * @method     ChildBeneficio findOneByCondicoes(string $condicoes) Return the first ChildBeneficio filtered by the condicoes column *

 * @method     ChildBeneficio requirePk($key, ConnectionInterface $con = null) Return the ChildBeneficio by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBeneficio requireOne(ConnectionInterface $con = null) Return the first ChildBeneficio matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBeneficio requireOneById(int $id) Return the first ChildBeneficio filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBeneficio requireOneByRedeCinemaId(int $rede_cinema_id) Return the first ChildBeneficio filtered by the rede_cinema_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBeneficio requireOneByTitulo(string $titulo) Return the first ChildBeneficio filtered by the titulo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBeneficio requireOneByInicioValidade(string $inicio_validade) Return the first ChildBeneficio filtered by the inicio_validade column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBeneficio requireOneByFimValidade(string $fim_validade) Return the first ChildBeneficio filtered by the fim_validade column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBeneficio requireOneByDescricao(string $descricao) Return the first ChildBeneficio filtered by the descricao column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBeneficio requireOneByCondicoes(string $condicoes) Return the first ChildBeneficio filtered by the condicoes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBeneficio[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBeneficio objects based on current ModelCriteria
 * @method     ChildBeneficio[]|ObjectCollection findById(int $id) Return ChildBeneficio objects filtered by the id column
 * @method     ChildBeneficio[]|ObjectCollection findByRedeCinemaId(int $rede_cinema_id) Return ChildBeneficio objects filtered by the rede_cinema_id column
 * @method     ChildBeneficio[]|ObjectCollection findByTitulo(string $titulo) Return ChildBeneficio objects filtered by the titulo column
 * @method     ChildBeneficio[]|ObjectCollection findByInicioValidade(string $inicio_validade) Return ChildBeneficio objects filtered by the inicio_validade column
 * @method     ChildBeneficio[]|ObjectCollection findByFimValidade(string $fim_validade) Return ChildBeneficio objects filtered by the fim_validade column
 * @method     ChildBeneficio[]|ObjectCollection findByDescricao(string $descricao) Return ChildBeneficio objects filtered by the descricao column
 * @method     ChildBeneficio[]|ObjectCollection findByCondicoes(string $condicoes) Return ChildBeneficio objects filtered by the condicoes column
 * @method     ChildBeneficio[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BeneficioQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BeneficioQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'my_cine_mania', $modelName = '\\Beneficio', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBeneficioQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBeneficioQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBeneficioQuery) {
            return $criteria;
        }
        $query = new ChildBeneficioQuery();
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
     * @return ChildBeneficio|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BeneficioTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BeneficioTableMap::DATABASE_NAME);
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
     * @return ChildBeneficio A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, rede_cinema_id, titulo, inicio_validade, fim_validade, descricao, condicoes FROM beneficios WHERE id = :p0';
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
            /** @var ChildBeneficio $obj */
            $obj = new ChildBeneficio();
            $obj->hydrate($row);
            BeneficioTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildBeneficio|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BeneficioTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BeneficioTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BeneficioTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BeneficioTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BeneficioTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the rede_cinema_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRedeCinemaId(1234); // WHERE rede_cinema_id = 1234
     * $query->filterByRedeCinemaId(array(12, 34)); // WHERE rede_cinema_id IN (12, 34)
     * $query->filterByRedeCinemaId(array('min' => 12)); // WHERE rede_cinema_id > 12
     * </code>
     *
     * @see       filterByRedeCinema()
     *
     * @param     mixed $redeCinemaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByRedeCinemaId($redeCinemaId = null, $comparison = null)
    {
        if (is_array($redeCinemaId)) {
            $useMinMax = false;
            if (isset($redeCinemaId['min'])) {
                $this->addUsingAlias(BeneficioTableMap::COL_REDE_CINEMA_ID, $redeCinemaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($redeCinemaId['max'])) {
                $this->addUsingAlias(BeneficioTableMap::COL_REDE_CINEMA_ID, $redeCinemaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BeneficioTableMap::COL_REDE_CINEMA_ID, $redeCinemaId, $comparison);
    }

    /**
     * Filter the query on the titulo column
     *
     * Example usage:
     * <code>
     * $query->filterByTitulo('fooValue');   // WHERE titulo = 'fooValue'
     * $query->filterByTitulo('%fooValue%'); // WHERE titulo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $titulo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByTitulo($titulo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($titulo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $titulo)) {
                $titulo = str_replace('*', '%', $titulo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BeneficioTableMap::COL_TITULO, $titulo, $comparison);
    }

    /**
     * Filter the query on the inicio_validade column
     *
     * Example usage:
     * <code>
     * $query->filterByInicioValidade('2011-03-14'); // WHERE inicio_validade = '2011-03-14'
     * $query->filterByInicioValidade('now'); // WHERE inicio_validade = '2011-03-14'
     * $query->filterByInicioValidade(array('max' => 'yesterday')); // WHERE inicio_validade > '2011-03-13'
     * </code>
     *
     * @param     mixed $inicioValidade The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByInicioValidade($inicioValidade = null, $comparison = null)
    {
        if (is_array($inicioValidade)) {
            $useMinMax = false;
            if (isset($inicioValidade['min'])) {
                $this->addUsingAlias(BeneficioTableMap::COL_INICIO_VALIDADE, $inicioValidade['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inicioValidade['max'])) {
                $this->addUsingAlias(BeneficioTableMap::COL_INICIO_VALIDADE, $inicioValidade['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BeneficioTableMap::COL_INICIO_VALIDADE, $inicioValidade, $comparison);
    }

    /**
     * Filter the query on the fim_validade column
     *
     * Example usage:
     * <code>
     * $query->filterByFimValidade('2011-03-14'); // WHERE fim_validade = '2011-03-14'
     * $query->filterByFimValidade('now'); // WHERE fim_validade = '2011-03-14'
     * $query->filterByFimValidade(array('max' => 'yesterday')); // WHERE fim_validade > '2011-03-13'
     * </code>
     *
     * @param     mixed $fimValidade The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByFimValidade($fimValidade = null, $comparison = null)
    {
        if (is_array($fimValidade)) {
            $useMinMax = false;
            if (isset($fimValidade['min'])) {
                $this->addUsingAlias(BeneficioTableMap::COL_FIM_VALIDADE, $fimValidade['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fimValidade['max'])) {
                $this->addUsingAlias(BeneficioTableMap::COL_FIM_VALIDADE, $fimValidade['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BeneficioTableMap::COL_FIM_VALIDADE, $fimValidade, $comparison);
    }

    /**
     * Filter the query on the descricao column
     *
     * Example usage:
     * <code>
     * $query->filterByDescricao('fooValue');   // WHERE descricao = 'fooValue'
     * $query->filterByDescricao('%fooValue%'); // WHERE descricao LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descricao The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByDescricao($descricao = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descricao)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $descricao)) {
                $descricao = str_replace('*', '%', $descricao);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BeneficioTableMap::COL_DESCRICAO, $descricao, $comparison);
    }

    /**
     * Filter the query on the condicoes column
     *
     * Example usage:
     * <code>
     * $query->filterByCondicoes('fooValue');   // WHERE condicoes = 'fooValue'
     * $query->filterByCondicoes('%fooValue%'); // WHERE condicoes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $condicoes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByCondicoes($condicoes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($condicoes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $condicoes)) {
                $condicoes = str_replace('*', '%', $condicoes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BeneficioTableMap::COL_CONDICOES, $condicoes, $comparison);
    }

    /**
     * Filter the query by a related \RedeCinema object
     *
     * @param \RedeCinema|ObjectCollection $redeCinema The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByRedeCinema($redeCinema, $comparison = null)
    {
        if ($redeCinema instanceof \RedeCinema) {
            return $this
                ->addUsingAlias(BeneficioTableMap::COL_REDE_CINEMA_ID, $redeCinema->getId(), $comparison);
        } elseif ($redeCinema instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BeneficioTableMap::COL_REDE_CINEMA_ID, $redeCinema->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRedeCinema() only accepts arguments of type \RedeCinema or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RedeCinema relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function joinRedeCinema($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RedeCinema');

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
            $this->addJoinObject($join, 'RedeCinema');
        }

        return $this;
    }

    /**
     * Use the RedeCinema relation RedeCinema object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RedeCinemaQuery A secondary query class using the current class as primary query
     */
    public function useRedeCinemaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRedeCinema($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RedeCinema', '\RedeCinemaQuery');
    }

    /**
     * Filter the query by a related \BeneficiosPreferencias object
     *
     * @param \BeneficiosPreferencias|ObjectCollection $beneficiosPreferencias the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByBeneficiosPreferencias($beneficiosPreferencias, $comparison = null)
    {
        if ($beneficiosPreferencias instanceof \BeneficiosPreferencias) {
            return $this
                ->addUsingAlias(BeneficioTableMap::COL_ID, $beneficiosPreferencias->getBeneficioId(), $comparison);
        } elseif ($beneficiosPreferencias instanceof ObjectCollection) {
            return $this
                ->useBeneficiosPreferenciasQuery()
                ->filterByPrimaryKeys($beneficiosPreferencias->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBeneficiosPreferencias() only accepts arguments of type \BeneficiosPreferencias or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BeneficiosPreferencias relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function joinBeneficiosPreferencias($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BeneficiosPreferencias');

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
            $this->addJoinObject($join, 'BeneficiosPreferencias');
        }

        return $this;
    }

    /**
     * Use the BeneficiosPreferencias relation BeneficiosPreferencias object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BeneficiosPreferenciasQuery A secondary query class using the current class as primary query
     */
    public function useBeneficiosPreferenciasQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBeneficiosPreferencias($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BeneficiosPreferencias', '\BeneficiosPreferenciasQuery');
    }

    /**
     * Filter the query by a related \ParticipantesPreferencias object
     *
     * @param \ParticipantesPreferencias|ObjectCollection $participantesPreferencias the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByParticipantesPreferencias($participantesPreferencias, $comparison = null)
    {
        if ($participantesPreferencias instanceof \ParticipantesPreferencias) {
            return $this
                ->addUsingAlias(BeneficioTableMap::COL_ID, $participantesPreferencias->getBeneficioId(), $comparison);
        } elseif ($participantesPreferencias instanceof ObjectCollection) {
            return $this
                ->useParticipantesPreferenciasQuery()
                ->filterByPrimaryKeys($participantesPreferencias->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByParticipantesPreferencias() only accepts arguments of type \ParticipantesPreferencias or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ParticipantesPreferencias relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function joinParticipantesPreferencias($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ParticipantesPreferencias');

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
            $this->addJoinObject($join, 'ParticipantesPreferencias');
        }

        return $this;
    }

    /**
     * Use the ParticipantesPreferencias relation ParticipantesPreferencias object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ParticipantesPreferenciasQuery A secondary query class using the current class as primary query
     */
    public function useParticipantesPreferenciasQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinParticipantesPreferencias($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ParticipantesPreferencias', '\ParticipantesPreferenciasQuery');
    }

    /**
     * Filter the query by a related \Voucher object
     *
     * @param \Voucher|ObjectCollection $voucher the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByVoucher($voucher, $comparison = null)
    {
        if ($voucher instanceof \Voucher) {
            return $this
                ->addUsingAlias(BeneficioTableMap::COL_ID, $voucher->getBeneficioId(), $comparison);
        } elseif ($voucher instanceof ObjectCollection) {
            return $this
                ->useVoucherQuery()
                ->filterByPrimaryKeys($voucher->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByVoucher() only accepts arguments of type \Voucher or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Voucher relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function joinVoucher($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Voucher');

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
            $this->addJoinObject($join, 'Voucher');
        }

        return $this;
    }

    /**
     * Use the Voucher relation Voucher object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \VoucherQuery A secondary query class using the current class as primary query
     */
    public function useVoucherQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinVoucher($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Voucher', '\VoucherQuery');
    }

    /**
     * Filter the query by a related Preferencia object
     * using the beneficios_preferencias table as cross reference
     *
     * @param Preferencia $preferencia the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByPreferencia($preferencia, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useBeneficiosPreferenciasQuery()
            ->filterByPreferencia($preferencia, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Participante object
     * using the participantes_preferencias table as cross reference
     *
     * @param Participante $participante the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBeneficioQuery The current query, for fluid interface
     */
    public function filterByParticipante($participante, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useParticipantesPreferenciasQuery()
            ->filterByParticipante($participante, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBeneficio $beneficio Object to remove from the list of results
     *
     * @return $this|ChildBeneficioQuery The current query, for fluid interface
     */
    public function prune($beneficio = null)
    {
        if ($beneficio) {
            $this->addUsingAlias(BeneficioTableMap::COL_ID, $beneficio->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the beneficios table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BeneficioTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BeneficioTableMap::clearInstancePool();
            BeneficioTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BeneficioTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BeneficioTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BeneficioTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BeneficioTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BeneficioQuery
