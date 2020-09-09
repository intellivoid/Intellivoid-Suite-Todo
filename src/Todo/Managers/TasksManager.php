<?php


    namespace Todo\Managers;


    use msqg\QueryBuilder;
    use Todo\Abstracts\Color;
    use Todo\Abstracts\SearchMethods\TaskSearchMethod;
    use Todo\Exceptions\DatabaseException;
    use Todo\Exceptions\InvalidColorException;
    use Todo\Exceptions\InvalidSearchMethodException;
    use Todo\Exceptions\InvalidTaskDescriptionException;
    use Todo\Exceptions\InvalidTaskTitleException;
    use Todo\Exceptions\TaskNotFoundException;
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
         * @throws InvalidSearchMethodException
         * @throws InvalidTaskDescriptionException
         * @throws InvalidTaskTitleException
         * @throws TaskNotFoundException
         * @noinspection PhpUnused
         */
        public function createTask(int $account_id, string $title, string $description, array $labels=[], int $group_id=null): Task
        {
            Validation::taskTitle($title, true);
            Validation::taskDescription($description, true);

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

            if($description !== null)
            {
                if(strlen($description) == 0)
                {
                    $description = null;
                }
                else
                {
                    $description = $this->todo->getDatabase()->real_escape_string(urlencode($description));
                }
            }

            $Query = QueryBuilder::insert_into("tasks", array(
                "public_id" => $this->todo->getDatabase()->real_escape_string($public_id),
                "account_id" => (int)$account_id,
                "group_id" => $group_id,
                "title" => $this->todo->getDatabase()->real_escape_string(urlencode($title)),
                "description" => $description,
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
                return self::getTask(TaskSearchMethod::byPublicId, $public_id);
            }
            else
            {
                throw new DatabaseException($Query, $this->todo->getDatabase()->error);
            }
        }

        /**
         * Gets an existing task from the database
         *
         * @param string $search_method
         * @param string $value
         * @return Task
         * @throws DatabaseException
         * @throws InvalidSearchMethodException
         * @throws TaskNotFoundException
         * @noinspection PhpUnused
         */
        public function getTask(string $search_method, string $value): Task
        {
            switch($search_method)
            {
                case TaskSearchMethod::byPublicId:
                    $search_method = $this->todo->getDatabase()->real_escape_string($search_method);
                    $value = $this->todo->getDatabase()->real_escape_string($value);
                    break;

                case TaskSearchMethod::byId:
                    $search_method = $this->todo->getDatabase()->real_escape_string($search_method);
                    $value = (int)$value;
                    break;

                default:
                    throw new InvalidSearchMethodException("The search method '" . $search_method . "' is inapplicable to this method");
            }

            $Query = QueryBuilder::select("tasks", array(
                "id",
                "public_id",
                "account_id",
                "group_id",
                "title",
                "description",
                "labels",
                "color",
                "is_completed",
                "is_deleted",
                "properties",
                "last_updated_timestamp",
                "created_timestamp"
            ), $search_method, $value);
            $QueryResults = $this->todo->getDatabase()->query($Query);

            if($QueryResults)
            {
                $Row = $QueryResults->fetch_array(MYSQLI_ASSOC);

                if ($Row == False)
                {
                    throw new TaskNotFoundException();
                }
                else
                {
                    $Row["labels"] = ZiProto::decode($Row["labels"]);
                    $Row["properties"] = ZiProto::decode($Row["properties"]);
                    $Row["title"] = urldecode($Row["title"]);
                    if($Row["description"] !== null)
                    {
                        $Row["description"] = urldecode($Row["description"]);
                    }
                    return(Task::fromArray($Row));
                }
            }
            else
            {
                throw new DatabaseException($Query, $this->todo->getDatabase()->error);
            }
        }

        /**
         * Updates an existing task object from the database
         *
         * @param Task $task
         * @return bool
         * @throws DatabaseException
         * @throws InvalidSearchMethodException
         * @throws InvalidTaskDescriptionException
         * @throws InvalidTaskTitleException
         * @throws TaskNotFoundException
         * @throws InvalidColorException
         * @noinspection PhpUnused
         */
        public function updateTask(Task $task): bool
        {
            self::getTask(TaskSearchMethod::byId, $task->ID);

            Validation::taskTitle($task->Title, true);
            Validation::taskDescription($task->Description, true);
            Validation::color($task->Color, true);

            $validated_labels = [];
            foreach($task->Labels as $label)
            {
                if(Validation::label($label, false))
                {
                    $validated_labels[] = $label;
                }
            }

            if($task->Description !== null)
            {
                if(strlen($task->Description) == 0)
                {
                    $task->Description = null;
                }
                else
                {
                    $task->Description = $this->todo->getDatabase()->real_escape_string(urlencode($task->Description));
                }
            }

            $Query = QueryBuilder::update("tasks", array(
                "group_id" => (int)$task->GroupID,
                "title" => $this->todo->getDatabase()->real_escape_string(urlencode($task->Title)),
                "description" => $task->Description,
                "labels" => $this->todo->getDatabase()->real_escape_string(ZiProto::encode($validated_labels)),
                "color" => (int)$task->Color,
                "is_completed" => (int)$task->IsCompleted,
                "is_deleted" => (int)$task->IsDeleted,
                "properties" => $this->todo->getDatabase()->real_escape_string(ZiProto::encode($task->Properties->toArray())),
                "last_updated_timestamp" => (int)time()
            ), TaskSearchMethod::byId, (int)$task->ID);
            $QueryResults = $this->todo->getDatabase()->query($Query);

            if($QueryResults)
            {
                return true;
            }
            else
            {
                throw new DatabaseException($Query, $this->todo->getDatabase()->error);
            }
        }

        /**
         * Returns all tasks associated with a Account ID
         *
         * @param int $account_id
         * @return Task[]
         * @throws DatabaseException
         * @noinspection PhpUnused
         */
        public function getTasks(int $account_id): array
        {
            $Results = array();
            $Query = QueryBuilder::select("tasks", array(
                "id",
                "public_id",
                "account_id",
                "group_id",
                "title",
                "description",
                "labels",
                "color",
                "is_completed",
                "is_deleted",
                "properties",
                "last_updated_timestamp",
                "created_timestamp"
            ), "account_id", (int)$account_id . "' AND `is_deleted`='0");
            $QueryResults = $this->todo->getDatabase()->query($Query);

            if($QueryResults)
            {
                if($QueryResults->num_rows == 0)
                {
                    return $Results;
                }

                while($row = $QueryResults->fetch_assoc())
                {
                    $row["labels"] = ZiProto::decode($row["labels"]);
                    $row["properties"] = ZiProto::decode($row["properties"]);
                    $row["title"] = urldecode($row["title"]);
                    if($row["description"] !== null)
                    {
                        $row["description"] = urldecode($row["description"]);
                    }
                    $Results[] = Task::fromArray($row);
                }
            }
            else
            {
                throw new DatabaseException($Query, $this->todo->getDatabase()->error);
            }

            return $Results;
        }
    }