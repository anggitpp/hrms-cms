<?php
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @noinspection PhpUnusedAliasInspection */

namespace LaravelIdea\Helper {

    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\ConnectionInterface;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Query\Expression;
    
    /**
     * @see \Illuminate\Database\Query\Builder::whereIn
     * @method $this whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::orWhereNotIn
     * @method $this orWhereNotIn(string $column, $values)
     * @see \Illuminate\Database\Query\Builder::selectRaw
     * @method $this selectRaw(string $expression, array $bindings = [])
     * @see \Illuminate\Database\Query\Builder::insertOrIgnore
     * @method int insertOrIgnore(array $values)
     * @see \Illuminate\Database\Query\Builder::unionAll
     * @method $this unionAll(\Closure|\Illuminate\Database\Query\Builder $query)
     * @see \Illuminate\Database\Query\Builder::orWhereNull
     * @method $this orWhereNull(array|string $column)
     * @see \Illuminate\Database\Query\Builder::joinWhere
     * @method $this joinWhere(string $table, \Closure|string $first, string $operator, string $second, string $type = 'inner')
     * @see \Illuminate\Database\Query\Builder::orWhereJsonContains
     * @method $this orWhereJsonContains(string $column, $value)
     * @see \Illuminate\Database\Query\Builder::orderBy
     * @method $this orderBy(\Closure|Builder|\Illuminate\Database\Query\Builder|Expression|string $column, string $direction = 'asc')
     * @see \Illuminate\Database\Query\Builder::raw
     * @method Expression raw($value)
     * @see \Illuminate\Database\Concerns\BuildsQueries::each
     * @method $this each(callable $callback, int $count = 1000)
     * @see \Illuminate\Database\Query\Builder::setBindings
     * @method $this setBindings(array $bindings, string $type = 'where')
     * @see \Illuminate\Database\Query\Builder::orWhereJsonLength
     * @method $this orWhereJsonLength(string $column, $operator, $value = null)
     * @see \Illuminate\Database\Query\Builder::whereRowValues
     * @method $this whereRowValues(array $columns, string $operator, array $values, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::orWhereNotExists
     * @method $this orWhereNotExists(\Closure $callback)
     * @see \Illuminate\Database\Query\Builder::orWhereIntegerInRaw
     * @method $this orWhereIntegerInRaw(string $column, array|Arrayable $values)
     * @see \Illuminate\Database\Query\Builder::newQuery
     * @method $this newQuery()
     * @see \Illuminate\Database\Query\Builder::rightJoinSub
     * @method $this rightJoinSub(\Closure|Builder|\Illuminate\Database\Query\Builder|string $query, string $as, \Closure|string $first, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::crossJoin
     * @method $this crossJoin(string $table, \Closure|null|string $first = null, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::average
     * @method mixed average(string $column)
     * @see \Illuminate\Database\Query\Builder::existsOr
     * @method $this existsOr(\Closure $callback)
     * @see \Illuminate\Database\Query\Builder::sum
     * @method int|mixed sum(string $column)
     * @see \Illuminate\Database\Query\Builder::havingRaw
     * @method $this havingRaw(string $sql, array $bindings = [], string $boolean = 'and')
     * @see \Illuminate\Database\Concerns\BuildsQueries::chunkMap
     * @method $this chunkMap(callable $callback, int $count = 1000)
     * @see \Illuminate\Database\Query\Builder::getRawBindings
     * @method $this getRawBindings()
     * @see \Illuminate\Database\Query\Builder::orWhereColumn
     * @method $this orWhereColumn(array|string $first, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::min
     * @method mixed min(string $column)
     * @see \Illuminate\Support\Traits\Conditionable::unless
     * @method $this unless($value, callable $callback, callable|null $default = null)
     * @see \Illuminate\Database\Query\Builder::whereNotIn
     * @method $this whereNotIn(string $column, $values, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::whereTime
     * @method $this whereTime(string $column, string $operator, \DateTimeInterface|null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::insertUsing
     * @method int insertUsing(array $columns, \Closure|\Illuminate\Database\Query\Builder|string $query)
     * @see \Illuminate\Database\Concerns\BuildsQueries::lazyById
     * @method $this lazyById($chunkSize = 1000, null|string $column = null, null|string $alias = null)
     * @see \Illuminate\Database\Query\Builder::rightJoinWhere
     * @method $this rightJoinWhere(string $table, \Closure|string $first, string $operator, string $second)
     * @see \Illuminate\Database\Query\Builder::union
     * @method $this union(\Closure|\Illuminate\Database\Query\Builder $query, bool $all = false)
     * @see \Illuminate\Database\Query\Builder::groupBy
     * @method $this groupBy(...$groups)
     * @see \Illuminate\Database\Query\Builder::orWhereDay
     * @method $this orWhereDay(string $column, string $operator, \DateTimeInterface|null|string $value = null)
     * @see \Illuminate\Database\Query\Builder::joinSub
     * @method $this joinSub(\Closure|Builder|\Illuminate\Database\Query\Builder|string $query, string $as, \Closure|string $first, null|string $operator = null, null|string $second = null, string $type = 'inner', bool $where = false)
     * @see \Illuminate\Database\Query\Builder::selectSub
     * @method $this selectSub(\Closure|Builder|\Illuminate\Database\Query\Builder|string $query, string $as)
     * @see \Illuminate\Database\Query\Builder::dd
     * @method void dd()
     * @see \Illuminate\Database\Query\Builder::whereNull
     * @method $this whereNull(array|string $columns, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::prepareValueAndOperator
     * @method $this prepareValueAndOperator(string $value, string $operator, bool $useDefault = false)
     * @see \Illuminate\Database\Query\Builder::whereIntegerNotInRaw
     * @method $this whereIntegerNotInRaw(string $column, array|Arrayable $values, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::orWhereRaw
     * @method $this orWhereRaw(string $sql, $bindings = [])
     * @see \Illuminate\Database\Query\Builder::whereJsonContains
     * @method $this whereJsonContains(string $column, $value, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::orWhereBetweenColumns
     * @method $this orWhereBetweenColumns(string $column, array $values)
     * @see \Illuminate\Database\Query\Builder::mergeWheres
     * @method $this mergeWheres(array $wheres, array $bindings)
     * @see \Illuminate\Database\Query\Builder::applyBeforeQueryCallbacks
     * @method $this applyBeforeQueryCallbacks()
     * @see \Illuminate\Database\Query\Builder::sharedLock
     * @method $this sharedLock()
     * @see \Illuminate\Database\Query\Builder::orderByRaw
     * @method $this orderByRaw(string $sql, array $bindings = [])
     * @see \Illuminate\Database\Query\Builder::doesntExist
     * @method bool doesntExist()
     * @see \Illuminate\Database\Query\Builder::orWhereMonth
     * @method $this orWhereMonth(string $column, string $operator, \DateTimeInterface|null|string $value = null)
     * @see \Illuminate\Database\Query\Builder::whereNotNull
     * @method $this whereNotNull(array|string $columns, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::count
     * @method int count(string $columns = '*')
     * @see \Illuminate\Database\Query\Builder::orWhereNotBetween
     * @method $this orWhereNotBetween(string $column, array $values)
     * @see \Illuminate\Database\Query\Builder::fromRaw
     * @method $this fromRaw(string $expression, $bindings = [])
     * @see \Illuminate\Support\Traits\Macroable::mixin
     * @method $this mixin(object $mixin, bool $replace = true)
     * @see \Illuminate\Database\Query\Builder::take
     * @method $this take(int $value)
     * @see \Illuminate\Database\Query\Builder::orWhereNotBetweenColumns
     * @method $this orWhereNotBetweenColumns(string $column, array $values)
     * @see \Illuminate\Database\Query\Builder::updateOrInsert
     * @method $this updateOrInsert(array $attributes, array $values = [])
     * @see \Illuminate\Database\Query\Builder::cloneWithout
     * @method $this cloneWithout(array $properties)
     * @see \Illuminate\Database\Query\Builder::whereBetweenColumns
     * @method $this whereBetweenColumns(string $column, array $values, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::fromSub
     * @method $this fromSub(\Closure|\Illuminate\Database\Query\Builder|string $query, string $as)
     * @see \Illuminate\Database\Query\Builder::cleanBindings
     * @method $this cleanBindings(array $bindings)
     * @see \Illuminate\Database\Query\Builder::orWhereDate
     * @method $this orWhereDate(string $column, string $operator, \DateTimeInterface|null|string $value = null)
     * @see \Illuminate\Database\Query\Builder::avg
     * @method mixed avg(string $column)
     * @see \Illuminate\Database\Query\Builder::addBinding
     * @method $this addBinding($value, string $type = 'where')
     * @see \Illuminate\Database\Query\Builder::getGrammar
     * @method $this getGrammar()
     * @see \Illuminate\Database\Query\Builder::lockForUpdate
     * @method $this lockForUpdate()
     * @see \Illuminate\Database\Concerns\BuildsQueries::eachById
     * @method $this eachById(callable $callback, int $count = 1000, null|string $column = null, null|string $alias = null)
     * @see \Illuminate\Database\Query\Builder::cloneWithoutBindings
     * @method $this cloneWithoutBindings(array $except)
     * @see \Illuminate\Database\Query\Builder::orHavingRaw
     * @method $this orHavingRaw(string $sql, array $bindings = [])
     * @see \Illuminate\Database\Query\Builder::forPageBeforeId
     * @method $this forPageBeforeId(int $perPage = 15, int|null $lastId = 0, string $column = 'id')
     * @see \Illuminate\Database\Query\Builder::orWhereBetween
     * @method $this orWhereBetween(string $column, array $values)
     * @see \Illuminate\Database\Concerns\ExplainsQueries::explain
     * @method $this explain()
     * @see \Illuminate\Database\Query\Builder::select
     * @method $this select(array|mixed $columns = ['*'])
     * @see \Illuminate\Database\Query\Builder::addSelect
     * @method $this addSelect(array|mixed $column)
     * @see \Illuminate\Support\Traits\Conditionable::when
     * @method $this when($value, callable $callback, callable|null $default = null)
     * @see \Illuminate\Database\Query\Builder::whereJsonLength
     * @method $this whereJsonLength(string $column, $operator, $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::orWhereExists
     * @method $this orWhereExists(\Closure $callback, bool $not = false)
     * @see \Illuminate\Database\Query\Builder::beforeQuery
     * @method $this beforeQuery(callable $callback)
     * @see \Illuminate\Database\Query\Builder::truncate
     * @method $this truncate()
     * @see \Illuminate\Database\Query\Builder::lock
     * @method $this lock(bool|string $value = true)
     * @see \Illuminate\Database\Query\Builder::join
     * @method $this join(string $table, \Closure|string $first, null|string $operator = null, null|string $second = null, string $type = 'inner', bool $where = false)
     * @see \Illuminate\Database\Query\Builder::whereMonth
     * @method $this whereMonth(string $column, string $operator, \DateTimeInterface|null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::having
     * @method $this having(string $column, null|string $operator = null, null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::whereNested
     * @method $this whereNested(\Closure $callback, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::orWhereRowValues
     * @method $this orWhereRowValues(array $columns, string $operator, array $values)
     * @see \Illuminate\Database\Query\Builder::useWritePdo
     * @method $this useWritePdo()
     * @see \Illuminate\Database\Query\Builder::orWhereIn
     * @method $this orWhereIn(string $column, $values)
     * @see \Illuminate\Database\Query\Builder::orderByDesc
     * @method $this orderByDesc(\Closure|Builder|\Illuminate\Database\Query\Builder|Expression|string $column)
     * @see \Illuminate\Database\Query\Builder::orWhereNotNull
     * @method $this orWhereNotNull(string $column)
     * @see \Illuminate\Database\Query\Builder::getProcessor
     * @method $this getProcessor()
     * @see \Illuminate\Database\Concerns\BuildsQueries::lazy
     * @method $this lazy(int $chunkSize = 1000)
     * @see \Illuminate\Database\Query\Builder::skip
     * @method $this skip(int $value)
     * @see \Illuminate\Database\Query\Builder::leftJoinWhere
     * @method $this leftJoinWhere(string $table, \Closure|string $first, string $operator, string $second)
     * @see \Illuminate\Database\Query\Builder::doesntExistOr
     * @method $this doesntExistOr(\Closure $callback)
     * @see \Illuminate\Database\Query\Builder::whereNotExists
     * @method $this whereNotExists(\Closure $callback, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::whereIntegerInRaw
     * @method $this whereIntegerInRaw(string $column, array|Arrayable $values, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::whereDay
     * @method $this whereDay(string $column, string $operator, \DateTimeInterface|null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::forNestedWhere
     * @method $this forNestedWhere()
     * @see \Illuminate\Database\Query\Builder::max
     * @method mixed max(string $column)
     * @see \Illuminate\Database\Query\Builder::whereExists
     * @method $this whereExists(\Closure $callback, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::inRandomOrder
     * @method $this inRandomOrder(string $seed = '')
     * @see \Illuminate\Database\Query\Builder::havingBetween
     * @method $this havingBetween(string $column, array $values, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::orWhereYear
     * @method $this orWhereYear(string $column, string $operator, \DateTimeInterface|int|null|string $value = null)
     * @see \Illuminate\Database\Concerns\BuildsQueries::chunkById
     * @method $this chunkById(int $count, callable $callback, null|string $column = null, null|string $alias = null)
     * @see \Illuminate\Database\Query\Builder::whereDate
     * @method $this whereDate(string $column, string $operator, \DateTimeInterface|null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::whereJsonDoesntContain
     * @method $this whereJsonDoesntContain(string $column, $value, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::forPageAfterId
     * @method $this forPageAfterId(int $perPage = 15, int|null $lastId = 0, string $column = 'id')
     * @see \Illuminate\Database\Query\Builder::forPage
     * @method $this forPage(int $page, int $perPage = 15)
     * @see \Illuminate\Database\Query\Builder::exists
     * @method bool exists()
     * @see \Illuminate\Support\Traits\Macroable::macroCall
     * @method $this macroCall(string $method, array $parameters)
     * @see \Illuminate\Database\Concerns\BuildsQueries::first
     * @method $this first(array|string $columns = ['*'])
     * @see \Illuminate\Database\Query\Builder::whereColumn
     * @method $this whereColumn(array|string $first, null|string $operator = null, null|string $second = null, null|string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::numericAggregate
     * @method $this numericAggregate(string $function, array $columns = ['*'])
     * @see \Illuminate\Database\Query\Builder::whereNotBetween
     * @method $this whereNotBetween(string $column, array $values, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::getConnection
     * @method ConnectionInterface getConnection()
     * @see \Illuminate\Database\Query\Builder::mergeBindings
     * @method $this mergeBindings(\Illuminate\Database\Query\Builder $query)
     * @see \Illuminate\Database\Query\Builder::orWhereJsonDoesntContain
     * @method $this orWhereJsonDoesntContain(string $column, $value)
     * @see \Illuminate\Database\Query\Builder::leftJoinSub
     * @method $this leftJoinSub(\Closure|Builder|\Illuminate\Database\Query\Builder|string $query, string $as, \Closure|string $first, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::crossJoinSub
     * @method $this crossJoinSub(\Closure|\Illuminate\Database\Query\Builder|string $query, string $as)
     * @see \Illuminate\Database\Query\Builder::limit
     * @method $this limit(int $value)
     * @see \Illuminate\Database\Query\Builder::from
     * @method $this from(\Closure|\Illuminate\Database\Query\Builder|string $table, null|string $as = null)
     * @see \Illuminate\Database\Query\Builder::whereNotBetweenColumns
     * @method $this whereNotBetweenColumns(string $column, array $values, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::insertGetId
     * @method int insertGetId(array $values, null|string $sequence = null)
     * @see \Illuminate\Database\Query\Builder::whereBetween
     * @method $this whereBetween(Expression|string $column, array $values, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Concerns\BuildsQueries::tap
     * @method $this tap(callable $callback)
     * @see \Illuminate\Database\Query\Builder::offset
     * @method $this offset(int $value)
     * @see \Illuminate\Database\Query\Builder::addNestedWhereQuery
     * @method $this addNestedWhereQuery(\Illuminate\Database\Query\Builder $query, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::rightJoin
     * @method $this rightJoin(string $table, \Closure|string $first, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::leftJoin
     * @method $this leftJoin(string $table, \Closure|string $first, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::insert
     * @method bool insert(array $values)
     * @see \Illuminate\Database\Query\Builder::distinct
     * @method $this distinct()
     * @see \Illuminate\Database\Concerns\BuildsQueries::chunk
     * @method $this chunk(int $count, callable $callback)
     * @see \Illuminate\Database\Query\Builder::reorder
     * @method $this reorder(\Closure|\Illuminate\Database\Query\Builder|Expression|null|string $column = null, string $direction = 'asc')
     * @see \Illuminate\Database\Query\Builder::whereYear
     * @method $this whereYear(string $column, string $operator, \DateTimeInterface|int|null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::getCountForPagination
     * @method $this getCountForPagination(array $columns = ['*'])
     * @see \Illuminate\Database\Query\Builder::groupByRaw
     * @method $this groupByRaw(string $sql, array $bindings = [])
     * @see \Illuminate\Database\Query\Builder::orWhereIntegerNotInRaw
     * @method $this orWhereIntegerNotInRaw(string $column, array|Arrayable $values)
     * @see \Illuminate\Database\Query\Builder::aggregate
     * @method $this aggregate(string $function, array $columns = ['*'])
     * @see \Illuminate\Database\Query\Builder::dump
     * @method \Illuminate\Database\Query\Builder dump()
     * @see \Illuminate\Database\Query\Builder::implode
     * @method $this implode(string $column, string $glue = '')
     * @see \Illuminate\Database\Query\Builder::addWhereExistsQuery
     * @method $this addWhereExistsQuery(\Illuminate\Database\Query\Builder $query, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Support\Traits\Macroable::macro
     * @method $this macro(string $name, callable|object $macro)
     * @see \Illuminate\Database\Query\Builder::whereRaw
     * @method $this whereRaw(string $sql, $bindings = [], string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::toSql
     * @method string toSql()
     * @see \Illuminate\Database\Query\Builder::orHaving
     * @method $this orHaving(string $column, null|string $operator = null, null|string $value = null)
     * @see \Illuminate\Database\Query\Builder::getBindings
     * @method array getBindings()
     * @see \Illuminate\Database\Query\Builder::orWhereTime
     * @method $this orWhereTime(string $column, string $operator, \DateTimeInterface|null|string $value = null)
     * @see \Illuminate\Database\Query\Builder::dynamicWhere
     * @method $this dynamicWhere(string $method, array $parameters)
     */
    class _BaseBuilder extends Builder {}
    
    /**
     * @method \Illuminate\Support\Collection mapSpread(callable $callback)
     * @method \Illuminate\Support\Collection mapWithKeys(callable $callback)
     * @method \Illuminate\Support\Collection zip(array $items)
     * @method \Illuminate\Support\Collection partition(callable|string $key, $operator = null, $value = null)
     * @method \Illuminate\Support\Collection mapInto(string $class)
     * @method \Illuminate\Support\Collection mapToGroups(callable $callback)
     * @method \Illuminate\Support\Collection map(callable $callback)
     * @method \Illuminate\Support\Collection groupBy(array|callable|string $groupBy, bool $preserveKeys = false)
     * @method \Illuminate\Support\Collection pluck(array|string $value, null|string $key = null)
     * @method \Illuminate\Support\Collection pad(int $size, $value)
     * @method \Illuminate\Support\Collection split(int $numberOfGroups)
     * @method \Illuminate\Support\Collection combine($values)
     * @method \Illuminate\Support\Collection countBy(callable|string $countBy = null)
     * @method \Illuminate\Support\Collection mapToDictionary(callable $callback)
     * @method \Illuminate\Support\Collection keys()
     * @method \Illuminate\Support\Collection transform(callable $callback)
     * @method \Illuminate\Support\Collection flatMap(callable $callback)
     * @method \Illuminate\Support\Collection collapse()
     */
    class _BaseCollection extends \Illuminate\Database\Eloquent\Collection {}
}

namespace LaravelIdea\Helper\App\Models\Attendance {

    use App\Models\Attendance\Attendance;
    use App\Models\Attendance\AttendanceRoster;
    use App\Models\Attendance\AttendanceShift;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method AttendanceRoster|$this shift(int $count = 1)
     * @method AttendanceRoster|null firstOrFail($key = null, $operator = null, $value = null)
     * @method AttendanceRoster|$this pop(int $count = 1)
     * @method AttendanceRoster|null get($key, $default = null)
     * @method AttendanceRoster|null pull($key, $default = null)
     * @method AttendanceRoster|null first(callable $callback = null, $default = null)
     * @method AttendanceRoster|null firstWhere(string $key, $operator = null, $value = null)
     * @method AttendanceRoster|null find($key, $default = null)
     * @method AttendanceRoster[] all()
     * @method AttendanceRoster|null last(callable $callback = null, $default = null)
     * @method AttendanceRoster|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_AttendanceRoster_C extends _BaseCollection {
        /**
         * @param int $size
         * @return AttendanceRoster[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method AttendanceRoster baseSole(array|string $columns = ['*'])
     * @method AttendanceRoster create(array $attributes = [])
     * @method _IH_AttendanceRoster_C|AttendanceRoster[] cursor()
     * @method AttendanceRoster|null|_IH_AttendanceRoster_C|AttendanceRoster[] find($id, array $columns = ['*'])
     * @method _IH_AttendanceRoster_C|AttendanceRoster[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method AttendanceRoster|_IH_AttendanceRoster_C|AttendanceRoster[] findOrFail($id, array $columns = ['*'])
     * @method AttendanceRoster|_IH_AttendanceRoster_C|AttendanceRoster[] findOrNew($id, array $columns = ['*'])
     * @method AttendanceRoster first(array|string $columns = ['*'])
     * @method AttendanceRoster firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method AttendanceRoster firstOrCreate(array $attributes = [], array $values = [])
     * @method AttendanceRoster firstOrFail(array $columns = ['*'])
     * @method AttendanceRoster firstOrNew(array $attributes = [], array $values = [])
     * @method AttendanceRoster firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method AttendanceRoster forceCreate(array $attributes)
     * @method _IH_AttendanceRoster_C|AttendanceRoster[] fromQuery(string $query, array $bindings = [])
     * @method _IH_AttendanceRoster_C|AttendanceRoster[] get(array|string $columns = ['*'])
     * @method AttendanceRoster getModel()
     * @method AttendanceRoster[] getModels(array|string $columns = ['*'])
     * @method _IH_AttendanceRoster_C|AttendanceRoster[] hydrate(array $items)
     * @method AttendanceRoster make(array $attributes = [])
     * @method AttendanceRoster newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|AttendanceRoster[]|_IH_AttendanceRoster_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|AttendanceRoster[]|_IH_AttendanceRoster_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method AttendanceRoster sole(array|string $columns = ['*'])
     * @method AttendanceRoster updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_AttendanceRoster_QB extends _BaseBuilder {}
    
    /**
     * @method AttendanceShift|$this shift(int $count = 1)
     * @method AttendanceShift|null firstOrFail($key = null, $operator = null, $value = null)
     * @method AttendanceShift|$this pop(int $count = 1)
     * @method AttendanceShift|null get($key, $default = null)
     * @method AttendanceShift|null pull($key, $default = null)
     * @method AttendanceShift|null first(callable $callback = null, $default = null)
     * @method AttendanceShift|null firstWhere(string $key, $operator = null, $value = null)
     * @method AttendanceShift|null find($key, $default = null)
     * @method AttendanceShift[] all()
     * @method AttendanceShift|null last(callable $callback = null, $default = null)
     * @method AttendanceShift|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_AttendanceShift_C extends _BaseCollection {
        /**
         * @param int $size
         * @return AttendanceShift[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method AttendanceShift baseSole(array|string $columns = ['*'])
     * @method AttendanceShift create(array $attributes = [])
     * @method _IH_AttendanceShift_C|AttendanceShift[] cursor()
     * @method AttendanceShift|null|_IH_AttendanceShift_C|AttendanceShift[] find($id, array $columns = ['*'])
     * @method _IH_AttendanceShift_C|AttendanceShift[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method AttendanceShift|_IH_AttendanceShift_C|AttendanceShift[] findOrFail($id, array $columns = ['*'])
     * @method AttendanceShift|_IH_AttendanceShift_C|AttendanceShift[] findOrNew($id, array $columns = ['*'])
     * @method AttendanceShift first(array|string $columns = ['*'])
     * @method AttendanceShift firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method AttendanceShift firstOrCreate(array $attributes = [], array $values = [])
     * @method AttendanceShift firstOrFail(array $columns = ['*'])
     * @method AttendanceShift firstOrNew(array $attributes = [], array $values = [])
     * @method AttendanceShift firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method AttendanceShift forceCreate(array $attributes)
     * @method _IH_AttendanceShift_C|AttendanceShift[] fromQuery(string $query, array $bindings = [])
     * @method _IH_AttendanceShift_C|AttendanceShift[] get(array|string $columns = ['*'])
     * @method AttendanceShift getModel()
     * @method AttendanceShift[] getModels(array|string $columns = ['*'])
     * @method _IH_AttendanceShift_C|AttendanceShift[] hydrate(array $items)
     * @method AttendanceShift make(array $attributes = [])
     * @method AttendanceShift newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|AttendanceShift[]|_IH_AttendanceShift_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|AttendanceShift[]|_IH_AttendanceShift_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method AttendanceShift sole(array|string $columns = ['*'])
     * @method AttendanceShift updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_AttendanceShift_QB extends _BaseBuilder {}
    
    /**
     * @method Attendance|$this shift(int $count = 1)
     * @method Attendance|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Attendance|$this pop(int $count = 1)
     * @method Attendance|null get($key, $default = null)
     * @method Attendance|null pull($key, $default = null)
     * @method Attendance|null first(callable $callback = null, $default = null)
     * @method Attendance|null firstWhere(string $key, $operator = null, $value = null)
     * @method Attendance|null find($key, $default = null)
     * @method Attendance[] all()
     * @method Attendance|null last(callable $callback = null, $default = null)
     * @method Attendance|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Attendance_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Attendance[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Attendance baseSole(array|string $columns = ['*'])
     * @method Attendance create(array $attributes = [])
     * @method _IH_Attendance_C|Attendance[] cursor()
     * @method Attendance|null|_IH_Attendance_C|Attendance[] find($id, array $columns = ['*'])
     * @method _IH_Attendance_C|Attendance[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Attendance|_IH_Attendance_C|Attendance[] findOrFail($id, array $columns = ['*'])
     * @method Attendance|_IH_Attendance_C|Attendance[] findOrNew($id, array $columns = ['*'])
     * @method Attendance first(array|string $columns = ['*'])
     * @method Attendance firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Attendance firstOrCreate(array $attributes = [], array $values = [])
     * @method Attendance firstOrFail(array $columns = ['*'])
     * @method Attendance firstOrNew(array $attributes = [], array $values = [])
     * @method Attendance firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Attendance forceCreate(array $attributes)
     * @method _IH_Attendance_C|Attendance[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Attendance_C|Attendance[] get(array|string $columns = ['*'])
     * @method Attendance getModel()
     * @method Attendance[] getModels(array|string $columns = ['*'])
     * @method _IH_Attendance_C|Attendance[] hydrate(array $items)
     * @method Attendance make(array $attributes = [])
     * @method Attendance newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Attendance[]|_IH_Attendance_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Attendance[]|_IH_Attendance_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Attendance sole(array|string $columns = ['*'])
     * @method Attendance updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Attendance_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\App\Models\BMS {

    use App\Models\BMS\Area;
    use App\Models\BMS\AreaObject;
    use App\Models\BMS\Building;
    use App\Models\BMS\Mapping;
    use App\Models\BMS\Master;
    use App\Models\BMS\Realization;
    use App\Models\BMS\Report;
    use App\Models\BMS\Shift;
    use App\Models\BMS\Target;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method AreaObject|$this shift(int $count = 1)
     * @method AreaObject|null firstOrFail($key = null, $operator = null, $value = null)
     * @method AreaObject|$this pop(int $count = 1)
     * @method AreaObject|null get($key, $default = null)
     * @method AreaObject|null pull($key, $default = null)
     * @method AreaObject|null first(callable $callback = null, $default = null)
     * @method AreaObject|null firstWhere(string $key, $operator = null, $value = null)
     * @method AreaObject|null find($key, $default = null)
     * @method AreaObject[] all()
     * @method AreaObject|null last(callable $callback = null, $default = null)
     * @method AreaObject|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_AreaObject_C extends _BaseCollection {
        /**
         * @param int $size
         * @return AreaObject[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_AreaObject_QB whereId($value)
     * @method _IH_AreaObject_QB whereServiceId($value)
     * @method _IH_AreaObject_QB whereBuildingId($value)
     * @method _IH_AreaObject_QB whereAreaId($value)
     * @method _IH_AreaObject_QB whereObjectId($value)
     * @method _IH_AreaObject_QB whereEmployeeId($value)
     * @method _IH_AreaObject_QB whereName($value)
     * @method _IH_AreaObject_QB whereDescription($value)
     * @method _IH_AreaObject_QB whereCode($value)
     * @method _IH_AreaObject_QB whereShift($value)
     * @method _IH_AreaObject_QB whereQr($value)
     * @method _IH_AreaObject_QB whereOrder($value)
     * @method _IH_AreaObject_QB whereStatus($value)
     * @method _IH_AreaObject_QB whereCreatedBy($value)
     * @method _IH_AreaObject_QB whereUpdatedBy($value)
     * @method _IH_AreaObject_QB whereCreatedAt($value)
     * @method _IH_AreaObject_QB whereUpdatedAt($value)
     * @method AreaObject baseSole(array|string $columns = ['*'])
     * @method AreaObject create(array $attributes = [])
     * @method _IH_AreaObject_C|AreaObject[] cursor()
     * @method AreaObject|null|_IH_AreaObject_C|AreaObject[] find($id, array $columns = ['*'])
     * @method _IH_AreaObject_C|AreaObject[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method AreaObject|_IH_AreaObject_C|AreaObject[] findOrFail($id, array $columns = ['*'])
     * @method AreaObject|_IH_AreaObject_C|AreaObject[] findOrNew($id, array $columns = ['*'])
     * @method AreaObject first(array|string $columns = ['*'])
     * @method AreaObject firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method AreaObject firstOrCreate(array $attributes = [], array $values = [])
     * @method AreaObject firstOrFail(array $columns = ['*'])
     * @method AreaObject firstOrNew(array $attributes = [], array $values = [])
     * @method AreaObject firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method AreaObject forceCreate(array $attributes)
     * @method _IH_AreaObject_C|AreaObject[] fromQuery(string $query, array $bindings = [])
     * @method _IH_AreaObject_C|AreaObject[] get(array|string $columns = ['*'])
     * @method AreaObject getModel()
     * @method AreaObject[] getModels(array|string $columns = ['*'])
     * @method _IH_AreaObject_C|AreaObject[] hydrate(array $items)
     * @method AreaObject make(array $attributes = [])
     * @method AreaObject newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|AreaObject[]|_IH_AreaObject_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|AreaObject[]|_IH_AreaObject_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method AreaObject sole(array|string $columns = ['*'])
     * @method AreaObject updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_AreaObject_QB extends _BaseBuilder {}
    
    /**
     * @method Area|$this shift(int $count = 1)
     * @method Area|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Area|$this pop(int $count = 1)
     * @method Area|null get($key, $default = null)
     * @method Area|null pull($key, $default = null)
     * @method Area|null first(callable $callback = null, $default = null)
     * @method Area|null firstWhere(string $key, $operator = null, $value = null)
     * @method Area|null find($key, $default = null)
     * @method Area[] all()
     * @method Area|null last(callable $callback = null, $default = null)
     * @method Area|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Area_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Area[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Area_QB whereId($value)
     * @method _IH_Area_QB whereBuildingId($value)
     * @method _IH_Area_QB whereServiceId($value)
     * @method _IH_Area_QB whereName($value)
     * @method _IH_Area_QB whereEmployeeId($value)
     * @method _IH_Area_QB whereCode($value)
     * @method _IH_Area_QB whereDescription($value)
     * @method _IH_Area_QB whereShift($value)
     * @method _IH_Area_QB whereOrder($value)
     * @method _IH_Area_QB whereStatus($value)
     * @method _IH_Area_QB whereCreatedBy($value)
     * @method _IH_Area_QB whereUpdatedBy($value)
     * @method _IH_Area_QB whereCreatedAt($value)
     * @method _IH_Area_QB whereUpdatedAt($value)
     * @method _IH_Area_QB whereQrFile($value)
     * @method Area baseSole(array|string $columns = ['*'])
     * @method Area create(array $attributes = [])
     * @method _IH_Area_C|Area[] cursor()
     * @method Area|null|_IH_Area_C|Area[] find($id, array $columns = ['*'])
     * @method _IH_Area_C|Area[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Area|_IH_Area_C|Area[] findOrFail($id, array $columns = ['*'])
     * @method Area|_IH_Area_C|Area[] findOrNew($id, array $columns = ['*'])
     * @method Area first(array|string $columns = ['*'])
     * @method Area firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Area firstOrCreate(array $attributes = [], array $values = [])
     * @method Area firstOrFail(array $columns = ['*'])
     * @method Area firstOrNew(array $attributes = [], array $values = [])
     * @method Area firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Area forceCreate(array $attributes)
     * @method _IH_Area_C|Area[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Area_C|Area[] get(array|string $columns = ['*'])
     * @method Area getModel()
     * @method Area[] getModels(array|string $columns = ['*'])
     * @method _IH_Area_C|Area[] hydrate(array $items)
     * @method Area make(array $attributes = [])
     * @method Area newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Area[]|_IH_Area_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Area[]|_IH_Area_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Area sole(array|string $columns = ['*'])
     * @method Area updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Area_QB extends _BaseBuilder {}
    
    /**
     * @method Building|$this shift(int $count = 1)
     * @method Building|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Building|$this pop(int $count = 1)
     * @method Building|null get($key, $default = null)
     * @method Building|null pull($key, $default = null)
     * @method Building|null first(callable $callback = null, $default = null)
     * @method Building|null firstWhere(string $key, $operator = null, $value = null)
     * @method Building|null find($key, $default = null)
     * @method Building[] all()
     * @method Building|null last(callable $callback = null, $default = null)
     * @method Building|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Building_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Building[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Building_QB whereId($value)
     * @method _IH_Building_QB whereCode($value)
     * @method _IH_Building_QB whereName($value)
     * @method _IH_Building_QB whereRegionId($value)
     * @method _IH_Building_QB whereTypeId($value)
     * @method _IH_Building_QB whereAddress($value)
     * @method _IH_Building_QB whereStatus($value)
     * @method _IH_Building_QB whereServices($value)
     * @method _IH_Building_QB wherePhoto($value)
     * @method _IH_Building_QB whereCreatedBy($value)
     * @method _IH_Building_QB whereUpdatedBy($value)
     * @method _IH_Building_QB whereCreatedAt($value)
     * @method _IH_Building_QB whereUpdatedAt($value)
     * @method Building baseSole(array|string $columns = ['*'])
     * @method Building create(array $attributes = [])
     * @method _IH_Building_C|Building[] cursor()
     * @method Building|null|_IH_Building_C|Building[] find($id, array $columns = ['*'])
     * @method _IH_Building_C|Building[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Building|_IH_Building_C|Building[] findOrFail($id, array $columns = ['*'])
     * @method Building|_IH_Building_C|Building[] findOrNew($id, array $columns = ['*'])
     * @method Building first(array|string $columns = ['*'])
     * @method Building firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Building firstOrCreate(array $attributes = [], array $values = [])
     * @method Building firstOrFail(array $columns = ['*'])
     * @method Building firstOrNew(array $attributes = [], array $values = [])
     * @method Building firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Building forceCreate(array $attributes)
     * @method _IH_Building_C|Building[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Building_C|Building[] get(array|string $columns = ['*'])
     * @method Building getModel()
     * @method Building[] getModels(array|string $columns = ['*'])
     * @method _IH_Building_C|Building[] hydrate(array $items)
     * @method Building make(array $attributes = [])
     * @method Building newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Building[]|_IH_Building_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Building[]|_IH_Building_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Building sole(array|string $columns = ['*'])
     * @method Building updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Building_QB extends _BaseBuilder {}
    
    /**
     * @method Mapping|$this shift(int $count = 1)
     * @method Mapping|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Mapping|$this pop(int $count = 1)
     * @method Mapping|null get($key, $default = null)
     * @method Mapping|null pull($key, $default = null)
     * @method Mapping|null first(callable $callback = null, $default = null)
     * @method Mapping|null firstWhere(string $key, $operator = null, $value = null)
     * @method Mapping|null find($key, $default = null)
     * @method Mapping[] all()
     * @method Mapping|null last(callable $callback = null, $default = null)
     * @method Mapping|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Mapping_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Mapping[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Mapping_QB whereId($value)
     * @method _IH_Mapping_QB whereEmployeeId($value)
     * @method _IH_Mapping_QB whereRegionId($value)
     * @method _IH_Mapping_QB whereBuildingId($value)
     * @method _IH_Mapping_QB whereService($value)
     * @method _IH_Mapping_QB whereCreatedBy($value)
     * @method _IH_Mapping_QB whereUpdatedBy($value)
     * @method _IH_Mapping_QB whereCreatedAt($value)
     * @method _IH_Mapping_QB whereUpdatedAt($value)
     * @method Mapping baseSole(array|string $columns = ['*'])
     * @method Mapping create(array $attributes = [])
     * @method _IH_Mapping_C|Mapping[] cursor()
     * @method Mapping|null|_IH_Mapping_C|Mapping[] find($id, array $columns = ['*'])
     * @method _IH_Mapping_C|Mapping[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Mapping|_IH_Mapping_C|Mapping[] findOrFail($id, array $columns = ['*'])
     * @method Mapping|_IH_Mapping_C|Mapping[] findOrNew($id, array $columns = ['*'])
     * @method Mapping first(array|string $columns = ['*'])
     * @method Mapping firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Mapping firstOrCreate(array $attributes = [], array $values = [])
     * @method Mapping firstOrFail(array $columns = ['*'])
     * @method Mapping firstOrNew(array $attributes = [], array $values = [])
     * @method Mapping firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Mapping forceCreate(array $attributes)
     * @method _IH_Mapping_C|Mapping[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Mapping_C|Mapping[] get(array|string $columns = ['*'])
     * @method Mapping getModel()
     * @method Mapping[] getModels(array|string $columns = ['*'])
     * @method _IH_Mapping_C|Mapping[] hydrate(array $items)
     * @method Mapping make(array $attributes = [])
     * @method Mapping newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Mapping[]|_IH_Mapping_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Mapping[]|_IH_Mapping_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Mapping sole(array|string $columns = ['*'])
     * @method Mapping updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Mapping_QB extends _BaseBuilder {}
    
    /**
     * @method Master|$this shift(int $count = 1)
     * @method Master|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Master|$this pop(int $count = 1)
     * @method Master|null get($key, $default = null)
     * @method Master|null pull($key, $default = null)
     * @method Master|null first(callable $callback = null, $default = null)
     * @method Master|null firstWhere(string $key, $operator = null, $value = null)
     * @method Master|null find($key, $default = null)
     * @method Master[] all()
     * @method Master|null last(callable $callback = null, $default = null)
     * @method Master|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Master_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Master[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Master_QB whereId($value)
     * @method _IH_Master_QB whereServiceId($value)
     * @method _IH_Master_QB whereObjectId($value)
     * @method _IH_Master_QB whereTargetId($value)
     * @method _IH_Master_QB whereCategoryId($value)
     * @method _IH_Master_QB whereName($value)
     * @method _IH_Master_QB whereCode($value)
     * @method _IH_Master_QB whereControlType($value)
     * @method _IH_Master_QB whereControlParameter($value)
     * @method _IH_Master_QB whereControlUnitId($value)
     * @method _IH_Master_QB whereIntervalId($value)
     * @method _IH_Master_QB whereDescription($value)
     * @method _IH_Master_QB whereOrder($value)
     * @method _IH_Master_QB whereStatus($value)
     * @method _IH_Master_QB whereCreatedBy($value)
     * @method _IH_Master_QB whereUpdatedBy($value)
     * @method _IH_Master_QB whereCreatedAt($value)
     * @method _IH_Master_QB whereUpdatedAt($value)
     * @method Master baseSole(array|string $columns = ['*'])
     * @method Master create(array $attributes = [])
     * @method _IH_Master_C|Master[] cursor()
     * @method Master|null|_IH_Master_C|Master[] find($id, array $columns = ['*'])
     * @method _IH_Master_C|Master[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Master|_IH_Master_C|Master[] findOrFail($id, array $columns = ['*'])
     * @method Master|_IH_Master_C|Master[] findOrNew($id, array $columns = ['*'])
     * @method Master first(array|string $columns = ['*'])
     * @method Master firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Master firstOrCreate(array $attributes = [], array $values = [])
     * @method Master firstOrFail(array $columns = ['*'])
     * @method Master firstOrNew(array $attributes = [], array $values = [])
     * @method Master firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Master forceCreate(array $attributes)
     * @method _IH_Master_C|Master[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Master_C|Master[] get(array|string $columns = ['*'])
     * @method Master getModel()
     * @method Master[] getModels(array|string $columns = ['*'])
     * @method _IH_Master_C|Master[] hydrate(array $items)
     * @method Master make(array $attributes = [])
     * @method Master newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Master[]|_IH_Master_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Master[]|_IH_Master_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Master sole(array|string $columns = ['*'])
     * @method Master updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Master_QB extends _BaseBuilder {}
    
    /**
     * @method Realization|$this shift(int $count = 1)
     * @method Realization|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Realization|$this pop(int $count = 1)
     * @method Realization|null get($key, $default = null)
     * @method Realization|null pull($key, $default = null)
     * @method Realization|null first(callable $callback = null, $default = null)
     * @method Realization|null firstWhere(string $key, $operator = null, $value = null)
     * @method Realization|null find($key, $default = null)
     * @method Realization[] all()
     * @method Realization|null last(callable $callback = null, $default = null)
     * @method Realization|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Realization_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Realization[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Realization_QB whereId($value)
     * @method _IH_Realization_QB whereEmployeeId($value)
     * @method _IH_Realization_QB whereBuildingId($value)
     * @method _IH_Realization_QB whereServiceId($value)
     * @method _IH_Realization_QB whereAreaId($value)
     * @method _IH_Realization_QB whereObjectId($value)
     * @method _IH_Realization_QB whereShiftId($value)
     * @method _IH_Realization_QB whereActivityId($value)
     * @method _IH_Realization_QB whereControlType($value)
     * @method _IH_Realization_QB whereControlResult($value)
     * @method _IH_Realization_QB whereCreatedBy($value)
     * @method _IH_Realization_QB whereUpdatedBy($value)
     * @method _IH_Realization_QB whereCreatedAt($value)
     * @method _IH_Realization_QB whereUpdatedAt($value)
     * @method Realization baseSole(array|string $columns = ['*'])
     * @method Realization create(array $attributes = [])
     * @method _IH_Realization_C|Realization[] cursor()
     * @method Realization|null|_IH_Realization_C|Realization[] find($id, array $columns = ['*'])
     * @method _IH_Realization_C|Realization[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Realization|_IH_Realization_C|Realization[] findOrFail($id, array $columns = ['*'])
     * @method Realization|_IH_Realization_C|Realization[] findOrNew($id, array $columns = ['*'])
     * @method Realization first(array|string $columns = ['*'])
     * @method Realization firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Realization firstOrCreate(array $attributes = [], array $values = [])
     * @method Realization firstOrFail(array $columns = ['*'])
     * @method Realization firstOrNew(array $attributes = [], array $values = [])
     * @method Realization firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Realization forceCreate(array $attributes)
     * @method _IH_Realization_C|Realization[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Realization_C|Realization[] get(array|string $columns = ['*'])
     * @method Realization getModel()
     * @method Realization[] getModels(array|string $columns = ['*'])
     * @method _IH_Realization_C|Realization[] hydrate(array $items)
     * @method Realization make(array $attributes = [])
     * @method Realization newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Realization[]|_IH_Realization_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Realization[]|_IH_Realization_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Realization sole(array|string $columns = ['*'])
     * @method Realization updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Realization_QB extends _BaseBuilder {}
    
    /**
     * @method Report|$this shift(int $count = 1)
     * @method Report|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Report|$this pop(int $count = 1)
     * @method Report|null get($key, $default = null)
     * @method Report|null pull($key, $default = null)
     * @method Report|null first(callable $callback = null, $default = null)
     * @method Report|null firstWhere(string $key, $operator = null, $value = null)
     * @method Report|null find($key, $default = null)
     * @method Report[] all()
     * @method Report|null last(callable $callback = null, $default = null)
     * @method Report|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Report_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Report[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Report_QB whereId($value)
     * @method _IH_Report_QB whereEmployeeId($value)
     * @method _IH_Report_QB whereBuildingId($value)
     * @method _IH_Report_QB whereAreaId($value)
     * @method _IH_Report_QB whereServiceId($value)
     * @method _IH_Report_QB whereDate($value)
     * @method _IH_Report_QB whereDescription($value)
     * @method _IH_Report_QB whereLocation($value)
     * @method _IH_Report_QB whereTime($value)
     * @method _IH_Report_QB whereImage($value)
     * @method _IH_Report_QB whereCreatedBy($value)
     * @method _IH_Report_QB whereUpdatedBy($value)
     * @method _IH_Report_QB whereCreatedAt($value)
     * @method _IH_Report_QB whereUpdatedAt($value)
     * @method Report baseSole(array|string $columns = ['*'])
     * @method Report create(array $attributes = [])
     * @method _IH_Report_C|Report[] cursor()
     * @method Report|null|_IH_Report_C|Report[] find($id, array $columns = ['*'])
     * @method _IH_Report_C|Report[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Report|_IH_Report_C|Report[] findOrFail($id, array $columns = ['*'])
     * @method Report|_IH_Report_C|Report[] findOrNew($id, array $columns = ['*'])
     * @method Report first(array|string $columns = ['*'])
     * @method Report firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Report firstOrCreate(array $attributes = [], array $values = [])
     * @method Report firstOrFail(array $columns = ['*'])
     * @method Report firstOrNew(array $attributes = [], array $values = [])
     * @method Report firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Report forceCreate(array $attributes)
     * @method _IH_Report_C|Report[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Report_C|Report[] get(array|string $columns = ['*'])
     * @method Report getModel()
     * @method Report[] getModels(array|string $columns = ['*'])
     * @method _IH_Report_C|Report[] hydrate(array $items)
     * @method Report make(array $attributes = [])
     * @method Report newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Report[]|_IH_Report_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Report[]|_IH_Report_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Report sole(array|string $columns = ['*'])
     * @method Report updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Report_QB extends _BaseBuilder {}
    
    /**
     * @method Shift|$this shift(int $count = 1)
     * @method Shift|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Shift|$this pop(int $count = 1)
     * @method Shift|null get($key, $default = null)
     * @method Shift|null pull($key, $default = null)
     * @method Shift|null first(callable $callback = null, $default = null)
     * @method Shift|null firstWhere(string $key, $operator = null, $value = null)
     * @method Shift|null find($key, $default = null)
     * @method Shift[] all()
     * @method Shift|null last(callable $callback = null, $default = null)
     * @method Shift|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Shift_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Shift[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Shift_QB whereId($value)
     * @method _IH_Shift_QB whereBuildingId($value)
     * @method _IH_Shift_QB whereServiceId($value)
     * @method _IH_Shift_QB whereAreaId($value)
     * @method _IH_Shift_QB whereName($value)
     * @method _IH_Shift_QB whereStart($value)
     * @method _IH_Shift_QB whereEnd($value)
     * @method _IH_Shift_QB whereCode($value)
     * @method _IH_Shift_QB whereIntervalId($value)
     * @method _IH_Shift_QB whereFinishToday($value)
     * @method _IH_Shift_QB whereDescription($value)
     * @method _IH_Shift_QB whereSpecial($value)
     * @method _IH_Shift_QB whereOrder($value)
     * @method _IH_Shift_QB whereStatus($value)
     * @method _IH_Shift_QB whereCreatedBy($value)
     * @method _IH_Shift_QB whereUpdatedBy($value)
     * @method _IH_Shift_QB whereCreatedAt($value)
     * @method _IH_Shift_QB whereUpdatedAt($value)
     * @method Shift baseSole(array|string $columns = ['*'])
     * @method Shift create(array $attributes = [])
     * @method _IH_Shift_C|Shift[] cursor()
     * @method Shift|null|_IH_Shift_C|Shift[] find($id, array $columns = ['*'])
     * @method _IH_Shift_C|Shift[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Shift|_IH_Shift_C|Shift[] findOrFail($id, array $columns = ['*'])
     * @method Shift|_IH_Shift_C|Shift[] findOrNew($id, array $columns = ['*'])
     * @method Shift first(array|string $columns = ['*'])
     * @method Shift firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Shift firstOrCreate(array $attributes = [], array $values = [])
     * @method Shift firstOrFail(array $columns = ['*'])
     * @method Shift firstOrNew(array $attributes = [], array $values = [])
     * @method Shift firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Shift forceCreate(array $attributes)
     * @method _IH_Shift_C|Shift[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Shift_C|Shift[] get(array|string $columns = ['*'])
     * @method Shift getModel()
     * @method Shift[] getModels(array|string $columns = ['*'])
     * @method _IH_Shift_C|Shift[] hydrate(array $items)
     * @method Shift make(array $attributes = [])
     * @method Shift newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Shift[]|_IH_Shift_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Shift[]|_IH_Shift_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Shift sole(array|string $columns = ['*'])
     * @method Shift updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Shift_QB extends _BaseBuilder {}
    
    /**
     * @method Target|$this shift(int $count = 1)
     * @method Target|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Target|$this pop(int $count = 1)
     * @method Target|null get($key, $default = null)
     * @method Target|null pull($key, $default = null)
     * @method Target|null first(callable $callback = null, $default = null)
     * @method Target|null firstWhere(string $key, $operator = null, $value = null)
     * @method Target|null find($key, $default = null)
     * @method Target[] all()
     * @method Target|null last(callable $callback = null, $default = null)
     * @method Target|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Target_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Target[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Target_QB whereId($value)
     * @method _IH_Target_QB whereServiceId($value)
     * @method _IH_Target_QB whereObjectId($value)
     * @method _IH_Target_QB whereName($value)
     * @method _IH_Target_QB whereCode($value)
     * @method _IH_Target_QB whereDescription($value)
     * @method _IH_Target_QB whereOrder($value)
     * @method _IH_Target_QB whereStatus($value)
     * @method _IH_Target_QB whereCreatedBy($value)
     * @method _IH_Target_QB whereUpdatedBy($value)
     * @method _IH_Target_QB whereCreatedAt($value)
     * @method _IH_Target_QB whereUpdatedAt($value)
     * @method Target baseSole(array|string $columns = ['*'])
     * @method Target create(array $attributes = [])
     * @method _IH_Target_C|Target[] cursor()
     * @method Target|null|_IH_Target_C|Target[] find($id, array $columns = ['*'])
     * @method _IH_Target_C|Target[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Target|_IH_Target_C|Target[] findOrFail($id, array $columns = ['*'])
     * @method Target|_IH_Target_C|Target[] findOrNew($id, array $columns = ['*'])
     * @method Target first(array|string $columns = ['*'])
     * @method Target firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Target firstOrCreate(array $attributes = [], array $values = [])
     * @method Target firstOrFail(array $columns = ['*'])
     * @method Target firstOrNew(array $attributes = [], array $values = [])
     * @method Target firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Target forceCreate(array $attributes)
     * @method _IH_Target_C|Target[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Target_C|Target[] get(array|string $columns = ['*'])
     * @method Target getModel()
     * @method Target[] getModels(array|string $columns = ['*'])
     * @method _IH_Target_C|Target[] hydrate(array $items)
     * @method Target make(array $attributes = [])
     * @method Target newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Target[]|_IH_Target_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Target[]|_IH_Target_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Target sole(array|string $columns = ['*'])
     * @method Target updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Target_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\App\Models\ESS {

    use App\Models\ESS\AttendanceLeave;
    use App\Models\ESS\AttendanceLeaveMaster;
    use App\Models\ESS\AttendanceOvertime;
    use App\Models\ESS\AttendancePermission;
    use App\Models\ESS\AttendanceReimbursement;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method AttendanceLeaveMaster|$this shift(int $count = 1)
     * @method AttendanceLeaveMaster|null firstOrFail($key = null, $operator = null, $value = null)
     * @method AttendanceLeaveMaster|$this pop(int $count = 1)
     * @method AttendanceLeaveMaster|null get($key, $default = null)
     * @method AttendanceLeaveMaster|null pull($key, $default = null)
     * @method AttendanceLeaveMaster|null first(callable $callback = null, $default = null)
     * @method AttendanceLeaveMaster|null firstWhere(string $key, $operator = null, $value = null)
     * @method AttendanceLeaveMaster|null find($key, $default = null)
     * @method AttendanceLeaveMaster[] all()
     * @method AttendanceLeaveMaster|null last(callable $callback = null, $default = null)
     * @method AttendanceLeaveMaster|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_AttendanceLeaveMaster_C extends _BaseCollection {
        /**
         * @param int $size
         * @return AttendanceLeaveMaster[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_AttendanceLeaveMaster_QB whereId($value)
     * @method _IH_AttendanceLeaveMaster_QB whereName($value)
     * @method _IH_AttendanceLeaveMaster_QB whereQuota($value)
     * @method _IH_AttendanceLeaveMaster_QB whereDescription($value)
     * @method _IH_AttendanceLeaveMaster_QB whereStartDate($value)
     * @method _IH_AttendanceLeaveMaster_QB whereEndDate($value)
     * @method _IH_AttendanceLeaveMaster_QB whereWorkingLife($value)
     * @method _IH_AttendanceLeaveMaster_QB whereGender($value)
     * @method _IH_AttendanceLeaveMaster_QB whereLocationId($value)
     * @method _IH_AttendanceLeaveMaster_QB whereStatus($value)
     * @method _IH_AttendanceLeaveMaster_QB whereCreatedBy($value)
     * @method _IH_AttendanceLeaveMaster_QB whereUpdatedBy($value)
     * @method _IH_AttendanceLeaveMaster_QB whereCreatedAt($value)
     * @method _IH_AttendanceLeaveMaster_QB whereUpdatedAt($value)
     * @method AttendanceLeaveMaster baseSole(array|string $columns = ['*'])
     * @method AttendanceLeaveMaster create(array $attributes = [])
     * @method _IH_AttendanceLeaveMaster_C|AttendanceLeaveMaster[] cursor()
     * @method AttendanceLeaveMaster|null|_IH_AttendanceLeaveMaster_C|AttendanceLeaveMaster[] find($id, array $columns = ['*'])
     * @method _IH_AttendanceLeaveMaster_C|AttendanceLeaveMaster[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method AttendanceLeaveMaster|_IH_AttendanceLeaveMaster_C|AttendanceLeaveMaster[] findOrFail($id, array $columns = ['*'])
     * @method AttendanceLeaveMaster|_IH_AttendanceLeaveMaster_C|AttendanceLeaveMaster[] findOrNew($id, array $columns = ['*'])
     * @method AttendanceLeaveMaster first(array|string $columns = ['*'])
     * @method AttendanceLeaveMaster firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method AttendanceLeaveMaster firstOrCreate(array $attributes = [], array $values = [])
     * @method AttendanceLeaveMaster firstOrFail(array $columns = ['*'])
     * @method AttendanceLeaveMaster firstOrNew(array $attributes = [], array $values = [])
     * @method AttendanceLeaveMaster firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method AttendanceLeaveMaster forceCreate(array $attributes)
     * @method _IH_AttendanceLeaveMaster_C|AttendanceLeaveMaster[] fromQuery(string $query, array $bindings = [])
     * @method _IH_AttendanceLeaveMaster_C|AttendanceLeaveMaster[] get(array|string $columns = ['*'])
     * @method AttendanceLeaveMaster getModel()
     * @method AttendanceLeaveMaster[] getModels(array|string $columns = ['*'])
     * @method _IH_AttendanceLeaveMaster_C|AttendanceLeaveMaster[] hydrate(array $items)
     * @method AttendanceLeaveMaster make(array $attributes = [])
     * @method AttendanceLeaveMaster newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|AttendanceLeaveMaster[]|_IH_AttendanceLeaveMaster_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|AttendanceLeaveMaster[]|_IH_AttendanceLeaveMaster_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method AttendanceLeaveMaster sole(array|string $columns = ['*'])
     * @method AttendanceLeaveMaster updateOrCreate(array $attributes, array $values = [])
     * @method _IH_AttendanceLeaveMaster_QB active()
     */
    class _IH_AttendanceLeaveMaster_QB extends _BaseBuilder {}
    
    /**
     * @method AttendanceLeave|$this shift(int $count = 1)
     * @method AttendanceLeave|null firstOrFail($key = null, $operator = null, $value = null)
     * @method AttendanceLeave|$this pop(int $count = 1)
     * @method AttendanceLeave|null get($key, $default = null)
     * @method AttendanceLeave|null pull($key, $default = null)
     * @method AttendanceLeave|null first(callable $callback = null, $default = null)
     * @method AttendanceLeave|null firstWhere(string $key, $operator = null, $value = null)
     * @method AttendanceLeave|null find($key, $default = null)
     * @method AttendanceLeave[] all()
     * @method AttendanceLeave|null last(callable $callback = null, $default = null)
     * @method AttendanceLeave|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_AttendanceLeave_C extends _BaseCollection {
        /**
         * @param int $size
         * @return AttendanceLeave[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_AttendanceLeave_QB whereId($value)
     * @method _IH_AttendanceLeave_QB whereEmployeeId($value)
     * @method _IH_AttendanceLeave_QB whereTypeId($value)
     * @method _IH_AttendanceLeave_QB whereNumber($value)
     * @method _IH_AttendanceLeave_QB whereDate($value)
     * @method _IH_AttendanceLeave_QB whereStartDate($value)
     * @method _IH_AttendanceLeave_QB whereEndDate($value)
     * @method _IH_AttendanceLeave_QB whereQuota($value)
     * @method _IH_AttendanceLeave_QB whereAmount($value)
     * @method _IH_AttendanceLeave_QB whereRemaining($value)
     * @method _IH_AttendanceLeave_QB whereDescription($value)
     * @method _IH_AttendanceLeave_QB whereFilename($value)
     * @method _IH_AttendanceLeave_QB whereApprovedBy($value)
     * @method _IH_AttendanceLeave_QB whereApprovedDate($value)
     * @method _IH_AttendanceLeave_QB whereApprovedNote($value)
     * @method _IH_AttendanceLeave_QB whereCreatedBy($value)
     * @method _IH_AttendanceLeave_QB whereUpdatedBy($value)
     * @method _IH_AttendanceLeave_QB whereCreatedAt($value)
     * @method _IH_AttendanceLeave_QB whereUpdatedAt($value)
     * @method _IH_AttendanceLeave_QB whereApprovedStatus($value)
     * @method AttendanceLeave baseSole(array|string $columns = ['*'])
     * @method AttendanceLeave create(array $attributes = [])
     * @method _IH_AttendanceLeave_C|AttendanceLeave[] cursor()
     * @method AttendanceLeave|null|_IH_AttendanceLeave_C|AttendanceLeave[] find($id, array $columns = ['*'])
     * @method _IH_AttendanceLeave_C|AttendanceLeave[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method AttendanceLeave|_IH_AttendanceLeave_C|AttendanceLeave[] findOrFail($id, array $columns = ['*'])
     * @method AttendanceLeave|_IH_AttendanceLeave_C|AttendanceLeave[] findOrNew($id, array $columns = ['*'])
     * @method AttendanceLeave first(array|string $columns = ['*'])
     * @method AttendanceLeave firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method AttendanceLeave firstOrCreate(array $attributes = [], array $values = [])
     * @method AttendanceLeave firstOrFail(array $columns = ['*'])
     * @method AttendanceLeave firstOrNew(array $attributes = [], array $values = [])
     * @method AttendanceLeave firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method AttendanceLeave forceCreate(array $attributes)
     * @method _IH_AttendanceLeave_C|AttendanceLeave[] fromQuery(string $query, array $bindings = [])
     * @method _IH_AttendanceLeave_C|AttendanceLeave[] get(array|string $columns = ['*'])
     * @method AttendanceLeave getModel()
     * @method AttendanceLeave[] getModels(array|string $columns = ['*'])
     * @method _IH_AttendanceLeave_C|AttendanceLeave[] hydrate(array $items)
     * @method AttendanceLeave make(array $attributes = [])
     * @method AttendanceLeave newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|AttendanceLeave[]|_IH_AttendanceLeave_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|AttendanceLeave[]|_IH_AttendanceLeave_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method AttendanceLeave sole(array|string $columns = ['*'])
     * @method AttendanceLeave updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_AttendanceLeave_QB extends _BaseBuilder {}
    
    /**
     * @method AttendanceOvertime|$this shift(int $count = 1)
     * @method AttendanceOvertime|null firstOrFail($key = null, $operator = null, $value = null)
     * @method AttendanceOvertime|$this pop(int $count = 1)
     * @method AttendanceOvertime|null get($key, $default = null)
     * @method AttendanceOvertime|null pull($key, $default = null)
     * @method AttendanceOvertime|null first(callable $callback = null, $default = null)
     * @method AttendanceOvertime|null firstWhere(string $key, $operator = null, $value = null)
     * @method AttendanceOvertime|null find($key, $default = null)
     * @method AttendanceOvertime[] all()
     * @method AttendanceOvertime|null last(callable $callback = null, $default = null)
     * @method AttendanceOvertime|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_AttendanceOvertime_C extends _BaseCollection {
        /**
         * @param int $size
         * @return AttendanceOvertime[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_AttendanceOvertime_QB whereId($value)
     * @method _IH_AttendanceOvertime_QB whereEmployeeId($value)
     * @method _IH_AttendanceOvertime_QB whereNumber($value)
     * @method _IH_AttendanceOvertime_QB whereDate($value)
     * @method _IH_AttendanceOvertime_QB whereStartDate($value)
     * @method _IH_AttendanceOvertime_QB whereEndDate($value)
     * @method _IH_AttendanceOvertime_QB whereStartTime($value)
     * @method _IH_AttendanceOvertime_QB whereEndTime($value)
     * @method _IH_AttendanceOvertime_QB whereDescription($value)
     * @method _IH_AttendanceOvertime_QB whereFilename($value)
     * @method _IH_AttendanceOvertime_QB whereApprovedBy($value)
     * @method _IH_AttendanceOvertime_QB whereApprovedStatus($value)
     * @method _IH_AttendanceOvertime_QB whereApprovedDate($value)
     * @method _IH_AttendanceOvertime_QB whereApprovedNote($value)
     * @method _IH_AttendanceOvertime_QB whereCreatedBy($value)
     * @method _IH_AttendanceOvertime_QB whereUpdatedBy($value)
     * @method _IH_AttendanceOvertime_QB whereCreatedAt($value)
     * @method _IH_AttendanceOvertime_QB whereUpdatedAt($value)
     * @method _IH_AttendanceOvertime_QB whereDuration($value)
     * @method AttendanceOvertime baseSole(array|string $columns = ['*'])
     * @method AttendanceOvertime create(array $attributes = [])
     * @method _IH_AttendanceOvertime_C|AttendanceOvertime[] cursor()
     * @method AttendanceOvertime|null|_IH_AttendanceOvertime_C|AttendanceOvertime[] find($id, array $columns = ['*'])
     * @method _IH_AttendanceOvertime_C|AttendanceOvertime[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method AttendanceOvertime|_IH_AttendanceOvertime_C|AttendanceOvertime[] findOrFail($id, array $columns = ['*'])
     * @method AttendanceOvertime|_IH_AttendanceOvertime_C|AttendanceOvertime[] findOrNew($id, array $columns = ['*'])
     * @method AttendanceOvertime first(array|string $columns = ['*'])
     * @method AttendanceOvertime firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method AttendanceOvertime firstOrCreate(array $attributes = [], array $values = [])
     * @method AttendanceOvertime firstOrFail(array $columns = ['*'])
     * @method AttendanceOvertime firstOrNew(array $attributes = [], array $values = [])
     * @method AttendanceOvertime firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method AttendanceOvertime forceCreate(array $attributes)
     * @method _IH_AttendanceOvertime_C|AttendanceOvertime[] fromQuery(string $query, array $bindings = [])
     * @method _IH_AttendanceOvertime_C|AttendanceOvertime[] get(array|string $columns = ['*'])
     * @method AttendanceOvertime getModel()
     * @method AttendanceOvertime[] getModels(array|string $columns = ['*'])
     * @method _IH_AttendanceOvertime_C|AttendanceOvertime[] hydrate(array $items)
     * @method AttendanceOvertime make(array $attributes = [])
     * @method AttendanceOvertime newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|AttendanceOvertime[]|_IH_AttendanceOvertime_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|AttendanceOvertime[]|_IH_AttendanceOvertime_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method AttendanceOvertime sole(array|string $columns = ['*'])
     * @method AttendanceOvertime updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_AttendanceOvertime_QB extends _BaseBuilder {}
    
    /**
     * @method AttendancePermission|$this shift(int $count = 1)
     * @method AttendancePermission|null firstOrFail($key = null, $operator = null, $value = null)
     * @method AttendancePermission|$this pop(int $count = 1)
     * @method AttendancePermission|null get($key, $default = null)
     * @method AttendancePermission|null pull($key, $default = null)
     * @method AttendancePermission|null first(callable $callback = null, $default = null)
     * @method AttendancePermission|null firstWhere(string $key, $operator = null, $value = null)
     * @method AttendancePermission|null find($key, $default = null)
     * @method AttendancePermission[] all()
     * @method AttendancePermission|null last(callable $callback = null, $default = null)
     * @method AttendancePermission|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_AttendancePermission_C extends _BaseCollection {
        /**
         * @param int $size
         * @return AttendancePermission[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_AttendancePermission_QB whereId($value)
     * @method _IH_AttendancePermission_QB whereEmployeeId($value)
     * @method _IH_AttendancePermission_QB whereCategoryId($value)
     * @method _IH_AttendancePermission_QB whereNumber($value)
     * @method _IH_AttendancePermission_QB whereDate($value)
     * @method _IH_AttendancePermission_QB whereStartDate($value)
     * @method _IH_AttendancePermission_QB whereEndDate($value)
     * @method _IH_AttendancePermission_QB whereDescription($value)
     * @method _IH_AttendancePermission_QB whereFilename($value)
     * @method _IH_AttendancePermission_QB whereApprovedBy($value)
     * @method _IH_AttendancePermission_QB whereApprovedStatus($value)
     * @method _IH_AttendancePermission_QB whereApprovedDate($value)
     * @method _IH_AttendancePermission_QB whereApprovedNote($value)
     * @method _IH_AttendancePermission_QB whereCreatedBy($value)
     * @method _IH_AttendancePermission_QB whereUpdatedBy($value)
     * @method _IH_AttendancePermission_QB whereCreatedAt($value)
     * @method _IH_AttendancePermission_QB whereUpdatedAt($value)
     * @method AttendancePermission baseSole(array|string $columns = ['*'])
     * @method AttendancePermission create(array $attributes = [])
     * @method _IH_AttendancePermission_C|AttendancePermission[] cursor()
     * @method AttendancePermission|null|_IH_AttendancePermission_C|AttendancePermission[] find($id, array $columns = ['*'])
     * @method _IH_AttendancePermission_C|AttendancePermission[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method AttendancePermission|_IH_AttendancePermission_C|AttendancePermission[] findOrFail($id, array $columns = ['*'])
     * @method AttendancePermission|_IH_AttendancePermission_C|AttendancePermission[] findOrNew($id, array $columns = ['*'])
     * @method AttendancePermission first(array|string $columns = ['*'])
     * @method AttendancePermission firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method AttendancePermission firstOrCreate(array $attributes = [], array $values = [])
     * @method AttendancePermission firstOrFail(array $columns = ['*'])
     * @method AttendancePermission firstOrNew(array $attributes = [], array $values = [])
     * @method AttendancePermission firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method AttendancePermission forceCreate(array $attributes)
     * @method _IH_AttendancePermission_C|AttendancePermission[] fromQuery(string $query, array $bindings = [])
     * @method _IH_AttendancePermission_C|AttendancePermission[] get(array|string $columns = ['*'])
     * @method AttendancePermission getModel()
     * @method AttendancePermission[] getModels(array|string $columns = ['*'])
     * @method _IH_AttendancePermission_C|AttendancePermission[] hydrate(array $items)
     * @method AttendancePermission make(array $attributes = [])
     * @method AttendancePermission newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|AttendancePermission[]|_IH_AttendancePermission_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|AttendancePermission[]|_IH_AttendancePermission_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method AttendancePermission sole(array|string $columns = ['*'])
     * @method AttendancePermission updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_AttendancePermission_QB extends _BaseBuilder {}
    
    /**
     * @method AttendanceReimbursement|$this shift(int $count = 1)
     * @method AttendanceReimbursement|null firstOrFail($key = null, $operator = null, $value = null)
     * @method AttendanceReimbursement|$this pop(int $count = 1)
     * @method AttendanceReimbursement|null get($key, $default = null)
     * @method AttendanceReimbursement|null pull($key, $default = null)
     * @method AttendanceReimbursement|null first(callable $callback = null, $default = null)
     * @method AttendanceReimbursement|null firstWhere(string $key, $operator = null, $value = null)
     * @method AttendanceReimbursement|null find($key, $default = null)
     * @method AttendanceReimbursement[] all()
     * @method AttendanceReimbursement|null last(callable $callback = null, $default = null)
     * @method AttendanceReimbursement|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_AttendanceReimbursement_C extends _BaseCollection {
        /**
         * @param int $size
         * @return AttendanceReimbursement[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_AttendanceReimbursement_QB whereId($value)
     * @method _IH_AttendanceReimbursement_QB whereEmployeeId($value)
     * @method _IH_AttendanceReimbursement_QB whereNumber($value)
     * @method _IH_AttendanceReimbursement_QB whereDate($value)
     * @method _IH_AttendanceReimbursement_QB whereCategoryId($value)
     * @method _IH_AttendanceReimbursement_QB whereDescription($value)
     * @method _IH_AttendanceReimbursement_QB whereFilename($value)
     * @method _IH_AttendanceReimbursement_QB whereValue($value)
     * @method _IH_AttendanceReimbursement_QB whereApprovedBy($value)
     * @method _IH_AttendanceReimbursement_QB whereApprovedDate($value)
     * @method _IH_AttendanceReimbursement_QB whereApprovedNote($value)
     * @method _IH_AttendanceReimbursement_QB whereApprovedStatus($value)
     * @method _IH_AttendanceReimbursement_QB whereCreatedBy($value)
     * @method _IH_AttendanceReimbursement_QB whereUpdatedBy($value)
     * @method _IH_AttendanceReimbursement_QB whereCreatedAt($value)
     * @method _IH_AttendanceReimbursement_QB whereUpdatedAt($value)
     * @method AttendanceReimbursement baseSole(array|string $columns = ['*'])
     * @method AttendanceReimbursement create(array $attributes = [])
     * @method _IH_AttendanceReimbursement_C|AttendanceReimbursement[] cursor()
     * @method AttendanceReimbursement|null|_IH_AttendanceReimbursement_C|AttendanceReimbursement[] find($id, array $columns = ['*'])
     * @method _IH_AttendanceReimbursement_C|AttendanceReimbursement[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method AttendanceReimbursement|_IH_AttendanceReimbursement_C|AttendanceReimbursement[] findOrFail($id, array $columns = ['*'])
     * @method AttendanceReimbursement|_IH_AttendanceReimbursement_C|AttendanceReimbursement[] findOrNew($id, array $columns = ['*'])
     * @method AttendanceReimbursement first(array|string $columns = ['*'])
     * @method AttendanceReimbursement firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method AttendanceReimbursement firstOrCreate(array $attributes = [], array $values = [])
     * @method AttendanceReimbursement firstOrFail(array $columns = ['*'])
     * @method AttendanceReimbursement firstOrNew(array $attributes = [], array $values = [])
     * @method AttendanceReimbursement firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method AttendanceReimbursement forceCreate(array $attributes)
     * @method _IH_AttendanceReimbursement_C|AttendanceReimbursement[] fromQuery(string $query, array $bindings = [])
     * @method _IH_AttendanceReimbursement_C|AttendanceReimbursement[] get(array|string $columns = ['*'])
     * @method AttendanceReimbursement getModel()
     * @method AttendanceReimbursement[] getModels(array|string $columns = ['*'])
     * @method _IH_AttendanceReimbursement_C|AttendanceReimbursement[] hydrate(array $items)
     * @method AttendanceReimbursement make(array $attributes = [])
     * @method AttendanceReimbursement newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|AttendanceReimbursement[]|_IH_AttendanceReimbursement_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|AttendanceReimbursement[]|_IH_AttendanceReimbursement_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method AttendanceReimbursement sole(array|string $columns = ['*'])
     * @method AttendanceReimbursement updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_AttendanceReimbursement_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\App\Models\Employee {

    use App\Models\Employee\Employee;
    use App\Models\Employee\EmployeeContact;
    use App\Models\Employee\EmployeeContract;
    use App\Models\Employee\EmployeeEducation;
    use App\Models\Employee\EmployeeFamily;
    use App\Models\Employee\EmployeePayroll;
    use App\Models\Employee\EmployeeTermination;
    use App\Models\Employee\EmployeeWork;
    use App\Models\Employee\MasterPlacement;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method EmployeeContact|$this shift(int $count = 1)
     * @method EmployeeContact|null firstOrFail($key = null, $operator = null, $value = null)
     * @method EmployeeContact|$this pop(int $count = 1)
     * @method EmployeeContact|null get($key, $default = null)
     * @method EmployeeContact|null pull($key, $default = null)
     * @method EmployeeContact|null first(callable $callback = null, $default = null)
     * @method EmployeeContact|null firstWhere(string $key, $operator = null, $value = null)
     * @method EmployeeContact|null find($key, $default = null)
     * @method EmployeeContact[] all()
     * @method EmployeeContact|null last(callable $callback = null, $default = null)
     * @method EmployeeContact|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_EmployeeContact_C extends _BaseCollection {
        /**
         * @param int $size
         * @return EmployeeContact[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method EmployeeContact baseSole(array|string $columns = ['*'])
     * @method EmployeeContact create(array $attributes = [])
     * @method _IH_EmployeeContact_C|EmployeeContact[] cursor()
     * @method EmployeeContact|null|_IH_EmployeeContact_C|EmployeeContact[] find($id, array $columns = ['*'])
     * @method _IH_EmployeeContact_C|EmployeeContact[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method EmployeeContact|_IH_EmployeeContact_C|EmployeeContact[] findOrFail($id, array $columns = ['*'])
     * @method EmployeeContact|_IH_EmployeeContact_C|EmployeeContact[] findOrNew($id, array $columns = ['*'])
     * @method EmployeeContact first(array|string $columns = ['*'])
     * @method EmployeeContact firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method EmployeeContact firstOrCreate(array $attributes = [], array $values = [])
     * @method EmployeeContact firstOrFail(array $columns = ['*'])
     * @method EmployeeContact firstOrNew(array $attributes = [], array $values = [])
     * @method EmployeeContact firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method EmployeeContact forceCreate(array $attributes)
     * @method _IH_EmployeeContact_C|EmployeeContact[] fromQuery(string $query, array $bindings = [])
     * @method _IH_EmployeeContact_C|EmployeeContact[] get(array|string $columns = ['*'])
     * @method EmployeeContact getModel()
     * @method EmployeeContact[] getModels(array|string $columns = ['*'])
     * @method _IH_EmployeeContact_C|EmployeeContact[] hydrate(array $items)
     * @method EmployeeContact make(array $attributes = [])
     * @method EmployeeContact newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|EmployeeContact[]|_IH_EmployeeContact_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|EmployeeContact[]|_IH_EmployeeContact_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method EmployeeContact sole(array|string $columns = ['*'])
     * @method EmployeeContact updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_EmployeeContact_QB extends _BaseBuilder {}
    
    /**
     * @method EmployeeContract|$this shift(int $count = 1)
     * @method EmployeeContract|null firstOrFail($key = null, $operator = null, $value = null)
     * @method EmployeeContract|$this pop(int $count = 1)
     * @method EmployeeContract|null get($key, $default = null)
     * @method EmployeeContract|null pull($key, $default = null)
     * @method EmployeeContract|null first(callable $callback = null, $default = null)
     * @method EmployeeContract|null firstWhere(string $key, $operator = null, $value = null)
     * @method EmployeeContract|null find($key, $default = null)
     * @method EmployeeContract[] all()
     * @method EmployeeContract|null last(callable $callback = null, $default = null)
     * @method EmployeeContract|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_EmployeeContract_C extends _BaseCollection {
        /**
         * @param int $size
         * @return EmployeeContract[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_EmployeeContract_QB whereAreaId($value)
     * @method EmployeeContract baseSole(array|string $columns = ['*'])
     * @method EmployeeContract create(array $attributes = [])
     * @method _IH_EmployeeContract_C|EmployeeContract[] cursor()
     * @method EmployeeContract|null|_IH_EmployeeContract_C|EmployeeContract[] find($id, array $columns = ['*'])
     * @method _IH_EmployeeContract_C|EmployeeContract[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method EmployeeContract|_IH_EmployeeContract_C|EmployeeContract[] findOrFail($id, array $columns = ['*'])
     * @method EmployeeContract|_IH_EmployeeContract_C|EmployeeContract[] findOrNew($id, array $columns = ['*'])
     * @method EmployeeContract first(array|string $columns = ['*'])
     * @method EmployeeContract firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method EmployeeContract firstOrCreate(array $attributes = [], array $values = [])
     * @method EmployeeContract firstOrFail(array $columns = ['*'])
     * @method EmployeeContract firstOrNew(array $attributes = [], array $values = [])
     * @method EmployeeContract firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method EmployeeContract forceCreate(array $attributes)
     * @method _IH_EmployeeContract_C|EmployeeContract[] fromQuery(string $query, array $bindings = [])
     * @method _IH_EmployeeContract_C|EmployeeContract[] get(array|string $columns = ['*'])
     * @method EmployeeContract getModel()
     * @method EmployeeContract[] getModels(array|string $columns = ['*'])
     * @method _IH_EmployeeContract_C|EmployeeContract[] hydrate(array $items)
     * @method EmployeeContract make(array $attributes = [])
     * @method EmployeeContract newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|EmployeeContract[]|_IH_EmployeeContract_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|EmployeeContract[]|_IH_EmployeeContract_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method EmployeeContract sole(array|string $columns = ['*'])
     * @method EmployeeContract updateOrCreate(array $attributes, array $values = [])
     * @method _IH_EmployeeContract_QB active()
     */
    class _IH_EmployeeContract_QB extends _BaseBuilder {}
    
    /**
     * @method EmployeeEducation|$this shift(int $count = 1)
     * @method EmployeeEducation|null firstOrFail($key = null, $operator = null, $value = null)
     * @method EmployeeEducation|$this pop(int $count = 1)
     * @method EmployeeEducation|null get($key, $default = null)
     * @method EmployeeEducation|null pull($key, $default = null)
     * @method EmployeeEducation|null first(callable $callback = null, $default = null)
     * @method EmployeeEducation|null firstWhere(string $key, $operator = null, $value = null)
     * @method EmployeeEducation|null find($key, $default = null)
     * @method EmployeeEducation[] all()
     * @method EmployeeEducation|null last(callable $callback = null, $default = null)
     * @method EmployeeEducation|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_EmployeeEducation_C extends _BaseCollection {
        /**
         * @param int $size
         * @return EmployeeEducation[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method EmployeeEducation baseSole(array|string $columns = ['*'])
     * @method EmployeeEducation create(array $attributes = [])
     * @method _IH_EmployeeEducation_C|EmployeeEducation[] cursor()
     * @method EmployeeEducation|null|_IH_EmployeeEducation_C|EmployeeEducation[] find($id, array $columns = ['*'])
     * @method _IH_EmployeeEducation_C|EmployeeEducation[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method EmployeeEducation|_IH_EmployeeEducation_C|EmployeeEducation[] findOrFail($id, array $columns = ['*'])
     * @method EmployeeEducation|_IH_EmployeeEducation_C|EmployeeEducation[] findOrNew($id, array $columns = ['*'])
     * @method EmployeeEducation first(array|string $columns = ['*'])
     * @method EmployeeEducation firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method EmployeeEducation firstOrCreate(array $attributes = [], array $values = [])
     * @method EmployeeEducation firstOrFail(array $columns = ['*'])
     * @method EmployeeEducation firstOrNew(array $attributes = [], array $values = [])
     * @method EmployeeEducation firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method EmployeeEducation forceCreate(array $attributes)
     * @method _IH_EmployeeEducation_C|EmployeeEducation[] fromQuery(string $query, array $bindings = [])
     * @method _IH_EmployeeEducation_C|EmployeeEducation[] get(array|string $columns = ['*'])
     * @method EmployeeEducation getModel()
     * @method EmployeeEducation[] getModels(array|string $columns = ['*'])
     * @method _IH_EmployeeEducation_C|EmployeeEducation[] hydrate(array $items)
     * @method EmployeeEducation make(array $attributes = [])
     * @method EmployeeEducation newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|EmployeeEducation[]|_IH_EmployeeEducation_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|EmployeeEducation[]|_IH_EmployeeEducation_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method EmployeeEducation sole(array|string $columns = ['*'])
     * @method EmployeeEducation updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_EmployeeEducation_QB extends _BaseBuilder {}
    
    /**
     * @method EmployeeFamily|$this shift(int $count = 1)
     * @method EmployeeFamily|null firstOrFail($key = null, $operator = null, $value = null)
     * @method EmployeeFamily|$this pop(int $count = 1)
     * @method EmployeeFamily|null get($key, $default = null)
     * @method EmployeeFamily|null pull($key, $default = null)
     * @method EmployeeFamily|null first(callable $callback = null, $default = null)
     * @method EmployeeFamily|null firstWhere(string $key, $operator = null, $value = null)
     * @method EmployeeFamily|null find($key, $default = null)
     * @method EmployeeFamily[] all()
     * @method EmployeeFamily|null last(callable $callback = null, $default = null)
     * @method EmployeeFamily|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_EmployeeFamily_C extends _BaseCollection {
        /**
         * @param int $size
         * @return EmployeeFamily[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method EmployeeFamily baseSole(array|string $columns = ['*'])
     * @method EmployeeFamily create(array $attributes = [])
     * @method _IH_EmployeeFamily_C|EmployeeFamily[] cursor()
     * @method EmployeeFamily|null|_IH_EmployeeFamily_C|EmployeeFamily[] find($id, array $columns = ['*'])
     * @method _IH_EmployeeFamily_C|EmployeeFamily[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method EmployeeFamily|_IH_EmployeeFamily_C|EmployeeFamily[] findOrFail($id, array $columns = ['*'])
     * @method EmployeeFamily|_IH_EmployeeFamily_C|EmployeeFamily[] findOrNew($id, array $columns = ['*'])
     * @method EmployeeFamily first(array|string $columns = ['*'])
     * @method EmployeeFamily firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method EmployeeFamily firstOrCreate(array $attributes = [], array $values = [])
     * @method EmployeeFamily firstOrFail(array $columns = ['*'])
     * @method EmployeeFamily firstOrNew(array $attributes = [], array $values = [])
     * @method EmployeeFamily firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method EmployeeFamily forceCreate(array $attributes)
     * @method _IH_EmployeeFamily_C|EmployeeFamily[] fromQuery(string $query, array $bindings = [])
     * @method _IH_EmployeeFamily_C|EmployeeFamily[] get(array|string $columns = ['*'])
     * @method EmployeeFamily getModel()
     * @method EmployeeFamily[] getModels(array|string $columns = ['*'])
     * @method _IH_EmployeeFamily_C|EmployeeFamily[] hydrate(array $items)
     * @method EmployeeFamily make(array $attributes = [])
     * @method EmployeeFamily newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|EmployeeFamily[]|_IH_EmployeeFamily_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|EmployeeFamily[]|_IH_EmployeeFamily_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method EmployeeFamily sole(array|string $columns = ['*'])
     * @method EmployeeFamily updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_EmployeeFamily_QB extends _BaseBuilder {}
    
    /**
     * @method EmployeePayroll|$this shift(int $count = 1)
     * @method EmployeePayroll|null firstOrFail($key = null, $operator = null, $value = null)
     * @method EmployeePayroll|$this pop(int $count = 1)
     * @method EmployeePayroll|null get($key, $default = null)
     * @method EmployeePayroll|null pull($key, $default = null)
     * @method EmployeePayroll|null first(callable $callback = null, $default = null)
     * @method EmployeePayroll|null firstWhere(string $key, $operator = null, $value = null)
     * @method EmployeePayroll|null find($key, $default = null)
     * @method EmployeePayroll[] all()
     * @method EmployeePayroll|null last(callable $callback = null, $default = null)
     * @method EmployeePayroll|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_EmployeePayroll_C extends _BaseCollection {
        /**
         * @param int $size
         * @return EmployeePayroll[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_EmployeePayroll_QB wherePayrollId($value)
     * @method EmployeePayroll baseSole(array|string $columns = ['*'])
     * @method EmployeePayroll create(array $attributes = [])
     * @method _IH_EmployeePayroll_C|EmployeePayroll[] cursor()
     * @method EmployeePayroll|null|_IH_EmployeePayroll_C|EmployeePayroll[] find($id, array $columns = ['*'])
     * @method _IH_EmployeePayroll_C|EmployeePayroll[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method EmployeePayroll|_IH_EmployeePayroll_C|EmployeePayroll[] findOrFail($id, array $columns = ['*'])
     * @method EmployeePayroll|_IH_EmployeePayroll_C|EmployeePayroll[] findOrNew($id, array $columns = ['*'])
     * @method EmployeePayroll first(array|string $columns = ['*'])
     * @method EmployeePayroll firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method EmployeePayroll firstOrCreate(array $attributes = [], array $values = [])
     * @method EmployeePayroll firstOrFail(array $columns = ['*'])
     * @method EmployeePayroll firstOrNew(array $attributes = [], array $values = [])
     * @method EmployeePayroll firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method EmployeePayroll forceCreate(array $attributes)
     * @method _IH_EmployeePayroll_C|EmployeePayroll[] fromQuery(string $query, array $bindings = [])
     * @method _IH_EmployeePayroll_C|EmployeePayroll[] get(array|string $columns = ['*'])
     * @method EmployeePayroll getModel()
     * @method EmployeePayroll[] getModels(array|string $columns = ['*'])
     * @method _IH_EmployeePayroll_C|EmployeePayroll[] hydrate(array $items)
     * @method EmployeePayroll make(array $attributes = [])
     * @method EmployeePayroll newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|EmployeePayroll[]|_IH_EmployeePayroll_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|EmployeePayroll[]|_IH_EmployeePayroll_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method EmployeePayroll sole(array|string $columns = ['*'])
     * @method EmployeePayroll updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_EmployeePayroll_QB extends _BaseBuilder {}
    
    /**
     * @method EmployeeTermination|$this shift(int $count = 1)
     * @method EmployeeTermination|null firstOrFail($key = null, $operator = null, $value = null)
     * @method EmployeeTermination|$this pop(int $count = 1)
     * @method EmployeeTermination|null get($key, $default = null)
     * @method EmployeeTermination|null pull($key, $default = null)
     * @method EmployeeTermination|null first(callable $callback = null, $default = null)
     * @method EmployeeTermination|null firstWhere(string $key, $operator = null, $value = null)
     * @method EmployeeTermination|null find($key, $default = null)
     * @method EmployeeTermination[] all()
     * @method EmployeeTermination|null last(callable $callback = null, $default = null)
     * @method EmployeeTermination|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_EmployeeTermination_C extends _BaseCollection {
        /**
         * @param int $size
         * @return EmployeeTermination[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method EmployeeTermination baseSole(array|string $columns = ['*'])
     * @method EmployeeTermination create(array $attributes = [])
     * @method _IH_EmployeeTermination_C|EmployeeTermination[] cursor()
     * @method EmployeeTermination|null|_IH_EmployeeTermination_C|EmployeeTermination[] find($id, array $columns = ['*'])
     * @method _IH_EmployeeTermination_C|EmployeeTermination[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method EmployeeTermination|_IH_EmployeeTermination_C|EmployeeTermination[] findOrFail($id, array $columns = ['*'])
     * @method EmployeeTermination|_IH_EmployeeTermination_C|EmployeeTermination[] findOrNew($id, array $columns = ['*'])
     * @method EmployeeTermination first(array|string $columns = ['*'])
     * @method EmployeeTermination firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method EmployeeTermination firstOrCreate(array $attributes = [], array $values = [])
     * @method EmployeeTermination firstOrFail(array $columns = ['*'])
     * @method EmployeeTermination firstOrNew(array $attributes = [], array $values = [])
     * @method EmployeeTermination firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method EmployeeTermination forceCreate(array $attributes)
     * @method _IH_EmployeeTermination_C|EmployeeTermination[] fromQuery(string $query, array $bindings = [])
     * @method _IH_EmployeeTermination_C|EmployeeTermination[] get(array|string $columns = ['*'])
     * @method EmployeeTermination getModel()
     * @method EmployeeTermination[] getModels(array|string $columns = ['*'])
     * @method _IH_EmployeeTermination_C|EmployeeTermination[] hydrate(array $items)
     * @method EmployeeTermination make(array $attributes = [])
     * @method EmployeeTermination newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|EmployeeTermination[]|_IH_EmployeeTermination_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|EmployeeTermination[]|_IH_EmployeeTermination_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method EmployeeTermination sole(array|string $columns = ['*'])
     * @method EmployeeTermination updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_EmployeeTermination_QB extends _BaseBuilder {}
    
    /**
     * @method EmployeeWork|$this shift(int $count = 1)
     * @method EmployeeWork|null firstOrFail($key = null, $operator = null, $value = null)
     * @method EmployeeWork|$this pop(int $count = 1)
     * @method EmployeeWork|null get($key, $default = null)
     * @method EmployeeWork|null pull($key, $default = null)
     * @method EmployeeWork|null first(callable $callback = null, $default = null)
     * @method EmployeeWork|null firstWhere(string $key, $operator = null, $value = null)
     * @method EmployeeWork|null find($key, $default = null)
     * @method EmployeeWork[] all()
     * @method EmployeeWork|null last(callable $callback = null, $default = null)
     * @method EmployeeWork|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_EmployeeWork_C extends _BaseCollection {
        /**
         * @param int $size
         * @return EmployeeWork[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method EmployeeWork baseSole(array|string $columns = ['*'])
     * @method EmployeeWork create(array $attributes = [])
     * @method _IH_EmployeeWork_C|EmployeeWork[] cursor()
     * @method EmployeeWork|null|_IH_EmployeeWork_C|EmployeeWork[] find($id, array $columns = ['*'])
     * @method _IH_EmployeeWork_C|EmployeeWork[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method EmployeeWork|_IH_EmployeeWork_C|EmployeeWork[] findOrFail($id, array $columns = ['*'])
     * @method EmployeeWork|_IH_EmployeeWork_C|EmployeeWork[] findOrNew($id, array $columns = ['*'])
     * @method EmployeeWork first(array|string $columns = ['*'])
     * @method EmployeeWork firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method EmployeeWork firstOrCreate(array $attributes = [], array $values = [])
     * @method EmployeeWork firstOrFail(array $columns = ['*'])
     * @method EmployeeWork firstOrNew(array $attributes = [], array $values = [])
     * @method EmployeeWork firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method EmployeeWork forceCreate(array $attributes)
     * @method _IH_EmployeeWork_C|EmployeeWork[] fromQuery(string $query, array $bindings = [])
     * @method _IH_EmployeeWork_C|EmployeeWork[] get(array|string $columns = ['*'])
     * @method EmployeeWork getModel()
     * @method EmployeeWork[] getModels(array|string $columns = ['*'])
     * @method _IH_EmployeeWork_C|EmployeeWork[] hydrate(array $items)
     * @method EmployeeWork make(array $attributes = [])
     * @method EmployeeWork newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|EmployeeWork[]|_IH_EmployeeWork_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|EmployeeWork[]|_IH_EmployeeWork_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method EmployeeWork sole(array|string $columns = ['*'])
     * @method EmployeeWork updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_EmployeeWork_QB extends _BaseBuilder {}
    
    /**
     * @method Employee|$this shift(int $count = 1)
     * @method Employee|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Employee|$this pop(int $count = 1)
     * @method Employee|null get($key, $default = null)
     * @method Employee|null pull($key, $default = null)
     * @method Employee|null first(callable $callback = null, $default = null)
     * @method Employee|null firstWhere(string $key, $operator = null, $value = null)
     * @method Employee|null find($key, $default = null)
     * @method Employee[] all()
     * @method Employee|null last(callable $callback = null, $default = null)
     * @method Employee|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Employee_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Employee[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Employee baseSole(array|string $columns = ['*'])
     * @method Employee create(array $attributes = [])
     * @method _IH_Employee_C|Employee[] cursor()
     * @method Employee|null|_IH_Employee_C|Employee[] find($id, array $columns = ['*'])
     * @method _IH_Employee_C|Employee[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Employee|_IH_Employee_C|Employee[] findOrFail($id, array $columns = ['*'])
     * @method Employee|_IH_Employee_C|Employee[] findOrNew($id, array $columns = ['*'])
     * @method Employee first(array|string $columns = ['*'])
     * @method Employee firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Employee firstOrCreate(array $attributes = [], array $values = [])
     * @method Employee firstOrFail(array $columns = ['*'])
     * @method Employee firstOrNew(array $attributes = [], array $values = [])
     * @method Employee firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Employee forceCreate(array $attributes)
     * @method _IH_Employee_C|Employee[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Employee_C|Employee[] get(array|string $columns = ['*'])
     * @method Employee getModel()
     * @method Employee[] getModels(array|string $columns = ['*'])
     * @method _IH_Employee_C|Employee[] hydrate(array $items)
     * @method Employee make(array $attributes = [])
     * @method Employee newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Employee[]|_IH_Employee_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Employee[]|_IH_Employee_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Employee sole(array|string $columns = ['*'])
     * @method Employee updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Employee_QB active($id = "")
     */
    class _IH_Employee_QB extends _BaseBuilder {}
    
    /**
     * @method MasterPlacement|$this shift(int $count = 1)
     * @method MasterPlacement|null firstOrFail($key = null, $operator = null, $value = null)
     * @method MasterPlacement|$this pop(int $count = 1)
     * @method MasterPlacement|null get($key, $default = null)
     * @method MasterPlacement|null pull($key, $default = null)
     * @method MasterPlacement|null first(callable $callback = null, $default = null)
     * @method MasterPlacement|null firstWhere(string $key, $operator = null, $value = null)
     * @method MasterPlacement|null find($key, $default = null)
     * @method MasterPlacement[] all()
     * @method MasterPlacement|null last(callable $callback = null, $default = null)
     * @method MasterPlacement|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_MasterPlacement_C extends _BaseCollection {
        /**
         * @param int $size
         * @return MasterPlacement[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_MasterPlacement_QB whereId($value)
     * @method _IH_MasterPlacement_QB whereName($value)
     * @method _IH_MasterPlacement_QB whereAdministrationId($value)
     * @method _IH_MasterPlacement_QB whereLeaderId($value)
     * @method _IH_MasterPlacement_QB whereDescription($value)
     * @method _IH_MasterPlacement_QB whereStatus($value)
     * @method _IH_MasterPlacement_QB whereCreatedBy($value)
     * @method _IH_MasterPlacement_QB whereUpdatedBy($value)
     * @method _IH_MasterPlacement_QB whereCreatedAt($value)
     * @method _IH_MasterPlacement_QB whereUpdatedAt($value)
     * @method MasterPlacement baseSole(array|string $columns = ['*'])
     * @method MasterPlacement create(array $attributes = [])
     * @method _IH_MasterPlacement_C|MasterPlacement[] cursor()
     * @method MasterPlacement|null|_IH_MasterPlacement_C|MasterPlacement[] find($id, array $columns = ['*'])
     * @method _IH_MasterPlacement_C|MasterPlacement[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method MasterPlacement|_IH_MasterPlacement_C|MasterPlacement[] findOrFail($id, array $columns = ['*'])
     * @method MasterPlacement|_IH_MasterPlacement_C|MasterPlacement[] findOrNew($id, array $columns = ['*'])
     * @method MasterPlacement first(array|string $columns = ['*'])
     * @method MasterPlacement firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method MasterPlacement firstOrCreate(array $attributes = [], array $values = [])
     * @method MasterPlacement firstOrFail(array $columns = ['*'])
     * @method MasterPlacement firstOrNew(array $attributes = [], array $values = [])
     * @method MasterPlacement firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method MasterPlacement forceCreate(array $attributes)
     * @method _IH_MasterPlacement_C|MasterPlacement[] fromQuery(string $query, array $bindings = [])
     * @method _IH_MasterPlacement_C|MasterPlacement[] get(array|string $columns = ['*'])
     * @method MasterPlacement getModel()
     * @method MasterPlacement[] getModels(array|string $columns = ['*'])
     * @method _IH_MasterPlacement_C|MasterPlacement[] hydrate(array $items)
     * @method MasterPlacement make(array $attributes = [])
     * @method MasterPlacement newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|MasterPlacement[]|_IH_MasterPlacement_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|MasterPlacement[]|_IH_MasterPlacement_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method MasterPlacement sole(array|string $columns = ['*'])
     * @method MasterPlacement updateOrCreate(array $attributes, array $values = [])
     * @method _IH_MasterPlacement_QB active($id = '')
     */
    class _IH_MasterPlacement_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\App\Models\Mobile {

    use App\Models\Mobile\MobileActivation;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method MobileActivation|$this shift(int $count = 1)
     * @method MobileActivation|null firstOrFail($key = null, $operator = null, $value = null)
     * @method MobileActivation|$this pop(int $count = 1)
     * @method MobileActivation|null get($key, $default = null)
     * @method MobileActivation|null pull($key, $default = null)
     * @method MobileActivation|null first(callable $callback = null, $default = null)
     * @method MobileActivation|null firstWhere(string $key, $operator = null, $value = null)
     * @method MobileActivation|null find($key, $default = null)
     * @method MobileActivation[] all()
     * @method MobileActivation|null last(callable $callback = null, $default = null)
     * @method MobileActivation|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_MobileActivation_C extends _BaseCollection {
        /**
         * @param int $size
         * @return MobileActivation[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_MobileActivation_QB whereId($value)
     * @method _IH_MobileActivation_QB whereUserId($value)
     * @method _IH_MobileActivation_QB whereDeviceId($value)
     * @method _IH_MobileActivation_QB whereDeviceName($value)
     * @method _IH_MobileActivation_QB whereStatus($value)
     * @method _IH_MobileActivation_QB whereCreatedBy($value)
     * @method _IH_MobileActivation_QB whereUpdatedBy($value)
     * @method _IH_MobileActivation_QB whereCreatedAt($value)
     * @method _IH_MobileActivation_QB whereUpdatedAt($value)
     * @method MobileActivation baseSole(array|string $columns = ['*'])
     * @method MobileActivation create(array $attributes = [])
     * @method _IH_MobileActivation_C|MobileActivation[] cursor()
     * @method MobileActivation|null|_IH_MobileActivation_C|MobileActivation[] find($id, array $columns = ['*'])
     * @method _IH_MobileActivation_C|MobileActivation[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method MobileActivation|_IH_MobileActivation_C|MobileActivation[] findOrFail($id, array $columns = ['*'])
     * @method MobileActivation|_IH_MobileActivation_C|MobileActivation[] findOrNew($id, array $columns = ['*'])
     * @method MobileActivation first(array|string $columns = ['*'])
     * @method MobileActivation firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method MobileActivation firstOrCreate(array $attributes = [], array $values = [])
     * @method MobileActivation firstOrFail(array $columns = ['*'])
     * @method MobileActivation firstOrNew(array $attributes = [], array $values = [])
     * @method MobileActivation firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method MobileActivation forceCreate(array $attributes)
     * @method _IH_MobileActivation_C|MobileActivation[] fromQuery(string $query, array $bindings = [])
     * @method _IH_MobileActivation_C|MobileActivation[] get(array|string $columns = ['*'])
     * @method MobileActivation getModel()
     * @method MobileActivation[] getModels(array|string $columns = ['*'])
     * @method _IH_MobileActivation_C|MobileActivation[] hydrate(array $items)
     * @method MobileActivation make(array $attributes = [])
     * @method MobileActivation newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|MobileActivation[]|_IH_MobileActivation_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|MobileActivation[]|_IH_MobileActivation_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method MobileActivation sole(array|string $columns = ['*'])
     * @method MobileActivation updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_MobileActivation_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\App\Models\Payroll {

    use App\Models\Payroll\BasicSalary;
    use App\Models\Payroll\PayrollComponent;
    use App\Models\Payroll\PayrollProcess;
    use App\Models\Payroll\PayrollProcessDetail;
    use App\Models\Payroll\PayrollType;
    use App\Models\Payroll\PayrollUpload;
    use App\Models\Payroll\PayrollUploadDetail;
    use App\Models\Payroll\PositionAllowance;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method BasicSalary|$this shift(int $count = 1)
     * @method BasicSalary|null firstOrFail($key = null, $operator = null, $value = null)
     * @method BasicSalary|$this pop(int $count = 1)
     * @method BasicSalary|null get($key, $default = null)
     * @method BasicSalary|null pull($key, $default = null)
     * @method BasicSalary|null first(callable $callback = null, $default = null)
     * @method BasicSalary|null firstWhere(string $key, $operator = null, $value = null)
     * @method BasicSalary|null find($key, $default = null)
     * @method BasicSalary[] all()
     * @method BasicSalary|null last(callable $callback = null, $default = null)
     * @method BasicSalary|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_BasicSalary_C extends _BaseCollection {
        /**
         * @param int $size
         * @return BasicSalary[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_BasicSalary_QB whereId($value)
     * @method _IH_BasicSalary_QB whereRankId($value)
     * @method _IH_BasicSalary_QB whereValue($value)
     * @method _IH_BasicSalary_QB whereDescription($value)
     * @method _IH_BasicSalary_QB whereCreatedBy($value)
     * @method _IH_BasicSalary_QB whereUpdatedBy($value)
     * @method _IH_BasicSalary_QB whereCreatedAt($value)
     * @method _IH_BasicSalary_QB whereUpdatedAt($value)
     * @method BasicSalary baseSole(array|string $columns = ['*'])
     * @method BasicSalary create(array $attributes = [])
     * @method _IH_BasicSalary_C|BasicSalary[] cursor()
     * @method BasicSalary|null|_IH_BasicSalary_C|BasicSalary[] find($id, array $columns = ['*'])
     * @method _IH_BasicSalary_C|BasicSalary[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method BasicSalary|_IH_BasicSalary_C|BasicSalary[] findOrFail($id, array $columns = ['*'])
     * @method BasicSalary|_IH_BasicSalary_C|BasicSalary[] findOrNew($id, array $columns = ['*'])
     * @method BasicSalary first(array|string $columns = ['*'])
     * @method BasicSalary firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method BasicSalary firstOrCreate(array $attributes = [], array $values = [])
     * @method BasicSalary firstOrFail(array $columns = ['*'])
     * @method BasicSalary firstOrNew(array $attributes = [], array $values = [])
     * @method BasicSalary firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method BasicSalary forceCreate(array $attributes)
     * @method _IH_BasicSalary_C|BasicSalary[] fromQuery(string $query, array $bindings = [])
     * @method _IH_BasicSalary_C|BasicSalary[] get(array|string $columns = ['*'])
     * @method BasicSalary getModel()
     * @method BasicSalary[] getModels(array|string $columns = ['*'])
     * @method _IH_BasicSalary_C|BasicSalary[] hydrate(array $items)
     * @method BasicSalary make(array $attributes = [])
     * @method BasicSalary newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|BasicSalary[]|_IH_BasicSalary_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|BasicSalary[]|_IH_BasicSalary_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method BasicSalary sole(array|string $columns = ['*'])
     * @method BasicSalary updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_BasicSalary_QB extends _BaseBuilder {}
    
    /**
     * @method PayrollComponent|$this shift(int $count = 1)
     * @method PayrollComponent|null firstOrFail($key = null, $operator = null, $value = null)
     * @method PayrollComponent|$this pop(int $count = 1)
     * @method PayrollComponent|null get($key, $default = null)
     * @method PayrollComponent|null pull($key, $default = null)
     * @method PayrollComponent|null first(callable $callback = null, $default = null)
     * @method PayrollComponent|null firstWhere(string $key, $operator = null, $value = null)
     * @method PayrollComponent|null find($key, $default = null)
     * @method PayrollComponent[] all()
     * @method PayrollComponent|null last(callable $callback = null, $default = null)
     * @method PayrollComponent|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_PayrollComponent_C extends _BaseCollection {
        /**
         * @param int $size
         * @return PayrollComponent[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_PayrollComponent_QB whereId($value)
     * @method _IH_PayrollComponent_QB whereTypeId($value)
     * @method _IH_PayrollComponent_QB whereCode($value)
     * @method _IH_PayrollComponent_QB whereName($value)
     * @method _IH_PayrollComponent_QB whereDescription($value)
     * @method _IH_PayrollComponent_QB whereStatus($value)
     * @method _IH_PayrollComponent_QB whereType($value)
     * @method _IH_PayrollComponent_QB whereMethod($value)
     * @method _IH_PayrollComponent_QB whereOrder($value)
     * @method _IH_PayrollComponent_QB whereCreatedBy($value)
     * @method _IH_PayrollComponent_QB whereUpdatedBy($value)
     * @method _IH_PayrollComponent_QB whereCreatedAt($value)
     * @method _IH_PayrollComponent_QB whereUpdatedAt($value)
     * @method _IH_PayrollComponent_QB whereMethodValue($value)
     * @method PayrollComponent baseSole(array|string $columns = ['*'])
     * @method PayrollComponent create(array $attributes = [])
     * @method _IH_PayrollComponent_C|PayrollComponent[] cursor()
     * @method PayrollComponent|null|_IH_PayrollComponent_C|PayrollComponent[] find($id, array $columns = ['*'])
     * @method _IH_PayrollComponent_C|PayrollComponent[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method PayrollComponent|_IH_PayrollComponent_C|PayrollComponent[] findOrFail($id, array $columns = ['*'])
     * @method PayrollComponent|_IH_PayrollComponent_C|PayrollComponent[] findOrNew($id, array $columns = ['*'])
     * @method PayrollComponent first(array|string $columns = ['*'])
     * @method PayrollComponent firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method PayrollComponent firstOrCreate(array $attributes = [], array $values = [])
     * @method PayrollComponent firstOrFail(array $columns = ['*'])
     * @method PayrollComponent firstOrNew(array $attributes = [], array $values = [])
     * @method PayrollComponent firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method PayrollComponent forceCreate(array $attributes)
     * @method _IH_PayrollComponent_C|PayrollComponent[] fromQuery(string $query, array $bindings = [])
     * @method _IH_PayrollComponent_C|PayrollComponent[] get(array|string $columns = ['*'])
     * @method PayrollComponent getModel()
     * @method PayrollComponent[] getModels(array|string $columns = ['*'])
     * @method _IH_PayrollComponent_C|PayrollComponent[] hydrate(array $items)
     * @method PayrollComponent make(array $attributes = [])
     * @method PayrollComponent newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|PayrollComponent[]|_IH_PayrollComponent_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|PayrollComponent[]|_IH_PayrollComponent_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method PayrollComponent sole(array|string $columns = ['*'])
     * @method PayrollComponent updateOrCreate(array $attributes, array $values = [])
     * @method _IH_PayrollComponent_QB active()
     */
    class _IH_PayrollComponent_QB extends _BaseBuilder {}
    
    /**
     * @method PayrollProcessDetail|$this shift(int $count = 1)
     * @method PayrollProcessDetail|null firstOrFail($key = null, $operator = null, $value = null)
     * @method PayrollProcessDetail|$this pop(int $count = 1)
     * @method PayrollProcessDetail|null get($key, $default = null)
     * @method PayrollProcessDetail|null pull($key, $default = null)
     * @method PayrollProcessDetail|null first(callable $callback = null, $default = null)
     * @method PayrollProcessDetail|null firstWhere(string $key, $operator = null, $value = null)
     * @method PayrollProcessDetail|null find($key, $default = null)
     * @method PayrollProcessDetail[] all()
     * @method PayrollProcessDetail|null last(callable $callback = null, $default = null)
     * @method PayrollProcessDetail|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_PayrollProcessDetail_C extends _BaseCollection {
        /**
         * @param int $size
         * @return PayrollProcessDetail[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_PayrollProcessDetail_QB whereId($value)
     * @method _IH_PayrollProcessDetail_QB whereProcessId($value)
     * @method _IH_PayrollProcessDetail_QB whereEmployeeId($value)
     * @method _IH_PayrollProcessDetail_QB whereValue($value)
     * @method _IH_PayrollProcessDetail_QB whereCreatedBy($value)
     * @method _IH_PayrollProcessDetail_QB whereUpdatedBy($value)
     * @method _IH_PayrollProcessDetail_QB whereCreatedAt($value)
     * @method _IH_PayrollProcessDetail_QB whereUpdatedAt($value)
     * @method _IH_PayrollProcessDetail_QB whereComponentId($value)
     * @method PayrollProcessDetail baseSole(array|string $columns = ['*'])
     * @method PayrollProcessDetail create(array $attributes = [])
     * @method _IH_PayrollProcessDetail_C|PayrollProcessDetail[] cursor()
     * @method PayrollProcessDetail|null|_IH_PayrollProcessDetail_C|PayrollProcessDetail[] find($id, array $columns = ['*'])
     * @method _IH_PayrollProcessDetail_C|PayrollProcessDetail[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method PayrollProcessDetail|_IH_PayrollProcessDetail_C|PayrollProcessDetail[] findOrFail($id, array $columns = ['*'])
     * @method PayrollProcessDetail|_IH_PayrollProcessDetail_C|PayrollProcessDetail[] findOrNew($id, array $columns = ['*'])
     * @method PayrollProcessDetail first(array|string $columns = ['*'])
     * @method PayrollProcessDetail firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method PayrollProcessDetail firstOrCreate(array $attributes = [], array $values = [])
     * @method PayrollProcessDetail firstOrFail(array $columns = ['*'])
     * @method PayrollProcessDetail firstOrNew(array $attributes = [], array $values = [])
     * @method PayrollProcessDetail firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method PayrollProcessDetail forceCreate(array $attributes)
     * @method _IH_PayrollProcessDetail_C|PayrollProcessDetail[] fromQuery(string $query, array $bindings = [])
     * @method _IH_PayrollProcessDetail_C|PayrollProcessDetail[] get(array|string $columns = ['*'])
     * @method PayrollProcessDetail getModel()
     * @method PayrollProcessDetail[] getModels(array|string $columns = ['*'])
     * @method _IH_PayrollProcessDetail_C|PayrollProcessDetail[] hydrate(array $items)
     * @method PayrollProcessDetail make(array $attributes = [])
     * @method PayrollProcessDetail newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|PayrollProcessDetail[]|_IH_PayrollProcessDetail_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|PayrollProcessDetail[]|_IH_PayrollProcessDetail_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method PayrollProcessDetail sole(array|string $columns = ['*'])
     * @method PayrollProcessDetail updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_PayrollProcessDetail_QB extends _BaseBuilder {}
    
    /**
     * @method PayrollProcess|$this shift(int $count = 1)
     * @method PayrollProcess|null firstOrFail($key = null, $operator = null, $value = null)
     * @method PayrollProcess|$this pop(int $count = 1)
     * @method PayrollProcess|null get($key, $default = null)
     * @method PayrollProcess|null pull($key, $default = null)
     * @method PayrollProcess|null first(callable $callback = null, $default = null)
     * @method PayrollProcess|null firstWhere(string $key, $operator = null, $value = null)
     * @method PayrollProcess|null find($key, $default = null)
     * @method PayrollProcess[] all()
     * @method PayrollProcess|null last(callable $callback = null, $default = null)
     * @method PayrollProcess|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_PayrollProcess_C extends _BaseCollection {
        /**
         * @param int $size
         * @return PayrollProcess[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_PayrollProcess_QB whereId($value)
     * @method _IH_PayrollProcess_QB whereLocationId($value)
     * @method _IH_PayrollProcess_QB whereMonth($value)
     * @method _IH_PayrollProcess_QB whereYear($value)
     * @method _IH_PayrollProcess_QB whereTotalEmployees($value)
     * @method _IH_PayrollProcess_QB whereTotalValues($value)
     * @method _IH_PayrollProcess_QB whereApprovedBy($value)
     * @method _IH_PayrollProcess_QB whereApprovedStatus($value)
     * @method _IH_PayrollProcess_QB whereApprovedDescription($value)
     * @method _IH_PayrollProcess_QB whereApprovedDate($value)
     * @method _IH_PayrollProcess_QB whereCreatedBy($value)
     * @method _IH_PayrollProcess_QB whereUpdatedBy($value)
     * @method _IH_PayrollProcess_QB whereCreatedAt($value)
     * @method _IH_PayrollProcess_QB whereUpdatedAt($value)
     * @method _IH_PayrollProcess_QB whereTypeId($value)
     * @method PayrollProcess baseSole(array|string $columns = ['*'])
     * @method PayrollProcess create(array $attributes = [])
     * @method _IH_PayrollProcess_C|PayrollProcess[] cursor()
     * @method PayrollProcess|null|_IH_PayrollProcess_C|PayrollProcess[] find($id, array $columns = ['*'])
     * @method _IH_PayrollProcess_C|PayrollProcess[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method PayrollProcess|_IH_PayrollProcess_C|PayrollProcess[] findOrFail($id, array $columns = ['*'])
     * @method PayrollProcess|_IH_PayrollProcess_C|PayrollProcess[] findOrNew($id, array $columns = ['*'])
     * @method PayrollProcess first(array|string $columns = ['*'])
     * @method PayrollProcess firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method PayrollProcess firstOrCreate(array $attributes = [], array $values = [])
     * @method PayrollProcess firstOrFail(array $columns = ['*'])
     * @method PayrollProcess firstOrNew(array $attributes = [], array $values = [])
     * @method PayrollProcess firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method PayrollProcess forceCreate(array $attributes)
     * @method _IH_PayrollProcess_C|PayrollProcess[] fromQuery(string $query, array $bindings = [])
     * @method _IH_PayrollProcess_C|PayrollProcess[] get(array|string $columns = ['*'])
     * @method PayrollProcess getModel()
     * @method PayrollProcess[] getModels(array|string $columns = ['*'])
     * @method _IH_PayrollProcess_C|PayrollProcess[] hydrate(array $items)
     * @method PayrollProcess make(array $attributes = [])
     * @method PayrollProcess newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|PayrollProcess[]|_IH_PayrollProcess_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|PayrollProcess[]|_IH_PayrollProcess_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method PayrollProcess sole(array|string $columns = ['*'])
     * @method PayrollProcess updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_PayrollProcess_QB extends _BaseBuilder {}
    
    /**
     * @method PayrollType|$this shift(int $count = 1)
     * @method PayrollType|null firstOrFail($key = null, $operator = null, $value = null)
     * @method PayrollType|$this pop(int $count = 1)
     * @method PayrollType|null get($key, $default = null)
     * @method PayrollType|null pull($key, $default = null)
     * @method PayrollType|null first(callable $callback = null, $default = null)
     * @method PayrollType|null firstWhere(string $key, $operator = null, $value = null)
     * @method PayrollType|null find($key, $default = null)
     * @method PayrollType[] all()
     * @method PayrollType|null last(callable $callback = null, $default = null)
     * @method PayrollType|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_PayrollType_C extends _BaseCollection {
        /**
         * @param int $size
         * @return PayrollType[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_PayrollType_QB whereId($value)
     * @method _IH_PayrollType_QB whereCode($value)
     * @method _IH_PayrollType_QB whereName($value)
     * @method _IH_PayrollType_QB whereDescription($value)
     * @method _IH_PayrollType_QB whereStatus($value)
     * @method _IH_PayrollType_QB whereCreatedBy($value)
     * @method _IH_PayrollType_QB whereUpdatedBy($value)
     * @method _IH_PayrollType_QB whereCreatedAt($value)
     * @method _IH_PayrollType_QB whereUpdatedAt($value)
     * @method PayrollType baseSole(array|string $columns = ['*'])
     * @method PayrollType create(array $attributes = [])
     * @method _IH_PayrollType_C|PayrollType[] cursor()
     * @method PayrollType|null|_IH_PayrollType_C|PayrollType[] find($id, array $columns = ['*'])
     * @method _IH_PayrollType_C|PayrollType[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method PayrollType|_IH_PayrollType_C|PayrollType[] findOrFail($id, array $columns = ['*'])
     * @method PayrollType|_IH_PayrollType_C|PayrollType[] findOrNew($id, array $columns = ['*'])
     * @method PayrollType first(array|string $columns = ['*'])
     * @method PayrollType firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method PayrollType firstOrCreate(array $attributes = [], array $values = [])
     * @method PayrollType firstOrFail(array $columns = ['*'])
     * @method PayrollType firstOrNew(array $attributes = [], array $values = [])
     * @method PayrollType firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method PayrollType forceCreate(array $attributes)
     * @method _IH_PayrollType_C|PayrollType[] fromQuery(string $query, array $bindings = [])
     * @method _IH_PayrollType_C|PayrollType[] get(array|string $columns = ['*'])
     * @method PayrollType getModel()
     * @method PayrollType[] getModels(array|string $columns = ['*'])
     * @method _IH_PayrollType_C|PayrollType[] hydrate(array $items)
     * @method PayrollType make(array $attributes = [])
     * @method PayrollType newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|PayrollType[]|_IH_PayrollType_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|PayrollType[]|_IH_PayrollType_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method PayrollType sole(array|string $columns = ['*'])
     * @method PayrollType updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_PayrollType_QB extends _BaseBuilder {}
    
    /**
     * @method PayrollUploadDetail|$this shift(int $count = 1)
     * @method PayrollUploadDetail|null firstOrFail($key = null, $operator = null, $value = null)
     * @method PayrollUploadDetail|$this pop(int $count = 1)
     * @method PayrollUploadDetail|null get($key, $default = null)
     * @method PayrollUploadDetail|null pull($key, $default = null)
     * @method PayrollUploadDetail|null first(callable $callback = null, $default = null)
     * @method PayrollUploadDetail|null firstWhere(string $key, $operator = null, $value = null)
     * @method PayrollUploadDetail|null find($key, $default = null)
     * @method PayrollUploadDetail[] all()
     * @method PayrollUploadDetail|null last(callable $callback = null, $default = null)
     * @method PayrollUploadDetail|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_PayrollUploadDetail_C extends _BaseCollection {
        /**
         * @param int $size
         * @return PayrollUploadDetail[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_PayrollUploadDetail_QB whereId($value)
     * @method _IH_PayrollUploadDetail_QB whereUploadId($value)
     * @method _IH_PayrollUploadDetail_QB whereEmployeeId($value)
     * @method _IH_PayrollUploadDetail_QB whereValue($value)
     * @method _IH_PayrollUploadDetail_QB whereDescription($value)
     * @method _IH_PayrollUploadDetail_QB whereCreatedBy($value)
     * @method _IH_PayrollUploadDetail_QB whereUpdatedBy($value)
     * @method _IH_PayrollUploadDetail_QB whereCreatedAt($value)
     * @method _IH_PayrollUploadDetail_QB whereUpdatedAt($value)
     * @method PayrollUploadDetail baseSole(array|string $columns = ['*'])
     * @method PayrollUploadDetail create(array $attributes = [])
     * @method _IH_PayrollUploadDetail_C|PayrollUploadDetail[] cursor()
     * @method PayrollUploadDetail|null|_IH_PayrollUploadDetail_C|PayrollUploadDetail[] find($id, array $columns = ['*'])
     * @method _IH_PayrollUploadDetail_C|PayrollUploadDetail[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method PayrollUploadDetail|_IH_PayrollUploadDetail_C|PayrollUploadDetail[] findOrFail($id, array $columns = ['*'])
     * @method PayrollUploadDetail|_IH_PayrollUploadDetail_C|PayrollUploadDetail[] findOrNew($id, array $columns = ['*'])
     * @method PayrollUploadDetail first(array|string $columns = ['*'])
     * @method PayrollUploadDetail firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method PayrollUploadDetail firstOrCreate(array $attributes = [], array $values = [])
     * @method PayrollUploadDetail firstOrFail(array $columns = ['*'])
     * @method PayrollUploadDetail firstOrNew(array $attributes = [], array $values = [])
     * @method PayrollUploadDetail firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method PayrollUploadDetail forceCreate(array $attributes)
     * @method _IH_PayrollUploadDetail_C|PayrollUploadDetail[] fromQuery(string $query, array $bindings = [])
     * @method _IH_PayrollUploadDetail_C|PayrollUploadDetail[] get(array|string $columns = ['*'])
     * @method PayrollUploadDetail getModel()
     * @method PayrollUploadDetail[] getModels(array|string $columns = ['*'])
     * @method _IH_PayrollUploadDetail_C|PayrollUploadDetail[] hydrate(array $items)
     * @method PayrollUploadDetail make(array $attributes = [])
     * @method PayrollUploadDetail newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|PayrollUploadDetail[]|_IH_PayrollUploadDetail_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|PayrollUploadDetail[]|_IH_PayrollUploadDetail_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method PayrollUploadDetail sole(array|string $columns = ['*'])
     * @method PayrollUploadDetail updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_PayrollUploadDetail_QB extends _BaseBuilder {}
    
    /**
     * @method PayrollUpload|$this shift(int $count = 1)
     * @method PayrollUpload|null firstOrFail($key = null, $operator = null, $value = null)
     * @method PayrollUpload|$this pop(int $count = 1)
     * @method PayrollUpload|null get($key, $default = null)
     * @method PayrollUpload|null pull($key, $default = null)
     * @method PayrollUpload|null first(callable $callback = null, $default = null)
     * @method PayrollUpload|null firstWhere(string $key, $operator = null, $value = null)
     * @method PayrollUpload|null find($key, $default = null)
     * @method PayrollUpload[] all()
     * @method PayrollUpload|null last(callable $callback = null, $default = null)
     * @method PayrollUpload|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_PayrollUpload_C extends _BaseCollection {
        /**
         * @param int $size
         * @return PayrollUpload[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_PayrollUpload_QB whereId($value)
     * @method _IH_PayrollUpload_QB whereCode($value)
     * @method _IH_PayrollUpload_QB whereMonth($value)
     * @method _IH_PayrollUpload_QB whereYear($value)
     * @method _IH_PayrollUpload_QB whereTotalEmployees($value)
     * @method _IH_PayrollUpload_QB whereTotalValues($value)
     * @method _IH_PayrollUpload_QB whereApprovedBy($value)
     * @method _IH_PayrollUpload_QB whereApprovedStatus($value)
     * @method _IH_PayrollUpload_QB whereApprovedDescription($value)
     * @method _IH_PayrollUpload_QB whereCreatedBy($value)
     * @method _IH_PayrollUpload_QB whereUpdatedBy($value)
     * @method _IH_PayrollUpload_QB whereCreatedAt($value)
     * @method _IH_PayrollUpload_QB whereUpdatedAt($value)
     * @method _IH_PayrollUpload_QB whereApprovedDate($value)
     * @method PayrollUpload baseSole(array|string $columns = ['*'])
     * @method PayrollUpload create(array $attributes = [])
     * @method _IH_PayrollUpload_C|PayrollUpload[] cursor()
     * @method PayrollUpload|null|_IH_PayrollUpload_C|PayrollUpload[] find($id, array $columns = ['*'])
     * @method _IH_PayrollUpload_C|PayrollUpload[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method PayrollUpload|_IH_PayrollUpload_C|PayrollUpload[] findOrFail($id, array $columns = ['*'])
     * @method PayrollUpload|_IH_PayrollUpload_C|PayrollUpload[] findOrNew($id, array $columns = ['*'])
     * @method PayrollUpload first(array|string $columns = ['*'])
     * @method PayrollUpload firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method PayrollUpload firstOrCreate(array $attributes = [], array $values = [])
     * @method PayrollUpload firstOrFail(array $columns = ['*'])
     * @method PayrollUpload firstOrNew(array $attributes = [], array $values = [])
     * @method PayrollUpload firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method PayrollUpload forceCreate(array $attributes)
     * @method _IH_PayrollUpload_C|PayrollUpload[] fromQuery(string $query, array $bindings = [])
     * @method _IH_PayrollUpload_C|PayrollUpload[] get(array|string $columns = ['*'])
     * @method PayrollUpload getModel()
     * @method PayrollUpload[] getModels(array|string $columns = ['*'])
     * @method _IH_PayrollUpload_C|PayrollUpload[] hydrate(array $items)
     * @method PayrollUpload make(array $attributes = [])
     * @method PayrollUpload newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|PayrollUpload[]|_IH_PayrollUpload_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|PayrollUpload[]|_IH_PayrollUpload_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method PayrollUpload sole(array|string $columns = ['*'])
     * @method PayrollUpload updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_PayrollUpload_QB extends _BaseBuilder {}
    
    /**
     * @method PositionAllowance|$this shift(int $count = 1)
     * @method PositionAllowance|null firstOrFail($key = null, $operator = null, $value = null)
     * @method PositionAllowance|$this pop(int $count = 1)
     * @method PositionAllowance|null get($key, $default = null)
     * @method PositionAllowance|null pull($key, $default = null)
     * @method PositionAllowance|null first(callable $callback = null, $default = null)
     * @method PositionAllowance|null firstWhere(string $key, $operator = null, $value = null)
     * @method PositionAllowance|null find($key, $default = null)
     * @method PositionAllowance[] all()
     * @method PositionAllowance|null last(callable $callback = null, $default = null)
     * @method PositionAllowance|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_PositionAllowance_C extends _BaseCollection {
        /**
         * @param int $size
         * @return PositionAllowance[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_PositionAllowance_QB whereId($value)
     * @method _IH_PositionAllowance_QB whereRankId($value)
     * @method _IH_PositionAllowance_QB whereValue($value)
     * @method _IH_PositionAllowance_QB whereDescription($value)
     * @method _IH_PositionAllowance_QB whereCreatedBy($value)
     * @method _IH_PositionAllowance_QB whereUpdatedBy($value)
     * @method _IH_PositionAllowance_QB whereCreatedAt($value)
     * @method _IH_PositionAllowance_QB whereUpdatedAt($value)
     * @method PositionAllowance baseSole(array|string $columns = ['*'])
     * @method PositionAllowance create(array $attributes = [])
     * @method _IH_PositionAllowance_C|PositionAllowance[] cursor()
     * @method PositionAllowance|null|_IH_PositionAllowance_C|PositionAllowance[] find($id, array $columns = ['*'])
     * @method _IH_PositionAllowance_C|PositionAllowance[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method PositionAllowance|_IH_PositionAllowance_C|PositionAllowance[] findOrFail($id, array $columns = ['*'])
     * @method PositionAllowance|_IH_PositionAllowance_C|PositionAllowance[] findOrNew($id, array $columns = ['*'])
     * @method PositionAllowance first(array|string $columns = ['*'])
     * @method PositionAllowance firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method PositionAllowance firstOrCreate(array $attributes = [], array $values = [])
     * @method PositionAllowance firstOrFail(array $columns = ['*'])
     * @method PositionAllowance firstOrNew(array $attributes = [], array $values = [])
     * @method PositionAllowance firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method PositionAllowance forceCreate(array $attributes)
     * @method _IH_PositionAllowance_C|PositionAllowance[] fromQuery(string $query, array $bindings = [])
     * @method _IH_PositionAllowance_C|PositionAllowance[] get(array|string $columns = ['*'])
     * @method PositionAllowance getModel()
     * @method PositionAllowance[] getModels(array|string $columns = ['*'])
     * @method _IH_PositionAllowance_C|PositionAllowance[] hydrate(array $items)
     * @method PositionAllowance make(array $attributes = [])
     * @method PositionAllowance newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|PositionAllowance[]|_IH_PositionAllowance_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|PositionAllowance[]|_IH_PositionAllowance_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method PositionAllowance sole(array|string $columns = ['*'])
     * @method PositionAllowance updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_PositionAllowance_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\App\Models\Recruitment {

    use App\Models\Recruitment\RecruitmentApplicant;
    use App\Models\Recruitment\RecruitmentApplicantContact;
    use App\Models\Recruitment\RecruitmentApplicantEducation;
    use App\Models\Recruitment\RecruitmentApplicantFamily;
    use App\Models\Recruitment\RecruitmentApplicantWork;
    use App\Models\Recruitment\RecruitmentContract;
    use App\Models\Recruitment\RecruitmentPlacement;
    use App\Models\Recruitment\RecruitmentPlan;
    use App\Models\Recruitment\RecruitmentSelection;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method RecruitmentApplicantContact|$this shift(int $count = 1)
     * @method RecruitmentApplicantContact|null firstOrFail($key = null, $operator = null, $value = null)
     * @method RecruitmentApplicantContact|$this pop(int $count = 1)
     * @method RecruitmentApplicantContact|null get($key, $default = null)
     * @method RecruitmentApplicantContact|null pull($key, $default = null)
     * @method RecruitmentApplicantContact|null first(callable $callback = null, $default = null)
     * @method RecruitmentApplicantContact|null firstWhere(string $key, $operator = null, $value = null)
     * @method RecruitmentApplicantContact|null find($key, $default = null)
     * @method RecruitmentApplicantContact[] all()
     * @method RecruitmentApplicantContact|null last(callable $callback = null, $default = null)
     * @method RecruitmentApplicantContact|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_RecruitmentApplicantContact_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RecruitmentApplicantContact[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method RecruitmentApplicantContact baseSole(array|string $columns = ['*'])
     * @method RecruitmentApplicantContact create(array $attributes = [])
     * @method _IH_RecruitmentApplicantContact_C|RecruitmentApplicantContact[] cursor()
     * @method RecruitmentApplicantContact|null|_IH_RecruitmentApplicantContact_C|RecruitmentApplicantContact[] find($id, array $columns = ['*'])
     * @method _IH_RecruitmentApplicantContact_C|RecruitmentApplicantContact[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RecruitmentApplicantContact|_IH_RecruitmentApplicantContact_C|RecruitmentApplicantContact[] findOrFail($id, array $columns = ['*'])
     * @method RecruitmentApplicantContact|_IH_RecruitmentApplicantContact_C|RecruitmentApplicantContact[] findOrNew($id, array $columns = ['*'])
     * @method RecruitmentApplicantContact first(array|string $columns = ['*'])
     * @method RecruitmentApplicantContact firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RecruitmentApplicantContact firstOrCreate(array $attributes = [], array $values = [])
     * @method RecruitmentApplicantContact firstOrFail(array $columns = ['*'])
     * @method RecruitmentApplicantContact firstOrNew(array $attributes = [], array $values = [])
     * @method RecruitmentApplicantContact firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RecruitmentApplicantContact forceCreate(array $attributes)
     * @method _IH_RecruitmentApplicantContact_C|RecruitmentApplicantContact[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RecruitmentApplicantContact_C|RecruitmentApplicantContact[] get(array|string $columns = ['*'])
     * @method RecruitmentApplicantContact getModel()
     * @method RecruitmentApplicantContact[] getModels(array|string $columns = ['*'])
     * @method _IH_RecruitmentApplicantContact_C|RecruitmentApplicantContact[] hydrate(array $items)
     * @method RecruitmentApplicantContact make(array $attributes = [])
     * @method RecruitmentApplicantContact newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RecruitmentApplicantContact[]|_IH_RecruitmentApplicantContact_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RecruitmentApplicantContact[]|_IH_RecruitmentApplicantContact_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RecruitmentApplicantContact sole(array|string $columns = ['*'])
     * @method RecruitmentApplicantContact updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RecruitmentApplicantContact_QB extends _BaseBuilder {}
    
    /**
     * @method RecruitmentApplicantEducation|$this shift(int $count = 1)
     * @method RecruitmentApplicantEducation|null firstOrFail($key = null, $operator = null, $value = null)
     * @method RecruitmentApplicantEducation|$this pop(int $count = 1)
     * @method RecruitmentApplicantEducation|null get($key, $default = null)
     * @method RecruitmentApplicantEducation|null pull($key, $default = null)
     * @method RecruitmentApplicantEducation|null first(callable $callback = null, $default = null)
     * @method RecruitmentApplicantEducation|null firstWhere(string $key, $operator = null, $value = null)
     * @method RecruitmentApplicantEducation|null find($key, $default = null)
     * @method RecruitmentApplicantEducation[] all()
     * @method RecruitmentApplicantEducation|null last(callable $callback = null, $default = null)
     * @method RecruitmentApplicantEducation|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_RecruitmentApplicantEducation_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RecruitmentApplicantEducation[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method RecruitmentApplicantEducation baseSole(array|string $columns = ['*'])
     * @method RecruitmentApplicantEducation create(array $attributes = [])
     * @method _IH_RecruitmentApplicantEducation_C|RecruitmentApplicantEducation[] cursor()
     * @method RecruitmentApplicantEducation|null|_IH_RecruitmentApplicantEducation_C|RecruitmentApplicantEducation[] find($id, array $columns = ['*'])
     * @method _IH_RecruitmentApplicantEducation_C|RecruitmentApplicantEducation[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RecruitmentApplicantEducation|_IH_RecruitmentApplicantEducation_C|RecruitmentApplicantEducation[] findOrFail($id, array $columns = ['*'])
     * @method RecruitmentApplicantEducation|_IH_RecruitmentApplicantEducation_C|RecruitmentApplicantEducation[] findOrNew($id, array $columns = ['*'])
     * @method RecruitmentApplicantEducation first(array|string $columns = ['*'])
     * @method RecruitmentApplicantEducation firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RecruitmentApplicantEducation firstOrCreate(array $attributes = [], array $values = [])
     * @method RecruitmentApplicantEducation firstOrFail(array $columns = ['*'])
     * @method RecruitmentApplicantEducation firstOrNew(array $attributes = [], array $values = [])
     * @method RecruitmentApplicantEducation firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RecruitmentApplicantEducation forceCreate(array $attributes)
     * @method _IH_RecruitmentApplicantEducation_C|RecruitmentApplicantEducation[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RecruitmentApplicantEducation_C|RecruitmentApplicantEducation[] get(array|string $columns = ['*'])
     * @method RecruitmentApplicantEducation getModel()
     * @method RecruitmentApplicantEducation[] getModels(array|string $columns = ['*'])
     * @method _IH_RecruitmentApplicantEducation_C|RecruitmentApplicantEducation[] hydrate(array $items)
     * @method RecruitmentApplicantEducation make(array $attributes = [])
     * @method RecruitmentApplicantEducation newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RecruitmentApplicantEducation[]|_IH_RecruitmentApplicantEducation_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RecruitmentApplicantEducation[]|_IH_RecruitmentApplicantEducation_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RecruitmentApplicantEducation sole(array|string $columns = ['*'])
     * @method RecruitmentApplicantEducation updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RecruitmentApplicantEducation_QB extends _BaseBuilder {}
    
    /**
     * @method RecruitmentApplicantFamily|$this shift(int $count = 1)
     * @method RecruitmentApplicantFamily|null firstOrFail($key = null, $operator = null, $value = null)
     * @method RecruitmentApplicantFamily|$this pop(int $count = 1)
     * @method RecruitmentApplicantFamily|null get($key, $default = null)
     * @method RecruitmentApplicantFamily|null pull($key, $default = null)
     * @method RecruitmentApplicantFamily|null first(callable $callback = null, $default = null)
     * @method RecruitmentApplicantFamily|null firstWhere(string $key, $operator = null, $value = null)
     * @method RecruitmentApplicantFamily|null find($key, $default = null)
     * @method RecruitmentApplicantFamily[] all()
     * @method RecruitmentApplicantFamily|null last(callable $callback = null, $default = null)
     * @method RecruitmentApplicantFamily|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_RecruitmentApplicantFamily_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RecruitmentApplicantFamily[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method RecruitmentApplicantFamily baseSole(array|string $columns = ['*'])
     * @method RecruitmentApplicantFamily create(array $attributes = [])
     * @method _IH_RecruitmentApplicantFamily_C|RecruitmentApplicantFamily[] cursor()
     * @method RecruitmentApplicantFamily|null|_IH_RecruitmentApplicantFamily_C|RecruitmentApplicantFamily[] find($id, array $columns = ['*'])
     * @method _IH_RecruitmentApplicantFamily_C|RecruitmentApplicantFamily[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RecruitmentApplicantFamily|_IH_RecruitmentApplicantFamily_C|RecruitmentApplicantFamily[] findOrFail($id, array $columns = ['*'])
     * @method RecruitmentApplicantFamily|_IH_RecruitmentApplicantFamily_C|RecruitmentApplicantFamily[] findOrNew($id, array $columns = ['*'])
     * @method RecruitmentApplicantFamily first(array|string $columns = ['*'])
     * @method RecruitmentApplicantFamily firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RecruitmentApplicantFamily firstOrCreate(array $attributes = [], array $values = [])
     * @method RecruitmentApplicantFamily firstOrFail(array $columns = ['*'])
     * @method RecruitmentApplicantFamily firstOrNew(array $attributes = [], array $values = [])
     * @method RecruitmentApplicantFamily firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RecruitmentApplicantFamily forceCreate(array $attributes)
     * @method _IH_RecruitmentApplicantFamily_C|RecruitmentApplicantFamily[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RecruitmentApplicantFamily_C|RecruitmentApplicantFamily[] get(array|string $columns = ['*'])
     * @method RecruitmentApplicantFamily getModel()
     * @method RecruitmentApplicantFamily[] getModels(array|string $columns = ['*'])
     * @method _IH_RecruitmentApplicantFamily_C|RecruitmentApplicantFamily[] hydrate(array $items)
     * @method RecruitmentApplicantFamily make(array $attributes = [])
     * @method RecruitmentApplicantFamily newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RecruitmentApplicantFamily[]|_IH_RecruitmentApplicantFamily_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RecruitmentApplicantFamily[]|_IH_RecruitmentApplicantFamily_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RecruitmentApplicantFamily sole(array|string $columns = ['*'])
     * @method RecruitmentApplicantFamily updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RecruitmentApplicantFamily_QB extends _BaseBuilder {}
    
    /**
     * @method RecruitmentApplicantWork|$this shift(int $count = 1)
     * @method RecruitmentApplicantWork|null firstOrFail($key = null, $operator = null, $value = null)
     * @method RecruitmentApplicantWork|$this pop(int $count = 1)
     * @method RecruitmentApplicantWork|null get($key, $default = null)
     * @method RecruitmentApplicantWork|null pull($key, $default = null)
     * @method RecruitmentApplicantWork|null first(callable $callback = null, $default = null)
     * @method RecruitmentApplicantWork|null firstWhere(string $key, $operator = null, $value = null)
     * @method RecruitmentApplicantWork|null find($key, $default = null)
     * @method RecruitmentApplicantWork[] all()
     * @method RecruitmentApplicantWork|null last(callable $callback = null, $default = null)
     * @method RecruitmentApplicantWork|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_RecruitmentApplicantWork_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RecruitmentApplicantWork[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method RecruitmentApplicantWork baseSole(array|string $columns = ['*'])
     * @method RecruitmentApplicantWork create(array $attributes = [])
     * @method _IH_RecruitmentApplicantWork_C|RecruitmentApplicantWork[] cursor()
     * @method RecruitmentApplicantWork|null|_IH_RecruitmentApplicantWork_C|RecruitmentApplicantWork[] find($id, array $columns = ['*'])
     * @method _IH_RecruitmentApplicantWork_C|RecruitmentApplicantWork[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RecruitmentApplicantWork|_IH_RecruitmentApplicantWork_C|RecruitmentApplicantWork[] findOrFail($id, array $columns = ['*'])
     * @method RecruitmentApplicantWork|_IH_RecruitmentApplicantWork_C|RecruitmentApplicantWork[] findOrNew($id, array $columns = ['*'])
     * @method RecruitmentApplicantWork first(array|string $columns = ['*'])
     * @method RecruitmentApplicantWork firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RecruitmentApplicantWork firstOrCreate(array $attributes = [], array $values = [])
     * @method RecruitmentApplicantWork firstOrFail(array $columns = ['*'])
     * @method RecruitmentApplicantWork firstOrNew(array $attributes = [], array $values = [])
     * @method RecruitmentApplicantWork firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RecruitmentApplicantWork forceCreate(array $attributes)
     * @method _IH_RecruitmentApplicantWork_C|RecruitmentApplicantWork[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RecruitmentApplicantWork_C|RecruitmentApplicantWork[] get(array|string $columns = ['*'])
     * @method RecruitmentApplicantWork getModel()
     * @method RecruitmentApplicantWork[] getModels(array|string $columns = ['*'])
     * @method _IH_RecruitmentApplicantWork_C|RecruitmentApplicantWork[] hydrate(array $items)
     * @method RecruitmentApplicantWork make(array $attributes = [])
     * @method RecruitmentApplicantWork newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RecruitmentApplicantWork[]|_IH_RecruitmentApplicantWork_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RecruitmentApplicantWork[]|_IH_RecruitmentApplicantWork_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RecruitmentApplicantWork sole(array|string $columns = ['*'])
     * @method RecruitmentApplicantWork updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RecruitmentApplicantWork_QB extends _BaseBuilder {}
    
    /**
     * @method RecruitmentApplicant|$this shift(int $count = 1)
     * @method RecruitmentApplicant|null firstOrFail($key = null, $operator = null, $value = null)
     * @method RecruitmentApplicant|$this pop(int $count = 1)
     * @method RecruitmentApplicant|null get($key, $default = null)
     * @method RecruitmentApplicant|null pull($key, $default = null)
     * @method RecruitmentApplicant|null first(callable $callback = null, $default = null)
     * @method RecruitmentApplicant|null firstWhere(string $key, $operator = null, $value = null)
     * @method RecruitmentApplicant|null find($key, $default = null)
     * @method RecruitmentApplicant[] all()
     * @method RecruitmentApplicant|null last(callable $callback = null, $default = null)
     * @method RecruitmentApplicant|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_RecruitmentApplicant_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RecruitmentApplicant[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method RecruitmentApplicant baseSole(array|string $columns = ['*'])
     * @method RecruitmentApplicant create(array $attributes = [])
     * @method _IH_RecruitmentApplicant_C|RecruitmentApplicant[] cursor()
     * @method RecruitmentApplicant|null|_IH_RecruitmentApplicant_C|RecruitmentApplicant[] find($id, array $columns = ['*'])
     * @method _IH_RecruitmentApplicant_C|RecruitmentApplicant[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RecruitmentApplicant|_IH_RecruitmentApplicant_C|RecruitmentApplicant[] findOrFail($id, array $columns = ['*'])
     * @method RecruitmentApplicant|_IH_RecruitmentApplicant_C|RecruitmentApplicant[] findOrNew($id, array $columns = ['*'])
     * @method RecruitmentApplicant first(array|string $columns = ['*'])
     * @method RecruitmentApplicant firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RecruitmentApplicant firstOrCreate(array $attributes = [], array $values = [])
     * @method RecruitmentApplicant firstOrFail(array $columns = ['*'])
     * @method RecruitmentApplicant firstOrNew(array $attributes = [], array $values = [])
     * @method RecruitmentApplicant firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RecruitmentApplicant forceCreate(array $attributes)
     * @method _IH_RecruitmentApplicant_C|RecruitmentApplicant[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RecruitmentApplicant_C|RecruitmentApplicant[] get(array|string $columns = ['*'])
     * @method RecruitmentApplicant getModel()
     * @method RecruitmentApplicant[] getModels(array|string $columns = ['*'])
     * @method _IH_RecruitmentApplicant_C|RecruitmentApplicant[] hydrate(array $items)
     * @method RecruitmentApplicant make(array $attributes = [])
     * @method RecruitmentApplicant newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RecruitmentApplicant[]|_IH_RecruitmentApplicant_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RecruitmentApplicant[]|_IH_RecruitmentApplicant_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RecruitmentApplicant sole(array|string $columns = ['*'])
     * @method RecruitmentApplicant updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RecruitmentApplicant_QB extends _BaseBuilder {}
    
    /**
     * @method RecruitmentContract|$this shift(int $count = 1)
     * @method RecruitmentContract|null firstOrFail($key = null, $operator = null, $value = null)
     * @method RecruitmentContract|$this pop(int $count = 1)
     * @method RecruitmentContract|null get($key, $default = null)
     * @method RecruitmentContract|null pull($key, $default = null)
     * @method RecruitmentContract|null first(callable $callback = null, $default = null)
     * @method RecruitmentContract|null firstWhere(string $key, $operator = null, $value = null)
     * @method RecruitmentContract|null find($key, $default = null)
     * @method RecruitmentContract[] all()
     * @method RecruitmentContract|null last(callable $callback = null, $default = null)
     * @method RecruitmentContract|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_RecruitmentContract_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RecruitmentContract[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method RecruitmentContract baseSole(array|string $columns = ['*'])
     * @method RecruitmentContract create(array $attributes = [])
     * @method _IH_RecruitmentContract_C|RecruitmentContract[] cursor()
     * @method RecruitmentContract|null|_IH_RecruitmentContract_C|RecruitmentContract[] find($id, array $columns = ['*'])
     * @method _IH_RecruitmentContract_C|RecruitmentContract[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RecruitmentContract|_IH_RecruitmentContract_C|RecruitmentContract[] findOrFail($id, array $columns = ['*'])
     * @method RecruitmentContract|_IH_RecruitmentContract_C|RecruitmentContract[] findOrNew($id, array $columns = ['*'])
     * @method RecruitmentContract first(array|string $columns = ['*'])
     * @method RecruitmentContract firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RecruitmentContract firstOrCreate(array $attributes = [], array $values = [])
     * @method RecruitmentContract firstOrFail(array $columns = ['*'])
     * @method RecruitmentContract firstOrNew(array $attributes = [], array $values = [])
     * @method RecruitmentContract firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RecruitmentContract forceCreate(array $attributes)
     * @method _IH_RecruitmentContract_C|RecruitmentContract[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RecruitmentContract_C|RecruitmentContract[] get(array|string $columns = ['*'])
     * @method RecruitmentContract getModel()
     * @method RecruitmentContract[] getModels(array|string $columns = ['*'])
     * @method _IH_RecruitmentContract_C|RecruitmentContract[] hydrate(array $items)
     * @method RecruitmentContract make(array $attributes = [])
     * @method RecruitmentContract newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RecruitmentContract[]|_IH_RecruitmentContract_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RecruitmentContract[]|_IH_RecruitmentContract_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RecruitmentContract sole(array|string $columns = ['*'])
     * @method RecruitmentContract updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RecruitmentContract_QB extends _BaseBuilder {}
    
    /**
     * @method RecruitmentPlacement|$this shift(int $count = 1)
     * @method RecruitmentPlacement|null firstOrFail($key = null, $operator = null, $value = null)
     * @method RecruitmentPlacement|$this pop(int $count = 1)
     * @method RecruitmentPlacement|null get($key, $default = null)
     * @method RecruitmentPlacement|null pull($key, $default = null)
     * @method RecruitmentPlacement|null first(callable $callback = null, $default = null)
     * @method RecruitmentPlacement|null firstWhere(string $key, $operator = null, $value = null)
     * @method RecruitmentPlacement|null find($key, $default = null)
     * @method RecruitmentPlacement[] all()
     * @method RecruitmentPlacement|null last(callable $callback = null, $default = null)
     * @method RecruitmentPlacement|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_RecruitmentPlacement_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RecruitmentPlacement[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method RecruitmentPlacement baseSole(array|string $columns = ['*'])
     * @method RecruitmentPlacement create(array $attributes = [])
     * @method _IH_RecruitmentPlacement_C|RecruitmentPlacement[] cursor()
     * @method RecruitmentPlacement|null|_IH_RecruitmentPlacement_C|RecruitmentPlacement[] find($id, array $columns = ['*'])
     * @method _IH_RecruitmentPlacement_C|RecruitmentPlacement[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RecruitmentPlacement|_IH_RecruitmentPlacement_C|RecruitmentPlacement[] findOrFail($id, array $columns = ['*'])
     * @method RecruitmentPlacement|_IH_RecruitmentPlacement_C|RecruitmentPlacement[] findOrNew($id, array $columns = ['*'])
     * @method RecruitmentPlacement first(array|string $columns = ['*'])
     * @method RecruitmentPlacement firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RecruitmentPlacement firstOrCreate(array $attributes = [], array $values = [])
     * @method RecruitmentPlacement firstOrFail(array $columns = ['*'])
     * @method RecruitmentPlacement firstOrNew(array $attributes = [], array $values = [])
     * @method RecruitmentPlacement firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RecruitmentPlacement forceCreate(array $attributes)
     * @method _IH_RecruitmentPlacement_C|RecruitmentPlacement[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RecruitmentPlacement_C|RecruitmentPlacement[] get(array|string $columns = ['*'])
     * @method RecruitmentPlacement getModel()
     * @method RecruitmentPlacement[] getModels(array|string $columns = ['*'])
     * @method _IH_RecruitmentPlacement_C|RecruitmentPlacement[] hydrate(array $items)
     * @method RecruitmentPlacement make(array $attributes = [])
     * @method RecruitmentPlacement newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RecruitmentPlacement[]|_IH_RecruitmentPlacement_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RecruitmentPlacement[]|_IH_RecruitmentPlacement_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RecruitmentPlacement sole(array|string $columns = ['*'])
     * @method RecruitmentPlacement updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RecruitmentPlacement_QB extends _BaseBuilder {}
    
    /**
     * @method RecruitmentPlan|$this shift(int $count = 1)
     * @method RecruitmentPlan|null firstOrFail($key = null, $operator = null, $value = null)
     * @method RecruitmentPlan|$this pop(int $count = 1)
     * @method RecruitmentPlan|null get($key, $default = null)
     * @method RecruitmentPlan|null pull($key, $default = null)
     * @method RecruitmentPlan|null first(callable $callback = null, $default = null)
     * @method RecruitmentPlan|null firstWhere(string $key, $operator = null, $value = null)
     * @method RecruitmentPlan|null find($key, $default = null)
     * @method RecruitmentPlan[] all()
     * @method RecruitmentPlan|null last(callable $callback = null, $default = null)
     * @method RecruitmentPlan|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_RecruitmentPlan_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RecruitmentPlan[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method RecruitmentPlan baseSole(array|string $columns = ['*'])
     * @method RecruitmentPlan create(array $attributes = [])
     * @method _IH_RecruitmentPlan_C|RecruitmentPlan[] cursor()
     * @method RecruitmentPlan|null|_IH_RecruitmentPlan_C|RecruitmentPlan[] find($id, array $columns = ['*'])
     * @method _IH_RecruitmentPlan_C|RecruitmentPlan[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RecruitmentPlan|_IH_RecruitmentPlan_C|RecruitmentPlan[] findOrFail($id, array $columns = ['*'])
     * @method RecruitmentPlan|_IH_RecruitmentPlan_C|RecruitmentPlan[] findOrNew($id, array $columns = ['*'])
     * @method RecruitmentPlan first(array|string $columns = ['*'])
     * @method RecruitmentPlan firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RecruitmentPlan firstOrCreate(array $attributes = [], array $values = [])
     * @method RecruitmentPlan firstOrFail(array $columns = ['*'])
     * @method RecruitmentPlan firstOrNew(array $attributes = [], array $values = [])
     * @method RecruitmentPlan firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RecruitmentPlan forceCreate(array $attributes)
     * @method _IH_RecruitmentPlan_C|RecruitmentPlan[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RecruitmentPlan_C|RecruitmentPlan[] get(array|string $columns = ['*'])
     * @method RecruitmentPlan getModel()
     * @method RecruitmentPlan[] getModels(array|string $columns = ['*'])
     * @method _IH_RecruitmentPlan_C|RecruitmentPlan[] hydrate(array $items)
     * @method RecruitmentPlan make(array $attributes = [])
     * @method RecruitmentPlan newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RecruitmentPlan[]|_IH_RecruitmentPlan_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RecruitmentPlan[]|_IH_RecruitmentPlan_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RecruitmentPlan sole(array|string $columns = ['*'])
     * @method RecruitmentPlan updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RecruitmentPlan_QB extends _BaseBuilder {}
    
    /**
     * @method RecruitmentSelection|$this shift(int $count = 1)
     * @method RecruitmentSelection|null firstOrFail($key = null, $operator = null, $value = null)
     * @method RecruitmentSelection|$this pop(int $count = 1)
     * @method RecruitmentSelection|null get($key, $default = null)
     * @method RecruitmentSelection|null pull($key, $default = null)
     * @method RecruitmentSelection|null first(callable $callback = null, $default = null)
     * @method RecruitmentSelection|null firstWhere(string $key, $operator = null, $value = null)
     * @method RecruitmentSelection|null find($key, $default = null)
     * @method RecruitmentSelection[] all()
     * @method RecruitmentSelection|null last(callable $callback = null, $default = null)
     * @method RecruitmentSelection|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_RecruitmentSelection_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RecruitmentSelection[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method RecruitmentSelection baseSole(array|string $columns = ['*'])
     * @method RecruitmentSelection create(array $attributes = [])
     * @method _IH_RecruitmentSelection_C|RecruitmentSelection[] cursor()
     * @method RecruitmentSelection|null|_IH_RecruitmentSelection_C|RecruitmentSelection[] find($id, array $columns = ['*'])
     * @method _IH_RecruitmentSelection_C|RecruitmentSelection[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RecruitmentSelection|_IH_RecruitmentSelection_C|RecruitmentSelection[] findOrFail($id, array $columns = ['*'])
     * @method RecruitmentSelection|_IH_RecruitmentSelection_C|RecruitmentSelection[] findOrNew($id, array $columns = ['*'])
     * @method RecruitmentSelection first(array|string $columns = ['*'])
     * @method RecruitmentSelection firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RecruitmentSelection firstOrCreate(array $attributes = [], array $values = [])
     * @method RecruitmentSelection firstOrFail(array $columns = ['*'])
     * @method RecruitmentSelection firstOrNew(array $attributes = [], array $values = [])
     * @method RecruitmentSelection firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RecruitmentSelection forceCreate(array $attributes)
     * @method _IH_RecruitmentSelection_C|RecruitmentSelection[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RecruitmentSelection_C|RecruitmentSelection[] get(array|string $columns = ['*'])
     * @method RecruitmentSelection getModel()
     * @method RecruitmentSelection[] getModels(array|string $columns = ['*'])
     * @method _IH_RecruitmentSelection_C|RecruitmentSelection[] hydrate(array $items)
     * @method RecruitmentSelection make(array $attributes = [])
     * @method RecruitmentSelection newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RecruitmentSelection[]|_IH_RecruitmentSelection_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RecruitmentSelection[]|_IH_RecruitmentSelection_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RecruitmentSelection sole(array|string $columns = ['*'])
     * @method RecruitmentSelection updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RecruitmentSelection_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\App\Models\Setting {

    use App\Models\Setting\Category;
    use App\Models\Setting\Group;
    use App\Models\Setting\GroupModul;
    use App\Models\Setting\Master;
    use App\Models\Setting\Menu;
    use App\Models\Setting\MenuAccess;
    use App\Models\Setting\Modul;
    use App\Models\Setting\Parameter;
    use App\Models\Setting\SubModul;
    use App\Models\Setting\User;
    use App\Models\Setting\UserAccess;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method Category|$this shift(int $count = 1)
     * @method Category|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Category|$this pop(int $count = 1)
     * @method Category|null get($key, $default = null)
     * @method Category|null pull($key, $default = null)
     * @method Category|null first(callable $callback = null, $default = null)
     * @method Category|null firstWhere(string $key, $operator = null, $value = null)
     * @method Category|null find($key, $default = null)
     * @method Category[] all()
     * @method Category|null last(callable $callback = null, $default = null)
     * @method Category|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Category_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Category[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Category baseSole(array|string $columns = ['*'])
     * @method Category create(array $attributes = [])
     * @method _IH_Category_C|Category[] cursor()
     * @method Category|null|_IH_Category_C|Category[] find($id, array $columns = ['*'])
     * @method _IH_Category_C|Category[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Category|_IH_Category_C|Category[] findOrFail($id, array $columns = ['*'])
     * @method Category|_IH_Category_C|Category[] findOrNew($id, array $columns = ['*'])
     * @method Category first(array|string $columns = ['*'])
     * @method Category firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Category firstOrCreate(array $attributes = [], array $values = [])
     * @method Category firstOrFail(array $columns = ['*'])
     * @method Category firstOrNew(array $attributes = [], array $values = [])
     * @method Category firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Category forceCreate(array $attributes)
     * @method _IH_Category_C|Category[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Category_C|Category[] get(array|string $columns = ['*'])
     * @method Category getModel()
     * @method Category[] getModels(array|string $columns = ['*'])
     * @method _IH_Category_C|Category[] hydrate(array $items)
     * @method Category make(array $attributes = [])
     * @method Category newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Category[]|_IH_Category_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Category[]|_IH_Category_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Category sole(array|string $columns = ['*'])
     * @method Category updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Category_QB extends _BaseBuilder {}
    
    /**
     * @method GroupModul|$this shift(int $count = 1)
     * @method GroupModul|null firstOrFail($key = null, $operator = null, $value = null)
     * @method GroupModul|$this pop(int $count = 1)
     * @method GroupModul|null get($key, $default = null)
     * @method GroupModul|null pull($key, $default = null)
     * @method GroupModul|null first(callable $callback = null, $default = null)
     * @method GroupModul|null firstWhere(string $key, $operator = null, $value = null)
     * @method GroupModul|null find($key, $default = null)
     * @method GroupModul[] all()
     * @method GroupModul|null last(callable $callback = null, $default = null)
     * @method GroupModul|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_GroupModul_C extends _BaseCollection {
        /**
         * @param int $size
         * @return GroupModul[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method GroupModul baseSole(array|string $columns = ['*'])
     * @method GroupModul create(array $attributes = [])
     * @method _IH_GroupModul_C|GroupModul[] cursor()
     * @method GroupModul|null|_IH_GroupModul_C|GroupModul[] find($id, array $columns = ['*'])
     * @method _IH_GroupModul_C|GroupModul[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method GroupModul|_IH_GroupModul_C|GroupModul[] findOrFail($id, array $columns = ['*'])
     * @method GroupModul|_IH_GroupModul_C|GroupModul[] findOrNew($id, array $columns = ['*'])
     * @method GroupModul first(array|string $columns = ['*'])
     * @method GroupModul firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method GroupModul firstOrCreate(array $attributes = [], array $values = [])
     * @method GroupModul firstOrFail(array $columns = ['*'])
     * @method GroupModul firstOrNew(array $attributes = [], array $values = [])
     * @method GroupModul firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method GroupModul forceCreate(array $attributes)
     * @method _IH_GroupModul_C|GroupModul[] fromQuery(string $query, array $bindings = [])
     * @method _IH_GroupModul_C|GroupModul[] get(array|string $columns = ['*'])
     * @method GroupModul getModel()
     * @method GroupModul[] getModels(array|string $columns = ['*'])
     * @method _IH_GroupModul_C|GroupModul[] hydrate(array $items)
     * @method GroupModul make(array $attributes = [])
     * @method GroupModul newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|GroupModul[]|_IH_GroupModul_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|GroupModul[]|_IH_GroupModul_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method GroupModul sole(array|string $columns = ['*'])
     * @method GroupModul updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_GroupModul_QB extends _BaseBuilder {}
    
    /**
     * @method Group|$this shift(int $count = 1)
     * @method Group|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Group|$this pop(int $count = 1)
     * @method Group|null get($key, $default = null)
     * @method Group|null pull($key, $default = null)
     * @method Group|null first(callable $callback = null, $default = null)
     * @method Group|null firstWhere(string $key, $operator = null, $value = null)
     * @method Group|null find($key, $default = null)
     * @method Group[] all()
     * @method Group|null last(callable $callback = null, $default = null)
     * @method Group|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Group_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Group[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Group baseSole(array|string $columns = ['*'])
     * @method Group create(array $attributes = [])
     * @method _IH_Group_C|Group[] cursor()
     * @method Group|null|_IH_Group_C|Group[] find($id, array $columns = ['*'])
     * @method _IH_Group_C|Group[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Group|_IH_Group_C|Group[] findOrFail($id, array $columns = ['*'])
     * @method Group|_IH_Group_C|Group[] findOrNew($id, array $columns = ['*'])
     * @method Group first(array|string $columns = ['*'])
     * @method Group firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Group firstOrCreate(array $attributes = [], array $values = [])
     * @method Group firstOrFail(array $columns = ['*'])
     * @method Group firstOrNew(array $attributes = [], array $values = [])
     * @method Group firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Group forceCreate(array $attributes)
     * @method _IH_Group_C|Group[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Group_C|Group[] get(array|string $columns = ['*'])
     * @method Group getModel()
     * @method Group[] getModels(array|string $columns = ['*'])
     * @method _IH_Group_C|Group[] hydrate(array $items)
     * @method Group make(array $attributes = [])
     * @method Group newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Group[]|_IH_Group_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Group[]|_IH_Group_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Group sole(array|string $columns = ['*'])
     * @method Group updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Group_QB extends _BaseBuilder {}
    
    /**
     * @method Master|$this shift(int $count = 1)
     * @method Master|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Master|$this pop(int $count = 1)
     * @method Master|null get($key, $default = null)
     * @method Master|null pull($key, $default = null)
     * @method Master|null first(callable $callback = null, $default = null)
     * @method Master|null firstWhere(string $key, $operator = null, $value = null)
     * @method Master|null find($key, $default = null)
     * @method Master[] all()
     * @method Master|null last(callable $callback = null, $default = null)
     * @method Master|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Master_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Master[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Master_QB whereParameter($value)
     * @method _IH_Master_QB whereAdditionalParameter($value)
     * @method Master baseSole(array|string $columns = ['*'])
     * @method Master create(array $attributes = [])
     * @method _IH_Master_C|Master[] cursor()
     * @method Master|null|_IH_Master_C|Master[] find($id, array $columns = ['*'])
     * @method _IH_Master_C|Master[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Master|_IH_Master_C|Master[] findOrFail($id, array $columns = ['*'])
     * @method Master|_IH_Master_C|Master[] findOrNew($id, array $columns = ['*'])
     * @method Master first(array|string $columns = ['*'])
     * @method Master firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Master firstOrCreate(array $attributes = [], array $values = [])
     * @method Master firstOrFail(array $columns = ['*'])
     * @method Master firstOrNew(array $attributes = [], array $values = [])
     * @method Master firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Master forceCreate(array $attributes)
     * @method _IH_Master_C|Master[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Master_C|Master[] get(array|string $columns = ['*'])
     * @method Master getModel()
     * @method Master[] getModels(array|string $columns = ['*'])
     * @method _IH_Master_C|Master[] hydrate(array $items)
     * @method Master make(array $attributes = [])
     * @method Master newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Master[]|_IH_Master_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Master[]|_IH_Master_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Master sole(array|string $columns = ['*'])
     * @method Master updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Master_QB active($id = '')
     */
    class _IH_Master_QB extends _BaseBuilder {}
    
    /**
     * @method MenuAccess|$this shift(int $count = 1)
     * @method MenuAccess|null firstOrFail($key = null, $operator = null, $value = null)
     * @method MenuAccess|$this pop(int $count = 1)
     * @method MenuAccess|null get($key, $default = null)
     * @method MenuAccess|null pull($key, $default = null)
     * @method MenuAccess|null first(callable $callback = null, $default = null)
     * @method MenuAccess|null firstWhere(string $key, $operator = null, $value = null)
     * @method MenuAccess|null find($key, $default = null)
     * @method MenuAccess[] all()
     * @method MenuAccess|null last(callable $callback = null, $default = null)
     * @method MenuAccess|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_MenuAccess_C extends _BaseCollection {
        /**
         * @param int $size
         * @return MenuAccess[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method MenuAccess baseSole(array|string $columns = ['*'])
     * @method MenuAccess create(array $attributes = [])
     * @method _IH_MenuAccess_C|MenuAccess[] cursor()
     * @method MenuAccess|null|_IH_MenuAccess_C|MenuAccess[] find($id, array $columns = ['*'])
     * @method _IH_MenuAccess_C|MenuAccess[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method MenuAccess|_IH_MenuAccess_C|MenuAccess[] findOrFail($id, array $columns = ['*'])
     * @method MenuAccess|_IH_MenuAccess_C|MenuAccess[] findOrNew($id, array $columns = ['*'])
     * @method MenuAccess first(array|string $columns = ['*'])
     * @method MenuAccess firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method MenuAccess firstOrCreate(array $attributes = [], array $values = [])
     * @method MenuAccess firstOrFail(array $columns = ['*'])
     * @method MenuAccess firstOrNew(array $attributes = [], array $values = [])
     * @method MenuAccess firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method MenuAccess forceCreate(array $attributes)
     * @method _IH_MenuAccess_C|MenuAccess[] fromQuery(string $query, array $bindings = [])
     * @method _IH_MenuAccess_C|MenuAccess[] get(array|string $columns = ['*'])
     * @method MenuAccess getModel()
     * @method MenuAccess[] getModels(array|string $columns = ['*'])
     * @method _IH_MenuAccess_C|MenuAccess[] hydrate(array $items)
     * @method MenuAccess make(array $attributes = [])
     * @method MenuAccess newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|MenuAccess[]|_IH_MenuAccess_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|MenuAccess[]|_IH_MenuAccess_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method MenuAccess sole(array|string $columns = ['*'])
     * @method MenuAccess updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_MenuAccess_QB extends _BaseBuilder {}
    
    /**
     * @method Menu|$this shift(int $count = 1)
     * @method Menu|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Menu|$this pop(int $count = 1)
     * @method Menu|null get($key, $default = null)
     * @method Menu|null pull($key, $default = null)
     * @method Menu|null first(callable $callback = null, $default = null)
     * @method Menu|null firstWhere(string $key, $operator = null, $value = null)
     * @method Menu|null find($key, $default = null)
     * @method Menu[] all()
     * @method Menu|null last(callable $callback = null, $default = null)
     * @method Menu|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Menu_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Menu[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Menu baseSole(array|string $columns = ['*'])
     * @method Menu create(array $attributes = [])
     * @method _IH_Menu_C|Menu[] cursor()
     * @method Menu|null|_IH_Menu_C|Menu[] find($id, array $columns = ['*'])
     * @method _IH_Menu_C|Menu[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Menu|_IH_Menu_C|Menu[] findOrFail($id, array $columns = ['*'])
     * @method Menu|_IH_Menu_C|Menu[] findOrNew($id, array $columns = ['*'])
     * @method Menu first(array|string $columns = ['*'])
     * @method Menu firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Menu firstOrCreate(array $attributes = [], array $values = [])
     * @method Menu firstOrFail(array $columns = ['*'])
     * @method Menu firstOrNew(array $attributes = [], array $values = [])
     * @method Menu firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Menu forceCreate(array $attributes)
     * @method _IH_Menu_C|Menu[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Menu_C|Menu[] get(array|string $columns = ['*'])
     * @method Menu getModel()
     * @method Menu[] getModels(array|string $columns = ['*'])
     * @method _IH_Menu_C|Menu[] hydrate(array $items)
     * @method Menu make(array $attributes = [])
     * @method Menu newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Menu[]|_IH_Menu_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Menu[]|_IH_Menu_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Menu sole(array|string $columns = ['*'])
     * @method Menu updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Menu_QB active()
     */
    class _IH_Menu_QB extends _BaseBuilder {}
    
    /**
     * @method Modul|$this shift(int $count = 1)
     * @method Modul|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Modul|$this pop(int $count = 1)
     * @method Modul|null get($key, $default = null)
     * @method Modul|null pull($key, $default = null)
     * @method Modul|null first(callable $callback = null, $default = null)
     * @method Modul|null firstWhere(string $key, $operator = null, $value = null)
     * @method Modul|null find($key, $default = null)
     * @method Modul[] all()
     * @method Modul|null last(callable $callback = null, $default = null)
     * @method Modul|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Modul_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Modul[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Modul baseSole(array|string $columns = ['*'])
     * @method Modul create(array $attributes = [])
     * @method _IH_Modul_C|Modul[] cursor()
     * @method Modul|null|_IH_Modul_C|Modul[] find($id, array $columns = ['*'])
     * @method _IH_Modul_C|Modul[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Modul|_IH_Modul_C|Modul[] findOrFail($id, array $columns = ['*'])
     * @method Modul|_IH_Modul_C|Modul[] findOrNew($id, array $columns = ['*'])
     * @method Modul first(array|string $columns = ['*'])
     * @method Modul firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Modul firstOrCreate(array $attributes = [], array $values = [])
     * @method Modul firstOrFail(array $columns = ['*'])
     * @method Modul firstOrNew(array $attributes = [], array $values = [])
     * @method Modul firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Modul forceCreate(array $attributes)
     * @method _IH_Modul_C|Modul[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Modul_C|Modul[] get(array|string $columns = ['*'])
     * @method Modul getModel()
     * @method Modul[] getModels(array|string $columns = ['*'])
     * @method _IH_Modul_C|Modul[] hydrate(array $items)
     * @method Modul make(array $attributes = [])
     * @method Modul newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Modul[]|_IH_Modul_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Modul[]|_IH_Modul_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Modul sole(array|string $columns = ['*'])
     * @method Modul updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Modul_QB active()
     */
    class _IH_Modul_QB extends _BaseBuilder {}
    
    /**
     * @method Parameter|$this shift(int $count = 1)
     * @method Parameter|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Parameter|$this pop(int $count = 1)
     * @method Parameter|null get($key, $default = null)
     * @method Parameter|null pull($key, $default = null)
     * @method Parameter|null first(callable $callback = null, $default = null)
     * @method Parameter|null firstWhere(string $key, $operator = null, $value = null)
     * @method Parameter|null find($key, $default = null)
     * @method Parameter[] all()
     * @method Parameter|null last(callable $callback = null, $default = null)
     * @method Parameter|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Parameter_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Parameter[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Parameter baseSole(array|string $columns = ['*'])
     * @method Parameter create(array $attributes = [])
     * @method _IH_Parameter_C|Parameter[] cursor()
     * @method Parameter|null|_IH_Parameter_C|Parameter[] find($id, array $columns = ['*'])
     * @method _IH_Parameter_C|Parameter[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Parameter|_IH_Parameter_C|Parameter[] findOrFail($id, array $columns = ['*'])
     * @method Parameter|_IH_Parameter_C|Parameter[] findOrNew($id, array $columns = ['*'])
     * @method Parameter first(array|string $columns = ['*'])
     * @method Parameter firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Parameter firstOrCreate(array $attributes = [], array $values = [])
     * @method Parameter firstOrFail(array $columns = ['*'])
     * @method Parameter firstOrNew(array $attributes = [], array $values = [])
     * @method Parameter firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Parameter forceCreate(array $attributes)
     * @method _IH_Parameter_C|Parameter[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Parameter_C|Parameter[] get(array|string $columns = ['*'])
     * @method Parameter getModel()
     * @method Parameter[] getModels(array|string $columns = ['*'])
     * @method _IH_Parameter_C|Parameter[] hydrate(array $items)
     * @method Parameter make(array $attributes = [])
     * @method Parameter newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Parameter[]|_IH_Parameter_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Parameter[]|_IH_Parameter_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Parameter sole(array|string $columns = ['*'])
     * @method Parameter updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Parameter_QB extends _BaseBuilder {}
    
    /**
     * @method SubModul|$this shift(int $count = 1)
     * @method SubModul|null firstOrFail($key = null, $operator = null, $value = null)
     * @method SubModul|$this pop(int $count = 1)
     * @method SubModul|null get($key, $default = null)
     * @method SubModul|null pull($key, $default = null)
     * @method SubModul|null first(callable $callback = null, $default = null)
     * @method SubModul|null firstWhere(string $key, $operator = null, $value = null)
     * @method SubModul|null find($key, $default = null)
     * @method SubModul[] all()
     * @method SubModul|null last(callable $callback = null, $default = null)
     * @method SubModul|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_SubModul_C extends _BaseCollection {
        /**
         * @param int $size
         * @return SubModul[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method SubModul baseSole(array|string $columns = ['*'])
     * @method SubModul create(array $attributes = [])
     * @method _IH_SubModul_C|SubModul[] cursor()
     * @method SubModul|null|_IH_SubModul_C|SubModul[] find($id, array $columns = ['*'])
     * @method _IH_SubModul_C|SubModul[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method SubModul|_IH_SubModul_C|SubModul[] findOrFail($id, array $columns = ['*'])
     * @method SubModul|_IH_SubModul_C|SubModul[] findOrNew($id, array $columns = ['*'])
     * @method SubModul first(array|string $columns = ['*'])
     * @method SubModul firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method SubModul firstOrCreate(array $attributes = [], array $values = [])
     * @method SubModul firstOrFail(array $columns = ['*'])
     * @method SubModul firstOrNew(array $attributes = [], array $values = [])
     * @method SubModul firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method SubModul forceCreate(array $attributes)
     * @method _IH_SubModul_C|SubModul[] fromQuery(string $query, array $bindings = [])
     * @method _IH_SubModul_C|SubModul[] get(array|string $columns = ['*'])
     * @method SubModul getModel()
     * @method SubModul[] getModels(array|string $columns = ['*'])
     * @method _IH_SubModul_C|SubModul[] hydrate(array $items)
     * @method SubModul make(array $attributes = [])
     * @method SubModul newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|SubModul[]|_IH_SubModul_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|SubModul[]|_IH_SubModul_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method SubModul sole(array|string $columns = ['*'])
     * @method SubModul updateOrCreate(array $attributes, array $values = [])
     * @method _IH_SubModul_QB active()
     */
    class _IH_SubModul_QB extends _BaseBuilder {}
    
    /**
     * @method UserAccess|$this shift(int $count = 1)
     * @method UserAccess|null firstOrFail($key = null, $operator = null, $value = null)
     * @method UserAccess|$this pop(int $count = 1)
     * @method UserAccess|null get($key, $default = null)
     * @method UserAccess|null pull($key, $default = null)
     * @method UserAccess|null first(callable $callback = null, $default = null)
     * @method UserAccess|null firstWhere(string $key, $operator = null, $value = null)
     * @method UserAccess|null find($key, $default = null)
     * @method UserAccess[] all()
     * @method UserAccess|null last(callable $callback = null, $default = null)
     * @method UserAccess|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_UserAccess_C extends _BaseCollection {
        /**
         * @param int $size
         * @return UserAccess[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method UserAccess baseSole(array|string $columns = ['*'])
     * @method UserAccess create(array $attributes = [])
     * @method _IH_UserAccess_C|UserAccess[] cursor()
     * @method UserAccess|null|_IH_UserAccess_C|UserAccess[] find($id, array $columns = ['*'])
     * @method _IH_UserAccess_C|UserAccess[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method UserAccess|_IH_UserAccess_C|UserAccess[] findOrFail($id, array $columns = ['*'])
     * @method UserAccess|_IH_UserAccess_C|UserAccess[] findOrNew($id, array $columns = ['*'])
     * @method UserAccess first(array|string $columns = ['*'])
     * @method UserAccess firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method UserAccess firstOrCreate(array $attributes = [], array $values = [])
     * @method UserAccess firstOrFail(array $columns = ['*'])
     * @method UserAccess firstOrNew(array $attributes = [], array $values = [])
     * @method UserAccess firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method UserAccess forceCreate(array $attributes)
     * @method _IH_UserAccess_C|UserAccess[] fromQuery(string $query, array $bindings = [])
     * @method _IH_UserAccess_C|UserAccess[] get(array|string $columns = ['*'])
     * @method UserAccess getModel()
     * @method UserAccess[] getModels(array|string $columns = ['*'])
     * @method _IH_UserAccess_C|UserAccess[] hydrate(array $items)
     * @method UserAccess make(array $attributes = [])
     * @method UserAccess newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|UserAccess[]|_IH_UserAccess_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|UserAccess[]|_IH_UserAccess_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method UserAccess sole(array|string $columns = ['*'])
     * @method UserAccess updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_UserAccess_QB extends _BaseBuilder {}
    
    /**
     * @method User|$this shift(int $count = 1)
     * @method User|null firstOrFail($key = null, $operator = null, $value = null)
     * @method User|$this pop(int $count = 1)
     * @method User|null get($key, $default = null)
     * @method User|null pull($key, $default = null)
     * @method User|null first(callable $callback = null, $default = null)
     * @method User|null firstWhere(string $key, $operator = null, $value = null)
     * @method User|null find($key, $default = null)
     * @method User[] all()
     * @method User|null last(callable $callback = null, $default = null)
     * @method User|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_User_C extends _BaseCollection {
        /**
         * @param int $size
         * @return User[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method User baseSole(array|string $columns = ['*'])
     * @method User create(array $attributes = [])
     * @method _IH_User_C|User[] cursor()
     * @method User|null|_IH_User_C|User[] find($id, array $columns = ['*'])
     * @method _IH_User_C|User[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method User|_IH_User_C|User[] findOrFail($id, array $columns = ['*'])
     * @method User|_IH_User_C|User[] findOrNew($id, array $columns = ['*'])
     * @method User first(array|string $columns = ['*'])
     * @method User firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method User firstOrCreate(array $attributes = [], array $values = [])
     * @method User firstOrFail(array $columns = ['*'])
     * @method User firstOrNew(array $attributes = [], array $values = [])
     * @method User firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method User forceCreate(array $attributes)
     * @method _IH_User_C|User[] fromQuery(string $query, array $bindings = [])
     * @method _IH_User_C|User[] get(array|string $columns = ['*'])
     * @method User getModel()
     * @method User[] getModels(array|string $columns = ['*'])
     * @method _IH_User_C|User[] hydrate(array $items)
     * @method User make(array $attributes = [])
     * @method User newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|User[]|_IH_User_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|User[]|_IH_User_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method User sole(array|string $columns = ['*'])
     * @method User updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_User_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\Glhd\LaravelDumper\Tests {

    use Glhd\LaravelDumper\Tests\Company;
    use Glhd\LaravelDumper\Tests\User;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method Company|$this shift(int $count = 1)
     * @method Company|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Company|$this pop(int $count = 1)
     * @method Company|null get($key, $default = null)
     * @method Company|null pull($key, $default = null)
     * @method Company|null first(callable $callback = null, $default = null)
     * @method Company|null firstWhere(string $key, $operator = null, $value = null)
     * @method Company|null find($key, $default = null)
     * @method Company[] all()
     * @method Company|null last(callable $callback = null, $default = null)
     * @method Company|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Company_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Company[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Company baseSole(array|string $columns = ['*'])
     * @method Company create(array $attributes = [])
     * @method _IH_Company_C|Company[] cursor()
     * @method Company|null|_IH_Company_C|Company[] find($id, array $columns = ['*'])
     * @method _IH_Company_C|Company[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Company|_IH_Company_C|Company[] findOrFail($id, array $columns = ['*'])
     * @method Company|_IH_Company_C|Company[] findOrNew($id, array $columns = ['*'])
     * @method Company first(array|string $columns = ['*'])
     * @method Company firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Company firstOrCreate(array $attributes = [], array $values = [])
     * @method Company firstOrFail(array $columns = ['*'])
     * @method Company firstOrNew(array $attributes = [], array $values = [])
     * @method Company firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Company forceCreate(array $attributes)
     * @method _IH_Company_C|Company[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Company_C|Company[] get(array|string $columns = ['*'])
     * @method Company getModel()
     * @method Company[] getModels(array|string $columns = ['*'])
     * @method _IH_Company_C|Company[] hydrate(array $items)
     * @method Company make(array $attributes = [])
     * @method Company newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Company[]|_IH_Company_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Company[]|_IH_Company_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Company sole(array|string $columns = ['*'])
     * @method Company updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Company_QB extends _BaseBuilder {}
    
    /**
     * @method User|$this shift(int $count = 1)
     * @method User|null firstOrFail($key = null, $operator = null, $value = null)
     * @method User|$this pop(int $count = 1)
     * @method User|null get($key, $default = null)
     * @method User|null pull($key, $default = null)
     * @method User|null first(callable $callback = null, $default = null)
     * @method User|null firstWhere(string $key, $operator = null, $value = null)
     * @method User|null find($key, $default = null)
     * @method User[] all()
     * @method User|null last(callable $callback = null, $default = null)
     * @method User|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_User_C extends _BaseCollection {
        /**
         * @param int $size
         * @return User[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method User baseSole(array|string $columns = ['*'])
     * @method User create(array $attributes = [])
     * @method _IH_User_C|User[] cursor()
     * @method User|null|_IH_User_C|User[] find($id, array $columns = ['*'])
     * @method _IH_User_C|User[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method User|_IH_User_C|User[] findOrFail($id, array $columns = ['*'])
     * @method User|_IH_User_C|User[] findOrNew($id, array $columns = ['*'])
     * @method User first(array|string $columns = ['*'])
     * @method User firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method User firstOrCreate(array $attributes = [], array $values = [])
     * @method User firstOrFail(array $columns = ['*'])
     * @method User firstOrNew(array $attributes = [], array $values = [])
     * @method User firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method User forceCreate(array $attributes)
     * @method _IH_User_C|User[] fromQuery(string $query, array $bindings = [])
     * @method _IH_User_C|User[] get(array|string $columns = ['*'])
     * @method User getModel()
     * @method User[] getModels(array|string $columns = ['*'])
     * @method _IH_User_C|User[] hydrate(array $items)
     * @method User make(array $attributes = [])
     * @method User newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|User[]|_IH_User_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|User[]|_IH_User_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method User sole(array|string $columns = ['*'])
     * @method User updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_User_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\Illuminate\Notifications {

    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Notifications\DatabaseNotification;
    use Illuminate\Notifications\DatabaseNotificationCollection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method DatabaseNotification|$this shift(int $count = 1)
     * @method DatabaseNotification|null firstOrFail($key = null, $operator = null, $value = null)
     * @method DatabaseNotification|$this pop(int $count = 1)
     * @method DatabaseNotification|null get($key, $default = null)
     * @method DatabaseNotification|null pull($key, $default = null)
     * @method DatabaseNotification|null first(callable $callback = null, $default = null)
     * @method DatabaseNotification|null firstWhere(string $key, $operator = null, $value = null)
     * @method DatabaseNotification|null find($key, $default = null)
     * @method DatabaseNotification[] all()
     * @method DatabaseNotification|null last(callable $callback = null, $default = null)
     * @method DatabaseNotification|null sole($key = null, $operator = null, $value = null)
     * @mixin DatabaseNotificationCollection
     */
    class _IH_DatabaseNotification_C extends _BaseCollection {
        /**
         * @param int $size
         * @return DatabaseNotification[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method DatabaseNotification baseSole(array|string $columns = ['*'])
     * @method DatabaseNotification create(array $attributes = [])
     * @method _IH_DatabaseNotification_C|DatabaseNotification[] cursor()
     * @method DatabaseNotification|null|_IH_DatabaseNotification_C|DatabaseNotification[] find($id, array $columns = ['*'])
     * @method _IH_DatabaseNotification_C|DatabaseNotification[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method DatabaseNotification|_IH_DatabaseNotification_C|DatabaseNotification[] findOrFail($id, array $columns = ['*'])
     * @method DatabaseNotification|_IH_DatabaseNotification_C|DatabaseNotification[] findOrNew($id, array $columns = ['*'])
     * @method DatabaseNotification first(array|string $columns = ['*'])
     * @method DatabaseNotification firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method DatabaseNotification firstOrCreate(array $attributes = [], array $values = [])
     * @method DatabaseNotification firstOrFail(array $columns = ['*'])
     * @method DatabaseNotification firstOrNew(array $attributes = [], array $values = [])
     * @method DatabaseNotification firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method DatabaseNotification forceCreate(array $attributes)
     * @method _IH_DatabaseNotification_C|DatabaseNotification[] fromQuery(string $query, array $bindings = [])
     * @method _IH_DatabaseNotification_C|DatabaseNotification[] get(array|string $columns = ['*'])
     * @method DatabaseNotification getModel()
     * @method DatabaseNotification[] getModels(array|string $columns = ['*'])
     * @method _IH_DatabaseNotification_C|DatabaseNotification[] hydrate(array $items)
     * @method DatabaseNotification make(array $attributes = [])
     * @method DatabaseNotification newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|DatabaseNotification[]|_IH_DatabaseNotification_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|DatabaseNotification[]|_IH_DatabaseNotification_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method DatabaseNotification sole(array|string $columns = ['*'])
     * @method DatabaseNotification updateOrCreate(array $attributes, array $values = [])
     * @method _IH_DatabaseNotification_QB read()
     * @method _IH_DatabaseNotification_QB unread()
     */
    class _IH_DatabaseNotification_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\Laravel\Passport {

    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use Laravel\Passport\AuthCode;
    use Laravel\Passport\Client;
    use Laravel\Passport\PersonalAccessClient;
    use Laravel\Passport\RefreshToken;
    use Laravel\Passport\Token;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method AuthCode|$this shift(int $count = 1)
     * @method AuthCode|null firstOrFail($key = null, $operator = null, $value = null)
     * @method AuthCode|$this pop(int $count = 1)
     * @method AuthCode|null get($key, $default = null)
     * @method AuthCode|null pull($key, $default = null)
     * @method AuthCode|null first(callable $callback = null, $default = null)
     * @method AuthCode|null firstWhere(string $key, $operator = null, $value = null)
     * @method AuthCode|null find($key, $default = null)
     * @method AuthCode[] all()
     * @method AuthCode|null last(callable $callback = null, $default = null)
     * @method AuthCode|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_AuthCode_C extends _BaseCollection {
        /**
         * @param int $size
         * @return AuthCode[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method AuthCode baseSole(array|string $columns = ['*'])
     * @method AuthCode create(array $attributes = [])
     * @method _IH_AuthCode_C|AuthCode[] cursor()
     * @method AuthCode|null|_IH_AuthCode_C|AuthCode[] find($id, array $columns = ['*'])
     * @method _IH_AuthCode_C|AuthCode[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method AuthCode|_IH_AuthCode_C|AuthCode[] findOrFail($id, array $columns = ['*'])
     * @method AuthCode|_IH_AuthCode_C|AuthCode[] findOrNew($id, array $columns = ['*'])
     * @method AuthCode first(array|string $columns = ['*'])
     * @method AuthCode firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method AuthCode firstOrCreate(array $attributes = [], array $values = [])
     * @method AuthCode firstOrFail(array $columns = ['*'])
     * @method AuthCode firstOrNew(array $attributes = [], array $values = [])
     * @method AuthCode firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method AuthCode forceCreate(array $attributes)
     * @method _IH_AuthCode_C|AuthCode[] fromQuery(string $query, array $bindings = [])
     * @method _IH_AuthCode_C|AuthCode[] get(array|string $columns = ['*'])
     * @method AuthCode getModel()
     * @method AuthCode[] getModels(array|string $columns = ['*'])
     * @method _IH_AuthCode_C|AuthCode[] hydrate(array $items)
     * @method AuthCode make(array $attributes = [])
     * @method AuthCode newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|AuthCode[]|_IH_AuthCode_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|AuthCode[]|_IH_AuthCode_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method AuthCode sole(array|string $columns = ['*'])
     * @method AuthCode updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_AuthCode_QB extends _BaseBuilder {}
    
    /**
     * @method Client|$this shift(int $count = 1)
     * @method Client|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Client|$this pop(int $count = 1)
     * @method Client|null get($key, $default = null)
     * @method Client|null pull($key, $default = null)
     * @method Client|null first(callable $callback = null, $default = null)
     * @method Client|null firstWhere(string $key, $operator = null, $value = null)
     * @method Client|null find($key, $default = null)
     * @method Client[] all()
     * @method Client|null last(callable $callback = null, $default = null)
     * @method Client|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Client_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Client[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Client baseSole(array|string $columns = ['*'])
     * @method Client create(array $attributes = [])
     * @method _IH_Client_C|Client[] cursor()
     * @method Client|null|_IH_Client_C|Client[] find($id, array $columns = ['*'])
     * @method _IH_Client_C|Client[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Client|_IH_Client_C|Client[] findOrFail($id, array $columns = ['*'])
     * @method Client|_IH_Client_C|Client[] findOrNew($id, array $columns = ['*'])
     * @method Client first(array|string $columns = ['*'])
     * @method Client firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Client firstOrCreate(array $attributes = [], array $values = [])
     * @method Client firstOrFail(array $columns = ['*'])
     * @method Client firstOrNew(array $attributes = [], array $values = [])
     * @method Client firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Client forceCreate(array $attributes)
     * @method _IH_Client_C|Client[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Client_C|Client[] get(array|string $columns = ['*'])
     * @method Client getModel()
     * @method Client[] getModels(array|string $columns = ['*'])
     * @method _IH_Client_C|Client[] hydrate(array $items)
     * @method Client make(array $attributes = [])
     * @method Client newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Client[]|_IH_Client_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Client[]|_IH_Client_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Client sole(array|string $columns = ['*'])
     * @method Client updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Client_QB extends _BaseBuilder {}
    
    /**
     * @method PersonalAccessClient|$this shift(int $count = 1)
     * @method PersonalAccessClient|null firstOrFail($key = null, $operator = null, $value = null)
     * @method PersonalAccessClient|$this pop(int $count = 1)
     * @method PersonalAccessClient|null get($key, $default = null)
     * @method PersonalAccessClient|null pull($key, $default = null)
     * @method PersonalAccessClient|null first(callable $callback = null, $default = null)
     * @method PersonalAccessClient|null firstWhere(string $key, $operator = null, $value = null)
     * @method PersonalAccessClient|null find($key, $default = null)
     * @method PersonalAccessClient[] all()
     * @method PersonalAccessClient|null last(callable $callback = null, $default = null)
     * @method PersonalAccessClient|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_PersonalAccessClient_C extends _BaseCollection {
        /**
         * @param int $size
         * @return PersonalAccessClient[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method PersonalAccessClient baseSole(array|string $columns = ['*'])
     * @method PersonalAccessClient create(array $attributes = [])
     * @method _IH_PersonalAccessClient_C|PersonalAccessClient[] cursor()
     * @method PersonalAccessClient|null|_IH_PersonalAccessClient_C|PersonalAccessClient[] find($id, array $columns = ['*'])
     * @method _IH_PersonalAccessClient_C|PersonalAccessClient[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method PersonalAccessClient|_IH_PersonalAccessClient_C|PersonalAccessClient[] findOrFail($id, array $columns = ['*'])
     * @method PersonalAccessClient|_IH_PersonalAccessClient_C|PersonalAccessClient[] findOrNew($id, array $columns = ['*'])
     * @method PersonalAccessClient first(array|string $columns = ['*'])
     * @method PersonalAccessClient firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method PersonalAccessClient firstOrCreate(array $attributes = [], array $values = [])
     * @method PersonalAccessClient firstOrFail(array $columns = ['*'])
     * @method PersonalAccessClient firstOrNew(array $attributes = [], array $values = [])
     * @method PersonalAccessClient firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method PersonalAccessClient forceCreate(array $attributes)
     * @method _IH_PersonalAccessClient_C|PersonalAccessClient[] fromQuery(string $query, array $bindings = [])
     * @method _IH_PersonalAccessClient_C|PersonalAccessClient[] get(array|string $columns = ['*'])
     * @method PersonalAccessClient getModel()
     * @method PersonalAccessClient[] getModels(array|string $columns = ['*'])
     * @method _IH_PersonalAccessClient_C|PersonalAccessClient[] hydrate(array $items)
     * @method PersonalAccessClient make(array $attributes = [])
     * @method PersonalAccessClient newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|PersonalAccessClient[]|_IH_PersonalAccessClient_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|PersonalAccessClient[]|_IH_PersonalAccessClient_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method PersonalAccessClient sole(array|string $columns = ['*'])
     * @method PersonalAccessClient updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_PersonalAccessClient_QB extends _BaseBuilder {}
    
    /**
     * @method RefreshToken|$this shift(int $count = 1)
     * @method RefreshToken|null firstOrFail($key = null, $operator = null, $value = null)
     * @method RefreshToken|$this pop(int $count = 1)
     * @method RefreshToken|null get($key, $default = null)
     * @method RefreshToken|null pull($key, $default = null)
     * @method RefreshToken|null first(callable $callback = null, $default = null)
     * @method RefreshToken|null firstWhere(string $key, $operator = null, $value = null)
     * @method RefreshToken|null find($key, $default = null)
     * @method RefreshToken[] all()
     * @method RefreshToken|null last(callable $callback = null, $default = null)
     * @method RefreshToken|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_RefreshToken_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RefreshToken[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method RefreshToken baseSole(array|string $columns = ['*'])
     * @method RefreshToken create(array $attributes = [])
     * @method _IH_RefreshToken_C|RefreshToken[] cursor()
     * @method RefreshToken|null|_IH_RefreshToken_C|RefreshToken[] find($id, array $columns = ['*'])
     * @method _IH_RefreshToken_C|RefreshToken[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RefreshToken|_IH_RefreshToken_C|RefreshToken[] findOrFail($id, array $columns = ['*'])
     * @method RefreshToken|_IH_RefreshToken_C|RefreshToken[] findOrNew($id, array $columns = ['*'])
     * @method RefreshToken first(array|string $columns = ['*'])
     * @method RefreshToken firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RefreshToken firstOrCreate(array $attributes = [], array $values = [])
     * @method RefreshToken firstOrFail(array $columns = ['*'])
     * @method RefreshToken firstOrNew(array $attributes = [], array $values = [])
     * @method RefreshToken firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RefreshToken forceCreate(array $attributes)
     * @method _IH_RefreshToken_C|RefreshToken[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RefreshToken_C|RefreshToken[] get(array|string $columns = ['*'])
     * @method RefreshToken getModel()
     * @method RefreshToken[] getModels(array|string $columns = ['*'])
     * @method _IH_RefreshToken_C|RefreshToken[] hydrate(array $items)
     * @method RefreshToken make(array $attributes = [])
     * @method RefreshToken newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RefreshToken[]|_IH_RefreshToken_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RefreshToken[]|_IH_RefreshToken_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RefreshToken sole(array|string $columns = ['*'])
     * @method RefreshToken updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RefreshToken_QB extends _BaseBuilder {}
    
    /**
     * @method Token|$this shift(int $count = 1)
     * @method Token|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Token|$this pop(int $count = 1)
     * @method Token|null get($key, $default = null)
     * @method Token|null pull($key, $default = null)
     * @method Token|null first(callable $callback = null, $default = null)
     * @method Token|null firstWhere(string $key, $operator = null, $value = null)
     * @method Token|null find($key, $default = null)
     * @method Token[] all()
     * @method Token|null last(callable $callback = null, $default = null)
     * @method Token|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_Token_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Token[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Token baseSole(array|string $columns = ['*'])
     * @method Token create(array $attributes = [])
     * @method _IH_Token_C|Token[] cursor()
     * @method Token|null|_IH_Token_C|Token[] find($id, array $columns = ['*'])
     * @method _IH_Token_C|Token[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Token|_IH_Token_C|Token[] findOrFail($id, array $columns = ['*'])
     * @method Token|_IH_Token_C|Token[] findOrNew($id, array $columns = ['*'])
     * @method Token first(array|string $columns = ['*'])
     * @method Token firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Token firstOrCreate(array $attributes = [], array $values = [])
     * @method Token firstOrFail(array $columns = ['*'])
     * @method Token firstOrNew(array $attributes = [], array $values = [])
     * @method Token firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Token forceCreate(array $attributes)
     * @method _IH_Token_C|Token[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Token_C|Token[] get(array|string $columns = ['*'])
     * @method Token getModel()
     * @method Token[] getModels(array|string $columns = ['*'])
     * @method _IH_Token_C|Token[] hydrate(array $items)
     * @method Token make(array $attributes = [])
     * @method Token newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Token[]|_IH_Token_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Token[]|_IH_Token_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Token sole(array|string $columns = ['*'])
     * @method Token updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Token_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\Laravel\Sanctum {

    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use Laravel\Sanctum\PersonalAccessToken;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method PersonalAccessToken|$this shift(int $count = 1)
     * @method PersonalAccessToken|null firstOrFail($key = null, $operator = null, $value = null)
     * @method PersonalAccessToken|$this pop(int $count = 1)
     * @method PersonalAccessToken|null get($key, $default = null)
     * @method PersonalAccessToken|null pull($key, $default = null)
     * @method PersonalAccessToken|null first(callable $callback = null, $default = null)
     * @method PersonalAccessToken|null firstWhere(string $key, $operator = null, $value = null)
     * @method PersonalAccessToken|null find($key, $default = null)
     * @method PersonalAccessToken[] all()
     * @method PersonalAccessToken|null last(callable $callback = null, $default = null)
     * @method PersonalAccessToken|null sole($key = null, $operator = null, $value = null)
     */
    class _IH_PersonalAccessToken_C extends _BaseCollection {
        /**
         * @param int $size
         * @return PersonalAccessToken[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method PersonalAccessToken baseSole(array|string $columns = ['*'])
     * @method PersonalAccessToken create(array $attributes = [])
     * @method _IH_PersonalAccessToken_C|PersonalAccessToken[] cursor()
     * @method PersonalAccessToken|null|_IH_PersonalAccessToken_C|PersonalAccessToken[] find($id, array $columns = ['*'])
     * @method _IH_PersonalAccessToken_C|PersonalAccessToken[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method PersonalAccessToken|_IH_PersonalAccessToken_C|PersonalAccessToken[] findOrFail($id, array $columns = ['*'])
     * @method PersonalAccessToken|_IH_PersonalAccessToken_C|PersonalAccessToken[] findOrNew($id, array $columns = ['*'])
     * @method PersonalAccessToken first(array|string $columns = ['*'])
     * @method PersonalAccessToken firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method PersonalAccessToken firstOrCreate(array $attributes = [], array $values = [])
     * @method PersonalAccessToken firstOrFail(array $columns = ['*'])
     * @method PersonalAccessToken firstOrNew(array $attributes = [], array $values = [])
     * @method PersonalAccessToken firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method PersonalAccessToken forceCreate(array $attributes)
     * @method _IH_PersonalAccessToken_C|PersonalAccessToken[] fromQuery(string $query, array $bindings = [])
     * @method _IH_PersonalAccessToken_C|PersonalAccessToken[] get(array|string $columns = ['*'])
     * @method PersonalAccessToken getModel()
     * @method PersonalAccessToken[] getModels(array|string $columns = ['*'])
     * @method _IH_PersonalAccessToken_C|PersonalAccessToken[] hydrate(array $items)
     * @method PersonalAccessToken make(array $attributes = [])
     * @method PersonalAccessToken newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|PersonalAccessToken[]|_IH_PersonalAccessToken_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|PersonalAccessToken[]|_IH_PersonalAccessToken_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method PersonalAccessToken sole(array|string $columns = ['*'])
     * @method PersonalAccessToken updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_PersonalAccessToken_QB extends _BaseBuilder {}
}