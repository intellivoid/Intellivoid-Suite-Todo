<?php


    namespace Todo\Utilities;

    use Todo\Exceptions\InvalidGroupTitleException;

    /**
     * Class Validation
     * @package Todo\Utilities
     */
    class Validation
    {
        /**
         * Validates the group title
         *
         * @param $input
         * @param bool $throw_exception
         * @return bool
         * @throws InvalidGroupTitleException
         */
        public static function groupTitle($input, bool $throw_exception=false): bool
        {
            if($input == null)
            {
                if($throw_exception)
                {
                    throw new InvalidGroupTitleException("The group title cannot be null");
                }

                return false;
            }

            if(strlen($input) == 0)
            {
                if($throw_exception)
                {
                    throw new InvalidGroupTitleException("The group title cannot be empty");
                }

                return false;
            }

            if(strlen($input) > 256)
            {
                if($throw_exception)
                {
                    throw new InvalidGroupTitleException("The group title cannot be larger than 256 characters");
                }

                return false;
            }

            return true;
        }
    }