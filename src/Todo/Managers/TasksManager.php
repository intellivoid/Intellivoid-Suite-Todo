<?php


    namespace Todo\Managers;


    use Todo\Todo;

    /**
     * Class TasksManager
     * @package Todo\Managers
     */
    class TasksManager
    {
        /**
         * @var Todo
         */
        private $todo;

        /**
         * TasksManager constructor.
         * @param Todo $todo
         */
        public function __construct(Todo $todo)
        {
            $this->todo = $todo;
        }
    }