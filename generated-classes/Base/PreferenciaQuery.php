<?php

namespace Base;

use \Preferencia as ChildPreferencia;
use \PreferenciaQuery as ChildPreferenciaQuery;
use \Exception;
use \PDO;
use Map\PreferenciaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'preferencias' table.
 *
 *
 *
 * @method     ChildPreferenciaQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPreferenciaQuery orderByDescricao($order = Criteria::ASC) Order by the descricao column
 *
 * @method     ChildPreferenciaQuery groupById() Group by the id column
 * @method     ChildPreferenciaQuery groupByDescricao() Group by the descricao column
 *
 * @method     ChildPreferenciaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPreferenciaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPreferenciaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPreferenciaQuery leftJoinBeneficiosPreferencias($relationAlias = null) Adds a LEFT JOIN clause to the query using the BeneficiosPreferencias relation
 * @method     ChildPreferenciaQuery rightJoinBeneficiosPreferencias($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BeneficiosPreferencias relation
 * @method     ChildPreferenciaQuery innerJoinBeneficiosPreferencias($relationAlias = null) Adds a INNER JOIN clause to the query using the BeneficiosPreferencias relation
 *
 * @method     ChildPreferenciaQuery leftJoinParticipantesPreferencias($relationAlias = null) Adds a LEFT JOIN clause to the query using the ParticipantesPreferencias relation
 * @method     ChildPreferenciaQuery rightJoinParticipantesPreferencias($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ParticipantesPreferencias relation
 * @method     ChildPreferenciaQuery innerJoinParticipantesPreferencias($relationAlias = null) Adds a INNER JOIN clause to the query using the ParticipantesPreferencias relation
 *
 * @method     \BeneficiosPreferenciasQuery|\ParticipantesPreferenciasQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPreferencia findOne(ConnectionInterface $con = null) Return the first ChildPreferencia matching the query
 * @method     ChildPreferencia findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPreferencia matching the query, or a new ChildPreferencia object populated from the query conditions when no match is found
 *
 * @method     ChildPreferencia findOneById(int $id) Return the first ChildPreferencia filtered by the id column
 * @method     ChildPreferencia findOneByDescricao(string $descricao) Return the first ChildPreferencia filtered by the descricao column *

 * @method     ChildPreferencia requirePk($key, ConnectionInterface $con = null) Return the ChildPreferencia by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferencia requireOne(ConnectionInterface $con = null) Return the first ChildPreferencia matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPreferencia requireOneById(int $id) Return the first ChildPreferencia filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferencia requireOneByDescricao(string $descricao) Return the first ChildPreferencia filtered by the descricao column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPreferencia[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPreferencia objects based on current ModelCriteria
 * @method     ChildPreferencia[]|ObjectCollection findById(int $id) Return ChildPreferencia objects filtered by the id column
 * @method     ChildPreferencia[]|ObjectCollection findByDescricao(string $descricao) Return ChildPreferencia objects filtered by the descricao column
 * @method     ChildPreferencia[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PreferenciaQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PreferenciaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'my_cine_mania', $modelName = '\\Preferencia', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPreferenciaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPreferenciaQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPreferenciaQuery) {
            return $criteria;
        }
        $query = new ChildPreferenciaQuery();
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
     * @return ChildPreferencia|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PreferenciaTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PreferenciaTableMap::DATABASE_NAME);
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
     * @return ChildPreferencia A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, descricao FROM preferencias WHERE id = :p0';
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
            /** @var ChildPreferencia $obj */
            $obj = new ChildPreferencia();
            $obj->hydrate($row);
            PreferenciaTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPreferencia|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPreferenciaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PreferenciaTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPreferenciaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PreferenciaTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPreferenciaQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PreferenciaTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PreferenciaTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PreferenciaTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPreferenciaQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PreferenciaTableMap::COL_DESCRICAO, $descricao, $comparison);
    }

    /**
     * Filter the query by a related \BeneficiosPreferencias object
     *
     * @param \BeneficiosPreferencias|ObjectCollection $beneficiosPreferencias the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPreferenciaQuery The current query, for fluid interface
     */
    public function filterByBeneficiosPreferencias($beneficiosPreferencias, $comparison = null)
    {
        if ($beneficiosPreferencias instanceof \BeneficiosPreferencias) {
            return $this
                ->addUsingAlias(PreferenciaTableMap::COL_ID, $beneficiosPreferencias->getPreferenciaId(), $comparison);
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
     * @return $this|ChildPreferenciaQuery The current query, for fluid interface
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
     * @return ChildPreferenciaQuery The current query, for fluid interface
     */
    public function filterByParticipantesPreferencias($participantesPreferencias, $comparison = null)
    {
        if ($participantesPreferencias instanceof \ParticipantesPreferencias) {
            return $this
                ->addUsingAlias(PreferenciaTableMap::COL_ID, $participantesPreferencias->getPreferenciaId(), $comparison);
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
     * @return $this|ChildPreferenciaQuery The current query, for fluid interface
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
     * Filter the query by a related Beneficio object
     * using the beneficios_preferencias table as cross reference
     *
     * @param Beneficio $beneficio the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPreferenciaQuery The current query, for fluid interface
     */
    public function filterByBeneficio($beneficio, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useBeneficiosPreferenciasQuery()
            ->filterByBeneficio($beneficio, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Participante object
     * using the participantes_preferencias table as cross reference
     *
     * @param Participante $participante the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPreferenciaQuery The current query, for fluid interface
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
     * @param   ChildPreferencia $preferencia Object to remove from the list of results
     *
     * @return $this|ChildPreferenciaQuery The current query, for fluid interface
     */
    public function prune($preferencia = null)
    {
        if ($preferencia) {
            $this->addUsingAlias(PreferenciaTableMap::COL_ID, $preferencia->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the preferencias table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PreferenciaTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PreferenciaTableMap::clearInstancePool();
            PreferenciaTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PreferenciaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PreferenciaTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PreferenciaTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PreferenciaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PreferenciaQuery
