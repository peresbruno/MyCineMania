<?php

namespace Base;

use \Participante as ChildParticipante;
use \ParticipanteQuery as ChildParticipanteQuery;
use \Exception;
use \PDO;
use Map\ParticipanteTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'participantes' table.
 *
 *
 *
 * @method     ChildParticipanteQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildParticipanteQuery orderByUsuarioId($order = Criteria::ASC) Order by the usuario_id column
 * @method     ChildParticipanteQuery orderByCpf($order = Criteria::ASC) Order by the cpf column
 * @method     ChildParticipanteQuery orderByFimValidade($order = Criteria::ASC) Order by the fim_validade column
 * @method     ChildParticipanteQuery orderByNome($order = Criteria::ASC) Order by the nome column
 * @method     ChildParticipanteQuery orderBySobrenome($order = Criteria::ASC) Order by the sobrenome column
 *
 * @method     ChildParticipanteQuery groupById() Group by the id column
 * @method     ChildParticipanteQuery groupByUsuarioId() Group by the usuario_id column
 * @method     ChildParticipanteQuery groupByCpf() Group by the cpf column
 * @method     ChildParticipanteQuery groupByFimValidade() Group by the fim_validade column
 * @method     ChildParticipanteQuery groupByNome() Group by the nome column
 * @method     ChildParticipanteQuery groupBySobrenome() Group by the sobrenome column
 *
 * @method     ChildParticipanteQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildParticipanteQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildParticipanteQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildParticipanteQuery leftJoinUsuario($relationAlias = null) Adds a LEFT JOIN clause to the query using the Usuario relation
 * @method     ChildParticipanteQuery rightJoinUsuario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Usuario relation
 * @method     ChildParticipanteQuery innerJoinUsuario($relationAlias = null) Adds a INNER JOIN clause to the query using the Usuario relation
 *
 * @method     ChildParticipanteQuery leftJoinParticipantesPreferencias($relationAlias = null) Adds a LEFT JOIN clause to the query using the ParticipantesPreferencias relation
 * @method     ChildParticipanteQuery rightJoinParticipantesPreferencias($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ParticipantesPreferencias relation
 * @method     ChildParticipanteQuery innerJoinParticipantesPreferencias($relationAlias = null) Adds a INNER JOIN clause to the query using the ParticipantesPreferencias relation
 *
 * @method     ChildParticipanteQuery leftJoinPagamento($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pagamento relation
 * @method     ChildParticipanteQuery rightJoinPagamento($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pagamento relation
 * @method     ChildParticipanteQuery innerJoinPagamento($relationAlias = null) Adds a INNER JOIN clause to the query using the Pagamento relation
 *
 * @method     ChildParticipanteQuery leftJoinVoucher($relationAlias = null) Adds a LEFT JOIN clause to the query using the Voucher relation
 * @method     ChildParticipanteQuery rightJoinVoucher($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Voucher relation
 * @method     ChildParticipanteQuery innerJoinVoucher($relationAlias = null) Adds a INNER JOIN clause to the query using the Voucher relation
 *
 * @method     \UsuarioQuery|\ParticipantesPreferenciasQuery|\PagamentoQuery|\VoucherQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildParticipante findOne(ConnectionInterface $con = null) Return the first ChildParticipante matching the query
 * @method     ChildParticipante findOneOrCreate(ConnectionInterface $con = null) Return the first ChildParticipante matching the query, or a new ChildParticipante object populated from the query conditions when no match is found
 *
 * @method     ChildParticipante findOneById(int $id) Return the first ChildParticipante filtered by the id column
 * @method     ChildParticipante findOneByUsuarioId(int $usuario_id) Return the first ChildParticipante filtered by the usuario_id column
 * @method     ChildParticipante findOneByCpf(string $cpf) Return the first ChildParticipante filtered by the cpf column
 * @method     ChildParticipante findOneByFimValidade(string $fim_validade) Return the first ChildParticipante filtered by the fim_validade column
 * @method     ChildParticipante findOneByNome(string $nome) Return the first ChildParticipante filtered by the nome column
 * @method     ChildParticipante findOneBySobrenome(string $sobrenome) Return the first ChildParticipante filtered by the sobrenome column *

 * @method     ChildParticipante requirePk($key, ConnectionInterface $con = null) Return the ChildParticipante by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipante requireOne(ConnectionInterface $con = null) Return the first ChildParticipante matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildParticipante requireOneById(int $id) Return the first ChildParticipante filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipante requireOneByUsuarioId(int $usuario_id) Return the first ChildParticipante filtered by the usuario_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipante requireOneByCpf(string $cpf) Return the first ChildParticipante filtered by the cpf column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipante requireOneByFimValidade(string $fim_validade) Return the first ChildParticipante filtered by the fim_validade column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipante requireOneByNome(string $nome) Return the first ChildParticipante filtered by the nome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipante requireOneBySobrenome(string $sobrenome) Return the first ChildParticipante filtered by the sobrenome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildParticipante[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildParticipante objects based on current ModelCriteria
 * @method     ChildParticipante[]|ObjectCollection findById(int $id) Return ChildParticipante objects filtered by the id column
 * @method     ChildParticipante[]|ObjectCollection findByUsuarioId(int $usuario_id) Return ChildParticipante objects filtered by the usuario_id column
 * @method     ChildParticipante[]|ObjectCollection findByCpf(string $cpf) Return ChildParticipante objects filtered by the cpf column
 * @method     ChildParticipante[]|ObjectCollection findByFimValidade(string $fim_validade) Return ChildParticipante objects filtered by the fim_validade column
 * @method     ChildParticipante[]|ObjectCollection findByNome(string $nome) Return ChildParticipante objects filtered by the nome column
 * @method     ChildParticipante[]|ObjectCollection findBySobrenome(string $sobrenome) Return ChildParticipante objects filtered by the sobrenome column
 * @method     ChildParticipante[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ParticipanteQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ParticipanteQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'my_cine_mania', $modelName = '\\Participante', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildParticipanteQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildParticipanteQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildParticipanteQuery) {
            return $criteria;
        }
        $query = new ChildParticipanteQuery();
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
     * @return ChildParticipante|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ParticipanteTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ParticipanteTableMap::DATABASE_NAME);
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
     * @return ChildParticipante A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, usuario_id, cpf, fim_validade, nome, sobrenome FROM participantes WHERE id = :p0';
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
            /** @var ChildParticipante $obj */
            $obj = new ChildParticipante();
            $obj->hydrate($row);
            ParticipanteTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildParticipante|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ParticipanteTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ParticipanteTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ParticipanteTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ParticipanteTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipanteTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByUsuarioId($usuarioId = null, $comparison = null)
    {
        if (is_array($usuarioId)) {
            $useMinMax = false;
            if (isset($usuarioId['min'])) {
                $this->addUsingAlias(ParticipanteTableMap::COL_USUARIO_ID, $usuarioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($usuarioId['max'])) {
                $this->addUsingAlias(ParticipanteTableMap::COL_USUARIO_ID, $usuarioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipanteTableMap::COL_USUARIO_ID, $usuarioId, $comparison);
    }

    /**
     * Filter the query on the cpf column
     *
     * Example usage:
     * <code>
     * $query->filterByCpf('fooValue');   // WHERE cpf = 'fooValue'
     * $query->filterByCpf('%fooValue%'); // WHERE cpf LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cpf The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByCpf($cpf = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cpf)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cpf)) {
                $cpf = str_replace('*', '%', $cpf);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ParticipanteTableMap::COL_CPF, $cpf, $comparison);
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
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByFimValidade($fimValidade = null, $comparison = null)
    {
        if (is_array($fimValidade)) {
            $useMinMax = false;
            if (isset($fimValidade['min'])) {
                $this->addUsingAlias(ParticipanteTableMap::COL_FIM_VALIDADE, $fimValidade['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fimValidade['max'])) {
                $this->addUsingAlias(ParticipanteTableMap::COL_FIM_VALIDADE, $fimValidade['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipanteTableMap::COL_FIM_VALIDADE, $fimValidade, $comparison);
    }

    /**
     * Filter the query on the nome column
     *
     * Example usage:
     * <code>
     * $query->filterByNome('fooValue');   // WHERE nome = 'fooValue'
     * $query->filterByNome('%fooValue%'); // WHERE nome LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nome The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByNome($nome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nome)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nome)) {
                $nome = str_replace('*', '%', $nome);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ParticipanteTableMap::COL_NOME, $nome, $comparison);
    }

    /**
     * Filter the query on the sobrenome column
     *
     * Example usage:
     * <code>
     * $query->filterBySobrenome('fooValue');   // WHERE sobrenome = 'fooValue'
     * $query->filterBySobrenome('%fooValue%'); // WHERE sobrenome LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sobrenome The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterBySobrenome($sobrenome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sobrenome)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sobrenome)) {
                $sobrenome = str_replace('*', '%', $sobrenome);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ParticipanteTableMap::COL_SOBRENOME, $sobrenome, $comparison);
    }

    /**
     * Filter the query by a related \Usuario object
     *
     * @param \Usuario|ObjectCollection $usuario The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByUsuario($usuario, $comparison = null)
    {
        if ($usuario instanceof \Usuario) {
            return $this
                ->addUsingAlias(ParticipanteTableMap::COL_USUARIO_ID, $usuario->getId(), $comparison);
        } elseif ($usuario instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ParticipanteTableMap::COL_USUARIO_ID, $usuario->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
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
     * Filter the query by a related \ParticipantesPreferencias object
     *
     * @param \ParticipantesPreferencias|ObjectCollection $participantesPreferencias the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByParticipantesPreferencias($participantesPreferencias, $comparison = null)
    {
        if ($participantesPreferencias instanceof \ParticipantesPreferencias) {
            return $this
                ->addUsingAlias(ParticipanteTableMap::COL_ID, $participantesPreferencias->getParticipanteId(), $comparison);
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
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
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
     * Filter the query by a related \Pagamento object
     *
     * @param \Pagamento|ObjectCollection $pagamento the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByPagamento($pagamento, $comparison = null)
    {
        if ($pagamento instanceof \Pagamento) {
            return $this
                ->addUsingAlias(ParticipanteTableMap::COL_ID, $pagamento->getParticipanteId(), $comparison);
        } elseif ($pagamento instanceof ObjectCollection) {
            return $this
                ->usePagamentoQuery()
                ->filterByPrimaryKeys($pagamento->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPagamento() only accepts arguments of type \Pagamento or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pagamento relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
     */
    public function joinPagamento($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pagamento');

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
            $this->addJoinObject($join, 'Pagamento');
        }

        return $this;
    }

    /**
     * Use the Pagamento relation Pagamento object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PagamentoQuery A secondary query class using the current class as primary query
     */
    public function usePagamentoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPagamento($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pagamento', '\PagamentoQuery');
    }

    /**
     * Filter the query by a related \Voucher object
     *
     * @param \Voucher|ObjectCollection $voucher the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByVoucher($voucher, $comparison = null)
    {
        if ($voucher instanceof \Voucher) {
            return $this
                ->addUsingAlias(ParticipanteTableMap::COL_ID, $voucher->getParticipanteId(), $comparison);
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
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
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
     * Filter the query by a related Beneficio object
     * using the participantes_preferencias table as cross reference
     *
     * @param Beneficio $beneficio the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParticipanteQuery The current query, for fluid interface
     */
    public function filterByBeneficio($beneficio, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useParticipantesPreferenciasQuery()
            ->filterByBeneficio($beneficio, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildParticipante $participante Object to remove from the list of results
     *
     * @return $this|ChildParticipanteQuery The current query, for fluid interface
     */
    public function prune($participante = null)
    {
        if ($participante) {
            $this->addUsingAlias(ParticipanteTableMap::COL_ID, $participante->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the participantes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipanteTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ParticipanteTableMap::clearInstancePool();
            ParticipanteTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipanteTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ParticipanteTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ParticipanteTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ParticipanteTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ParticipanteQuery
