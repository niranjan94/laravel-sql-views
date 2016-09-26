<?php
/**
 * Created by PhpStorm.
 * User: niranjan94
 * Date: 9/26/16
 * Time: 11:43 AM
 */

namespace CodeZero\LaravelSqlViews;


use Illuminate\Support\Facades\DB;

abstract class BaseSqlViewMigration
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    abstract function getQuery();
    abstract function getViewName();

    function createView() {
        $sqlQuery = $this->getQuery()->toSql();
        DB::statement("CREATE OR REPLACE VIEW {$this->getViewName()} AS {$sqlQuery}");
    }

    function dropView() {
        DB::statement("DROP VIEW IF EXISTS {$this->getViewName()}");
    }
}