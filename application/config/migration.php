<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Enable/Disable Migrations
|--------------------------------------------------------------------------
|
| Migrations are disabled by default for security reasons.
| You should enable migrations whenever you intend to do a schema migration
| and disable it back when you're done.
|
*/
$config['migration_enabled'] = TRUE;

/*
|--------------------------------------------------------------------------
| Migration Type
|--------------------------------------------------------------------------
|
| Migration file names may be based on a sequential identifier or on
| a timestamp. Options are:
|
|   'sequential' = Sequential migration naming (001_add_blog.php)
|   'timestamp'  = Timestamp migration naming (20121031104401_add_blog.php)
|                  Use timestamp format YYYYMMDDHHIISS.
|
| Note: If this configuration value is missing the Migration library
|       defaults to 'sequential' for backward compatibility with CI2.
|
*/
$config['migration_type'] = 'timestamp';

/*
|--------------------------------------------------------------------------
| Migrations table
|--------------------------------------------------------------------------
|
| This is the name of the table that will store the current migrations state.
| When migrations runs it will store in a database table which migration
| level the system is at. It then compares the migration level in this
| table to the $config['migration_version'] if they are not the same it
| will migrate up. This must be set.
|
*/
$config['migration_table'] = 'migrations';

/*
|--------------------------------------------------------------------------
| Auto Migrate To Latest
|--------------------------------------------------------------------------
|
| If this is set to TRUE when you load the migrations class and have
| $config['migration_enabled'] set to TRUE the system will auto migrate
| to your latest migration (whatever $config['migration_version'] is
| set to). This way you do not have to call migrations anywhere else
| in your code to have the latest migration.
|
*/
$config['migration_auto_latest'] = FALSE;

/*
|--------------------------------------------------------------------------
| Migrations version
|--------------------------------------------------------------------------
|
| This is used to set migration version that the file system should be on.
| If you run $this->migration->current() this is the version that schema will
| be upgraded / downgraded to.
|
*/
//$config['migration_version'] = '';  // initial db

//$config['migration_version'] = 20200308154940; // Add_about_us_table
//$config['migration_version'] = 20200308155500; // Add_topic_entities_trans_table
//$config['migration_version'] = 20200308155800; // Add_topics_table
//$config['migration_version'] = 20200308155900; // Add_contact_inquiries_table
//$config['migration_version'] = 20200308160000; // Add_blogs_table
//$config['migration_version'] = 20200308160215; // Add_emails_table
//$config['migration_version'] = 20200308160400; // Add_privacy_and_policy_table
//$config['migration_version'] = 20200308160500; // Add_terms_and_conditions_table
//$config['migration_version'] = 20200308160815; // Add_subscribers_table
//$config['migration_version'] = 20200308161525; // Add_news_types_table
//$config['migration_version'] = 20200308162530; // Add_news_table
//$config['migration_version'] = 20200313162530; // Add_menu_items_table
//$config['migration_version'] = 20200313172530; // Add_menu_sub_items_table
//$config['migration_version'] = 20200324182530; // Add_visitor_statistics_table
//$config['migration_version'] = 20200324183030; // Add_module_statistics_table
//$config['migration_version'] = 20200329221530; // Add_search_table
//$config['migration_version'] = 20211906112630; // Add_exclusive_news_table
//$config['migration_version'] = 20211906113000; // Add_live_news_table
//$config['migration_version'] = 20212406162530; // Add_videos_table
//$config['migration_version'] = 20212406172530; // Add_epaper_table
//$config['migration_version'] = 20212406173530; // Add_epaper_trans_table
$config['migration_version'] = 20212406173730; // Add_subscriptions_table

/*
|--------------------------------------------------------------------------
| Migrations Path
|--------------------------------------------------------------------------
|
| Path to your migrations folder.
| Typically, it will be within your application path.
| Also, writing permission is required within the migrations path.
|
*/
$config['migration_path'] = APPPATH.'migrations/';
