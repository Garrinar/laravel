<?php

namespace Garrinar\Models\Eloquent{

    use Garrinar\Traits\ErrorsTrait;
    use Illuminate\Database\Eloquent\Model as EloquentModel;

    /**
     * Class Model
     * @package Garrinar\Models\Eloquent
     */
    class Model extends EloquentModel
    {
        use ErrorsTrait;

        protected $validationRules = [];

        /**
         * Create a new Eloquent query builder for the model.
         *
         * @param  \Illuminate\Database\Query\Builder $query
         * @return \Illuminate\Database\Eloquent\Builder|static
         */
        public function newEloquentBuilder($query)
        {
            return new Builder($query);
        }

        /**
         * @return Builder
         */
        public static function query()
        {
            return parent::query();
        }

        public function relation($related, $foreignKey = null, $otherKey = null, $relation = null)
        {
            return $this->belongsTo($related)->firstOrNew([]);
        }
    }
}
