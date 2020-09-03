<?php


    namespace Todo\Utilities;

    /**
     * Class Hashing
     * @package Todo\Utilities
     */
    class Hashing
    {
        /**
         * Peppers a hash using whirlpool
         *
         * @param string $Data The hash to pepper
         * @param int $Min Minimal amounts of executions
         * @param int $Max Maximum amount of executions
         * @return string
         * @noinspection PhpUnused
         */
        public static function pepper(string $Data, int $Min = 100, int $Max = 1000): string
        {
            $n = rand($Min, $Max);
            $res = '';
            $Data = hash('whirlpool', $Data);
            for ($i=0,$l=strlen($Data) ; $l ; $l--)
            {
                $i = ($i+$n-1) % $l;
                $res = $res . $Data[$i];
                $Data = ($i ? substr($Data, 0, $i) : '') . ($i < $l-1 ? substr($Data, $i+1) : '');
            }
            return($res);
        }

        /**
         * Generates a Group Public ID
         *
         * @param int $account_id
         * @param string $title
         * @param int $created_timestamp
         * @return string
         */
        public static function groupPublicId(int $account_id, string $title, int $created_timestamp): string
        {
            return hash("sha256",
                self::pepper($account_id . $created_timestamp) . $title . $created_timestamp . $account_id);
        }

        /**
         * Generates a Task Public ID
         *
         * @param int $account_id
         * @param string $title
         * @param string|null $description
         * @param int $created_timestamp
         * @return string
         * @noinspection PhpUnused
         */
        public static function taskPublicId(int $account_id, string $title, string $description, int $created_timestamp): string
        {
            if($description == null)
            {
                return hash("sha256",
                    self::pepper($account_id . $created_timestamp) . $title . $created_timestamp . $account_id
                );
            }
            else
            {
                return hash("sha256",
                    self::pepper($account_id . $created_timestamp . $description) . $title . $created_timestamp . $account_id . $description
                );
            }
        }

    }