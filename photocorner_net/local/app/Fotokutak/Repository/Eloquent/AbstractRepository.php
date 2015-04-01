<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */

namespace Fotokutak\Repository\Eloquent;


abstract class AbstractRepository {


    protected $model;


    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    /**
     * @param array $attributes
     * @return mixed
     */
    public function getNew(array $attributes = [])
    {
        return $this->model->newInstance($attributes);
    }
}