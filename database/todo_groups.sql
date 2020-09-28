create table if not exists intellivoid_suite.todo_groups
(
    id                     int(255) auto_increment comment 'The Unique Internal Database ID for this record',
    public_id              varchar(255) null comment 'The Public ID for this record',
    account_id             int(255)     null comment 'The Account ID that owns this group task',
    title                  mediumtext   null comment 'The title of the group',
    color                  tinyint      null comment 'The label color for this group',
    is_deleted             tinyint(1)   null comment 'Indicates if this group is marked as deleted',
    last_updated_timestamp int(255)     null comment 'The Unix Timestamp for when this record was last updated',
    created_timestamp      int(255)     null comment 'The Unix Timestamp for when this record was created',
    constraint todo_groups_id_uindex unique (id),
    constraint todo_groups_public_id_uindex unique (public_id)
) comment 'Table of groups for tasks';
alter table intellivoid_suite.`todo_groups` add primary key (id);