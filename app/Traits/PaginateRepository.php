<?php

namespace App\Traits;

use Auth;
use Schema;
use Storage;

trait PaginateRepository
{
    private function searchQuery($result, &$query, $table)
    {
        if (isset($query['s'])) { //search
            $s = $query['s'];
            unset($query['s']);
            $columns = Schema::getColumnListing($table);

            $result->where(function ($query) use ($columns, $s) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', '%'.$s.'%');
                }
            });
        }

        return $result;
    }

    private function select($result, &$query)
    {
        if (isset($query['select'])) {
            $selectArray = str_replace(' ', '', $query['select']);
            $selectArray = explode(',', $selectArray);
            $result->select(...$selectArray);
            unset($query['select']);
        }

        return $result;
    }

    private function whereIn($result, &$query)
    {
        if (isset($query['whereIn'])) {
            $explode = str_replace(' ', '', $query['whereIn']);
            $explode = explode(':', $explode);
            $column = $explode[0];
            $whereIn = explode(',', $explode[1]);
            $result->whereIn($column, $whereIn);
            unset($query['whereIn']);
        }

        return $result;
    }

    private function with($result, &$query)
    {
        if (isset($query['with'])) {
            $selectArray = str_replace(' ', '', $query['with']);
            $selectArray = explode('|', $selectArray);

            error_log(print_r($selectArray, true));
            $result->with(...$selectArray);
            unset($query['with']);
        }

        return $result;
    }

    private function filterColumn(&$result, $query, $table)
    {
        foreach ($query as $key => $value) {  //filter column
            if ($key == 'perPage' || $key == 'page') {
                continue;
            }

            if (Schema::hasColumn($table, $key)) {
                $result->where($key, $value);
            } else {
                return 'La columna '.$key.' no existe';
            }
        }

        return false;
    }

    public function query($class, $query, $fn = null, $map = null)
    {
        $result = ($class)::orderBy('created_at', 'DESC');
        if ($fn != null) {
            $result = $fn($result);
        }

        $result = $this->select($result, $query);
        $result = $this->with($result, $query);
        $result = $this->whereIn($result, $query);

        $table = (new $class)->getTable();

        $result = $this->searchQuery($result, $query, $table);

        $error = $this->filterColumn($result, $query, $table);

        if ($error) {
            return bad_request($error, $query);
        }

        $perPage = 10;
        if (isset($query['perPage'])) {  //pagination
            $perPage = $query['perPage'];
            unset($query['perPage']);
        }

        if (isset($query['page'])) {
            $rows = $result;

            $rows = $rows->count();
            $pages = ceil($rows / $perPage);

            $page = $query['page'];
            unset($query['page']);
            $skip = ($page * $perPage) - $perPage;
            $result->skip($skip)->take($perPage);

            $result = $result->get();
            if ($map) {
                $result = $map($result);
            }

            return ok('', [
                'rows' => $rows,
                'pages' => $pages,
                'current' => $page,
                'next' => $page >= $pages ? $page : $page + 1,
                'prev' => $page <= 1 ? 1 : $page - 1,
                'data' => $this->toTranslate($result),
            ]);
        }

        $result = $result->get();
        if ($map) {
            $result = $map($result);
        }

        return ok('', $this->toTranslate($result));
    }

    private function translateText($object, $language = [])
    {
        if (is_object($object)) {
            try {
                $object = $object->toArray();
            } catch (\Error $e) {
                $object = (array) $object;
            }
        }

        foreach ($object as $key => $value) {
            error_log($key);
            if (is_array($value) || is_object($value)) {
                $object[$key] = $this->translateText($value, $language);
            }

            if (is_string($value)) {
                $object[$key] = $language[$value] ?? $value;
            }
        }

        return  $object;
    }

    public function toTranslate($object)
    {
        $language = Auth::user()->profile['language'] ?? false;
        $translate = '[]';

        if ($language) {
            try {
                $translate = Storage::disk('s3')->get('/lang/'.$language.'.json');
            } catch (\Exception $e) {
                error_log($e);
                $translate = '[]';
            }
        }

        $translate = json_decode($translate, true);

        return $this->translateText($object, $translate);
    }
}
