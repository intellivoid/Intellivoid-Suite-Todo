<?php


    namespace Todo;

    use acm\acm;
    use Exception;
    use mysqli;
    use Todo\Managers\GroupManager;
    use Todo\Managers\TasksManager;

    require_once(__DIR__ . DIRECTORY_SEPARATOR . "AutoConfig.php");

    /**
     * Class Todo
     * @package Todo
     */
    class Todo
    {
        /**
         * @var acm
         */
        private $acm;

        /**
         * @var mixed
         */
        private $DatabaseConfiguration;

        /**
         * @var mixed
         */
        private $ServerConfiguration;

        /**
         * @var mysqli|null
         */
        private $database;

        /**
         * @var GroupManager
         */
        private $GroupManager;

        /**
         * @var TasksManager
         */
        private $TasksManager;

        /**
         * Todo constructor.
         * @throws Exception
         */
        public function __construct()
        {
            $this->acm = new acm(__DIR__, 'CoffeeHouse');
            $this->DatabaseConfiguration = $this->acm->getConfiguration('Database');
            $this->ServerConfiguration = $this->acm->getConfiguration('CoffeeHouseServer');
            $this->database = null;

            $this->GroupManager = new GroupManager($this);
            $this->TasksManager = new TasksManager($this);
        }

        /**
         * @return mysqli
         * @noinspection PhpUnused
         */
        public function getDatabase()
        {
            if($this->database == null)
            {
                $this->database = new mysqli(
                    $this->DatabaseConfiguration['Host'],
                    $this->DatabaseConfiguration['Username'],
                    $this->DatabaseConfiguration['Password'],
                    $this->DatabaseConfiguration['Name'],
                    $this->DatabaseConfiguration['Port']
                );
            }

            return $this->database;
        }

        /**
         * @return GroupManager
         * @noinspection PhpUnused
         */
        public function getGroupManager(): GroupManager
        {
            return $this->GroupManager;
        }

        /**
         * @return TasksManager
         * @noinspection PhpUnused
         */
        public function getTasksManager(): TasksManager
        {
            return $this->TasksManager;
        }
    }