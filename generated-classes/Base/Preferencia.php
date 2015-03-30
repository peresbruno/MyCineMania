<?php

namespace Base;

use \Beneficio as ChildBeneficio;
use \BeneficioQuery as ChildBeneficioQuery;
use \BeneficiosPreferencias as ChildBeneficiosPreferencias;
use \BeneficiosPreferenciasQuery as ChildBeneficiosPreferenciasQuery;
use \Participante as ChildParticipante;
use \ParticipanteQuery as ChildParticipanteQuery;
use \ParticipantesPreferencias as ChildParticipantesPreferencias;
use \ParticipantesPreferenciasQuery as ChildParticipantesPreferenciasQuery;
use \Preferencia as ChildPreferencia;
use \PreferenciaQuery as ChildPreferenciaQuery;
use \Exception;
use \PDO;
use Map\PreferenciaTableMap;
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
 * Base class that represents a row from the 'preferencias' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Preferencia implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PreferenciaTableMap';


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
     * The value for the descricao field.
     * @var        string
     */
    protected $descricao;

    /**
     * @var        ObjectCollection|ChildBeneficiosPreferencias[] Collection to store aggregation of ChildBeneficiosPreferencias objects.
     */
    protected $collBeneficiosPreferenciass;
    protected $collBeneficiosPreferenciassPartial;

    /**
     * @var        ObjectCollection|ChildParticipantesPreferencias[] Collection to store aggregation of ChildParticipantesPreferencias objects.
     */
    protected $collParticipantesPreferenciass;
    protected $collParticipantesPreferenciassPartial;

    /**
     * @var        ObjectCollection|ChildBeneficio[] Cross Collection to store aggregation of ChildBeneficio objects.
     */
    protected $collBeneficios;

    /**
     * @var bool
     */
    protected $collBeneficiosPartial;

    /**
     * @var        ObjectCollection|ChildParticipante[] Cross Collection to store aggregation of ChildParticipante objects.
     */
    protected $collParticipantes;

    /**
     * @var bool
     */
    protected $collParticipantesPartial;

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
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildParticipante[]
     */
    protected $participantesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBeneficiosPreferencias[]
     */
    protected $beneficiosPreferenciassScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildParticipantesPreferencias[]
     */
    protected $participantesPreferenciassScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Preferencia object.
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
     * Compares this with another <code>Preferencia</code> instance.  If
     * <code>obj</code> is an instance of <code>Preferencia</code>, delegates to
     * <code>equals(Preferencia)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Preferencia The current object, for fluid interface
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
     * Get the [descricao] column value.
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Preferencia The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PreferenciaTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [descricao] column.
     *
     * @param string $v new value
     * @return $this|\Preferencia The current object (for fluent API support)
     */
    public function setDescricao($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->descricao !== $v) {
            $this->descricao = $v;
            $this->modifiedColumns[PreferenciaTableMap::COL_DESCRICAO] = true;
        }

        return $this;
    } // setDescricao()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PreferenciaTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PreferenciaTableMap::translateFieldName('Descricao', TableMap::TYPE_PHPNAME, $indexType)];
            $this->descricao = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = PreferenciaTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Preferencia'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PreferenciaTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPreferenciaQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collBeneficiosPreferenciass = null;

            $this->collParticipantesPreferenciass = null;

            $this->collBeneficios = null;
            $this->collParticipantes = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Preferencia::setDeleted()
     * @see Preferencia::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PreferenciaTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPreferenciaQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PreferenciaTableMap::DATABASE_NAME);
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
                PreferenciaTableMap::addInstanceToPool($this);
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

            if ($this->beneficiosScheduledForDeletion !== null) {
                if (!$this->beneficiosScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->beneficiosScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \BeneficiosPreferenciasQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->beneficiosScheduledForDeletion = null;
                }

            }

            if ($this->collBeneficios) {
                foreach ($this->collBeneficios as $beneficio) {
                    if (!$beneficio->isDeleted() && ($beneficio->isNew() || $beneficio->isModified())) {
                        $beneficio->save($con);
                    }
                }
            }


            if ($this->participantesScheduledForDeletion !== null) {
                if (!$this->participantesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->participantesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \ParticipantesPreferenciasQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->participantesScheduledForDeletion = null;
                }

            }

            if ($this->collParticipantes) {
                foreach ($this->collParticipantes as $participante) {
                    if (!$participante->isDeleted() && ($participante->isNew() || $participante->isModified())) {
                        $participante->save($con);
                    }
                }
            }


            if ($this->beneficiosPreferenciassScheduledForDeletion !== null) {
                if (!$this->beneficiosPreferenciassScheduledForDeletion->isEmpty()) {
                    \BeneficiosPreferenciasQuery::create()
                        ->filterByPrimaryKeys($this->beneficiosPreferenciassScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->beneficiosPreferenciassScheduledForDeletion = null;
                }
            }

            if ($this->collBeneficiosPreferenciass !== null) {
                foreach ($this->collBeneficiosPreferenciass as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
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

        $this->modifiedColumns[PreferenciaTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PreferenciaTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('preferencias_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PreferenciaTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PreferenciaTableMap::COL_DESCRICAO)) {
            $modifiedColumns[':p' . $index++]  = 'descricao';
        }

        $sql = sprintf(
            'INSERT INTO preferencias (%s) VALUES (%s)',
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
                    case 'descricao':
                        $stmt->bindValue($identifier, $this->descricao, PDO::PARAM_STR);
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
        $pos = PreferenciaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getDescricao();
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

        if (isset($alreadyDumpedObjects['Preferencia'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Preferencia'][$this->hashCode()] = true;
        $keys = PreferenciaTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getDescricao(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collBeneficiosPreferenciass) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'beneficiosPreferenciass';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'beneficios_preferenciass';
                        break;
                    default:
                        $key = 'BeneficiosPreferenciass';
                }

                $result[$key] = $this->collBeneficiosPreferenciass->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Preferencia
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PreferenciaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Preferencia
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setDescricao($value);
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
        $keys = PreferenciaTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDescricao($arr[$keys[1]]);
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
     * @return $this|\Preferencia The current object, for fluid interface
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
        $criteria = new Criteria(PreferenciaTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PreferenciaTableMap::COL_ID)) {
            $criteria->add(PreferenciaTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PreferenciaTableMap::COL_DESCRICAO)) {
            $criteria->add(PreferenciaTableMap::COL_DESCRICAO, $this->descricao);
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
        $criteria = ChildPreferenciaQuery::create();
        $criteria->add(PreferenciaTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Preferencia (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDescricao($this->getDescricao());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBeneficiosPreferenciass() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBeneficiosPreferencias($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getParticipantesPreferenciass() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addParticipantesPreferencias($relObj->copy($deepCopy));
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
     * @return \Preferencia Clone of current object.
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
        if ('BeneficiosPreferencias' == $relationName) {
            return $this->initBeneficiosPreferenciass();
        }
        if ('ParticipantesPreferencias' == $relationName) {
            return $this->initParticipantesPreferenciass();
        }
    }

    /**
     * Clears out the collBeneficiosPreferenciass collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBeneficiosPreferenciass()
     */
    public function clearBeneficiosPreferenciass()
    {
        $this->collBeneficiosPreferenciass = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBeneficiosPreferenciass collection loaded partially.
     */
    public function resetPartialBeneficiosPreferenciass($v = true)
    {
        $this->collBeneficiosPreferenciassPartial = $v;
    }

    /**
     * Initializes the collBeneficiosPreferenciass collection.
     *
     * By default this just sets the collBeneficiosPreferenciass collection to an empty array (like clearcollBeneficiosPreferenciass());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBeneficiosPreferenciass($overrideExisting = true)
    {
        if (null !== $this->collBeneficiosPreferenciass && !$overrideExisting) {
            return;
        }
        $this->collBeneficiosPreferenciass = new ObjectCollection();
        $this->collBeneficiosPreferenciass->setModel('\BeneficiosPreferencias');
    }

    /**
     * Gets an array of ChildBeneficiosPreferencias objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPreferencia is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBeneficiosPreferencias[] List of ChildBeneficiosPreferencias objects
     * @throws PropelException
     */
    public function getBeneficiosPreferenciass(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBeneficiosPreferenciassPartial && !$this->isNew();
        if (null === $this->collBeneficiosPreferenciass || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBeneficiosPreferenciass) {
                // return empty collection
                $this->initBeneficiosPreferenciass();
            } else {
                $collBeneficiosPreferenciass = ChildBeneficiosPreferenciasQuery::create(null, $criteria)
                    ->filterByPreferencia($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBeneficiosPreferenciassPartial && count($collBeneficiosPreferenciass)) {
                        $this->initBeneficiosPreferenciass(false);

                        foreach ($collBeneficiosPreferenciass as $obj) {
                            if (false == $this->collBeneficiosPreferenciass->contains($obj)) {
                                $this->collBeneficiosPreferenciass->append($obj);
                            }
                        }

                        $this->collBeneficiosPreferenciassPartial = true;
                    }

                    return $collBeneficiosPreferenciass;
                }

                if ($partial && $this->collBeneficiosPreferenciass) {
                    foreach ($this->collBeneficiosPreferenciass as $obj) {
                        if ($obj->isNew()) {
                            $collBeneficiosPreferenciass[] = $obj;
                        }
                    }
                }

                $this->collBeneficiosPreferenciass = $collBeneficiosPreferenciass;
                $this->collBeneficiosPreferenciassPartial = false;
            }
        }

        return $this->collBeneficiosPreferenciass;
    }

    /**
     * Sets a collection of ChildBeneficiosPreferencias objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $beneficiosPreferenciass A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPreferencia The current object (for fluent API support)
     */
    public function setBeneficiosPreferenciass(Collection $beneficiosPreferenciass, ConnectionInterface $con = null)
    {
        /** @var ChildBeneficiosPreferencias[] $beneficiosPreferenciassToDelete */
        $beneficiosPreferenciassToDelete = $this->getBeneficiosPreferenciass(new Criteria(), $con)->diff($beneficiosPreferenciass);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->beneficiosPreferenciassScheduledForDeletion = clone $beneficiosPreferenciassToDelete;

        foreach ($beneficiosPreferenciassToDelete as $beneficiosPreferenciasRemoved) {
            $beneficiosPreferenciasRemoved->setPreferencia(null);
        }

        $this->collBeneficiosPreferenciass = null;
        foreach ($beneficiosPreferenciass as $beneficiosPreferencias) {
            $this->addBeneficiosPreferencias($beneficiosPreferencias);
        }

        $this->collBeneficiosPreferenciass = $beneficiosPreferenciass;
        $this->collBeneficiosPreferenciassPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BeneficiosPreferencias objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BeneficiosPreferencias objects.
     * @throws PropelException
     */
    public function countBeneficiosPreferenciass(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBeneficiosPreferenciassPartial && !$this->isNew();
        if (null === $this->collBeneficiosPreferenciass || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBeneficiosPreferenciass) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBeneficiosPreferenciass());
            }

            $query = ChildBeneficiosPreferenciasQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPreferencia($this)
                ->count($con);
        }

        return count($this->collBeneficiosPreferenciass);
    }

    /**
     * Method called to associate a ChildBeneficiosPreferencias object to this object
     * through the ChildBeneficiosPreferencias foreign key attribute.
     *
     * @param  ChildBeneficiosPreferencias $l ChildBeneficiosPreferencias
     * @return $this|\Preferencia The current object (for fluent API support)
     */
    public function addBeneficiosPreferencias(ChildBeneficiosPreferencias $l)
    {
        if ($this->collBeneficiosPreferenciass === null) {
            $this->initBeneficiosPreferenciass();
            $this->collBeneficiosPreferenciassPartial = true;
        }

        if (!$this->collBeneficiosPreferenciass->contains($l)) {
            $this->doAddBeneficiosPreferencias($l);
        }

        return $this;
    }

    /**
     * @param ChildBeneficiosPreferencias $beneficiosPreferencias The ChildBeneficiosPreferencias object to add.
     */
    protected function doAddBeneficiosPreferencias(ChildBeneficiosPreferencias $beneficiosPreferencias)
    {
        $this->collBeneficiosPreferenciass[]= $beneficiosPreferencias;
        $beneficiosPreferencias->setPreferencia($this);
    }

    /**
     * @param  ChildBeneficiosPreferencias $beneficiosPreferencias The ChildBeneficiosPreferencias object to remove.
     * @return $this|ChildPreferencia The current object (for fluent API support)
     */
    public function removeBeneficiosPreferencias(ChildBeneficiosPreferencias $beneficiosPreferencias)
    {
        if ($this->getBeneficiosPreferenciass()->contains($beneficiosPreferencias)) {
            $pos = $this->collBeneficiosPreferenciass->search($beneficiosPreferencias);
            $this->collBeneficiosPreferenciass->remove($pos);
            if (null === $this->beneficiosPreferenciassScheduledForDeletion) {
                $this->beneficiosPreferenciassScheduledForDeletion = clone $this->collBeneficiosPreferenciass;
                $this->beneficiosPreferenciassScheduledForDeletion->clear();
            }
            $this->beneficiosPreferenciassScheduledForDeletion[]= clone $beneficiosPreferencias;
            $beneficiosPreferencias->setPreferencia(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Preferencia is new, it will return
     * an empty collection; or if this Preferencia has previously
     * been saved, it will retrieve related BeneficiosPreferenciass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Preferencia.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBeneficiosPreferencias[] List of ChildBeneficiosPreferencias objects
     */
    public function getBeneficiosPreferenciassJoinBeneficio(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBeneficiosPreferenciasQuery::create(null, $criteria);
        $query->joinWith('Beneficio', $joinBehavior);

        return $this->getBeneficiosPreferenciass($query, $con);
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
     * If this ChildPreferencia is new, it will return
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
                    ->filterByPreferencia($this)
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
     * @return $this|ChildPreferencia The current object (for fluent API support)
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
            $participantesPreferenciasRemoved->setPreferencia(null);
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
                ->filterByPreferencia($this)
                ->count($con);
        }

        return count($this->collParticipantesPreferenciass);
    }

    /**
     * Method called to associate a ChildParticipantesPreferencias object to this object
     * through the ChildParticipantesPreferencias foreign key attribute.
     *
     * @param  ChildParticipantesPreferencias $l ChildParticipantesPreferencias
     * @return $this|\Preferencia The current object (for fluent API support)
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
        $participantesPreferencias->setPreferencia($this);
    }

    /**
     * @param  ChildParticipantesPreferencias $participantesPreferencias The ChildParticipantesPreferencias object to remove.
     * @return $this|ChildPreferencia The current object (for fluent API support)
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
            $participantesPreferencias->setPreferencia(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Preferencia is new, it will return
     * an empty collection; or if this Preferencia has previously
     * been saved, it will retrieve related ParticipantesPreferenciass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Preferencia.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildParticipantesPreferencias[] List of ChildParticipantesPreferencias objects
     */
    public function getParticipantesPreferenciassJoinParticipante(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildParticipantesPreferenciasQuery::create(null, $criteria);
        $query->joinWith('Participante', $joinBehavior);

        return $this->getParticipantesPreferenciass($query, $con);
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
     * Initializes the collBeneficios crossRef collection.
     *
     * By default this just sets the collBeneficios collection to an empty collection (like clearBeneficios());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initBeneficios()
    {
        $this->collBeneficios = new ObjectCollection();
        $this->collBeneficiosPartial = true;

        $this->collBeneficios->setModel('\Beneficio');
    }

    /**
     * Checks if the collBeneficios collection is loaded.
     *
     * @return bool
     */
    public function isBeneficiosLoaded()
    {
        return null !== $this->collBeneficios;
    }

    /**
     * Gets a collection of ChildBeneficio objects related by a many-to-many relationship
     * to the current object by way of the beneficios_preferencias cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPreferencia is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildBeneficio[] List of ChildBeneficio objects
     */
    public function getBeneficios(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBeneficiosPartial && !$this->isNew();
        if (null === $this->collBeneficios || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collBeneficios) {
                    $this->initBeneficios();
                }
            } else {

                $query = ChildBeneficioQuery::create(null, $criteria)
                    ->filterByPreferencia($this);
                $collBeneficios = $query->find($con);
                if (null !== $criteria) {
                    return $collBeneficios;
                }

                if ($partial && $this->collBeneficios) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collBeneficios as $obj) {
                        if (!$collBeneficios->contains($obj)) {
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
     * Sets a collection of Beneficio objects related by a many-to-many relationship
     * to the current object by way of the beneficios_preferencias cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $beneficios A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPreferencia The current object (for fluent API support)
     */
    public function setBeneficios(Collection $beneficios, ConnectionInterface $con = null)
    {
        $this->clearBeneficios();
        $currentBeneficios = $this->getBeneficios();

        $beneficiosScheduledForDeletion = $currentBeneficios->diff($beneficios);

        foreach ($beneficiosScheduledForDeletion as $toDelete) {
            $this->removeBeneficio($toDelete);
        }

        foreach ($beneficios as $beneficio) {
            if (!$currentBeneficios->contains($beneficio)) {
                $this->doAddBeneficio($beneficio);
            }
        }

        $this->collBeneficiosPartial = false;
        $this->collBeneficios = $beneficios;

        return $this;
    }

    /**
     * Gets the number of Beneficio objects related by a many-to-many relationship
     * to the current object by way of the beneficios_preferencias cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Beneficio objects
     */
    public function countBeneficios(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBeneficiosPartial && !$this->isNew();
        if (null === $this->collBeneficios || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBeneficios) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getBeneficios());
                }

                $query = ChildBeneficioQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPreferencia($this)
                    ->count($con);
            }
        } else {
            return count($this->collBeneficios);
        }
    }

    /**
     * Associate a ChildBeneficio to this object
     * through the beneficios_preferencias cross reference table.
     *
     * @param ChildBeneficio $beneficio
     * @return ChildPreferencia The current object (for fluent API support)
     */
    public function addBeneficio(ChildBeneficio $beneficio)
    {
        if ($this->collBeneficios === null) {
            $this->initBeneficios();
        }

        if (!$this->getBeneficios()->contains($beneficio)) {
            // only add it if the **same** object is not already associated
            $this->collBeneficios->push($beneficio);
            $this->doAddBeneficio($beneficio);
        }

        return $this;
    }

    /**
     *
     * @param ChildBeneficio $beneficio
     */
    protected function doAddBeneficio(ChildBeneficio $beneficio)
    {
        $beneficiosPreferencias = new ChildBeneficiosPreferencias();

        $beneficiosPreferencias->setBeneficio($beneficio);

        $beneficiosPreferencias->setPreferencia($this);

        $this->addBeneficiosPreferencias($beneficiosPreferencias);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$beneficio->isPreferenciasLoaded()) {
            $beneficio->initPreferencias();
            $beneficio->getPreferencias()->push($this);
        } elseif (!$beneficio->getPreferencias()->contains($this)) {
            $beneficio->getPreferencias()->push($this);
        }

    }

    /**
     * Remove beneficio of this object
     * through the beneficios_preferencias cross reference table.
     *
     * @param ChildBeneficio $beneficio
     * @return ChildPreferencia The current object (for fluent API support)
     */
    public function removeBeneficio(ChildBeneficio $beneficio)
    {
        if ($this->getBeneficios()->contains($beneficio)) { $beneficiosPreferencias = new ChildBeneficiosPreferencias();

            $beneficiosPreferencias->setBeneficio($beneficio);
            if ($beneficio->isPreferenciasLoaded()) {
                //remove the back reference if available
                $beneficio->getPreferencias()->removeObject($this);
            }

            $beneficiosPreferencias->setPreferencia($this);
            $this->removeBeneficiosPreferencias(clone $beneficiosPreferencias);
            $beneficiosPreferencias->clear();

            $this->collBeneficios->remove($this->collBeneficios->search($beneficio));

            if (null === $this->beneficiosScheduledForDeletion) {
                $this->beneficiosScheduledForDeletion = clone $this->collBeneficios;
                $this->beneficiosScheduledForDeletion->clear();
            }

            $this->beneficiosScheduledForDeletion->push($beneficio);
        }


        return $this;
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
     * Initializes the collParticipantes crossRef collection.
     *
     * By default this just sets the collParticipantes collection to an empty collection (like clearParticipantes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initParticipantes()
    {
        $this->collParticipantes = new ObjectCollection();
        $this->collParticipantesPartial = true;

        $this->collParticipantes->setModel('\Participante');
    }

    /**
     * Checks if the collParticipantes collection is loaded.
     *
     * @return bool
     */
    public function isParticipantesLoaded()
    {
        return null !== $this->collParticipantes;
    }

    /**
     * Gets a collection of ChildParticipante objects related by a many-to-many relationship
     * to the current object by way of the participantes_preferencias cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPreferencia is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildParticipante[] List of ChildParticipante objects
     */
    public function getParticipantes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantesPartial && !$this->isNew();
        if (null === $this->collParticipantes || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collParticipantes) {
                    $this->initParticipantes();
                }
            } else {

                $query = ChildParticipanteQuery::create(null, $criteria)
                    ->filterByPreferencia($this);
                $collParticipantes = $query->find($con);
                if (null !== $criteria) {
                    return $collParticipantes;
                }

                if ($partial && $this->collParticipantes) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collParticipantes as $obj) {
                        if (!$collParticipantes->contains($obj)) {
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
     * Sets a collection of Participante objects related by a many-to-many relationship
     * to the current object by way of the participantes_preferencias cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $participantes A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPreferencia The current object (for fluent API support)
     */
    public function setParticipantes(Collection $participantes, ConnectionInterface $con = null)
    {
        $this->clearParticipantes();
        $currentParticipantes = $this->getParticipantes();

        $participantesScheduledForDeletion = $currentParticipantes->diff($participantes);

        foreach ($participantesScheduledForDeletion as $toDelete) {
            $this->removeParticipante($toDelete);
        }

        foreach ($participantes as $participante) {
            if (!$currentParticipantes->contains($participante)) {
                $this->doAddParticipante($participante);
            }
        }

        $this->collParticipantesPartial = false;
        $this->collParticipantes = $participantes;

        return $this;
    }

    /**
     * Gets the number of Participante objects related by a many-to-many relationship
     * to the current object by way of the participantes_preferencias cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Participante objects
     */
    public function countParticipantes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantesPartial && !$this->isNew();
        if (null === $this->collParticipantes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collParticipantes) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getParticipantes());
                }

                $query = ChildParticipanteQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPreferencia($this)
                    ->count($con);
            }
        } else {
            return count($this->collParticipantes);
        }
    }

    /**
     * Associate a ChildParticipante to this object
     * through the participantes_preferencias cross reference table.
     *
     * @param ChildParticipante $participante
     * @return ChildPreferencia The current object (for fluent API support)
     */
    public function addParticipante(ChildParticipante $participante)
    {
        if ($this->collParticipantes === null) {
            $this->initParticipantes();
        }

        if (!$this->getParticipantes()->contains($participante)) {
            // only add it if the **same** object is not already associated
            $this->collParticipantes->push($participante);
            $this->doAddParticipante($participante);
        }

        return $this;
    }

    /**
     *
     * @param ChildParticipante $participante
     */
    protected function doAddParticipante(ChildParticipante $participante)
    {
        $participantesPreferencias = new ChildParticipantesPreferencias();

        $participantesPreferencias->setParticipante($participante);

        $participantesPreferencias->setPreferencia($this);

        $this->addParticipantesPreferencias($participantesPreferencias);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$participante->isPreferenciasLoaded()) {
            $participante->initPreferencias();
            $participante->getPreferencias()->push($this);
        } elseif (!$participante->getPreferencias()->contains($this)) {
            $participante->getPreferencias()->push($this);
        }

    }

    /**
     * Remove participante of this object
     * through the participantes_preferencias cross reference table.
     *
     * @param ChildParticipante $participante
     * @return ChildPreferencia The current object (for fluent API support)
     */
    public function removeParticipante(ChildParticipante $participante)
    {
        if ($this->getParticipantes()->contains($participante)) { $participantesPreferencias = new ChildParticipantesPreferencias();

            $participantesPreferencias->setParticipante($participante);
            if ($participante->isPreferenciasLoaded()) {
                //remove the back reference if available
                $participante->getPreferencias()->removeObject($this);
            }

            $participantesPreferencias->setPreferencia($this);
            $this->removeParticipantesPreferencias(clone $participantesPreferencias);
            $participantesPreferencias->clear();

            $this->collParticipantes->remove($this->collParticipantes->search($participante));

            if (null === $this->participantesScheduledForDeletion) {
                $this->participantesScheduledForDeletion = clone $this->collParticipantes;
                $this->participantesScheduledForDeletion->clear();
            }

            $this->participantesScheduledForDeletion->push($participante);
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
        $this->descricao = null;
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
            if ($this->collBeneficiosPreferenciass) {
                foreach ($this->collBeneficiosPreferenciass as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collParticipantesPreferenciass) {
                foreach ($this->collParticipantesPreferenciass as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBeneficios) {
                foreach ($this->collBeneficios as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collParticipantes) {
                foreach ($this->collParticipantes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBeneficiosPreferenciass = null;
        $this->collParticipantesPreferenciass = null;
        $this->collBeneficios = null;
        $this->collParticipantes = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PreferenciaTableMap::DEFAULT_STRING_FORMAT);
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
        $metadata->addPropertyConstraint('descricao', new Unique());
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

            if (null !== $this->collBeneficiosPreferenciass) {
                foreach ($this->collBeneficiosPreferenciass as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
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
