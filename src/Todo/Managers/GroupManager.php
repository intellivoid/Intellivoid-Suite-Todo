<?php


    namespace Todo\Managers;


    use Todo\Todo;

    /**
     * Class GroupManager
     * @package Todo\Managers
     */
    class GroupManager
    {
        /**
         * @var Todo
         */
        private $todo;

        /**
         * GroupManager constructor.
         * @param Todo $todo
         */
        public function __construct(Todo $todo)
        {
            $this->todo = $todo;
        }
    }