<?php


    namespace Todo\Managers;


    use msqg\QueryBuilder;
    use Todo\Abstracts\Color;
    use Todo\Abstracts\SearchMethods\GroupSearchMethod;
    use Todo\Exceptions\DatabaseException;
    use Todo\Exceptions\GroupNotFoundException;
    use Todo\Exceptions\InvalidGroupTitleException;
    use Todo\Exceptions\InvalidSearchMethodException;
    use Todo\Objects\Group;
    use Todo\Todo;
    use Todo\Utilities\Hashing;
    use Todo\Utilities\Validation;

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

        /**
         * Creates a new group record in the database
         *
         * @param int $account_id
         * @param string $title
         * @return Group
         * @throws DatabaseException
         * @throws GroupNotFoundException
         * @throws InvalidGroupTitleException
         * @throws InvalidSearchMethodException
         * @noinspection PhpUnused
         */
        public function createGroup(int $account_id, string $title): Group
        {
            Validation::groupTitle($title, true);

            $CreatedTimestamp = (int)time();
            $PublicID = Hashing::groupPublicId($account_id, $title, $CreatedTimestamp);

            $Query = QueryBuilder::insert_into("groups", array(
                "public_id" => $this->todo->getDatabase()->real_escape_string($PublicID),
                "account_id" => (int)$account_id,
                "title" => $this->todo->getDatabase()->real_escape_string(urlencode($title)),
                "color" => (int)Color::None,
                "is_deleted" => 0,
                "last_updated_timestamp" => $CreatedTimestamp,
                "created_timestamp" => $CreatedTimestamp
            ));

            $QueryResults = $this->todo->getDatabase()->query($Query);
            if($QueryResults)
            {
                // TODO: Return the group object from the database
                return self::getGroup(GroupSearchMethod::byPublicId, $PublicID);
            }
            else
            {
                throw new DatabaseException($Query, $this->todo->getDatabase()->error);
            }
        }

        /**
         * Finds a group object from the database
         *
         * @param string|GroupSearchMethod $search_method
         * @param string $value
         * @return Group
         * @throws DatabaseException
         * @throws GroupNotFoundException
         * @throws InvalidSearchMethodException
         * @noinspection PhpUnused
         */
        public function getGroup(string $search_method, string $value): Group
        {
            switch($search_method)
            {
                case GroupSearchMethod::byPublicId:
                    $search_method = $this->todo->getDatabase()->real_escape_string($search_method);
                    $value = $this->todo->getDatabase()->real_escape_string($value);
                    break;

                case GroupSearchMethod::byId:
                    $search_method = $this->todo->getDatabase()->real_escape_string($search_method);
                    $value = (int)$value;
                    break;

                default:
                    throw new InvalidSearchMethodException("The search method '" . $search_method . "' is inapplicable to this method");
            }

            $Query = QueryBuilder::select("groups", array(
                "id",
                "public_id",
                "account_id",
                "title",
                "color",
                "is_deleted",
                "last_updated_timestamp",
                "created_timestamp"
            ), $search_method, $value);
            $QueryResults = $this->todo->getDatabase()->query($Query);

            if($QueryResults)
            {
                $Row = $QueryResults->fetch_array(MYSQLI_ASSOC);

                if ($Row == False)
                {
                    throw new GroupNotFoundException();
                }
                else
                {
                    return(Group::fromArray($Row));
                }
            }
            else
            {
                throw new DatabaseException($Query, $this->todo->getDatabase()->error);
            }
        }
    }