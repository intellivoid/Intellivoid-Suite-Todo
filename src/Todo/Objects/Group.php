<?php


    namespace Todo\Objects;

    use Todo\Abstracts\Color;

    /**
     * Class Group
     * @package Todo\Objects
     */
    class Group
    {
        /**
         * Unique Internal Database ID
         *
         * @var int
         */
        public $ID;

        /**
         * The Unique Public ID for this group
         *
         * @var string
         */
        public $PublicID;

        /**
         * The Account ID that owns this group
         *
         * @var int
         */
        public $AccountID;

        /**
         * The title for the group
         *
         * @var string
         */
        public $Title;

        /**
         * The color assigned to this group
         *
         * @var int|Color
         */
        public $Color;

        /**
         * Indicates if this group is marked as deleted
         *
         * @var bool
         */
        public $IsDeleted;

        /**
         * The Unix Timestamp for when this group was last updated
         *
         * @var int
         */
        public $LastUpdatedTimestamp;

        /**
         * The Unix Timestamp for when this group was created
         *
         * @var int
         */
        public $CreatedTimestamp;

        /**
         * Returns an array representation of the object
         *
         * @return array
         */
        public function toArray(): array
        {
            return array(
                "id" => $this->ID,
                "public_id" => $this->PublicID,
                "account_id" => $this->AccountID,
                "title" => $this->Title,
                "color" => $this->Color,
                "is_deleted" => $this->IsDeleted,
                "last_updated_timestamp" => $this->LastUpdatedTimestamp,
                "created_timestamp" => $this->CreatedTimestamp
            );
        }

        /**
         * Constructs object from array
         *
         * @param array $data
         * @return Group
         */
        public static function fromArray(array $data): Group
        {
            $GroupObject = new Group();

            if(isset($data["id"]))
            {
                $GroupObject->ID = (int)$data["id"];
            }

            if(isset($data["public_id"]))
            {
                $GroupObject->PublicID = $data["public_id"];
            }

            if(isset($data["account_id"]))
            {
                $GroupObject->AccountID = (int)$data["account_id"];
            }

            if(isset($data["title"]))
            {
                $GroupObject->Title = $data["title"];
            }

            if(isset($data["color"]))
            {
                $GroupObject->Color = $data["color"];
            }

            if(isset($data["is_deleted"]))
            {
                $GroupObject->IsDeleted = (bool)$data["is_deleted"];
            }

            if(isset($data["last_updated_timestamp"]))
            {
                $GroupObject->LastUpdatedTimestamp = (int)$data["last_updated_timestamp"];
            }

            if(isset($data["created_timestamp"]))
            {
                $GroupObject->CreatedTimestamp = (int)$data["created_timestamp"];
            }

            return $GroupObject;
        }
    }