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
        protected $perPage = 15;
        protected $currentPage = 1;

        /**
         * @var Model
         */
        protected $model;

        /** @var  Builder */
        protected $query;


        public function __construct()
        {
            if (!$this->request()->ajax()) {
                abort(401);
            }

            $this->currentPage = $this->request()->get('page', 1);
        }

        protected function getQuery()
        {
            return $this->query;
        }

        protected function getModel()
        {
            return $this->model;
        }

        protected function setModel($model)
        {
            $this->model = $model;
            $this->query = $this->model->query();
        }

        protected function execute()
        {
            return
                $this
                    ->getQuery()
                    ->get($this->getModel()->getVisible());
//                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
        }

        public function response($data = [], $status = Response::HTTP_OK)
        {
            $data['data'] = $this->prepareData($this->execute());
            return
                new GridResponse($data);
        }

        public function get()
        {
            $this->getQuery()->select($this->getModel()->getVisible());
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

        protected function onDataPrepare($row)
        {
            return $row;
        }

        /**
         * @param array $items
         * @return array
         */
        protected function prepareData(array $items)
        {
            if (method_exists($this, 'onDataPrepare')) {
                $items = $item = $this->onRowPrepare($items);
            }

            return collect($items)
                ->map(function ($item) {
                    if (method_exists($this, 'onRowPrepare')) {
                        $item = $this->onRowPrepare($item);
                    }
                    return
                        collect($item)
                            ->only($this->getModel()->getVisible())
                            ->values();
                })->toArray();
        }
    }
}
