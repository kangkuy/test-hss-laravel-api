<?php

namespace App\Helpers;

class Datatable
{
    protected $request;
    protected $query;
    protected $columns = [];

    protected $start;
    protected $length;
    protected $search;

    public function __construct($request, $query)
    {
        $this->request = $request;
        $this->query   = $query;

        $this->start  = (int) $request->get('start', 0);
        $this->length = (int) $request->get('length', 10);
        $this->search = data_get($request->all(), 'search.value', '');
    }

    public static function make($request, $query)
    {
        return new static($request, $query);
    }

    public function query()
    {
        return $this->query;
    }

    /** Jika query sudah diubah di controller, bisa di-set ulang */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    public function addColumn(string $key,\Closure $callback)
    {
        $this->columns[$key] = $callback;
        return $this;
    }

    public function response()
    {
        $recordsTotal    = (clone $this->query)->count();
        $recordsFiltered = (clone $this->query)->count();

        $query = (clone $this->query);

        if ($this->length > 0) {
            $items = $query->skip($this->start)->take($this->length)->cursor();
        } else {
            $items = $query->cursor();
        }

        $rows = [];
        foreach ($items as $item) {
            $row = [];
            foreach ($this->columns as $key => $callback) {
                $row[$key] = $callback($item);
            }
            $rows[] = $row;
        }

        return response()->json([
            'draw'            => intval($this->request->get('draw')),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $rows,
            'start'             => $this->start,
            'length'             => $this->length,
            'search'             => $this->request->get('search'),
            'success'           => true,
            'message'           => 'Data berhasil ditampilkan'

        ]);
    }
}
