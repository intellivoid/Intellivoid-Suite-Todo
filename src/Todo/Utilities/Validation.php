<?php


    namespace Todo\Utilities;

    use Todo\Abstracts\Color;
    use Todo\Exceptions\InvalidColorException;
    use Todo\Exceptions\InvalidGroupTitleException;
    use Todo\Exceptions\InvalidTaskDescriptionException;
    use Todo\Exceptions\InvalidTaskTitleException;

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

        /**
         * Validates the task title
         *
         * @param $input
         * @param bool $throw_exception
         * @return bool
         * @throws InvalidTaskTitleException
         * @noinspection PhpUnused
         */
        public static function taskTitle($input, bool $throw_exception=false): bool
        {
            if($input == null)
            {
                if($throw_exception)
                {
                    throw new InvalidTaskTitleException("The task title cannot be null");
                }

                return false;
            }

            if(strlen($input) == 0)
            {
                if($throw_exception)
                {
                    throw new InvalidTaskTitleException("The task title cannot be empty");
                }

                return false;
            }

            if(strlen($input) > 526)
            {
                if($throw_exception)
                {
                    throw new InvalidTaskTitleException("The task title cannot be larger than 526 characters");
                }

                return false;
            }

            return true;
        }

        /**
         * Validates the task description, won't cause invalidation if the input is null
         *
         * @param $input
         * @param bool $throw_exception
         * @return bool
         * @throws InvalidTaskDescriptionException
         * @noinspection PhpUnused
         */
        public static function taskDescription($input, bool $throw_exception=false): bool
        {
            if($input == null)
            {
                return true;
            }

            if(strlen($input) == 0)
            {
                return true;
            }

            if(strlen($input) > 2526)
            {
                if($throw_exception)
                {
                    throw new InvalidTaskDescriptionException("The task title cannot be larger than 2526 characters");
                }

                return false;
            }

            return true;
        }

        /**
         * Validates a label
         *
         * @param $input
         * @param bool $throw_exception
         * @return bool
         * @throws InvalidTaskTitleException
         */
        public static function label($input, bool $throw_exception=false): bool
        {
            if($input == null)
            {
                if($throw_exception)
                {
                    throw new InvalidTaskTitleException("The label cannot be null");
                }

                return false;
            }

            if(strlen($input) == 0)
            {
                if($throw_exception)
                {
                    throw new InvalidTaskTitleException("The label cannot be empty");
                }

                return false;
            }

            if(strlen($input) > 64)
            {
                if($throw_exception)
                {
                    throw new InvalidTaskTitleException("The label cannot be larger than 64 characters");
                }

                return false;
            }

            return true;
        }
    }