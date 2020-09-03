<?php


    namespace Todo\Managers;


    use msqg\QueryBuilder;
    use Todo\Abstracts\Color;
    use Todo\Exceptions\DatabaseException;
    use Todo\Exceptions\InvalidTaskDescriptionException;
    use Todo\Exceptions\InvalidTaskTitleException;
    use Todo\Objects\Task;
    use Todo\Todo;
    use Todo\Utilities\Hashing;
    use Todo\Utilities\Validation;
    use ZiProto\ZiProto;

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

        /**
         * Creates a new task and registers it into the database
         *
         * @param int $account_id
         * @param string $title
         * @param string $description
         * @param array $labels
         * @param int|null $group_id
         * @return Task
         * @throws DatabaseException
         * @throws InvalidTaskDescriptionException
         * @throws InvalidTaskTitleException
         * @noinspection PhpUnused
         */
        public function createTask(int $account_id, string $title, string $description, array $labels=[], int $group_id=null): Task
        {
            Validation::taskTitle($title);
            Validation::taskDescription($description);

            $validated_labels = [];
            foreach($labels as $label)
            {
                if(Validation::label($label, false))
                {
                    $validated_labels[] = $label;
                }
            }

            $created_timestamp = (int)time();
            $public_id = Hashing::taskPublicId($account_id, $title, $description, $created_timestamp);
            $properties = new Task\Properties();
            if($group_id !== null)
            {
                $group_id = (int)$group_id;
            }

            $Query = QueryBuilder::insert_into("tasks", array(
                "public_id" => $this->todo->getDatabase()->real_escape_string($public_id),
                "account_id" => (int)$account_id,
                "group_id" => $group_id,
                "title" => $this->todo->getDatabase()->real_escape_string($title),
                "description" => $this->todo->getDatabase()->real_escape_string($description),
                "labels" => $this->todo->getDatabase()->real_escape_string(ZiProto::encode($labels)),
                "color" => (int)Color::None,
                "is_completed" => (int)false,
                "is_deleted" => (int)false,
                "properties" => $this->todo->getDatabase()->real_escape_string(ZiProto::encode($properties->toArray())),
                "last_updated_timestamp" => (int)time(),
                "created_timestamp" => (int)time()
            ));
            $QueryResults = $this->todo->getDatabase()->query($Query);
            if($QueryResults)
            {
                // TODO: Add the ability to return the task
                return null;
            }
            else
            {
                throw new DatabaseException($Query, $this->todo->getDatabase()->error);
            }
        }
    }