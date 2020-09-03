<?php


    namespace Todo\Objects;


    use Todo\Abstracts\Color;
    use Todo\Objects\Task\Properties;

    /**
     * Class Task
     * @package Todo\Objects
     */
    class Task
    {
        /**
         * Unique Internal Database ID for this task
         *
         * @var int
         */
        public $ID;

        /**
         * The Public ID for this task
         *
         * @var string
         */
        public $PublicID;

        /**
         * The Account ID that owns this task record
         *
         * @var int
         */
        public $AccountID;

        /**
         * The ID of the group that this task belongs to if any
         *
         * @var int|null
         */
        public $GroupID;

        /**
         * The title of the task
         *
         * @var string
         */
        public $Title;

        /**
         * The description for this task
         *
         * @var string
         */
        public $Description;

        /**
         * Labels associated with this task
         *
         * @var string[]
         */
        public $Labels;

        /**
         * The color associated with this task
         *
         * @var int|Color
         */
        public $Color;

        /**
         * Indicates if this task was completed
         *
         * @var bool
         */
        public $IsCompleted;

        /**
         * Indicates if this task has been permanently deleted
         *
         * @var bool
         */
        public $IsDeleted;

        /**
         * Properties related to this task
         *
         * @var Properties
         */
        public $Properties;

        /**
         * The Unix Timestamp for when this record was last updated
         *
         * @var int
         */
        public $LastUpdatedTimestamp;

        /**
         * The Unix Timestamp for when this record was created
         *
         * @var int
         */
        public $CreatedTimestamp;

        /**
         * Returns an array which represents this object
         *
         * @return array
         */
        public function toArray(): array
        {
            return array(
                "id" => $this->ID,
                "public_id" => $this->PublicID,
                "account_id" => $this->AccountID,
                "group_id" => $this->GroupID,
                "title" => $this->Title,
                "description" => $this->Description,
                "labels" => $this->Labels,
                "color" => $this->Color,
                "is_completed" => $this->IsCompleted,
                "is_deleted" => $this->IsDeleted,
                "properties" => $this->Properties->toArray(),
                "last_updated_timestamp" => $this->LastUpdatedTimestamp,
                "created_timestamp" => $this->CreatedTimestamp
            );
        }

        /**
         * Constructs object from array
         *
         * @param array $data
         * @return Task
         */
        public static function fromArray(array $data): Task
        {
            $TaskObject = new Task();

            if(isset($data["id"]))
            {
                $TaskObject->ID = $data["id"];
            }

            if(isset($data["public_id"]))
            {
                $TaskObject->PublicID = $data["public_id"];
            }

            if(isset($data["account_id"]))
            {
                $TaskObject->AccountID = $data["account_id"];
            }

            if(isset($data["group_id"]))
            {
                $TaskObject->GroupID = $data["group_id"];
            }

            if(isset($data["title"]))
            {
                $TaskObject->Title = $data["title"];
            }

            if(isset($data["description"]))
            {
                $TaskObject->Description = $data["description"];
            }

            if(isset($data["labels"]))
            {
                $TaskObject->Labels = $data["labels"];
            }

            if(isset($data["color"]))
            {
                $TaskObject->Color = $data["color"];
            }

            if(isset($data["is_completed"]))
            {
                $TaskObject->IsCompleted = $data["is_completed"];
            }

            if(isset($data["is_deleted"]))
            {
                $TaskObject->IsDeleted = $data["is_deleted"];
            }

            if(isset($data["properties"]))
            {
                $TaskObject->Properties = Properties::fromArray($data["properties"]);
            }

            if(isset($data["last_updated_timestamp"]))
            {
                $TaskObject->LastUpdatedTimestamp = $data["last_updated_timestamp"];
            }

            if(isset($data["created_timestamp"]))
            {
                $TaskObject->CreatedTimestamp = $data["created_timestamp"];
            }

            return $TaskObject;
        }
    }