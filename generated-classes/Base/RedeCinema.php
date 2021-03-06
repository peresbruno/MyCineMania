<?php

namespace Base;

use \Beneficio as ChildBeneficio;
use \BeneficioQuery as ChildBeneficioQuery;
use \RedeCinema as ChildRedeCinema;
use \RedeCinemaQuery as ChildRedeCinemaQuery;
use \Usuario as ChildUsuario;
use \UsuarioQuery as ChildUsuarioQuery;
use \Exception;
use \PDO;
use Map\RedeCinemaTableMap;
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
 * Base class that represents a row from the 'redes_cinema' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class RedeCinema implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\RedeCinemaTableMap';


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
     * The value for the cnpj field.
     * @var        string
     */
    protected $cnpj;

    /**
     * The value for the usuario_id field.
     * @var        int
     */
    protected $usuario_id;

    /**
     * The value for the nome_fantasia field.
     * @var        string
     */
    protected $nome_fantasia;

    /**
     * The value for the razao_social field.
     * @var        string
     */
    protected $razao_social;

    /**
     * The value for the endereco field.
     * @var        string
     */
    protected $endereco;

    /**
     * @var        ChildUsuario
     */
    protected $aUsuario;

    /**
     * @var        ObjectCollection|ChildBeneficio[] Collection to store aggregation of ChildBeneficio objects.
     */
    protected $collBeneficios;
    protected $collBeneficiosPartial;

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
     * @var ObjectCollection|ChildBeneficio[]
     */
    protected $beneficiosScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\RedeCinema object.
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
     * Compares this with another <code>RedeCinema</code> instance.  If
     * <code>obj</code> is an instance of <code>RedeCinema</code>, delegates to
     * <code>equals(RedeCinema)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|RedeCinema The current object, for fluid interface
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
     * Get the [cnpj] column value.
     *
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
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
     * Get the [nome_fantasia] column value.
     *
     * @return string
     */
    public function getNomeFantasia()
    {
        return $this->nome_fantasia;
    }

    /**
     * Get the [razao_social] column value.
     *
     * @return string
     */
    public function getRazaoSocial()
    {
        return $this->razao_social;
    }

    /**
     * Get the [endereco] column value.
     *
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\RedeCinema The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[RedeCinemaTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [cnpj] column.
     *
     * @param string $v new value
     * @return $this|\RedeCinema The current object (for fluent API support)
     */
    public function setCnpj($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cnpj !== $v) {
            $this->cnpj = $v;
            $this->modifiedColumns[RedeCinemaTableMap::COL_CNPJ] = true;
        }

        return $this;
    } // setCnpj()

    /**
     * Set the value of [usuario_id] column.
     *
     * @param int $v new value
     * @return $this|\RedeCinema The current object (for fluent API support)
     */
    public function setUsuarioId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->usuario_id !== $v) {
            $this->usuario_id = $v;
            $this->modifiedColumns[RedeCinemaTableMap::COL_USUARIO_ID] = true;
        }

        if ($this->aUsuario !== null && $this->aUsuario->getId() !== $v) {
            $this->aUsuario = null;
        }

        return $this;
    } // setUsuarioId()

    /**
     * Set the value of [nome_fantasia] column.
     *
     * @param string $v new value
     * @return $this|\RedeCinema The current object (for fluent API support)
     */
    public function setNomeFantasia($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nome_fantasia !== $v) {
            $this->nome_fantasia = $v;
            $this->modifiedColumns[RedeCinemaTableMap::COL_NOME_FANTASIA] = true;
        }

        return $this;
    } // setNomeFantasia()

    /**
     * Set the value of [razao_social] column.
     *
     * @param string $v new value
     * @return $this|\RedeCinema The current object (for fluent API support)
     */
    public function setRazaoSocial($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->razao_social !== $v) {
            $this->razao_social = $v;
            $this->modifiedColumns[RedeCinemaTableMap::COL_RAZAO_SOCIAL] = true;
        }

        return $this;
    } // setRazaoSocial()

    /**
     * Set the value of [endereco] column.
     *
     * @param string $v new value
     * @return $this|\RedeCinema The current object (for fluent API support)
     */
    public function setEndereco($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->endereco !== $v) {
            $this->endereco = $v;
            $this->modifiedColumns[RedeCinemaTableMap::COL_ENDERECO] = true;
        }

        return $this;
    } // setEndereco()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RedeCinemaTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RedeCinemaTableMap::translateFieldName('Cnpj', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cnpj = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RedeCinemaTableMap::translateFieldName('UsuarioId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->usuario_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RedeCinemaTableMap::translateFieldName('NomeFantasia', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nome_fantasia = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : RedeCinemaTableMap::translateFieldName('RazaoSocial', TableMap::TYPE_PHPNAME, $indexType)];
            $this->razao_social = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : RedeCinemaTableMap::translateFieldName('Endereco', TableMap::TYPE_PHPNAME, $indexType)];
            $this->endereco = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = RedeCinemaTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\RedeCinema'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(RedeCinemaTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRedeCinemaQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUsuario = null;
            $this->collBeneficios = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see RedeCinema::setDeleted()
     * @see RedeCinema::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RedeCinemaTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRedeCinemaQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(RedeCinemaTableMap::DATABASE_NAME);
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
                RedeCinemaTableMap::addInstanceToPool($this);
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

            if ($this->beneficiosScheduledForDeletion !== null) {
                if (!$this->beneficiosScheduledForDeletion->isEmpty()) {
                    \BeneficioQuery::create()
                        ->filterByPrimaryKeys($this->beneficiosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->beneficiosScheduledForDeletion = null;
                }
            }

            if ($this->collBeneficios !== null) {
                foreach ($this->collBeneficios as $referrerFK) {
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

        $this->modifiedColumns[RedeCinemaTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RedeCinemaTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('redes_cinema_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RedeCinemaTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(RedeCinemaTableMap::COL_CNPJ)) {
            $modifiedColumns[':p' . $index++]  = 'cnpj';
        }
        if ($this->isColumnModified(RedeCinemaTableMap::COL_USUARIO_ID)) {
            $modifiedColumns[':p' . $index++]  = 'usuario_id';
        }
        if ($this->isColumnModified(RedeCinemaTableMap::COL_NOME_FANTASIA)) {
            $modifiedColumns[':p' . $index++]  = 'nome_fantasia';
        }
        if ($this->isColumnModified(RedeCinemaTableMap::COL_RAZAO_SOCIAL)) {
            $modifiedColumns[':p' . $index++]  = 'razao_social';
        }
        if ($this->isColumnModified(RedeCinemaTableMap::COL_ENDERECO)) {
            $modifiedColumns[':p' . $index++]  = 'endereco';
        }

        $sql = sprintf(
            'INSERT INTO redes_cinema (%s) VALUES (%s)',
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
                    case 'cnpj':
                        $stmt->bindValue($identifier, $this->cnpj, PDO::PARAM_STR);
                        break;
                    case 'usuario_id':
                        $stmt->bindValue($identifier, $this->usuario_id, PDO::PARAM_INT);
                        break;
                    case 'nome_fantasia':
                        $stmt->bindValue($identifier, $this->nome_fantasia, PDO::PARAM_STR);
                        break;
                    case 'razao_social':
                        $stmt->bindValue($identifier, $this->razao_social, PDO::PARAM_STR);
                        break;
                    case 'endereco':
                        $stmt->bindValue($identifier, $this->endereco, PDO::PARAM_STR);
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
        $pos = RedeCinemaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCnpj();
                break;
            case 2:
                return $this->getUsuarioId();
                break;
            case 3:
                return $this->getNomeFantasia();
                break;
            case 4:
                return $this->getRazaoSocial();
                break;
            case 5:
                return $this->getEndereco();
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

        if (isset($alreadyDumpedObjects['RedeCinema'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['RedeCinema'][$this->hashCode()] = true;
        $keys = RedeCinemaTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCnpj(),
            $keys[2] => $this->getUsuarioId(),
            $keys[3] => $this->getNomeFantasia(),
            $keys[4] => $this->getRazaoSocial(),
            $keys[5] => $this->getEndereco(),
        );
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
            if (null !== $this->collBeneficios) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'beneficios';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'beneficioss';
                        break;
                    default:
                        $key = 'Beneficios';
                }

                $result[$key] = $this->collBeneficios->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\RedeCinema
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RedeCinemaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\RedeCinema
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCnpj($value);
                break;
            case 2:
                $this->setUsuarioId($value);
                break;
            case 3:
                $this->setNomeFantasia($value);
                break;
            case 4:
                $this->setRazaoSocial($value);
                break;
            case 5:
                $this->setEndereco($value);
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
        $keys = RedeCinemaTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCnpj($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUsuarioId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setNomeFantasia($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setRazaoSocial($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setEndereco($arr[$keys[5]]);
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
     * @return $this|\RedeCinema The current object, for fluid interface
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
        $criteria = new Criteria(RedeCinemaTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RedeCinemaTableMap::COL_ID)) {
            $criteria->add(RedeCinemaTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(RedeCinemaTableMap::COL_CNPJ)) {
            $criteria->add(RedeCinemaTableMap::COL_CNPJ, $this->cnpj);
        }
        if ($this->isColumnModified(RedeCinemaTableMap::COL_USUARIO_ID)) {
            $criteria->add(RedeCinemaTableMap::COL_USUARIO_ID, $this->usuario_id);
        }
        if ($this->isColumnModified(RedeCinemaTableMap::COL_NOME_FANTASIA)) {
            $criteria->add(RedeCinemaTableMap::COL_NOME_FANTASIA, $this->nome_fantasia);
        }
        if ($this->isColumnModified(RedeCinemaTableMap::COL_RAZAO_SOCIAL)) {
            $criteria->add(RedeCinemaTableMap::COL_RAZAO_SOCIAL, $this->razao_social);
        }
        if ($this->isColumnModified(RedeCinemaTableMap::COL_ENDERECO)) {
            $criteria->add(RedeCinemaTableMap::COL_ENDERECO, $this->endereco);
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
        $criteria = ChildRedeCinemaQuery::create();
        $criteria->add(RedeCinemaTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \RedeCinema (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCnpj($this->getCnpj());
        $copyObj->setUsuarioId($this->getUsuarioId());
        $copyObj->setNomeFantasia($this->getNomeFantasia());
        $copyObj->setRazaoSocial($this->getRazaoSocial());
        $copyObj->setEndereco($this->getEndereco());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBeneficios() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBeneficio($relObj->copy($deepCopy));
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
     * @return \RedeCinema Clone of current object.
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
     * @return $this|\RedeCinema The current object (for fluent API support)
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
            $v->addRedeCinema($this);
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
                $this->aUsuario->addRedeCinemas($this);
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
        if ('Beneficio' == $relationName) {
            return $this->initBeneficios();
        }
    }

    /**
     * Clears out the collBeneficios collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBeneficios()
     */
    public function clearBeneficios()
    {
        $this->collBeneficios = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBeneficios collection loaded partially.
     */
    public function resetPartialBeneficios($v = true)
    {
        $this->collBeneficiosPartial = $v;
    }

    /**
     * Initializes the collBeneficios collection.
     *
     * By default this just sets the collBeneficios collection to an empty array (like clearcollBeneficios());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBeneficios($overrideExisting = true)
    {
        if (null !== $this->collBeneficios && !$overrideExisting) {
            return;
        }
        $this->collBeneficios = new ObjectCollection();
        $this->collBeneficios->setModel('\Beneficio');
    }

    /**
     * Gets an array of ChildBeneficio objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRedeCinema is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBeneficio[] List of ChildBeneficio objects
     * @throws PropelException
     */
    public function getBeneficios(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBeneficiosPartial && !$this->isNew();
        if (null === $this->collBeneficios || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBeneficios) {
                // return empty collection
                $this->initBeneficios();
            } else {
                $collBeneficios = ChildBeneficioQuery::create(null, $criteria)
                    ->filterByRedeCinema($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBeneficiosPartial && count($collBeneficios)) {
                        $this->initBeneficios(false);

                        foreach ($collBeneficios as $obj) {
                            if (false == $this->collBeneficios->contains($obj)) {
                                $this->collBeneficios->append($obj);
                            }
                        }

                        $this->collBeneficiosPartial = true;
                    }

                    return $collBeneficios;
                }

                if ($partial && $this->collBeneficios) {
                    foreach ($this->collBeneficios as $obj) {
                        if ($obj->isNew()) {
                            $collBeneficios[] = $obj;
                        }
                    }
                }

                $this->collBeneficios = $collBeneficios;
                $this->collBeneficiosPartial = false;
            }
        }

        return $this->collBeneficios;
    }

    /**
     * Sets a collection of ChildBeneficio objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $beneficios A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRedeCinema The current object (for fluent API support)
     */
    public function setBeneficios(Collection $beneficios, ConnectionInterface $con = null)
    {
        /** @var ChildBeneficio[] $beneficiosToDelete */
        $beneficiosToDelete = $this->getBeneficios(new Criteria(), $con)->diff($beneficios);


        $this->beneficiosScheduledForDeletion = $beneficiosToDelete;

        foreach ($beneficiosToDelete as $beneficioRemoved) {
            $beneficioRemoved->setRedeCinema(null);
        }

        $this->collBeneficios = null;
        foreach ($beneficios as $beneficio) {
            $this->addBeneficio($beneficio);
        }

        $this->collBeneficios = $beneficios;
        $this->collBeneficiosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Beneficio objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Beneficio objects.
     * @throws PropelException
     */
    public function countBeneficios(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBeneficiosPartial && !$this->isNew();
        if (null === $this->collBeneficios || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBeneficios) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBeneficios());
            }

            $query = ChildBeneficioQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRedeCinema($this)
                ->count($con);
        }

        return count($this->collBeneficios);
    }

    /**
     * Method called to associate a ChildBeneficio object to this object
     * through the ChildBeneficio foreign key attribute.
     *
     * @param  ChildBeneficio $l ChildBeneficio
     * @return $this|\RedeCinema The current object (for fluent API support)
     */
    public function addBeneficio(ChildBeneficio $l)
    {
        if ($this->collBeneficios === null) {
            $this->initBeneficios();
            $this->collBeneficiosPartial = true;
        }

        if (!$this->collBeneficios->contains($l)) {
            $this->doAddBeneficio($l);
        }

        return $this;
    }

    /**
     * @param ChildBeneficio $beneficio The ChildBeneficio object to add.
     */
    protected function doAddBeneficio(ChildBeneficio $beneficio)
    {
        $this->collBeneficios[]= $beneficio;
        $beneficio->setRedeCinema($this);
    }

    /**
     * @param  ChildBeneficio $beneficio The ChildBeneficio object to remove.
     * @return $this|ChildRedeCinema The current object (for fluent API support)
     */
    public function removeBeneficio(ChildBeneficio $beneficio)
    {
        if ($this->getBeneficios()->contains($beneficio)) {
            $pos = $this->collBeneficios->search($beneficio);
            $this->collBeneficios->remove($pos);
            if (null === $this->beneficiosScheduledForDeletion) {
                $this->beneficiosScheduledForDeletion = clone $this->collBeneficios;
                $this->beneficiosScheduledForDeletion->clear();
            }
            $this->beneficiosScheduledForDeletion[]= clone $beneficio;
            $beneficio->setRedeCinema(null);
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
            $this->aUsuario->removeRedeCinema($this);
        }
        $this->id = null;
        $this->cnpj = null;
        $this->usuario_id = null;
        $this->nome_fantasia = null;
        $this->razao_social = null;
        $this->endereco = null;
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
            if ($this->collBeneficios) {
                foreach ($this->collBeneficios as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBeneficios = null;
        $this->aUsuario = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RedeCinemaTableMap::DEFAULT_STRING_FORMAT);
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
        $metadata->addPropertyConstraint('cnpj', new Unique());
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

            if (null !== $this->collBeneficios) {
                foreach ($this->collBeneficios as $referrerFK) {
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
