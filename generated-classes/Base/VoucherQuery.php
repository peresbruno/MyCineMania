<?php

namespace Base;

use \Voucher as ChildVoucher;
use \VoucherQuery as ChildVoucherQuery;
use \Exception;
use \PDO;
use Map\VoucherTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'vouchers' table.
 *
 *
 *
 * @method     ChildVoucherQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildVoucherQuery orderByBeneficioId($order = Criteria::ASC) Order by the beneficio_id column
 * @method     ChildVoucherQuery orderByParticipanteId($order = Criteria::ASC) Order by the participante_id column
 * @method     ChildVoucherQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildVoucherQuery orderByCodigo($order = Criteria::ASC) Order by the codigo column
 * @method     ChildVoucherQuery orderByDataEmissao($order = Criteria::ASC) Order by the data_emissao column
 * @method     ChildVoucherQuery orderByHoraEmissao($order = Criteria::ASC) Order by the hora_emissao column
 *
 * @method     ChildVoucherQuery groupById() Group by the id column
 * @method     ChildVoucherQuery groupByBeneficioId() Group by the beneficio_id column
 * @method     ChildVoucherQuery groupByParticipanteId() Group by the participante_id column
 * @method     ChildVoucherQuery groupByStatus() Group by the status column
 * @method     ChildVoucherQuery groupByCodigo() Group by the codigo column
 * @method     ChildVoucherQuery groupByDataEmissao() Group by the data_emissao column
 * @method     ChildVoucherQuery groupByHoraEmissao() Group by the hora_emissao column
 *
 * @method     ChildVoucherQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVoucherQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVoucherQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVoucherQuery leftJoinBeneficio($relationAlias = null) Adds a LEFT JOIN clause to the query using the Beneficio relation
 * @method     ChildVoucherQuery rightJoinBeneficio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Beneficio relation
 * @method     ChildVoucherQuery innerJoinBeneficio($relationAlias = null) Adds a INNER JOIN clause to the query using the Beneficio relation
 *
 * @method     ChildVoucherQuery leftJoinParticipante($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participante relation
 * @method     ChildVoucherQuery rightJoinParticipante($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participante relation
 * @method     ChildVoucherQuery innerJoinParticipante($relationAlias = null) Adds a INNER JOIN clause to the query using the Participante relation
 *
 * @method     \BeneficioQuery|\ParticipanteQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVoucher findOne(ConnectionInterface $con = null) Return the first ChildVoucher matching the query
 * @method     ChildVoucher findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVoucher matching the query, or a new ChildVoucher object populated from the query conditions when no match is found
 *
 * @method     ChildVoucher findOneById(int $id) Return the first ChildVoucher filtered by the id column
 * @method     ChildVoucher findOneByBeneficioId(int $beneficio_id) Return the first ChildVoucher filtered by the beneficio_id column
 * @method     ChildVoucher findOneByParticipanteId(int $participante_id) Return the first ChildVoucher filtered by the participante_id column
 * @method     ChildVoucher findOneByStatus(string $status) Return the first ChildVoucher filtered by the status column
 * @method     ChildVoucher findOneByCodigo(string $codigo) Return the first ChildVoucher filtered by the codigo column
 * @method     ChildVoucher findOneByDataEmissao(string $data_emissao) Return the first ChildVoucher filtered by the data_emissao column
 * @method     ChildVoucher findOneByHoraEmissao(string $hora_emissao) Return the first ChildVoucher filtered by the hora_emissao column *

 * @method     ChildVoucher requirePk($key, ConnectionInterface $con = null) Return the ChildVoucher by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOne(ConnectionInterface $con = null) Return the first ChildVoucher matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoucher requireOneById(int $id) Return the first ChildVoucher filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByBeneficioId(int $beneficio_id) Return the first ChildVoucher filtered by the beneficio_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByParticipanteId(int $participante_id) Return the first ChildVoucher filtered by the participante_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByStatus(string $status) Return the first ChildVoucher filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByCodigo(string $codigo) Return the first ChildVoucher filtered by the codigo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByDataEmissao(string $data_emissao) Return the first ChildVoucher filtered by the data_emissao column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByHoraEmissao(string $hora_emissao) Return the first ChildVoucher filtered by the hora_emissao column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoucher[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVoucher objects based on current ModelCriteria
 * @method     ChildVoucher[]|ObjectCollection findById(int $id) Return ChildVoucher objects filtered by the id column
 * @method     ChildVoucher[]|ObjectCollection findByBeneficioId(int $beneficio_id) Return ChildVoucher objects filtered by the beneficio_id column
 * @method     ChildVoucher[]|ObjectCollection findByParticipanteId(int $participante_id) Return ChildVoucher objects filtered by the participante_id column
 * @method     ChildVoucher[]|ObjectCollection findByStatus(string $status) Return ChildVoucher objects filtered by the status column
 * @method     ChildVoucher[]|ObjectCollection findByCodigo(string $codigo) Return ChildVoucher objects filtered by the codigo column
 * @method     ChildVoucher[]|ObjectCollection findByDataEmissao(string $data_emissao) Return ChildVoucher objects filtered by the data_emissao column
 * @method     ChildVoucher[]|ObjectCollection findByHoraEmissao(string $hora_emissao) Return ChildVoucher objects filtered by the hora_emissao column
 * @method     ChildVoucher[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VoucherQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\VoucherQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'my_cine_mania', $modelName = '\\Voucher', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVoucherQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVoucherQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVoucherQuery) {
            return $criteria;
        }
        $query = new ChildVoucherQuery();
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
     * @return ChildVoucher|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = VoucherTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VoucherTableMap::DATABASE_NAME);
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
     * @return ChildVoucher A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, beneficio_id, participante_id, status, codigo, data_emissao, hora_emissao FROM vouchers WHERE id = :p0';
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
            /** @var ChildVoucher $obj */
            $obj = new ChildVoucher();
            $obj->hydrate($row);
            VoucherTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildVoucher|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VoucherTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VoucherTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the beneficio_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBeneficioId(1234); // WHERE beneficio_id = 1234
     * $query->filterByBeneficioId(array(12, 34)); // WHERE beneficio_id IN (12, 34)
     * $query->filterByBeneficioId(array('min' => 12)); // WHERE beneficio_id > 12
     * </code>
     *
     * @see       filterByBeneficio()
     *
     * @param     mixed $beneficioId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByBeneficioId($beneficioId = null, $comparison = null)
    {
        if (is_array($beneficioId)) {
            $useMinMax = false;
            if (isset($beneficioId['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_BENEFICIO_ID, $beneficioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($beneficioId['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_BENEFICIO_ID, $beneficioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_BENEFICIO_ID, $beneficioId, $comparison);
    }

    /**
     * Filter the query on the participante_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParticipanteId(1234); // WHERE participante_id = 1234
     * $query->filterByParticipanteId(array(12, 34)); // WHERE participante_id IN (12, 34)
     * $query->filterByParticipanteId(array('min' => 12)); // WHERE participante_id > 12
     * </code>
     *
     * @see       filterByParticipante()
     *
     * @param     mixed $participanteId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByParticipanteId($participanteId = null, $comparison = null)
    {
        if (is_array($participanteId)) {
            $useMinMax = false;
            if (isset($participanteId['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_PARTICIPANTE_ID, $participanteId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($participanteId['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_PARTICIPANTE_ID, $participanteId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_PARTICIPANTE_ID, $participanteId, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the codigo column
     *
     * Example usage:
     * <code>
     * $query->filterByCodigo('fooValue');   // WHERE codigo = 'fooValue'
     * $query->filterByCodigo('%fooValue%'); // WHERE codigo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codigo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByCodigo($codigo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codigo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $codigo)) {
                $codigo = str_replace('*', '%', $codigo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_CODIGO, $codigo, $comparison);
    }

    /**
     * Filter the query on the data_emissao column
     *
     * Example usage:
     * <code>
     * $query->filterByDataEmissao('2011-03-14'); // WHERE data_emissao = '2011-03-14'
     * $query->filterByDataEmissao('now'); // WHERE data_emissao = '2011-03-14'
     * $query->filterByDataEmissao(array('max' => 'yesterday')); // WHERE data_emissao > '2011-03-13'
     * </code>
     *
     * @param     mixed $dataEmissao The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByDataEmissao($dataEmissao = null, $comparison = null)
    {
        if (is_array($dataEmissao)) {
            $useMinMax = false;
            if (isset($dataEmissao['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_DATA_EMISSAO, $dataEmissao['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataEmissao['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_DATA_EMISSAO, $dataEmissao['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_DATA_EMISSAO, $dataEmissao, $comparison);
    }

    /**
     * Filter the query on the hora_emissao column
     *
     * Example usage:
     * <code>
     * $query->filterByHoraEmissao('2011-03-14'); // WHERE hora_emissao = '2011-03-14'
     * $query->filterByHoraEmissao('now'); // WHERE hora_emissao = '2011-03-14'
     * $query->filterByHoraEmissao(array('max' => 'yesterday')); // WHERE hora_emissao > '2011-03-13'
     * </code>
     *
     * @param     mixed $horaEmissao The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByHoraEmissao($horaEmissao = null, $comparison = null)
    {
        if (is_array($horaEmissao)) {
            $useMinMax = false;
            if (isset($horaEmissao['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_HORA_EMISSAO, $horaEmissao['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($horaEmissao['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_HORA_EMISSAO, $horaEmissao['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_HORA_EMISSAO, $horaEmissao, $comparison);
    }

    /**
     * Filter the query by a related \Beneficio object
     *
     * @param \Beneficio|ObjectCollection $beneficio The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByBeneficio($beneficio, $comparison = null)
    {
        if ($beneficio instanceof \Beneficio) {
            return $this
                ->addUsingAlias(VoucherTableMap::COL_BENEFICIO_ID, $beneficio->getId(), $comparison);
        } elseif ($beneficio instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoucherTableMap::COL_BENEFICIO_ID, $beneficio->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
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
     * Filter the query by a related \Participante object
     *
     * @param \Participante|ObjectCollection $participante The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByParticipante($participante, $comparison = null)
    {
        if ($participante instanceof \Participante) {
            return $this
                ->addUsingAlias(VoucherTableMap::COL_PARTICIPANTE_ID, $participante->getId(), $comparison);
        } elseif ($participante instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoucherTableMap::COL_PARTICIPANTE_ID, $participante->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildVoucher $voucher Object to remove from the list of results
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function prune($voucher = null)
    {
        if ($voucher) {
            $this->addUsingAlias(VoucherTableMap::COL_ID, $voucher->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the vouchers table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoucherTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VoucherTableMap::clearInstancePool();
            VoucherTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VoucherTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VoucherTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VoucherTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VoucherTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // VoucherQuery
