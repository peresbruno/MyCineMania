<?php

namespace Base;

use \Pagamento as ChildPagamento;
use \PagamentoQuery as ChildPagamentoQuery;
use \Participante as ChildParticipante;
use \ParticipanteQuery as ChildParticipanteQuery;
use \ParticipantesPreferencias as ChildParticipantesPreferencias;
use \ParticipantesPreferenciasQuery as ChildParticipantesPreferenciasQuery;
use \Preferencia as ChildPreferencia;
use \PreferenciaQuery as ChildPreferenciaQuery;
use \Usuario as ChildUsuario;
use \UsuarioQuery as ChildUsuarioQuery;
use \Voucher as ChildVoucher;
use \VoucherQuery as ChildVoucherQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\ParticipanteTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use Propel\Runtime\Validator\Constraints\Unique;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\DefaultTranslator;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\LegacyValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'participantes' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Participante implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ParticipanteTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the usuario_id field.
     * @var        int
     */
    protected $usuario_id;

    /**
     * The value for the cpf field.
     * @var        string
     */
    protected $cpf;

    /**
     * The value for the fim_validade field.
     * @var        \DateTime
     */
    protected $fim_validade;

    /**
     * The value for the nome field.
     * @var        string
     */
    protected $nome;

    /**
     * The value for the sobrenome field.
     * @var        string
     */
    protected $sobrenome;

    /**
     * @var        ChildUsuario
     */
    protected $aUsuario;

    /**
     * @var        ObjectCollection|ChildParticipantesPreferencias[] Collection to store aggregation of ChildParticipantesPreferencias objects.
     */
    protected $collParticipantesPreferenciass;
    protected $collParticipantesPreferenciassPartial;

    /**
     * @var        ObjectCollection|ChildPagamento[] Collection to store aggregation of ChildPagamento objects.
     */
    protected $collPagamentos;
    protected $collPagamentosPartial;

    /**
     * @var        ObjectCollection|ChildVoucher[] Collection to store aggregation of ChildVoucher objects.
     */
    protected $collVouchers;
    protected $collVouchersPartial;

    /**
     * @var        ObjectCollection|ChildPreferencia[] Cross Collection to store aggregation of ChildPreferencia objects.
     */
    protected $collPreferencias;

    /**
     * @var bool
     */
    protected $collPreferenciasPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // validate behavior

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * ConstraintViolationList object
     *
     * @see     http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolationList.html
     * @var     ConstraintViolationList
     */
    protected $validationFailures;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPreferencia[]
     */
    protected $preferenciasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildParticipantesPreferencias[]
     */
    protected $participantesPreferenciassScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPagamento[]
     */
    protected $pagamentosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVoucher[]
     */
    protected $vouchersScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Participante object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Participante</code> instance.  If
     * <code>obj</code> is an instance of <code>Participante</code>, delegates to
     * <code>equals(Participante)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Participante The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [usuario_id] column value.
     *
     * @return int
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    /**
     * Get the [cpf] column value.
     *
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Get the [optionally formatted] temporal [fim_validade] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFimValidade($format = NULL)
    {
        if ($format === null) {
            return $this->fim_validade;
        } else {
            return $this->fim_validade instanceof \DateTime ? $this->fim_validade->format($format) : null;
        }
    }

    /**
     * Get the [nome] column value.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Get the [sobrenome] column value.
     *
     * @return string
     */
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Participante The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ParticipanteTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [usuario_id] column.
     *
     * @param int $v new value
     * @return $this|\Participante The current object (for fluent API support)
     */
    public function setUsuarioId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->usuario_id !== $v) {
            $this->usuario_id = $v;
            $this->modifiedColumns[ParticipanteTableMap::COL_USUARIO_ID] = true;
        }

        if ($this->aUsuario !== null && $this->aUsuario->getId() !== $v) {
            $this->aUsuario = null;
        }

        return $this;
    } // setUsuarioId()

    /**
     * Set the value of [cpf] column.
     *
     * @param string $v new value
     * @return $this|\Participante The current object (for fluent API support)
     */
    public function setCpf($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cpf !== $v) {
            $this->cpf = $v;
            $this->modifiedColumns[ParticipanteTableMap::COL_CPF] = true;
        }

        return $this;
    } // setCpf()

    /**
     * Sets the value of [fim_validade] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Participante The current object (for fluent API support)
     */
    public function setFimValidade($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fim_validade !== null || $dt !== null) {
            if ($this->fim_validade === null || $dt === null || $dt->format("Y-m-d") !== $this->fim_validade->format("Y-m-d")) {
                $this->fim_validade = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ParticipanteTableMap::COL_FIM_VALIDADE] = true;
            }
        } // if either are not null

        return $this;
    } // setFimValidade()

    /**
     * Set the value of [nome] column.
     *
     * @param string $v new value
     * @return $this|\Participante The current object (for fluent API support)
     */
    public function setNome($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nome !== $v) {
            $this->nome = $v;
            $this->modifiedColumns[ParticipanteTableMap::COL_NOME] = true;
        }

        return $this;
    } // setNome()

    /**
     * Set the value of [sobrenome] column.
     *
     * @param string $v new value
     * @return $this|\Participante The current object (for fluent API support)
     */
    public function setSobrenome($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sobrenome !== $v) {
            $this->sobrenome = $v;
            $this->modifiedColumns[ParticipanteTableMap::COL_SOBRENOME] = true;
        }

        return $this;
    } // setSobrenome()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ParticipanteTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ParticipanteTableMap::translateFieldName('UsuarioId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->usuario_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ParticipanteTableMap::translateFieldName('Cpf', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cpf = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ParticipanteTableMap::translateFieldName('FimValidade', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fim_validade = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ParticipanteTableMap::translateFieldName('Nome', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nome = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ParticipanteTableMap::translateFieldName('Sobrenome', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sobrenome = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = ParticipanteTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Participante'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aUsuario !== null && $this->usuario_id !== $this->aUsuario->getId()) {
            $this->aUsuario = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ParticipanteTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildParticipanteQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUsuario = null;
            $this->collParticipantesPreferenciass = null;

            $this->collPagamentos = null;

            $this->collVouchers = null;

            $this->collPreferencias = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Participante::setDeleted()
     * @see Participante::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipanteTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildParticipanteQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipanteTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ParticipanteTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUsuario !== null) {
                if ($this->aUsuario->isModified() || $this->aUsuario->isNew()) {
                    $affectedRows += $this->aUsuario->save($con);
                }
                $this->setUsuario($this->aUsuario);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->preferenciasScheduledForDeletion !== null) {
                if (!$this->preferenciasScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->preferenciasScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \ParticipantesPreferenciasQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->preferenciasScheduledForDeletion = null;
                }

            }

            if ($this->collPreferencias) {
                foreach ($this->collPreferencias as $preferencia) {
                    if (!$preferencia->isDeleted() && ($preferencia->isNew() || $preferencia->isModified())) {
                        $preferencia->save($con);
                    }
                }
            }


            if ($this->participantesPreferenciassScheduledForDeletion !== null) {
                if (!$this->participantesPreferenciassScheduledForDeletion->isEmpty()) {
                    \ParticipantesPreferenciasQuery::create()
                        ->filterByPrimaryKeys($this->participantesPreferenciassScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->participantesPreferenciassScheduledForDeletion = null;
                }
            }

            if ($this->collParticipantesPreferenciass !== null) {
                foreach ($this->collParticipantesPreferenciass as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pagamentosScheduledForDeletion !== null) {
                if (!$this->pagamentosScheduledForDeletion->isEmpty()) {
                    \PagamentoQuery::create()
                        ->filterByPrimaryKeys($this->pagamentosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pagamentosScheduledForDeletion = null;
                }
            }

            if ($this->collPagamentos !== null) {
                foreach ($this->collPagamentos as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->vouchersScheduledForDeletion !== null) {
                if (!$this->vouchersScheduledForDeletion->isEmpty()) {
                    \VoucherQuery::create()
                        ->filterByPrimaryKeys($this->vouchersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->vouchersScheduledForDeletion = null;
                }
            }

            if ($this->collVouchers !== null) {
                foreach ($this->collVouchers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[ParticipanteTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ParticipanteTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('participantes_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ParticipanteTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ParticipanteTableMap::COL_USUARIO_ID)) {
            $modifiedColumns[':p' . $index++]  = 'usuario_id';
        }
        if ($this->isColumnModified(ParticipanteTableMap::COL_CPF)) {
            $modifiedColumns[':p' . $index++]  = 'cpf';
        }
        if ($this->isColumnModified(ParticipanteTableMap::COL_FIM_VALIDADE)) {
            $modifiedColumns[':p' . $index++]  = 'fim_validade';
        }
        if ($this->isColumnModified(ParticipanteTableMap::COL_NOME)) {
            $modifiedColumns[':p' . $index++]  = 'nome';
        }
        if ($this->isColumnModified(ParticipanteTableMap::COL_SOBRENOME)) {
            $modifiedColumns[':p' . $index++]  = 'sobrenome';
        }

        $sql = sprintf(
            'INSERT INTO participantes (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'usuario_id':
                        $stmt->bindValue($identifier, $this->usuario_id, PDO::PARAM_INT);
                        break;
                    case 'cpf':
                        $stmt->bindValue($identifier, $this->cpf, PDO::PARAM_STR);
                        break;
                    case 'fim_validade':
                        $stmt->bindValue($identifier, $this->fim_validade ? $this->fim_validade->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'nome':
                        $stmt->bindValue($identifier, $this->nome, PDO::PARAM_STR);
                        break;
                    case 'sobrenome':
                        $stmt->bindValue($identifier, $this->sobrenome, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ParticipanteTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getUsuarioId();
                break;
            case 2:
                return $this->getCpf();
                break;
            case 3:
                return $this->getFimValidade();
                break;
            case 4:
                return $this->getNome();
                break;
            case 5:
                return $this->getSobrenome();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Participante'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Participante'][$this->hashCode()] = true;
        $keys = ParticipanteTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsuarioId(),
            $keys[2] => $this->getCpf(),
            $keys[3] => $this->getFimValidade(),
            $keys[4] => $this->getNome(),
            $keys[5] => $this->getSobrenome(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[3]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[3]];
            $result[$keys[3]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUsuario) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'usuario';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'usuarios';
                        break;
                    default:
                        $key = 'Usuario';
                }

                $result[$key] = $this->aUsuario->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collParticipantesPreferenciass) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'participantesPreferenciass';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'participantes_preferenciass';
                        break;
                    default:
                        $key = 'ParticipantesPreferenciass';
                }

                $result[$key] = $this->collParticipantesPreferenciass->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPagamentos) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pagamentos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pagamentoss';
                        break;
                    default:
                        $key = 'Pagamentos';
                }

                $result[$key] = $this->collPagamentos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collVouchers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'vouchers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'voucherss';
                        break;
                    default:
                        $key = 'Vouchers';
                }

                $result[$key] = $this->collVouchers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Participante
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ParticipanteTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Participante
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUsuarioId($value);
                break;
            case 2:
                $this->setCpf($value);
                break;
            case 3:
                $this->setFimValidade($value);
                break;
            case 4:
                $this->setNome($value);
                break;
            case 5:
                $this->setSobrenome($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ParticipanteTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUsuarioId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCpf($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setFimValidade($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setNome($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSobrenome($arr[$keys[5]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Participante The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ParticipanteTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ParticipanteTableMap::COL_ID)) {
            $criteria->add(ParticipanteTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ParticipanteTableMap::COL_USUARIO_ID)) {
            $criteria->add(ParticipanteTableMap::COL_USUARIO_ID, $this->usuario_id);
        }
        if ($this->isColumnModified(ParticipanteTableMap::COL_CPF)) {
            $criteria->add(ParticipanteTableMap::COL_CPF, $this->cpf);
        }
        if ($this->isColumnModified(ParticipanteTableMap::COL_FIM_VALIDADE)) {
            $criteria->add(ParticipanteTableMap::COL_FIM_VALIDADE, $this->fim_validade);
        }
        if ($this->isColumnModified(ParticipanteTableMap::COL_NOME)) {
            $criteria->add(ParticipanteTableMap::COL_NOME, $this->nome);
        }
        if ($this->isColumnModified(ParticipanteTableMap::COL_SOBRENOME)) {
            $criteria->add(ParticipanteTableMap::COL_SOBRENOME, $this->sobrenome);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildParticipanteQuery::create();
        $criteria->add(ParticipanteTableMap::COL_ID, $this->id);
        $criteria->add(ParticipanteTableMap::COL_USUARIO_ID, $this->usuario_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId() &&
            null !== $this->getUsuarioId();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation participantes_fk_614747 to table usuarios
        if ($this->aUsuario && $hash = spl_object_hash($this->aUsuario)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getId();
        $pks[1] = $this->getUsuarioId();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setId($keys[0]);
        $this->setUsuarioId($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getId()) && (null === $this->getUsuarioId());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Participante (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUsuarioId($this->getUsuarioId());
        $copyObj->setCpf($this->getCpf());
        $copyObj->setFimValidade($this->getFimValidade());
        $copyObj->setNome($this->getNome());
        $copyObj->setSobrenome($this->getSobrenome());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getParticipantesPreferenciass() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addParticipantesPreferencias($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPagamentos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPagamento($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getVouchers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVoucher($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Participante Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildUsuario object.
     *
     * @param  ChildUsuario $v
     * @return $this|\Participante The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUsuario(ChildUsuario $v = null)
    {
        if ($v === null) {
            $this->setUsuarioId(NULL);
        } else {
            $this->setUsuarioId($v->getId());
        }

        $this->aUsuario = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsuario object, it will not be re-added.
        if ($v !== null) {
            $v->addParticipante($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsuario object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsuario The associated ChildUsuario object.
     * @throws PropelException
     */
    public function getUsuario(ConnectionInterface $con = null)
    {
        if ($this->aUsuario === null && ($this->usuario_id !== null)) {
            $this->aUsuario = ChildUsuarioQuery::create()->findPk($this->usuario_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUsuario->addParticipantes($this);
             */
        }

        return $this->aUsuario;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ParticipantesPreferencias' == $relationName) {
            return $this->initParticipantesPreferenciass();
        }
        if ('Pagamento' == $relationName) {
            return $this->initPagamentos();
        }
        if ('Voucher' == $relationName) {
            return $this->initVouchers();
        }
    }

    /**
     * Clears out the collParticipantesPreferenciass collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addParticipantesPreferenciass()
     */
    public function clearParticipantesPreferenciass()
    {
        $this->collParticipantesPreferenciass = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collParticipantesPreferenciass collection loaded partially.
     */
    public function resetPartialParticipantesPreferenciass($v = true)
    {
        $this->collParticipantesPreferenciassPartial = $v;
    }

    /**
     * Initializes the collParticipantesPreferenciass collection.
     *
     * By default this just sets the collParticipantesPreferenciass collection to an empty array (like clearcollParticipantesPreferenciass());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initParticipantesPreferenciass($overrideExisting = true)
    {
        if (null !== $this->collParticipantesPreferenciass && !$overrideExisting) {
            return;
        }
        $this->collParticipantesPreferenciass = new ObjectCollection();
        $this->collParticipantesPreferenciass->setModel('\ParticipantesPreferencias');
    }

    /**
     * Gets an array of ChildParticipantesPreferencias objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParticipante is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildParticipantesPreferencias[] List of ChildParticipantesPreferencias objects
     * @throws PropelException
     */
    public function getParticipantesPreferenciass(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantesPreferenciassPartial && !$this->isNew();
        if (null === $this->collParticipantesPreferenciass || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collParticipantesPreferenciass) {
                // return empty collection
                $this->initParticipantesPreferenciass();
            } else {
                $collParticipantesPreferenciass = ChildParticipantesPreferenciasQuery::create(null, $criteria)
                    ->filterByParticipante($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collParticipantesPreferenciassPartial && count($collParticipantesPreferenciass)) {
                        $this->initParticipantesPreferenciass(false);

                        foreach ($collParticipantesPreferenciass as $obj) {
                            if (false == $this->collParticipantesPreferenciass->contains($obj)) {
                                $this->collParticipantesPreferenciass->append($obj);
                            }
                        }

                        $this->collParticipantesPreferenciassPartial = true;
                    }

                    return $collParticipantesPreferenciass;
                }

                if ($partial && $this->collParticipantesPreferenciass) {
                    foreach ($this->collParticipantesPreferenciass as $obj) {
                        if ($obj->isNew()) {
                            $collParticipantesPreferenciass[] = $obj;
                        }
                    }
                }

                $this->collParticipantesPreferenciass = $collParticipantesPreferenciass;
                $this->collParticipantesPreferenciassPartial = false;
            }
        }

        return $this->collParticipantesPreferenciass;
    }

    /**
     * Sets a collection of ChildParticipantesPreferencias objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $participantesPreferenciass A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParticipante The current object (for fluent API support)
     */
    public function setParticipantesPreferenciass(Collection $participantesPreferenciass, ConnectionInterface $con = null)
    {
        /** @var ChildParticipantesPreferencias[] $participantesPreferenciassToDelete */
        $participantesPreferenciassToDelete = $this->getParticipantesPreferenciass(new Criteria(), $con)->diff($participantesPreferenciass);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->participantesPreferenciassScheduledForDeletion = clone $participantesPreferenciassToDelete;

        foreach ($participantesPreferenciassToDelete as $participantesPreferenciasRemoved) {
            $participantesPreferenciasRemoved->setParticipante(null);
        }

        $this->collParticipantesPreferenciass = null;
        foreach ($participantesPreferenciass as $participantesPreferencias) {
            $this->addParticipantesPreferencias($participantesPreferencias);
        }

        $this->collParticipantesPreferenciass = $participantesPreferenciass;
        $this->collParticipantesPreferenciassPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ParticipantesPreferencias objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ParticipantesPreferencias objects.
     * @throws PropelException
     */
    public function countParticipantesPreferenciass(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantesPreferenciassPartial && !$this->isNew();
        if (null === $this->collParticipantesPreferenciass || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collParticipantesPreferenciass) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getParticipantesPreferenciass());
            }

            $query = ChildParticipantesPreferenciasQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParticipante($this)
                ->count($con);
        }

        return count($this->collParticipantesPreferenciass);
    }

    /**
     * Method called to associate a ChildParticipantesPreferencias object to this object
     * through the ChildParticipantesPreferencias foreign key attribute.
     *
     * @param  ChildParticipantesPreferencias $l ChildParticipantesPreferencias
     * @return $this|\Participante The current object (for fluent API support)
     */
    public function addParticipantesPreferencias(ChildParticipantesPreferencias $l)
    {
        if ($this->collParticipantesPreferenciass === null) {
            $this->initParticipantesPreferenciass();
            $this->collParticipantesPreferenciassPartial = true;
        }

        if (!$this->collParticipantesPreferenciass->contains($l)) {
            $this->doAddParticipantesPreferencias($l);
        }

        return $this;
    }

    /**
     * @param ChildParticipantesPreferencias $participantesPreferencias The ChildParticipantesPreferencias object to add.
     */
    protected function doAddParticipantesPreferencias(ChildParticipantesPreferencias $participantesPreferencias)
    {
        $this->collParticipantesPreferenciass[]= $participantesPreferencias;
        $participantesPreferencias->setParticipante($this);
    }

    /**
     * @param  ChildParticipantesPreferencias $participantesPreferencias The ChildParticipantesPreferencias object to remove.
     * @return $this|ChildParticipante The current object (for fluent API support)
     */
    public function removeParticipantesPreferencias(ChildParticipantesPreferencias $participantesPreferencias)
    {
        if ($this->getParticipantesPreferenciass()->contains($participantesPreferencias)) {
            $pos = $this->collParticipantesPreferenciass->search($participantesPreferencias);
            $this->collParticipantesPreferenciass->remove($pos);
            if (null === $this->participantesPreferenciassScheduledForDeletion) {
                $this->participantesPreferenciassScheduledForDeletion = clone $this->collParticipantesPreferenciass;
                $this->participantesPreferenciassScheduledForDeletion->clear();
            }
            $this->participantesPreferenciassScheduledForDeletion[]= clone $participantesPreferencias;
            $participantesPreferencias->setParticipante(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Participante is new, it will return
     * an empty collection; or if this Participante has previously
     * been saved, it will retrieve related ParticipantesPreferenciass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Participante.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildParticipantesPreferencias[] List of ChildParticipantesPreferencias objects
     */
    public function getParticipantesPreferenciassJoinPreferencia(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildParticipantesPreferenciasQuery::create(null, $criteria);
        $query->joinWith('Preferencia', $joinBehavior);

        return $this->getParticipantesPreferenciass($query, $con);
    }

    /**
     * Clears out the collPagamentos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPagamentos()
     */
    public function clearPagamentos()
    {
        $this->collPagamentos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPagamentos collection loaded partially.
     */
    public function resetPartialPagamentos($v = true)
    {
        $this->collPagamentosPartial = $v;
    }

    /**
     * Initializes the collPagamentos collection.
     *
     * By default this just sets the collPagamentos collection to an empty array (like clearcollPagamentos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPagamentos($overrideExisting = true)
    {
        if (null !== $this->collPagamentos && !$overrideExisting) {
            return;
        }
        $this->collPagamentos = new ObjectCollection();
        $this->collPagamentos->setModel('\Pagamento');
    }

    /**
     * Gets an array of ChildPagamento objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParticipante is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPagamento[] List of ChildPagamento objects
     * @throws PropelException
     */
    public function getPagamentos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPagamentosPartial && !$this->isNew();
        if (null === $this->collPagamentos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPagamentos) {
                // return empty collection
                $this->initPagamentos();
            } else {
                $collPagamentos = ChildPagamentoQuery::create(null, $criteria)
                    ->filterByParticipante($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPagamentosPartial && count($collPagamentos)) {
                        $this->initPagamentos(false);

                        foreach ($collPagamentos as $obj) {
                            if (false == $this->collPagamentos->contains($obj)) {
                                $this->collPagamentos->append($obj);
                            }
                        }

                        $this->collPagamentosPartial = true;
                    }

                    return $collPagamentos;
                }

                if ($partial && $this->collPagamentos) {
                    foreach ($this->collPagamentos as $obj) {
                        if ($obj->isNew()) {
                            $collPagamentos[] = $obj;
                        }
                    }
                }

                $this->collPagamentos = $collPagamentos;
                $this->collPagamentosPartial = false;
            }
        }

        return $this->collPagamentos;
    }

    /**
     * Sets a collection of ChildPagamento objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pagamentos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParticipante The current object (for fluent API support)
     */
    public function setPagamentos(Collection $pagamentos, ConnectionInterface $con = null)
    {
        /** @var ChildPagamento[] $pagamentosToDelete */
        $pagamentosToDelete = $this->getPagamentos(new Criteria(), $con)->diff($pagamentos);


        $this->pagamentosScheduledForDeletion = $pagamentosToDelete;

        foreach ($pagamentosToDelete as $pagamentoRemoved) {
            $pagamentoRemoved->setParticipante(null);
        }

        $this->collPagamentos = null;
        foreach ($pagamentos as $pagamento) {
            $this->addPagamento($pagamento);
        }

        $this->collPagamentos = $pagamentos;
        $this->collPagamentosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pagamento objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Pagamento objects.
     * @throws PropelException
     */
    public function countPagamentos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPagamentosPartial && !$this->isNew();
        if (null === $this->collPagamentos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPagamentos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPagamentos());
            }

            $query = ChildPagamentoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParticipante($this)
                ->count($con);
        }

        return count($this->collPagamentos);
    }

    /**
     * Method called to associate a ChildPagamento object to this object
     * through the ChildPagamento foreign key attribute.
     *
     * @param  ChildPagamento $l ChildPagamento
     * @return $this|\Participante The current object (for fluent API support)
     */
    public function addPagamento(ChildPagamento $l)
    {
        if ($this->collPagamentos === null) {
            $this->initPagamentos();
            $this->collPagamentosPartial = true;
        }

        if (!$this->collPagamentos->contains($l)) {
            $this->doAddPagamento($l);
        }

        return $this;
    }

    /**
     * @param ChildPagamento $pagamento The ChildPagamento object to add.
     */
    protected function doAddPagamento(ChildPagamento $pagamento)
    {
        $this->collPagamentos[]= $pagamento;
        $pagamento->setParticipante($this);
    }

    /**
     * @param  ChildPagamento $pagamento The ChildPagamento object to remove.
     * @return $this|ChildParticipante The current object (for fluent API support)
     */
    public function removePagamento(ChildPagamento $pagamento)
    {
        if ($this->getPagamentos()->contains($pagamento)) {
            $pos = $this->collPagamentos->search($pagamento);
            $this->collPagamentos->remove($pos);
            if (null === $this->pagamentosScheduledForDeletion) {
                $this->pagamentosScheduledForDeletion = clone $this->collPagamentos;
                $this->pagamentosScheduledForDeletion->clear();
            }
            $this->pagamentosScheduledForDeletion[]= clone $pagamento;
            $pagamento->setParticipante(null);
        }

        return $this;
    }

    /**
     * Clears out the collVouchers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVouchers()
     */
    public function clearVouchers()
    {
        $this->collVouchers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVouchers collection loaded partially.
     */
    public function resetPartialVouchers($v = true)
    {
        $this->collVouchersPartial = $v;
    }

    /**
     * Initializes the collVouchers collection.
     *
     * By default this just sets the collVouchers collection to an empty array (like clearcollVouchers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVouchers($overrideExisting = true)
    {
        if (null !== $this->collVouchers && !$overrideExisting) {
            return;
        }
        $this->collVouchers = new ObjectCollection();
        $this->collVouchers->setModel('\Voucher');
    }

    /**
     * Gets an array of ChildVoucher objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParticipante is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVoucher[] List of ChildVoucher objects
     * @throws PropelException
     */
    public function getVouchers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVouchersPartial && !$this->isNew();
        if (null === $this->collVouchers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVouchers) {
                // return empty collection
                $this->initVouchers();
            } else {
                $collVouchers = ChildVoucherQuery::create(null, $criteria)
                    ->filterByParticipante($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVouchersPartial && count($collVouchers)) {
                        $this->initVouchers(false);

                        foreach ($collVouchers as $obj) {
                            if (false == $this->collVouchers->contains($obj)) {
                                $this->collVouchers->append($obj);
                            }
                        }

                        $this->collVouchersPartial = true;
                    }

                    return $collVouchers;
                }

                if ($partial && $this->collVouchers) {
                    foreach ($this->collVouchers as $obj) {
                        if ($obj->isNew()) {
                            $collVouchers[] = $obj;
                        }
                    }
                }

                $this->collVouchers = $collVouchers;
                $this->collVouchersPartial = false;
            }
        }

        return $this->collVouchers;
    }

    /**
     * Sets a collection of ChildVoucher objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $vouchers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParticipante The current object (for fluent API support)
     */
    public function setVouchers(Collection $vouchers, ConnectionInterface $con = null)
    {
        /** @var ChildVoucher[] $vouchersToDelete */
        $vouchersToDelete = $this->getVouchers(new Criteria(), $con)->diff($vouchers);


        $this->vouchersScheduledForDeletion = $vouchersToDelete;

        foreach ($vouchersToDelete as $voucherRemoved) {
            $voucherRemoved->setParticipante(null);
        }

        $this->collVouchers = null;
        foreach ($vouchers as $voucher) {
            $this->addVoucher($voucher);
        }

        $this->collVouchers = $vouchers;
        $this->collVouchersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Voucher objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Voucher objects.
     * @throws PropelException
     */
    public function countVouchers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVouchersPartial && !$this->isNew();
        if (null === $this->collVouchers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVouchers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVouchers());
            }

            $query = ChildVoucherQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParticipante($this)
                ->count($con);
        }

        return count($this->collVouchers);
    }

    /**
     * Method called to associate a ChildVoucher object to this object
     * through the ChildVoucher foreign key attribute.
     *
     * @param  ChildVoucher $l ChildVoucher
     * @return $this|\Participante The current object (for fluent API support)
     */
    public function addVoucher(ChildVoucher $l)
    {
        if ($this->collVouchers === null) {
            $this->initVouchers();
            $this->collVouchersPartial = true;
        }

        if (!$this->collVouchers->contains($l)) {
            $this->doAddVoucher($l);
        }

        return $this;
    }

    /**
     * @param ChildVoucher $voucher The ChildVoucher object to add.
     */
    protected function doAddVoucher(ChildVoucher $voucher)
    {
        $this->collVouchers[]= $voucher;
        $voucher->setParticipante($this);
    }

    /**
     * @param  ChildVoucher $voucher The ChildVoucher object to remove.
     * @return $this|ChildParticipante The current object (for fluent API support)
     */
    public function removeVoucher(ChildVoucher $voucher)
    {
        if ($this->getVouchers()->contains($voucher)) {
            $pos = $this->collVouchers->search($voucher);
            $this->collVouchers->remove($pos);
            if (null === $this->vouchersScheduledForDeletion) {
                $this->vouchersScheduledForDeletion = clone $this->collVouchers;
                $this->vouchersScheduledForDeletion->clear();
            }
            $this->vouchersScheduledForDeletion[]= clone $voucher;
            $voucher->setParticipante(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Participante is new, it will return
     * an empty collection; or if this Participante has previously
     * been saved, it will retrieve related Vouchers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Participante.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVoucher[] List of ChildVoucher objects
     */
    public function getVouchersJoinBeneficio(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVoucherQuery::create(null, $criteria);
        $query->joinWith('Beneficio', $joinBehavior);

        return $this->getVouchers($query, $con);
    }

    /**
     * Clears out the collPreferencias collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPreferencias()
     */
    public function clearPreferencias()
    {
        $this->collPreferencias = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collPreferencias crossRef collection.
     *
     * By default this just sets the collPreferencias collection to an empty collection (like clearPreferencias());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initPreferencias()
    {
        $this->collPreferencias = new ObjectCollection();
        $this->collPreferenciasPartial = true;

        $this->collPreferencias->setModel('\Preferencia');
    }

    /**
     * Checks if the collPreferencias collection is loaded.
     *
     * @return bool
     */
    public function isPreferenciasLoaded()
    {
        return null !== $this->collPreferencias;
    }

    /**
     * Gets a collection of ChildPreferencia objects related by a many-to-many relationship
     * to the current object by way of the participantes_preferencias cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParticipante is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildPreferencia[] List of ChildPreferencia objects
     */
    public function getPreferencias(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPreferenciasPartial && !$this->isNew();
        if (null === $this->collPreferencias || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPreferencias) {
                    $this->initPreferencias();
                }
            } else {

                $query = ChildPreferenciaQuery::create(null, $criteria)
                    ->filterByParticipante($this);
                $collPreferencias = $query->find($con);
                if (null !== $criteria) {
                    return $collPreferencias;
                }

                if ($partial && $this->collPreferencias) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collPreferencias as $obj) {
                        if (!$collPreferencias->contains($obj)) {
                            $collPreferencias[] = $obj;
                        }
                    }
                }

                $this->collPreferencias = $collPreferencias;
                $this->collPreferenciasPartial = false;
            }
        }

        return $this->collPreferencias;
    }

    /**
     * Sets a collection of Preferencia objects related by a many-to-many relationship
     * to the current object by way of the participantes_preferencias cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $preferencias A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildParticipante The current object (for fluent API support)
     */
    public function setPreferencias(Collection $preferencias, ConnectionInterface $con = null)
    {
        $this->clearPreferencias();
        $currentPreferencias = $this->getPreferencias();

        $preferenciasScheduledForDeletion = $currentPreferencias->diff($preferencias);

        foreach ($preferenciasScheduledForDeletion as $toDelete) {
            $this->removePreferencia($toDelete);
        }

        foreach ($preferencias as $preferencia) {
            if (!$currentPreferencias->contains($preferencia)) {
                $this->doAddPreferencia($preferencia);
            }
        }

        $this->collPreferenciasPartial = false;
        $this->collPreferencias = $preferencias;

        return $this;
    }

    /**
     * Gets the number of Preferencia objects related by a many-to-many relationship
     * to the current object by way of the participantes_preferencias cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Preferencia objects
     */
    public function countPreferencias(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPreferenciasPartial && !$this->isNew();
        if (null === $this->collPreferencias || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPreferencias) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getPreferencias());
                }

                $query = ChildPreferenciaQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByParticipante($this)
                    ->count($con);
            }
        } else {
            return count($this->collPreferencias);
        }
    }

    /**
     * Associate a ChildPreferencia to this object
     * through the participantes_preferencias cross reference table.
     *
     * @param ChildPreferencia $preferencia
     * @return ChildParticipante The current object (for fluent API support)
     */
    public function addPreferencia(ChildPreferencia $preferencia)
    {
        if ($this->collPreferencias === null) {
            $this->initPreferencias();
        }

        if (!$this->getPreferencias()->contains($preferencia)) {
            // only add it if the **same** object is not already associated
            $this->collPreferencias->push($preferencia);
            $this->doAddPreferencia($preferencia);
        }

        return $this;
    }

    /**
     *
     * @param ChildPreferencia $preferencia
     */
    protected function doAddPreferencia(ChildPreferencia $preferencia)
    {
        $participantesPreferencias = new ChildParticipantesPreferencias();

        $participantesPreferencias->setPreferencia($preferencia);

        $participantesPreferencias->setParticipante($this);

        $this->addParticipantesPreferencias($participantesPreferencias);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$preferencia->isParticipantesLoaded()) {
            $preferencia->initParticipantes();
            $preferencia->getParticipantes()->push($this);
        } elseif (!$preferencia->getParticipantes()->contains($this)) {
            $preferencia->getParticipantes()->push($this);
        }

    }

    /**
     * Remove preferencia of this object
     * through the participantes_preferencias cross reference table.
     *
     * @param ChildPreferencia $preferencia
     * @return ChildParticipante The current object (for fluent API support)
     */
    public function removePreferencia(ChildPreferencia $preferencia)
    {
        if ($this->getPreferencias()->contains($preferencia)) { $participantesPreferencias = new ChildParticipantesPreferencias();

            $participantesPreferencias->setPreferencia($preferencia);
            if ($preferencia->isParticipantesLoaded()) {
                //remove the back reference if available
                $preferencia->getParticipantes()->removeObject($this);
            }

            $participantesPreferencias->setParticipante($this);
            $this->removeParticipantesPreferencias(clone $participantesPreferencias);
            $participantesPreferencias->clear();

            $this->collPreferencias->remove($this->collPreferencias->search($preferencia));

            if (null === $this->preferenciasScheduledForDeletion) {
                $this->preferenciasScheduledForDeletion = clone $this->collPreferencias;
                $this->preferenciasScheduledForDeletion->clear();
            }

            $this->preferenciasScheduledForDeletion->push($preferencia);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUsuario) {
            $this->aUsuario->removeParticipante($this);
        }
        $this->id = null;
        $this->usuario_id = null;
        $this->cpf = null;
        $this->fim_validade = null;
        $this->nome = null;
        $this->sobrenome = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collParticipantesPreferenciass) {
                foreach ($this->collParticipantesPreferenciass as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPagamentos) {
                foreach ($this->collPagamentos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVouchers) {
                foreach ($this->collVouchers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPreferencias) {
                foreach ($this->collPreferencias as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collParticipantesPreferenciass = null;
        $this->collPagamentos = null;
        $this->collVouchers = null;
        $this->collPreferencias = null;
        $this->aUsuario = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ParticipanteTableMap::DEFAULT_STRING_FORMAT);
    }

    // validate behavior

    /**
     * Configure validators constraints. The Validator object uses this method
     * to perform object validation.
     *
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('cpf', new Unique());
    }

    /**
     * Validates the object and all objects related to this table.
     *
     * @see        getValidationFailures()
     * @param      object $validator A Validator class instance
     * @return     boolean Whether all objects pass validation.
     */
    public function validate(ValidatorInterface $validator = null)
    {
        if (null === $validator) {
            if(class_exists('Symfony\\Component\\Validator\\Validator\\LegacyValidator')){
                $validator = new LegacyValidator(
                            new ExecutionContextFactory(new DefaultTranslator()),
                            new ClassMetaDataFactory(new StaticMethodLoader()),
                            new ConstraintValidatorFactory()
                );
            }else{
                $validator = new Validator(
                            new ClassMetadataFactory(new StaticMethodLoader()),
                            new ConstraintValidatorFactory(),
                            new DefaultTranslator()
                );
            }
        }

        $failureMap = new ConstraintViolationList();

        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aUsuario, 'validate')) {
                if (!$this->aUsuario->validate($validator)) {
                    $failureMap->addAll($this->aUsuario->getValidationFailures());
                }
            }

            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collParticipantesPreferenciass) {
                foreach ($this->collParticipantesPreferenciass as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPagamentos) {
                foreach ($this->collPagamentos as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collVouchers) {
                foreach ($this->collVouchers as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }

            $this->alreadyInValidation = false;
        }

        $this->validationFailures = $failureMap;

        return (Boolean) (!(count($this->validationFailures) > 0));

    }

    /**
     * Gets any ConstraintViolation objects that resulted from last call to validate().
     *
     *
     * @return     object ConstraintViolationList
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {

    // delegate behavior

    if (is_callable(array('\Usuario', $name))) {
        if (!$delegate = $this->getUsuario()) {
            $delegate = new ChildUsuario();
            $this->setUsuario($delegate);
        }

        return call_user_func_array(array($delegate, $name), $params);
    }
        return $this->__parentCall($name, $params);
    }

    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __parentCall($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
