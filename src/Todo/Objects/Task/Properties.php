<?php


    namespace Todo\Objects\Task;

    /**
     * Class Properties
     * @package Todo\Objects\Task
     */
    class Properties
    {
        /**
         * @var bool
         */
        public $IsDeleted;

        /**
         * The Unix Timestamp for when this task will be deleted permanently
         *
         * @var int
         */
        public $TimeTillTrueDeleted;

        /**
         * Returns an array which represent this object structure
         *
         * @return array
         */
        public function toArray(): array
        {
            return array(
                "is_deleted" => $this->IsDeleted,
                "time_till_true_deleted" => $this->TimeTillTrueDeleted
            );
        }

        /**
         * Constructs object from array
         *
         * @param array $data
         * @return Properties
         */
        public static function fromArray(array $data): Properties
        {
            $PropertiesObject = new Properties();

            if(isset($data["is_deleted"]))
            {
                $PropertiesObject->IsDeleted = $data["is_deleted"];
            }

            if(isset($data["time_till_true_deleted"]))
            {
                $PropertiesObject->TimeTillTrueDeleted = $data["time_till_true_deleted"];
            }

            return $PropertiesObject;
        }
    }