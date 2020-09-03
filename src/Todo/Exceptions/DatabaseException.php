<?php


    namespace Todo\Exceptions;


    use Exception;

    /**
     * Class DatabaseException
     * @package Todo\Exceptions
     */
    class DatabaseException extends Exception
    {
        /**
         * @var string
         */
        private $query;

        /**
         * @var string
         */
        private $error_message;

        /**
         * DatabaseException constructor.
         * @param string $query
         * @param string $error_message
         */
        public function __construct(string $query, string $error_message)
        {
            parent::__construct($error_message, 0, null);
            $this->query = $query;
            $this->error_message = $error_message;
        }

        /**
         * @return string
         */
        public function getQuery(): string
        {
            return $this->query;
        }

        /**
         * @return string
         */
        public function getErrorMessage(): string
        {
            return $this->error_message;
        }
    }