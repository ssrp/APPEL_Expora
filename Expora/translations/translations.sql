-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2016 at 04:46 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `appel`
--

-- --------------------------------------------------------

--
-- Table structure for table `petitions_translations`
--

CREATE TABLE IF NOT EXISTS `petitions_translations` (
  `id` text NOT NULL,
  `english` text NOT NULL,
  `french` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `petitions_translations`
--

INSERT INTO `petitions_translations` (`id`, `english`, `french`) VALUES
('interface_title', 'Export Text Corpora From The Database', 'Export de corpus textuels depuis une base de données'),
('interface_toolbar_expora', 'EXPORA', 'EXPORA'),
('interface_sql_title', 'SQL Query', 'Requête SQL'),
('interface_toolbar_subcorpora', 'Extract Sub-Corpus', 'Extraction de sous-corpus'),
('interface_toolbar_metadata', 'Add Metadata', 'Ajout de métadonnées'),
('interface_toolbar_history', 'Your History', 'Historique'),
('interface_toolbar_shared', 'Shared Queries', 'Requêtes partagées'),
('interface_toolbar_logout', 'Logout', 'Déconnexion'),
('interface_toolbar_language', 'Language', 'Langue'),
('interface_toolbar_language_english', 'English', 'Anglais'),
('interface_toolbar_language_french', 'French', 'Français'),
('interface_pretreatments_title', 'Pretreatments', 'Prétraitements'),
('interface_format_title', 'File Format', 'Format de fichier'),
('interface_button_previous', 'Previous', 'Précédent'),
('interface_button_next', 'Next', 'Suivant'),
('interface_output_title', 'Output', 'Sortie'),
('interface_pretreatments_lowercase', 'All Lowercase', 'Tout en minuscules'),
('interface_pretreatments_smileys', 'Replacement of emoticons', 'Remplacement des smileys'),
('interface_pretreatments_findreplace', 'Find / Replace from a File', 'Rechercher/remplacer à partir d''un fichier'),
('interface_pretreatments_browse', 'Browse', 'Parcourir'),
('interface_sql_output_share', 'Share this query with others', 'Partager cette requête'),
('interface_sql_output_favourites', 'Add to favourites', 'Ajouter aux favoris'),
('interface_button_export', 'EXPORT', 'EXPORT'),
('interface_sql_output_xsl', 'Upload XSL File and use XSL transformations', 'Envoi d’un fichier XSL'),
('interface_sql_sorting_asc', 'ascending', 'croissant'),
('interface_sql_sorting_desc', 'descending', 'décroissant'),
('interface_sql_sorting_title', 'Field To Use For Sorting', 'Champ à utiliser pour trier'),
('interface_sql_sorting_type', 'Sorting Type', 'Type de tri'),
('interface_sql_sorting_title', 'Sorting', 'Tri'),
('interface_request_title', 'Request', 'Requête'),
('interface_sql_filters_to_use', 'Filter to use', 'Filtre à utiliser'),
('interface_sql_filters_field', 'Field to use', 'Champs à utiliser'),
('interface_sql_filters_value', 'Field value', 'Valeur du champ'),
('interface_sql_filters_and', 'AND', 'ET'),
('interface_sql_filters_or', 'OR', 'OU'),
('interface_sql_filters_min', 'Min Value', 'Valeur minimale'),
('interface_sql_filters_max', 'Max Value', 'Valeur maximale'),
('interface_sql_filters_interval', 'Interval', 'intervalle'),
('interface_sql_filters_not_interval', 'Out of interval', 'En dehors de l''intervalle'),
('interface_sql_filters_regex', 'Regular expression', 'expression régulière'),
('interface_sql_filters_not_regex', 'Unlike regular expression', 'Ne respectant pas l''expression régulière'),
('interface_sql_filters_syntax', 'SQL Syntax', 'syntaxe SQL'),
('interface_sql_filters_equals', 'Equals', 'est égal à'),
('interface_sql_filters_equals_no_case', 'Equals (ignoring case)', 'est égal à (en ignorant la casse)'),
('interface_sql_filters_not_equals', 'NOT equal to', 'différent de'),
('interface_sql_filters_list', 'Items from list', 'Liste d''éléments'),
('interface_sql_filters_not_list', 'Items not in the list', 'Pas dans la liste d''éléments'),
('interface_sql_filters_not_equals', 'NOT equal to', 'différent de'),
('interface_sql_filters_starts', 'Starts With', 'commence par'),
('interface_sql_filters_ends', 'Ends With', 'finit par'),
('interface_sql_filters_contains', 'Contains', 'contient'),
('interface_sql_filters_starts_no_case', 'Starts With (ignoring case)', 'commence par (en ignorant la casse)'),
('interface_sql_filters_ends_no_case', 'Ends With (ignoring case)', 'finit par (en ignorant la casse)'),
('interface_sql_filters_contains_no_case', 'Contains (ignoring case)', 'contient (en ignorant la casse)'),
('interface_sql_filters_title', 'Filters', 'filtre'),
('interaface_sql_filters_touse', 'Filter To Use', 'Champ à utiliser'),
('interface_sql_data_metadata_choice', 'Choice of Exported Metadata', 'Choix des métadonnées exportées'),
('interface_sql_data_textdata_choice', 'Choice of Exported Text Data', 'Choix des données textuelles exportées'),
('interface_sql_data_textdata_title', 'Exported Text Data', 'Données textuelles exportées'),
('interface_sql_data_metadata_title', 'Exported Metadata', 'Métadonnées exportées'),
('interface_sql_filters_title', 'Filters', 'Filtres'),
('interface_metadata_csv', 'Update Using CSV', 'Mise à jour par fichier CSV'),
('interface_metadata_add_medatata', 'Add Metadata', 'Ajout de métadonnées'),
('interface_metadata_primary', 'Primary Keys', 'Clés primaires'),
('interface_metadata_upload_title', 'Upload A CSV', 'Envoi d’un CSV'),
('interface_metadata_csv_descp', 'Upload a CSV in the proper format (as given in the ''add metadata'' option)', 'Envoyer un fichier CSV au bon format (comme indiqué dans l’option ''ajout de métadonnées'')'),
('interface_metadata_csv_choose', 'Choose CSV', 'Choix du CSV'),
('interface_metadata_primary_desc_one', 'Following are the primary keys of the tables in the database. Use them to add the metadata!', 'Les clés primaires des tables de la base de données sont indiquées ci-dessous. Utilisez-les pour ajouter des métadonnées !'),
('interface_metadata_primary_note', 'Note', 'Note'),
('interface_metadata_primary_desc_two', 'The metadata should not contain semicolons '';'' anywhere except for the separation of items. Every item is stored in "double quotes".', 'Les métadonnées ne devraient pas contenir le caractère '';'' ailleurs que pour la séparation de cellules. Toute cellule devrait être entourée de "guillemets doubles".'),
('interface_log_history_title', 'History', 'Historique'),
('interface_log_history_desc', 'Here are all SQL Queries that you have used so far', 'Voici toutes les requêtes SQL que vous avez utilisées à ce jour'),
('interface_log_shared_title', 'Shared Queries', 'Requêtes partagées'),
('interface_log_shared_desc', 'Here are all the Queries shared by other users', 'Voici toutes les requêtes partagées par d’autres utilisateurs'),
('log_time_title', 'Time', 'Temps'),
('log_query_title', 'Query', 'Requête'),
('log_shared_title', 'Shared', 'Partagé'),
('log_favourites_title', 'Favourites', 'Favoris'),
('interface_about_expora_description', '<h3>About Expora</h3>\r\nExpora is a web-application/web-interface which helps you extract any database which as maximum two tables, in many export formats(HTML, Lexico, TreeCloud, etc). The supported database management systems are MySQL and PostgreSQL. The application is made as generic as possible and currently, it''s in French and English language. The code behind Expora is very easy to understand and can be edited/improved for any specific use.\r\n<br>\r\nYou can connect your database by altering the connect.php file and adding the appropriate tables in the database. Here is the complete app, you may also find a very detailed installation process here:<br>\r\n<center><a href = "https://github.com/ssrp/APPEL_Expora" class = "text-center btn btn-success" target = "_blank">Download Expora</a></center>\r\n<h3>Database Is Secure!</h3>\r\nThe database is properly protected from the people who are not authorized to use Expora. They should have an account to access the database. So, there''s no loss/leakage of data. When signing up, an <b>Authentication Key</b> is required by the user without which, he/she can not access Expora. If someone tries to use any ''bad'' queries which might affect the database, he/she will be caught because every time user runs the query, his username, query, time of execution and IP address is logged.\r\n<br>\r\n<h3>Using Expora</h3>\r\nIf you have an experience with SQL, you can use the <b>SQL Query</b> pane to export the data in any format you want. If not, then Expora has a <b>Extract Sub-Corpus</b> pane using which, you can select the data that you want to extract and download the output in varied formats. It also has the options for filters and sorting the data(so, you don''t need to have knowledge about SQL, Expora will do the job!). Pretreatments(like replacement of smileys, text etc), XSL Transformations, Visualisations are some of the features of Expora.\r\n<br>\r\nWhenever a user executes the query, it gets saved in the <b>History</b> pane for the furthur use. Also, if the user wants to share the query, he can choose the share option and it''ll be visible to all the users who use Expora(under same database).\r\n<br><br>', '<h3>About Expora</h3>\r\nExpora is a web-application/web-interface which helps you extract any database which as maximum two tables, in many export formats(HTML, Lexico, TreeCloud, etc). The supported database management systems are MySQL and PostgreSQL. The application is made as generic as possible and currently, it''s in French and English language. The code behind Expora is very easy to understand and can be edited/improved for any specific use.\r\n<br>\r\nYou can connect your database by altering the connect.php file and adding the appropriate tables in the database. Here is the complete app, you may also find a very detailed installation process here:<br>\r\n<center><a href = "https://github.com/ssrp/APPEL_Expora" class = "text-center btn btn-success" target = "_blank">Download Expora</a></center>\r\n<h3>Database Is Secure!</h3>\r\nThe database is properly protected from the people who are not authorized to use Expora. They should have an account to access the database. So, there''s no loss/leakage of data. When signing up, an <b>Authentication Key</b> is required by the user without which, he/she can not access Expora. If someone tries to use any ''bad'' queries which might affect the database, he/she will be caught because every time user runs the query, his username, query, time of execution and IP address is logged.\r\n<br>\r\n<h3>Using Expora</h3>\r\nIf you have an experience with SQL, you can use the <b>SQL Query</b> pane to export the data in any format you want. If not, then Expora has a <b>Extract Sub-Corpus</b> pane using which, you can select the data that you want to extract and download the output in varied formats. It also has the options for filters and sorting the data(so, you don''t need to have knowledge about SQL, Expora will do the job!). Pretreatments(like replacement of smileys, text etc), XSL Transformations, Visualisations are some of the features of Expora.\r\n<br>\r\nWhenever a user executes the query, it gets saved in the <b>History</b> pane for the furthur use. Also, if the user wants to share the query, he can choose the share option and it''ll be visible to all the users who use Expora(under same database).\r\n<br><br>'),
('interface_how_to_use_description', '<h3>How to use - EXTRACT SUB-CORPUS</h3>\r\n\r\n<br>\r\n<ol>\r\n<li>\r\n<b>Select Exporting Text Data</b><br>\r\nJust select the text data that you want to extract and click on next\r\n</li>\r\n<li>\r\n<b>Select Exporting Metadata</b><br>\r\nSelect the metadata that you want to extract and click next.\r\n</li>\r\n<li>\r\n<b>Using Filters</b><br>\r\nFilters are used to add some conditions in the query, For example, I want to extract all cars whose name start with S. You can achieve the "whose name start with S" using filters. \r\n\r\n</li>\r\n<li>\r\n<b>Sorting</b><br>\r\nYou can sort the output using any of the fields in asc or dsc order.\r\n</li>\r\n<li>\r\n<b>Pretreatments</b><br>\r\nChoose the pretreatments like all lowercase(output to be lowercase), replacement of smileys(explain), use csv file to find and replace from a file.\r\n</li>\r\n<li>\r\n<b>Output Format</b><br>\r\nChoose the output formats that you want to use, if you''d like to use the XSL Transformation, then upload the XSL file and the Expora will transform a simple XML (Example here) file into the output using the XSL File you uploaded.\r\nYou can also share the generated query with other users working and add the query to your favourites(it won''t be shown to all)\r\n</li>\r\n</ol>\r\nNow clicking on ''<b>EXPORT!</b>'' will create the output for you!', '<h3>How to use - EXTRACT SUB-CORPUS</h3>\r\n\r\n<br>\r\n<ol>\r\n<li>\r\n<b>Select Exporting Text Data</b><br>\r\nJust select the text data that you want to extract and click on next\r\n</li>\r\n<li>\r\n<b>Select Exporting Metadata</b><br>\r\nSelect the metadata that you want to extract and click next.\r\n</li>\r\n<li>\r\n<b>Using Filters</b><br>\r\nFilters are used to add some conditions in the query, For example, I want to extract all cars whose name start with S. You can achieve the "whose name start with S" using filters. \r\n\r\n</li>\r\n<li>\r\n<b>Sorting</b><br>\r\nYou can sort the output using any of the fields in asc or dsc order.\r\n</li>\r\n<li>\r\n<b>Pretreatments</b><br>\r\nChoose the pretreatments like all lowercase(output to be lowercase), replacement of smileys(explain), use csv file to find and replace from a file.\r\n</li>\r\n<li>\r\n<b>Output Format</b><br>\r\nChoose the output formats that you want to use, if you''d like to use the XSL Transformation, then upload the XSL file and the Expora will transform a simple XML (Example here) file into the output using the XSL File you uploaded.\r\nYou can also share the generated query with other users working and add the query to your favourites(it won''t be shown to all)\r\n</li>\r\n</ol>\r\nNow clicking on ''<b>EXPORT!</b>'' will create the output for you!'),
('interface_history_shared_queries_description', '<h3>What is ''Your History''?</span></h3>\r\nThis is a table which contains all the queries that you executed so far. If you do not have knowledge of SQL, then also you can get to know which query you used, otherwise, <b>you can use the search field to locate the query by the name you gave it</b>.\r\n<br>\r\n<h3>What are ''Shared Queries''?</h3>\r\nYou can see all the queries which are made public to all the other users working with Expora under same environment.\r\n', '<h3>What is ''Your History''?</span></h3>\r\nThis is a table which contains all the queries that you executed so far. If you do not have knowledge of SQL, then also you can get to know which query you used, otherwise, <b>you can use the search field to locate the query by the name you gave it</b>.\r\n<br>\r\n<h3>What are ''Shared Queries''?</h3>\r\nYou can see all the queries which are made public to all the other users working with Expora under same environment.\r\n'),
('interface_sql_query_pane_description', '<h3>How to use ''SQL Query'' Pane?</h3>\r\nYou can enter your SQL Query in the provided fields and choose the pretreatments and file format the same way you choose for Extract Sub Corpus and you are good to go!\r\n', '<h3>How to use ''SQL Query'' Pane?</h3>\r\nYou can enter your SQL Query in the provided fields and choose the pretreatments and file format the same way you choose for Extract Sub Corpus and you are good to go!\r\n'),
('interface_metadata_description', '<h3>How To Add Metadata?</h3>\r\nThis pane is used to add some new column to the current available tables. There are four things that a new column needs: \r\n<ul>\r\n<li>Column name</li>\r\n<li>Which table should has it?</li>\r\n<li>Its description (to be shown in the extracting fields)</li>\r\n<li>The values corresponding to different rows in that table(using primary key)</li>\r\n</ul>\r\n<b>Note</b>: PRIMARY_KEY is the <u>key of the table in which the new column has to be inserted</u>.\r\n<br>For that, we have the following format:\r\n<br>\r\n<b>\r\n<br>"lang-english";"DESCRIPTION IN ENGLISH"\r\n<br>"lang-french";"DESCRIPTION IN FRENCH"\r\n<br>"PRIMARY_KEY";"NEW_COLUMN_NAME"\r\n<br>"KEY_VALUE1";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE1"\r\n<br>"KEY_VALUE2";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE2"\r\n<br>"KEY_VALUE3";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE3"\r\n<br>"KEY_VALUE4";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE4"\r\n<br>"KEY_VALUE5";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE5"\r\n</b>\r\n<br>\r\n<br>\r\nYou can add more columns using semicolons. Also, there''s an option for uploading a CSV File if the data is too large to handle!\r\n<br>\r\nThe primary key pane shows the description about the primary keys of the tables used.', '<h3>How To Add Metadata?</h3>\r\nThis pane is used to add some new column to the current available tables. There are four things that a new column needs: \r\n<ul>\r\n<li>Column name</li>\r\n<li>Which table should has it?</li>\r\n<li>Its description (to be shown in the extracting fields)</li>\r\n<li>The values corresponding to different rows in that table(using primary key)</li>\r\n</ul>\r\n<b>Note</b>: PRIMARY_KEY is the <u>key of the table in which the new column has to be inserted</u>.\r\n<br>For that, we have the following format:\r\n<br>\r\n<b>\r\n<br>"lang-english";"DESCRIPTION IN ENGLISH"\r\n<br>"lang-french";"DESCRIPTION IN FRENCH"\r\n<br>"PRIMARY_KEY";"NEW_COLUMN_NAME"\r\n<br>"KEY_VALUE1";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE1"\r\n<br>"KEY_VALUE2";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE2"\r\n<br>"KEY_VALUE3";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE3"\r\n<br>"KEY_VALUE4";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE4"\r\n<br>"KEY_VALUE5";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE5"\r\n</b>\r\n<br>\r\n<br>\r\nYou can add more columns using semicolons. Also, there''s an option for uploading a CSV File if the data is too large to handle!\r\n<br>\r\nThe primary key pane shows the description about the primary keys of the tables used.'),
('interface_developers_description', '<h3>Meet The Developers!</h3>\r\n<b>Expora</b> is designed and developed by <b>Mr. Sai Samarth R Phaye</b> under the supervision of <b>Dr. Philippe Gambette</b> and <b>Dr. Jean-Marc Leblanc</b> at Laboratoire d''Informatique Gaspard-Monge, UPEM.\r\n', '<h3>Meet The Developers!</h3>\r\n<b>Expora</b> is designed and developed by <b>Mr. Sai Samarth R Phaye</b> under the supervision of <b>Dr. Philippe Gambette</b> and <b>Dr. Jean-Marc Leblanc</b> at Laboratoire d''Informatique Gaspard-Monge, UPEM.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
