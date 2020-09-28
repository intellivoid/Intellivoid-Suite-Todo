<?php

    use acm\acm;
    use acm\Objects\Schema;

    if(defined("PPM") == false)
    {
        if(class_exists('acm\acm') == false)
        {
            include_once(__DIR__ . DIRECTORY_SEPARATOR . 'acm' . DIRECTORY_SEPARATOR . 'acm.php');
        }
    }

    $acm = new acm(__DIR__, 'todo');

    $DatabaseSchema = new Schema();
    $DatabaseSchema->setDefinition('Host', 'localhost');
    $DatabaseSchema->setDefinition('Port', '3306');
    $DatabaseSchema->setDefinition('Username', 'admin');
    $DatabaseSchema->setDefinition('Password', 'admin');
    $DatabaseSchema->setDefinition('Name', 'intelivoid_suite');
    $acm->defineSchema('Database', $DatabaseSchema);

    $acm->processCommandLine();