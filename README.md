# Laravel Guardian

Laravel Guardian makes it easy to perform authorization


```php
<?php

namespace App\Guardian\Traits;

use Illuminate\Support\Facades\DB;

trait QueryKit
{
    /**
     * Insert new rows or update existed rows
     *
     * @param array $data
     * @param array $insertKeys
     * @param array $updateKeys
     *
     * @return void
     */
    public static function insertDuplicate(array $data, array $insertKeys, array $updateKeys)
    {
        $model = new static;
        $query = "INSERT INTO {$model->getTable()} __INSERTKEYS__ VALUES __INSERTVALUE__ ON DUPLICATE KEY UPDATE __UPDATEVALUES__";
        $tmpInKeys = array_fill_keys($insertKeys, null);
        $tmpUpKeys = array_fill_keys($updateKeys, null);

        try {
            DB::beginTransaction();
            foreach ($data as $item) {
                $insertValue = array_intersect_key($item, $tmpInKeys);

                $updateValue = implode(', ', array_map(
                    function ($v, $k) { return sprintf("`%s`='%s'", $k, $v); },
                    array_intersect_key($item, $tmpUpKeys),
                    $updateKeys
                ));

                $statement = str_replace(
                    ['__INSERTKEYS__', '__INSERTVALUE__', '__UPDATEVALUES__'],
                    ["(`" . implode("`,`", $insertKeys) . "`)", "('" . implode("','", $insertValue) . "')", $updateValue],
                    $query
                );
                DB::statement($statement);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            throw new \Exception($e->getMessage());
        }
    }
}

```
