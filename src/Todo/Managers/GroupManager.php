<?php


    namespace Todo\Managers;


    use msqg\QueryBuilder;
    use Todo\Abstracts\Color;
    use Todo\Exceptions\DatabaseException;
    use Todo\Exceptions\InvalidGroupTitleException;
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
         * @throws InvalidGroupTitleException
         * @throws DatabaseException
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
                return null;
            }
            else
            {
                throw new DatabaseException($Query, $this->todo->getDatabase()->error);
            }
        }
    }