<?php


    namespace Todo\Exceptions;


    use Exception;
    use Throwable;

    /**
     * Class InvalidColorException
     * @package Todo\Exceptions
     */
    class InvalidColorException extends Exception
    {
        /**
         * InvalidColorException constructor.
         * @param string $message
         * @param int $code
         * @param Throwable|null $previous
         */
        public function __construct($message = "", $code = 0, Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
    }