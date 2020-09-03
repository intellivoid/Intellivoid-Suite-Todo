<?php


    namespace Todo\Utilities;

    use Todo\Abstracts\Color;
    use Todo\Exceptions\InvalidColorException;
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

        /**
         * Validates the input
         *
         * @param $input
         * @param bool $throw_exception
         * @return bool
         * @throws InvalidColorException
         */
        public static function color($input, bool $throw_exception=false): bool
        {
            if($input == null)
            {
                if($throw_exception)
                {
                    throw new InvalidColorException("The input cannot be null");
                }

                return false;
            }

            switch((int)$input)
            {
                case Color::None:
                case Color::Red:
                case Color::Blue:
                case Color::Yellow:
                case Color::Green:
                case Color::Pink:
                    return true;

                default:
                    if($throw_exception)
                    {
                        throw new InvalidColorException("The color option is invalid");
                    }

                    return false;
            }
        }
    }