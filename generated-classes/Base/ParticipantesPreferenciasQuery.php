<?php

namespace Base;

use \ParticipantesPreferencias as ChildParticipantesPreferencias;
use \ParticipantesPreferenciasQuery as ChildParticipantesPreferenciasQuery;
use \Exception;
use \PDO;
use Map\ParticipantesPreferenciasTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'participantes_preferencias' table.
 *
 *
 *
 * @method     ChildParticipantesPreferenciasQuery orderByParticipanteId($order = Criteria::ASC) Order by the participante_id column
 * @method     ChildParticipantesPreferenciasQuery orderByBeneficioId($order = Criteria::ASC) Order by the beneficio_id column
 *
 * @method     ChildParticipantesPreferenciasQuery groupByParticipanteId() Group by the participante_id column
 * @method     ChildParticipantesPreferenciasQuery groupByBeneficioId() Group by the beneficio_id column
 *
 * @method     ChildParticipantesPreferenciasQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildParticipantesPreferenciasQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildParticipantesPreferenciasQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildParticipantesPreferenciasQuery leftJoinParticipante($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participante relation
 * @method     ChildParticipantesPreferenciasQuery rightJoinParticipante($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participante relation
 * @method     ChildParticipantesPreferenciasQuery innerJoinParticipante($relationAlias = null) Adds a INNER JOIN clause to the query using the Participante relation
 *
 * @method     ChildParticipantesPreferenciasQuery leftJoinBeneficio($relationAlias = null) Adds a LEFT JOIN clause to the query using the Beneficio relation
 * @method     ChildParticipantesPreferenciasQuery rightJoinBeneficio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Beneficio relation
 * @method     ChildParticipantesPreferenciasQuery innerJoinBeneficio($relationAlias = null) Adds a INNER JOIN clause to the query using the Beneficio relation
 *
 * @method     \ParticipanteQuery|\BeneficioQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildParticipantesPreferencias findOne(ConnectionInterface $con = null) Return the first ChildParticipantesPreferencias matching the query
 * @method     ChildParticipantesPreferencias findOneOrCreate(ConnectionInterface $con = null) Return the first ChildParticipantesPreferencias matching the query, or a new ChildParticipantesPreferencias object populated from the query conditions when no match is found
 *
 * @method     ChildParticipantesPreferencias findOneByParticipanteId(int $participante_id) Return the first ChildParticipantesPreferencias filtered by the participante_id column
 * @method     ChildParticipantesPreferencias findOneByBeneficioId(int $beneficio_id) Return the first ChildParticipantesPreferencias filtered by the beneficio_id column *

 * @method     ChildParticipantesPreferencias requirePk($key, ConnectionInterface $con = null) Return the ChildParticipantesPreferencias by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipantesPreferencias requireOne(ConnectionInterface $con = null) Return the first ChildParticipantesPreferencias matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildParticipantesPreferencias requireOneByParticipanteId(int $participante_id) Return the first ChildParticipantesPreferencias filtered by the participante_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipantesPreferencias requireOneByBeneficioId(int $beneficio_id) Return the first ChildParticipantesPreferencias filtered by the beneficio_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildParticipantesPreferencias[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildParticipantesPreferencias objects based on current ModelCriteria
 * @method     ChildParticipantesPreferencias[]|ObjectCollection findByParticipanteId(int $participante_id) Return ChildParticipantesPreferencias objects filtered by the participante_id column
 * @method     ChildParticipantesPreferencias[]|ObjectCollection findByBeneficioId(int $beneficio_id) Return ChildParticipantesPreferencias objects filtered by the beneficio_id column
 * @method     ChildParticipantesPreferencias[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ParticipantesPreferenciasQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ParticipantesPreferenciasQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'my_cine_mania', $modelName = '\\ParticipantesPreferencias', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildParticipantesPreferenciasQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildParticipantesPreferenciasQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildParticipantesPreferenciasQuery) {
            return $criteria;
        }
        $query = new ChildParticipantesPreferenciasQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$participante_id, $beneficio_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildParticipantesPreferencias|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ParticipantesPreferenciasTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ParticipantesPreferenciasTableMap::DATABASE_NAME);
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
     * @return ChildParticipantesPreferencias A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT participante_id, beneficio_id FROM participantes_preferencias WHERE participante_id = :p0 AND beneficio_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildParticipantesPreferencias $obj */
            $obj = new ChildParticipantesPreferencias();
            $obj->hydrate($row);
            ParticipantesPreferenciasTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildParticipantesPreferencias|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildParticipantesPreferenciasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ParticipantesPreferenciasTableMap::COL_PARTICIPANTE_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ParticipantesPreferenciasTableMap::COL_BENEFICIO_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildParticipantesPreferenciasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ParticipantesPreferenciasTableMap::COL_PARTICIPANTE_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ParticipantesPreferenciasTableMap::COL_BENEFICIO_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildParticipantesPreferenciasQuery The current query, for fluid interface
     */
    public function filterByParticipanteId($participanteId = null, $comparison = null)
    {
        if (is_array($participanteId)) {
            $useMinMax = false;
            if (isset($participanteId['min'])) {
                $this->addUsingAlias(ParticipantesPreferenciasTableMap::COL_PARTICIPANTE_ID, $participanteId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($participanteId['max'])) {
                $this->addUsingAlias(ParticipantesPreferenciasTableMap::COL_PARTICIPANTE_ID, $participanteId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantesPreferenciasTableMap::COL_PARTICIPANTE_ID, $participanteId, $comparison);
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
     * @return $this|ChildParticipantesPreferenciasQuery The current query, for fluid interface
     */
    public function filterByBeneficioId($beneficioId = null, $comparison = null)
    {
        if (is_array($beneficioId)) {
            $useMinMax = false;
            if (isset($beneficioId['min'])) {
                $this->addUsingAlias(ParticipantesPreferenciasTableMap::COL_BENEFICIO_ID, $beneficioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($beneficioId['max'])) {
                $this->addUsingAlias(ParticipantesPreferenciasTableMap::COL_BENEFICIO_ID, $beneficioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantesPreferenciasTableMap::COL_BENEFICIO_ID, $beneficioId, $comparison);
    }

    /**
     * Filter the query by a related \Participante object
     *
     * @param \Participante|ObjectCollection $participante The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildParticipantesPreferenciasQuery The current query, for fluid interface
     */
    public function filterByParticipante($participante, $comparison = null)
    {
        if ($participante instanceof \Participante) {
            return $this
                ->addUsingAlias(ParticipantesPreferenciasTableMap::COL_PARTICIPANTE_ID, $participante->getId(), $comparison);
        } elseif ($participante instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ParticipantesPreferenciasTableMap::COL_PARTICIPANTE_ID, $participante->toKeyValue('Id', 'Id'), $comparison);
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
     * @return $this|ChildParticipantesPreferenciasQuery The current query, for fluid interface
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
     * Filter the query by a related \Beneficio object
     *
     * @param \Beneficio|ObjectCollection $beneficio The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildParticipantesPreferenciasQuery The current query, for fluid interface
     */
    public function filterByBeneficio($beneficio, $comparison = null)
    {
        if ($beneficio instanceof \Beneficio) {
            return $this
                ->addUsingAlias(ParticipantesPreferenciasTableMap::COL_BENEFICIO_ID, $beneficio->getId(), $comparison);
        } elseif ($beneficio instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ParticipantesPreferenciasTableMap::COL_BENEFICIO_ID, $beneficio->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildParticipantesPreferenciasQuery The current query, for fluid interface
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
     * @param   ChildParticipantesPreferencias $participantesPreferencias Object to remove from the list of results
     *
     * @return $this|ChildParticipantesPreferenciasQuery The current query, for fluid interface
     */
    public function prune($participantesPreferencias = null)
    {
        if ($participantesPreferencias) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ParticipantesPreferenciasTableMap::COL_PARTICIPANTE_ID), $participantesPreferencias->getParticipanteId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ParticipantesPreferenciasTableMap::COL_BENEFICIO_ID), $participantesPreferencias->getBeneficioId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the participantes_preferencias table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantesPreferenciasTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ParticipantesPreferenciasTableMap::clearInstancePool();
            ParticipantesPreferenciasTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantesPreferenciasTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ParticipantesPreferenciasTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ParticipantesPreferenciasTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ParticipantesPreferenciasTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ParticipantesPreferenciasQuery
