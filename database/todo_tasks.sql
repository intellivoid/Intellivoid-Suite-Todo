create table if not exists intellivoid_suite.todo_tasks
(
    id                     int(255) auto_increment comment 'Unique Internal Database ID',
    public_id              varchar(255) null comment 'The public ID for this task record',
    account_id             int(255)     null comment 'The Account ID that owns this record',
    group_id               int(255)     null comment 'The group ID that this task belongs to',
    title                  mediumtext   null comment 'The Title of the task',
    description            longtext     null comment 'The description of the task',
    labels                 blob         null comment 'ZiProto Encoded array of labels associated with this task',
    color                  tinyint      null comment 'The color assigned to this task',
    is_completed           tinyint(1)   null comment 'Indicates if this task is marked as completed',
    is_deleted             tinyint(1)   null comment 'Indicates if this record is marked as deleted (Unrecoverable)',
    properties             blob         null comment 'ZiProto Encoded Properties Object that holds information about the task',
    last_updated_timestamp int(255)     null comment 'The Unix Timestmap of when this record was last updated',
    created_timestamp      int(255)     null comment 'The Unix Timestamp for when this record was created',
    constraint todo_tasks_id_uindex unique (id),
    constraint todo_tasks_public_id_uindex unique (public_id)
) comment 'The table for storing Todo tasks';
alter table intellivoid_suite.todo_tasks add primary key (id);

