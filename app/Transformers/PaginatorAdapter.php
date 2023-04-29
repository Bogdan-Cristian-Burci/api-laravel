<?php

    namespace App\Transformers;

    use League\Fractal\Pagination\PaginatorInterface;
    use Illuminate\Contracts\Pagination\Paginator;

    class PaginatorAdapter implements PaginatorInterface{

        /**
         * The paginator instance
         * @var Paginator
         */
        protected Paginator $paginator;

        /**
         * Create a new pagination adapter
         * @param Paginator $paginator
         * @return void
         */
        public function __construct(Paginator $paginator){
            $this->paginator=$paginator;
        }

        /**
         * Get the current page
         * @return int
         */
        public function getCurrentPage(): int
        {
            return $this->paginator->currentPage();
        }

        /**
         * Get the last page
         * @return int
         */
        public function getLastPage(): int
        {
            return $this->paginator->hasMorePages()? $this->getCurrentPage() + 1 : $this->getCurrentPage();
        }

        /**
         * Get the total
         * @return int
         */
        public function getTotal(): int
        {
            return count($this->paginator->items());
        }

        /**
         * Get the count
         * @return int
         */
        public function getCount(): int
        {
            return count($this->paginator->items());
        }

        /**
         * Get the number per page
         * @return int
         */
        public function getPerPage(): int
        {
            return $this->paginator->perPage();
        }

        /**
         * Get the url for a given page
         * @param int $page
         * @return string
         */
        public function getUrl(int $page): string
        {
            return $this->paginator->url($page);
        }

        /**
         * Get paginator instance
         * @return Paginator
         */
        public function getPaginator(): Paginator
        {
            return $this->paginator;
        }
    }
