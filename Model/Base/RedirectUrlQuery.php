<?php

namespace TheliaRedirectUrl\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use TheliaRedirectUrl\Model\RedirectUrl as ChildRedirectUrl;
use TheliaRedirectUrl\Model\RedirectUrlQuery as ChildRedirectUrlQuery;
use TheliaRedirectUrl\Model\Map\RedirectUrlTableMap;

/**
 * Base class that represents a query for the 'redirect_url' table.
 *
 *
 *
 * @method     ChildRedirectUrlQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRedirectUrlQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildRedirectUrlQuery orderByTempRedirect($order = Criteria::ASC) Order by the temp_redirect column
 * @method     ChildRedirectUrlQuery orderByRedirect($order = Criteria::ASC) Order by the redirect column
 * @method     ChildRedirectUrlQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildRedirectUrlQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildRedirectUrlQuery groupById() Group by the id column
 * @method     ChildRedirectUrlQuery groupByUrl() Group by the url column
 * @method     ChildRedirectUrlQuery groupByTempRedirect() Group by the temp_redirect column
 * @method     ChildRedirectUrlQuery groupByRedirect() Group by the redirect column
 * @method     ChildRedirectUrlQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildRedirectUrlQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildRedirectUrlQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRedirectUrlQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRedirectUrlQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRedirectUrl findOne(ConnectionInterface $con = null) Return the first ChildRedirectUrl matching the query
 * @method     ChildRedirectUrl findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRedirectUrl matching the query, or a new ChildRedirectUrl object populated from the query conditions when no match is found
 *
 * @method     ChildRedirectUrl findOneById(int $id) Return the first ChildRedirectUrl filtered by the id column
 * @method     ChildRedirectUrl findOneByUrl(string $url) Return the first ChildRedirectUrl filtered by the url column
 * @method     ChildRedirectUrl findOneByTempRedirect(string $temp_redirect) Return the first ChildRedirectUrl filtered by the temp_redirect column
 * @method     ChildRedirectUrl findOneByRedirect(string $redirect) Return the first ChildRedirectUrl filtered by the redirect column
 * @method     ChildRedirectUrl findOneByCreatedAt(string $created_at) Return the first ChildRedirectUrl filtered by the created_at column
 * @method     ChildRedirectUrl findOneByUpdatedAt(string $updated_at) Return the first ChildRedirectUrl filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildRedirectUrl objects filtered by the id column
 * @method     array findByUrl(string $url) Return ChildRedirectUrl objects filtered by the url column
 * @method     array findByTempRedirect(string $temp_redirect) Return ChildRedirectUrl objects filtered by the temp_redirect column
 * @method     array findByRedirect(string $redirect) Return ChildRedirectUrl objects filtered by the redirect column
 * @method     array findByCreatedAt(string $created_at) Return ChildRedirectUrl objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildRedirectUrl objects filtered by the updated_at column
 *
 */
abstract class RedirectUrlQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \TheliaRedirectUrl\Model\Base\RedirectUrlQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\TheliaRedirectUrl\\Model\\RedirectUrl', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRedirectUrlQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRedirectUrlQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \TheliaRedirectUrl\Model\RedirectUrlQuery) {
            return $criteria;
        }
        $query = new \TheliaRedirectUrl\Model\RedirectUrlQuery();
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
     * @return ChildRedirectUrl|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RedirectUrlTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RedirectUrlTableMap::DATABASE_NAME);
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
     * @return   ChildRedirectUrl A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, URL, TEMP_REDIRECT, REDIRECT, CREATED_AT, UPDATED_AT FROM redirect_url WHERE ID = :p0';
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
            $obj = new ChildRedirectUrl();
            $obj->hydrate($row);
            RedirectUrlTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRedirectUrl|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
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
    public function findPks($keys, $con = null)
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
     * @return ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RedirectUrlTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RedirectUrlTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RedirectUrlTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RedirectUrlTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RedirectUrlTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $url)) {
                $url = str_replace('*', '%', $url);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RedirectUrlTableMap::URL, $url, $comparison);
    }

    /**
     * Filter the query on the temp_redirect column
     *
     * Example usage:
     * <code>
     * $query->filterByTempRedirect('fooValue');   // WHERE temp_redirect = 'fooValue'
     * $query->filterByTempRedirect('%fooValue%'); // WHERE temp_redirect LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tempRedirect The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function filterByTempRedirect($tempRedirect = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tempRedirect)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tempRedirect)) {
                $tempRedirect = str_replace('*', '%', $tempRedirect);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RedirectUrlTableMap::TEMP_REDIRECT, $tempRedirect, $comparison);
    }

    /**
     * Filter the query on the redirect column
     *
     * Example usage:
     * <code>
     * $query->filterByRedirect('fooValue');   // WHERE redirect = 'fooValue'
     * $query->filterByRedirect('%fooValue%'); // WHERE redirect LIKE '%fooValue%'
     * </code>
     *
     * @param     string $redirect The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function filterByRedirect($redirect = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($redirect)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $redirect)) {
                $redirect = str_replace('*', '%', $redirect);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RedirectUrlTableMap::REDIRECT, $redirect, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(RedirectUrlTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(RedirectUrlTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RedirectUrlTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(RedirectUrlTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(RedirectUrlTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RedirectUrlTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRedirectUrl $redirectUrl Object to remove from the list of results
     *
     * @return ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function prune($redirectUrl = null)
    {
        if ($redirectUrl) {
            $this->addUsingAlias(RedirectUrlTableMap::ID, $redirectUrl->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the redirect_url table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RedirectUrlTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RedirectUrlTableMap::clearInstancePool();
            RedirectUrlTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildRedirectUrl or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildRedirectUrl object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RedirectUrlTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RedirectUrlTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        RedirectUrlTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RedirectUrlTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(RedirectUrlTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(RedirectUrlTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(RedirectUrlTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(RedirectUrlTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(RedirectUrlTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildRedirectUrlQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(RedirectUrlTableMap::CREATED_AT);
    }

} // RedirectUrlQuery
