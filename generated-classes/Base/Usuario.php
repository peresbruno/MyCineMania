<?php

namespace Base;

use \Participante as ChildParticipante;
use \ParticipanteQuery as ChildParticipanteQuery;
use \RedeCinema as ChildRedeCinema;
use \RedeCinemaQuery as ChildRedeCinemaQuery;
use \Usuario as ChildUsuario;
use \UsuarioQuery as ChildUsuarioQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\UsuarioTableMap;
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
 * Base class that represents a row from the 'usuarios' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Usuario implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UsuarioTableMap';


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
     * The value for the data_inscricao field.
     * @var        \DateTime
     */
    protected $data_inscricao;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the liberado field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $liberado;

    /**
     * The value for the nome_usuario field.
     * @var        string
     */
    protected $nome_usuario;

    /**
     * The value for the senha field.
     * @var        string
     */
    protected $senha;

    /**
     * The value for the tipo field.
     * @var        int
     */
    protected $tipo;

    /**
     * @var        ObjectCollection|ChildParticipante[] Collection to store aggregation of ChildParticipante objects.
     */
    protected $collParticipantes;
    protected $collParticipantesPartial;

    /**
     * @var        ObjectCollection|ChildRedeCinema[] Collection to store aggregation of ChildRedeCinema objects.
     */
    protected $collRedeCinemas;
    protected $collRedeCinemasPartial;

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
     * @var ObjectCollection|ChildParticipante[]
     */
    protected $participantesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRedeCinema[]
     */
    protected $redeCinemasScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->liberado = false;
    }

    /**
     * Initializes internal state of Base\Usuario object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Usuario</code> instance.  If
     * <code>obj</code> is an instance of <code>Usuario</code>, delegates to
     * <code>equals(Usuario)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Usuario The current object, for fluid interface
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
     * Get the [optionally formatted] temporal [data_inscricao] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDataInscricao($format = NULL)
    {
        if ($format === null) {
            return $this->data_inscricao;
        } else {
            return $this->data_inscricao instanceof \DateTime ? $this->data_inscricao->format($format) : null;
        }
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [liberado] column value.
     *
     * @return boolean
     */
    public function getLiberado()
    {
        return $this->liberado;
    }

    /**
     * Get the [liberado] column value.
     *
     * @return boolean
     */
    public function isLiberado()
    {
        return $this->getLiberado();
    }

    /**
     * Get the [nome_usuario] column value.
     *
     * @return string
     */
    public function getNomeUsuario()
    {
        return $this->nome_usuario;
    }

    /**
     * Get the [senha] column value.
     *
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Get the [tipo] column value.
     *
     * @return string
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getTipo()
    {
        if (null === $this->tipo) {
            return null;
        }
        $valueSet = UsuarioTableMap::getValueSet(UsuarioTableMap::COL_TIPO);
        if (!isset($valueSet[$this->tipo])) {
            throw new PropelException('Unknown stored enum key: ' . $this->tipo);
        }

        return $valueSet[$this->tipo];
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Sets the value of [data_inscricao] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setDataInscricao($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->data_inscricao !== null || $dt !== null) {
            if ($dt !== $this->data_inscricao) {
                $this->data_inscricao = $dt;
                $this->modifiedColumns[UsuarioTableMap::COL_DATA_INSCRICAO] = true;
            }
        } // if either are not null

        return $this;
    } // setDataInscricao()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Sets the value of the [liberado] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setLiberado($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->liberado !== $v) {
            $this->liberado = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_LIBERADO] = true;
        }

        return $this;
    } // setLiberado()

    /**
     * Set the value of [nome_usuario] column.
     *
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setNomeUsuario($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nome_usuario !== $v) {
            $this->nome_usuario = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_NOME_USUARIO] = true;
        }

        return $this;
    } // setNomeUsuario()

    /**
     * Set the value of [senha] column.
     *
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setSenha($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->senha !== $v) {
            $this->senha = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_SENHA] = true;
        }

        return $this;
    } // setSenha()

    /**
     * Set the value of [tipo] column.
     *
     * @param  string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setTipo($v)
    {
        if ($v !== null) {
            $valueSet = UsuarioTableMap::getValueSet(UsuarioTableMap::COL_TIPO);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->tipo !== $v) {
            $this->tipo = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_TIPO] = true;
        }

        return $this;
    } // setTipo()

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
            if ($this->liberado !== false) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UsuarioTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UsuarioTableMap::translateFieldName('DataInscricao', TableMap::TYPE_PHPNAME, $indexType)];
            $this->data_inscricao = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UsuarioTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UsuarioTableMap::translateFieldName('Liberado', TableMap::TYPE_PHPNAME, $indexType)];
            $this->liberado = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UsuarioTableMap::translateFieldName('NomeUsuario', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nome_usuario = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UsuarioTableMap::translateFieldName('Senha', TableMap::TYPE_PHPNAME, $indexType)];
            $this->senha = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UsuarioTableMap::translateFieldName('Tipo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tipo = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = UsuarioTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Usuario'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UsuarioTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUsuarioQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collParticipantes = null;

            $this->collRedeCinemas = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Usuario::setDeleted()
     * @see Usuario::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsuarioTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUsuarioQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UsuarioTableMap::DATABASE_NAME);
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
                UsuarioTableMap::addInstanceToPool($this);
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

            if ($this->participantesScheduledForDeletion !== null) {
                if (!$this->participantesScheduledForDeletion->isEmpty()) {
                    \ParticipanteQuery::create()
                        ->filterByPrimaryKeys($this->participantesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->participantesScheduledForDeletion = null;
                }
            }

            if ($this->collParticipantes !== null) {
                foreach ($this->collParticipantes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->redeCinemasScheduledForDeletion !== null) {
                if (!$this->redeCinemasScheduledForDeletion->isEmpty()) {
                    \RedeCinemaQuery::create()
                        ->filterByPrimaryKeys($this->redeCinemasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->redeCinemasScheduledForDeletion = null;
                }
            }

            if ($this->collRedeCinemas !== null) {
                foreach ($this->collRedeCinemas as $referrerFK) {
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

        $this->modifiedColumns[UsuarioTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UsuarioTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('usuarios_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UsuarioTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_DATA_INSCRICAO)) {
            $modifiedColumns[':p' . $index++]  = 'data_inscricao';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_LIBERADO)) {
            $modifiedColumns[':p' . $index++]  = 'liberado';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_NOME_USUARIO)) {
            $modifiedColumns[':p' . $index++]  = 'nome_usuario';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_SENHA)) {
            $modifiedColumns[':p' . $index++]  = 'senha';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_TIPO)) {
            $modifiedColumns[':p' . $index++]  = 'tipo';
        }

        $sql = sprintf(
            'INSERT INTO usuarios (%s) VALUES (%s)',
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
                    case 'data_inscricao':
                        $stmt->bindValue($identifier, $this->data_inscricao ? $this->data_inscricao->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'liberado':
                        $stmt->bindValue($identifier, $this->liberado, PDO::PARAM_BOOL);
                        break;
                    case 'nome_usuario':
                        $stmt->bindValue($identifier, $this->nome_usuario, PDO::PARAM_STR);
                        break;
                    case 'senha':
                        $stmt->bindValue($identifier, $this->senha, PDO::PARAM_STR);
                        break;
                    case 'tipo':
                        $stmt->bindValue($identifier, $this->tipo, PDO::PARAM_INT);
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
        $pos = UsuarioTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getDataInscricao();
                break;
            case 2:
                return $this->getEmail();
                break;
            case 3:
                return $this->getLiberado();
                break;
            case 4:
                return $this->getNomeUsuario();
                break;
            case 5:
                return $this->getSenha();
                break;
            case 6:
                return $this->getTipo();
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

        if (isset($alreadyDumpedObjects['Usuario'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Usuario'][$this->hashCode()] = true;
        $keys = UsuarioTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getDataInscricao(),
            $keys[2] => $this->getEmail(),
            $keys[3] => $this->getLiberado(),
            $keys[4] => $this->getNomeUsuario(),
            $keys[5] => $this->getSenha(),
            $keys[6] => $this->getTipo(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[1]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[1]];
            $result[$keys[1]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collParticipantes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'participantes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'participantess';
                        break;
                    default:
                        $key = 'Participantes';
                }

                $result[$key] = $this->collParticipantes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRedeCinemas) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'redeCinemas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'redes_cinemas';
                        break;
                    default:
                        $key = 'RedeCinemas';
                }

                $result[$key] = $this->collRedeCinemas->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Usuario
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsuarioTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Usuario
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setDataInscricao($value);
                break;
            case 2:
                $this->setEmail($value);
                break;
            case 3:
                $this->setLiberado($value);
                break;
            case 4:
                $this->setNomeUsuario($value);
                break;
            case 5:
                $this->setSenha($value);
                break;
            case 6:
                $valueSet = UsuarioTableMap::getValueSet(UsuarioTableMap::COL_TIPO);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setTipo($value);
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
        $keys = UsuarioTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDataInscricao($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEmail($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLiberado($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setNomeUsuario($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSenha($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setTipo($arr[$keys[6]]);
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
     * @return $this|\Usuario The current object, for fluid interface
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
        $criteria = new Criteria(UsuarioTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UsuarioTableMap::COL_ID)) {
            $criteria->add(UsuarioTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_DATA_INSCRICAO)) {
            $criteria->add(UsuarioTableMap::COL_DATA_INSCRICAO, $this->data_inscricao);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_EMAIL)) {
            $criteria->add(UsuarioTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_LIBERADO)) {
            $criteria->add(UsuarioTableMap::COL_LIBERADO, $this->liberado);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_NOME_USUARIO)) {
            $criteria->add(UsuarioTableMap::COL_NOME_USUARIO, $this->nome_usuario);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_SENHA)) {
            $criteria->add(UsuarioTableMap::COL_SENHA, $this->senha);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_TIPO)) {
            $criteria->add(UsuarioTableMap::COL_TIPO, $this->tipo);
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
        $criteria = ChildUsuarioQuery::create();
        $criteria->add(UsuarioTableMap::COL_ID, $this->id);

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
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Usuario (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDataInscricao($this->getDataInscricao());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setLiberado($this->getLiberado());
        $copyObj->setNomeUsuario($this->getNomeUsuario());
        $copyObj->setSenha($this->getSenha());
        $copyObj->setTipo($this->getTipo());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getParticipantes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addParticipante($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRedeCinemas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRedeCinema($relObj->copy($deepCopy));
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
     * @return \Usuario Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Participante' == $relationName) {
            return $this->initParticipantes();
        }
        if ('RedeCinema' == $relationName) {
            return $this->initRedeCinemas();
        }
    }

    /**
     * Clears out the collParticipantes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addParticipantes()
     */
    public function clearParticipantes()
    {
        $this->collParticipantes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collParticipantes collection loaded partially.
     */
    public function resetPartialParticipantes($v = true)
    {
        $this->collParticipantesPartial = $v;
    }

    /**
     * Initializes the collParticipantes collection.
     *
     * By default this just sets the collParticipantes collection to an empty array (like clearcollParticipantes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initParticipantes($overrideExisting = true)
    {
        if (null !== $this->collParticipantes && !$overrideExisting) {
            return;
        }
        $this->collParticipantes = new ObjectCollection();
        $this->collParticipantes->setModel('\Participante');
    }

    /**
     * Gets an array of ChildParticipante objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildParticipante[] List of ChildParticipante objects
     * @throws PropelException
     */
    public function getParticipantes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantesPartial && !$this->isNew();
        if (null === $this->collParticipantes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collParticipantes) {
                // return empty collection
                $this->initParticipantes();
            } else {
                $collParticipantes = ChildParticipanteQuery::create(null, $criteria)
                    ->filterByUsuario($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collParticipantesPartial && count($collParticipantes)) {
                        $this->initParticipantes(false);

                        foreach ($collParticipantes as $obj) {
                            if (false == $this->collParticipantes->contains($obj)) {
                                $this->collParticipantes->append($obj);
                            }
                        }

                        $this->collParticipantesPartial = true;
                    }

                    return $collParticipantes;
                }

                if ($partial && $this->collParticipantes) {
                    foreach ($this->collParticipantes as $obj) {
                        if ($obj->isNew()) {
                            $collParticipantes[] = $obj;
                        }
                    }
                }

                $this->collParticipantes = $collParticipantes;
                $this->collParticipantesPartial = false;
            }
        }

        return $this->collParticipantes;
    }

    /**
     * Sets a collection of ChildParticipante objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $participantes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setParticipantes(Collection $participantes, ConnectionInterface $con = null)
    {
        /** @var ChildParticipante[] $participantesToDelete */
        $participantesToDelete = $this->getParticipantes(new Criteria(), $con)->diff($participantes);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->participantesScheduledForDeletion = clone $participantesToDelete;

        foreach ($participantesToDelete as $participanteRemoved) {
            $participanteRemoved->setUsuario(null);
        }

        $this->collParticipantes = null;
        foreach ($participantes as $participante) {
            $this->addParticipante($participante);
        }

        $this->collParticipantes = $participantes;
        $this->collParticipantesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Participante objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Participante objects.
     * @throws PropelException
     */
    public function countParticipantes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantesPartial && !$this->isNew();
        if (null === $this->collParticipantes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collParticipantes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getParticipantes());
            }

            $query = ChildParticipanteQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuario($this)
                ->count($con);
        }

        return count($this->collParticipantes);
    }

    /**
     * Method called to associate a ChildParticipante object to this object
     * through the ChildParticipante foreign key attribute.
     *
     * @param  ChildParticipante $l ChildParticipante
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addParticipante(ChildParticipante $l)
    {
        if ($this->collParticipantes === null) {
            $this->initParticipantes();
            $this->collParticipantesPartial = true;
        }

        if (!$this->collParticipantes->contains($l)) {
            $this->doAddParticipante($l);
        }

        return $this;
    }

    /**
     * @param ChildParticipante $participante The ChildParticipante object to add.
     */
    protected function doAddParticipante(ChildParticipante $participante)
    {
        $this->collParticipantes[]= $participante;
        $participante->setUsuario($this);
    }

    /**
     * @param  ChildParticipante $participante The ChildParticipante object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeParticipante(ChildParticipante $participante)
    {
        if ($this->getParticipantes()->contains($participante)) {
            $pos = $this->collParticipantes->search($participante);
            $this->collParticipantes->remove($pos);
            if (null === $this->participantesScheduledForDeletion) {
                $this->participantesScheduledForDeletion = clone $this->collParticipantes;
                $this->participantesScheduledForDeletion->clear();
            }
            $this->participantesScheduledForDeletion[]= clone $participante;
            $participante->setUsuario(null);
        }

        return $this;
    }

    /**
     * Clears out the collRedeCinemas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRedeCinemas()
     */
    public function clearRedeCinemas()
    {
        $this->collRedeCinemas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRedeCinemas collection loaded partially.
     */
    public function resetPartialRedeCinemas($v = true)
    {
        $this->collRedeCinemasPartial = $v;
    }

    /**
     * Initializes the collRedeCinemas collection.
     *
     * By default this just sets the collRedeCinemas collection to an empty array (like clearcollRedeCinemas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRedeCinemas($overrideExisting = true)
    {
        if (null !== $this->collRedeCinemas && !$overrideExisting) {
            return;
        }
        $this->collRedeCinemas = new ObjectCollection();
        $this->collRedeCinemas->setModel('\RedeCinema');
    }

    /**
     * Gets an array of ChildRedeCinema objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRedeCinema[] List of ChildRedeCinema objects
     * @throws PropelException
     */
    public function getRedeCinemas(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRedeCinemasPartial && !$this->isNew();
        if (null === $this->collRedeCinemas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRedeCinemas) {
                // return empty collection
                $this->initRedeCinemas();
            } else {
                $collRedeCinemas = ChildRedeCinemaQuery::create(null, $criteria)
                    ->filterByUsuario($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRedeCinemasPartial && count($collRedeCinemas)) {
                        $this->initRedeCinemas(false);

                        foreach ($collRedeCinemas as $obj) {
                            if (false == $this->collRedeCinemas->contains($obj)) {
                                $this->collRedeCinemas->append($obj);
                            }
                        }

                        $this->collRedeCinemasPartial = true;
                    }

                    return $collRedeCinemas;
                }

                if ($partial && $this->collRedeCinemas) {
                    foreach ($this->collRedeCinemas as $obj) {
                        if ($obj->isNew()) {
                            $collRedeCinemas[] = $obj;
                        }
                    }
                }

                $this->collRedeCinemas = $collRedeCinemas;
                $this->collRedeCinemasPartial = false;
            }
        }

        return $this->collRedeCinemas;
    }

    /**
     * Sets a collection of ChildRedeCinema objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $redeCinemas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setRedeCinemas(Collection $redeCinemas, ConnectionInterface $con = null)
    {
        /** @var ChildRedeCinema[] $redeCinemasToDelete */
        $redeCinemasToDelete = $this->getRedeCinemas(new Criteria(), $con)->diff($redeCinemas);


        $this->redeCinemasScheduledForDeletion = $redeCinemasToDelete;

        foreach ($redeCinemasToDelete as $redeCinemaRemoved) {
            $redeCinemaRemoved->setUsuario(null);
        }

        $this->collRedeCinemas = null;
        foreach ($redeCinemas as $redeCinema) {
            $this->addRedeCinema($redeCinema);
        }

        $this->collRedeCinemas = $redeCinemas;
        $this->collRedeCinemasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RedeCinema objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RedeCinema objects.
     * @throws PropelException
     */
    public function countRedeCinemas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRedeCinemasPartial && !$this->isNew();
        if (null === $this->collRedeCinemas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRedeCinemas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRedeCinemas());
            }

            $query = ChildRedeCinemaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuario($this)
                ->count($con);
        }

        return count($this->collRedeCinemas);
    }

    /**
     * Method called to associate a ChildRedeCinema object to this object
     * through the ChildRedeCinema foreign key attribute.
     *
     * @param  ChildRedeCinema $l ChildRedeCinema
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addRedeCinema(ChildRedeCinema $l)
    {
        if ($this->collRedeCinemas === null) {
            $this->initRedeCinemas();
            $this->collRedeCinemasPartial = true;
        }

        if (!$this->collRedeCinemas->contains($l)) {
            $this->doAddRedeCinema($l);
        }

        return $this;
    }

    /**
     * @param ChildRedeCinema $redeCinema The ChildRedeCinema object to add.
     */
    protected function doAddRedeCinema(ChildRedeCinema $redeCinema)
    {
        $this->collRedeCinemas[]= $redeCinema;
        $redeCinema->setUsuario($this);
    }

    /**
     * @param  ChildRedeCinema $redeCinema The ChildRedeCinema object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeRedeCinema(ChildRedeCinema $redeCinema)
    {
        if ($this->getRedeCinemas()->contains($redeCinema)) {
            $pos = $this->collRedeCinemas->search($redeCinema);
            $this->collRedeCinemas->remove($pos);
            if (null === $this->redeCinemasScheduledForDeletion) {
                $this->redeCinemasScheduledForDeletion = clone $this->collRedeCinemas;
                $this->redeCinemasScheduledForDeletion->clear();
            }
            $this->redeCinemasScheduledForDeletion[]= clone $redeCinema;
            $redeCinema->setUsuario(null);
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
        $this->id = null;
        $this->data_inscricao = null;
        $this->email = null;
        $this->liberado = null;
        $this->nome_usuario = null;
        $this->senha = null;
        $this->tipo = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collParticipantes) {
                foreach ($this->collParticipantes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRedeCinemas) {
                foreach ($this->collRedeCinemas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collParticipantes = null;
        $this->collRedeCinemas = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UsuarioTableMap::DEFAULT_STRING_FORMAT);
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
        $metadata->addPropertyConstraint('email', new Unique());
        $metadata->addPropertyConstraint('nome_usuario', new Unique());
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


            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collParticipantes) {
                foreach ($this->collParticipantes as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collRedeCinemas) {
                foreach ($this->collRedeCinemas as $referrerFK) {
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
    public function __call($name, $params)
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
