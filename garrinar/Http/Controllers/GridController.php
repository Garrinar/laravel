<?php

namespace Garrinar\Http\Controllers {


    use Garrinar\Http\Response\GridResponse;
    use Garrinar\Models\Eloquent\Builder;
    use Garrinar\Models\Eloquent\Model;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;

    abstract class GridController extends AjaxController
    {
        /**
         * @var Model
         */
        protected $model;

        /** @var  Builder */
        protected $query;


        public function __construct(Model $model)
        {
            if (!$this->request()->ajax()) {
                abort(401);
            }

            $this->model = $model;
            $this->query = $this->model->query();
        }

        protected function getQuery()
        {
            return $this->query;
        }

        protected function getModel()
        {
            return $this->model;
        }

        protected function execute()
        {
            return $this->getQuery()->get($this->getModel()->getVisible())->toArray();
        }

        public function response($data = [], $status = Response::HTTP_OK)
        {
            $result = $this->execute();
            $data['data'] = $this->prepareData($result);
            return
                new GridResponse($data);
        }

        public function get()
        {
            return $this->response();
        }

        public function filter(Request $request)
        {
            $this
                ->getQuery()
                ->where($request->toArray());
            return
                $this->response();
        }

        public function sort(Request $request)
        {
            $this
                ->getQuery()
                ->where($request->toArray());
            return $this->response();
        }

        protected function onRowPrepare($row)
        {
            return $row;
        }

        protected function onDataPrepare($data)
        {
            return $data;
        }

        /**
         * @param array $items
         * @return array
         */
        protected function prepareData(array $items)
        {
            if (method_exists($this, 'onDataPrepare')) {
                $items = $this->onDataPrepare($items);
            }

            return
                collect($items)
                    ->map(function ($item) {
                        if (method_exists($this, 'onRowPrepare')) {
                            $item = $this->onRowPrepare($item);
                        }
                        return
                            collect($item)
                                ->values();
                    })
                    ->toArray();
        }
    }
}
