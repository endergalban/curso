<?php

namespace App;

use Illuminate\Support\Arr;

class Sortable
{
    protected $currentUrl;
    protected $query = [];

    public function __construct($currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }

    public function appends($query)
    {
        $this->query = $query;
    }

    public function url($column)
    {
      if ($this->isSortingBy($column)) {
        return $this->buildSortableUrl("{$column}-desc");
      }

      return $this->buildSortableUrl($column);
    }

    protected function buildSortableUrl($order)
    {
      return $this->currentUrl.'?'.Arr::query(array_merge($this->query, ['order' => $order]));
    }

    public function classes($column)
    {
        if ($this->isSortingBy($column)) {
          return 'arrow_drop_up';
        }

        if ($this->isSortingBy("{$column}-desc")) {
            return 'arrow_drop_down';
        }

        return 'unfold_more';
    }

    protected function isSortingBy($column)
    {
        return Arr::get($this->query, 'order') == $column;
    }

}
