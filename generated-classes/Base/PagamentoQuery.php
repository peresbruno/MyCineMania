<?php

namespace Base;

use \Pagamento as ChildPagamento;
use \PagamentoQuery as ChildPagamentoQuery;
use \Exception;
use \PDO;
use Map\PagamentoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'pagamentos' table.
 *
 *
 *
 * @method     ChildPagamentoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPagamentoQuery orderByParticipanteId($order = Criteria::ASC) Order by the participante_id column
 * @method     ChildPagamentoQuery orderByDataPagamento($order = Criteria::ASC) Order by the data_pagamento column
 * @method     ChildPagamentoQuery orderByDataVencimento($order = Criteria::ASC) Order by the data_vencimento column
 * @method     ChildPagamentoQuery orderByNumeroBoleto($order = Criteria::ASC) Order by the numero_boleto column
 * @method     ChildPagamentoQuery orderByValor($order = Criteria::ASC) Order by the valor column
 *
 * @method     ChildPagamentoQuery groupById() Group by the id column
 * @method     ChildPagamentoQuery groupByParticipanteId() Group by the participante_id column
 * @method     ChildPagamentoQuery groupByDataPagamento() Group by the data_pagamento column
 * @method     ChildPagamentoQuery groupByDataVencimento() Group by the data_vencimento column
 * @method     ChildPagamentoQuery groupByNumeroBoleto() Group by the numero_boleto column
 * @method     ChildPagamentoQuery groupByValor() Group by the valor column
 *
 * @method     ChildPagamentoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPagamentoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPagamentoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPagamentoQuery leftJoinParticipante($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participante relation
 * @method     ChildPagamentoQuery rightJoinParticipante($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participante relation
 * @method     ChildPagamentoQuery innerJoinParticipante($relationAlias = null) Adds a INNER JOIN clause to the query using the Participante relation
 *
 * @method     \ParticipanteQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPagamento findOne(ConnectionInterface $con = null) Return the first ChildPagamento matching the query
 * @method     ChildPagamento findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPagamento matching the query, or a new ChildPagamento object populated from the query conditions when no match is found
 *
 * @method     ChildPagamento findOneById(int $id) Return the first ChildPagamento filtered by the id column
 * @method     ChildPagamento findOneByParticipanteId(int $participante_id) Return the first ChildPagamento filtered by the participante_id column
 * @method     ChildPagamento findOneByDataPagamento(string $data_pagamento) Return the first ChildPagamento filtered by the data_pagamento column
 * @method     ChildPagamento findOneByDataVencimento(string $data_vencimento) Return the first ChildPagamento filtered by the data_vencimento column
 * @method     ChildPagamento findOneByNumeroBoleto(string $numero_boleto) Return the first ChildPagamento filtered by the numero_boleto column
 * @method     ChildPagamento findOneByValor(double $valor) Return the first ChildPagamento filtered by the valor column *

 * @method     ChildPagamento requirePk($key, ConnectionInterface $con = null) Return the ChildPagamento by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPagamento requireOne(ConnectionInterface $con = null) Return the first ChildPagamento matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPagamento requireOneById(int $id) Return the first ChildPagamento filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPagamento requireOneByParticipanteId(int $participante_id) Return the first ChildPagamento filtered by the participante_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPagamento requireOneByDataPagamento(string $data_pagamento) Return the first ChildPagamento filtered by the data_pagamento column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPagamento requireOneByDataVencimento(string $data_vencimento) Return the first ChildPagamento filtered by the data_vencimento column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPagamento requireOneByNumeroBoleto(string $numero_boleto) Return the first ChildPagamento filtered by the numero_boleto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPagamento requireOneByValor(double $valor) Return the first ChildPagamento filtered by the valor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPagamento[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPagamento objects based on current ModelCriteria
 * @method     ChildPagamento[]|ObjectCollection findById(int $id) Return ChildPagamento objects filtered by the id column
 * @method     ChildPagamento[]|ObjectCollection findByParticipanteId(int $participante_id) Return ChildPagamento objects filtered by the participante_id column
 * @method     ChildPagamento[]|ObjectCollection findByDataPagamento(string $data_pagamento) Return ChildPagamento objects filtered by the data_pagamento column
 * @method     ChildPagamento[]|ObjectCollection findByDataVencimento(string $data_vencimento) Return ChildPagamento objects filtered by the data_vencimento column
 * @method     ChildPagamento[]|ObjectCollection findByNumeroBoleto(string $numero_boleto) Return ChildPagamento objects filtered by the numero_boleto column
 * @method     ChildPagamento[]|ObjectCollection findByValor(double $valor) Return ChildPagamento objects filtered by the valor column
 * @method     ChildPagamento[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PagamentoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PagamentoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'my_cine_mania', $modelName = '\\Pagamento', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPagamentoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPagamentoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPagamentoQuery) {
            return $criteria;
        }
        $query = new ChildPagamentoQuery();
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
     * @return ChildPagamento|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PagamentoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PagamentoTableMap::DATABASE_NAME);
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
     * @return ChildPagamento A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, participante_id, data_pagamento, data_vencimento, numero_boleto, valor FROM pagamentos WHERE id = :p0';
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
            /** @var ChildPagamento $obj */
            $obj = new ChildPagamento();
            $obj->hydrate($row);
            PagamentoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPagamento|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPagamentoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PagamentoTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPagamentoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PagamentoTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPagamentoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PagamentoTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PagamentoTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PagamentoTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPagamentoQuery The current query, for fluid interface
     */
    public function filterByParticipanteId($participanteId = null, $comparison = null)
    {
        if (is_array($participanteId)) {
            $useMinMax = false;
            if (isset($participanteId['min'])) {
                $this->addUsingAlias(PagamentoTableMap::COL_PARTICIPANTE_ID, $participanteId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($participanteId['max'])) {
                $this->addUsingAlias(PagamentoTableMap::COL_PARTICIPANTE_ID, $participanteId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PagamentoTableMap::COL_PARTICIPANTE_ID, $participanteId, $comparison);
    }

    /**
     * Filter the query on the data_pagamento column
     *
     * Example usage:
     * <code>
     * $query->filterByDataPagamento('2011-03-14'); // WHERE data_pagamento = '2011-03-14'
     * $query->filterByDataPagamento('now'); // WHERE data_pagamento = '2011-03-14'
     * $query->filterByDataPagamento(array('max' => 'yesterday')); // WHERE data_pagamento > '2011-03-13'
     * </code>
     *
     * @param     mixed $dataPagamento The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPagamentoQuery The current query, for fluid interface
     */
    public function filterByDataPagamento($dataPagamento = null, $comparison = null)
    {
        if (is_array($dataPagamento)) {
            $useMinMax = false;
            if (isset($dataPagamento['min'])) {
                $this->addUsingAlias(PagamentoTableMap::COL_DATA_PAGAMENTO, $dataPagamento['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataPagamento['max'])) {
                $this->addUsingAlias(PagamentoTableMap::COL_DATA_PAGAMENTO, $dataPagamento['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PagamentoTableMap::COL_DATA_PAGAMENTO, $dataPagamento, $comparison);
    }

    /**
     * Filter the query on the data_vencimento column
     *
     * Example usage:
     * <code>
     * $query->filterByDataVencimento('2011-03-14'); // WHERE data_vencimento = '2011-03-14'
     * $query->filterByDataVencimento('now'); // WHERE data_vencimento = '2011-03-14'
     * $query->filterByDataVencimento(array('max' => 'yesterday')); // WHERE data_vencimento > '2011-03-13'
     * </code>
     *
     * @param     mixed $dataVencimento The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPagamentoQuery The current query, for fluid interface
     */
    public function filterByDataVencimento($dataVencimento = null, $comparison = null)
    {
        if (is_array($dataVencimento)) {
            $useMinMax = false;
            if (isset($dataVencimento['min'])) {
                $this->addUsingAlias(PagamentoTableMap::COL_DATA_VENCIMENTO, $dataVencimento['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataVencimento['max'])) {
                $this->addUsingAlias(PagamentoTableMap::COL_DATA_VENCIMENTO, $dataVencimento['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PagamentoTableMap::COL_DATA_VENCIMENTO, $dataVencimento, $comparison);
    }

    /**
     * Filter the query on the numero_boleto column
     *
     * Example usage:
     * <code>
     * $query->filterByNumeroBoleto('fooValue');   // WHERE numero_boleto = 'fooValue'
     * $query->filterByNumeroBoleto('%fooValue%'); // WHERE numero_boleto LIKE '%fooValue%'
     * </code>
     *
     * @param     string $numeroBoleto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPagamentoQuery The current query, for fluid interface
     */
    public function filterByNumeroBoleto($numeroBoleto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($numeroBoleto)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $numeroBoleto)) {
                $numeroBoleto = str_replace('*', '%', $numeroBoleto);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PagamentoTableMap::COL_NUMERO_BOLETO, $numeroBoleto, $comparison);
    }

    /**
     * Filter the query on the valor column
     *
     * Example usage:
     * <code>
     * $query->filterByValor(1234); // WHERE valor = 1234
     * $query->filterByValor(array(12, 34)); // WHERE valor IN (12, 34)
     * $query->filterByValor(array('min' => 12)); // WHERE valor > 12
     * </code>
     *
     * @param     mixed $valor The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPagamentoQuery The current query, for fluid interface
     */
    public function filterByValor($valor = null, $comparison = null)
    {
        if (is_array($valor)) {
            $useMinMax = false;
            if (isset($valor['min'])) {
                $this->addUsingAlias(PagamentoTableMap::COL_VALOR, $valor['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valor['max'])) {
                $this->addUsingAlias(PagamentoTableMap::COL_VALOR, $valor['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PagamentoTableMap::COL_VALOR, $valor, $comparison);
    }

    /**
     * Filter the query by a related \Participante object
     *
     * @param \Participante|ObjectCollection $participante The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPagamentoQuery The current query, for fluid interface
     */
    public function filterByParticipante($participante, $comparison = null)
    {
        if ($participante instanceof \Participante) {
            return $this
                ->addUsingAlias(PagamentoTableMap::COL_PARTICIPANTE_ID, $participante->getId(), $comparison);
        } elseif ($participante instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PagamentoTableMap::COL_PARTICIPANTE_ID, $participante->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPagamentoQuery The current query, for fluid interface
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
     * @param   ChildPagamento $pagamento Object to remove from the list of results
     *
     * @return $this|ChildPagamentoQuery The current query, for fluid interface
     */
    public function prune($pagamento = null)
    {
        if ($pagamento) {
            $this->addUsingAlias(PagamentoTableMap::COL_ID, $pagamento->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pagamentos table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PagamentoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PagamentoTableMap::clearInstancePool();
            PagamentoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PagamentoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PagamentoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PagamentoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PagamentoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PagamentoQuery
