<?php
namespace App\Helpers\Pagination;

/**
 * Pagination helper
 */
class Paginate
{
    protected $limit = 0;

    /**
     * Sets the limit value
     * @param int $limit Setter value
     */
    public function __set($key, $value)
    {
        $this->limit = $value;
    }

    /**
     * Gets the limit value
     * @return int Getter value
     */
    public function __get($key)
    {
        return $this->limit;
    }

    /**
     * Paginates by query
     * @param  ServerRequestInterface $request Page Request
     * @param  string $query   Query string
     * @return array           Pagination data
     */
    public function getPagination($request, $query)
    {
        $page      = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
        $skip      = ($page - 1) * $this->limit;
        $count     = $query->count();
        $lastpage  = (ceil($count / $this->limit) == 0 ? 1 : ceil($count / $this->limit));

        return [
            'type'          => 1,
            'needed'        => $count > $this->limit,
            'count'         => $count,
            'page'          => $page,
            'lastpage'      => $lastpage,
            'limit'         => $this->limit,
            'skip'          => $skip
        ];
    }
}
