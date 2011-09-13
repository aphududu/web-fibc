--
-- Create table banner
--

DROP TABLE IF EXISTS `#__banner`;
CREATE TABLE `#__banner` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` varchar(30) NOT NULL DEFAULT 'banner',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `imageurl` varchar(100) NOT NULL DEFAULT '',
  `clickurl` varchar(200) NOT NULL DEFAULT '',
  `date` datetime DEFAULT NULL,
  `showBanner` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor` varchar(50) DEFAULT NULL,
  `custombannercode` text,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tags` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`bid`),
  KEY `viewbanner` (`showBanner`),
  KEY `idx_banner_catid` (`catid`)
) TYPE=MyISAM AUTO_INCREMENT=9;
--
-- Create table bannerclient
--

DROP TABLE IF EXISTS `#__bannerclient`;
CREATE TABLE `#__bannerclient` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out_time` time DEFAULT NULL,
  `editor` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) TYPE=MyISAM AUTO_INCREMENT=2;
--
-- Create table bannertrack
--

DROP TABLE IF EXISTS `#__bannertrack`;
CREATE TABLE `#__bannertrack` (
  `track_date` date NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL
) TYPE=MyISAM;
--
-- Create table categories
--

DROP TABLE IF EXISTS `#__categories`;
CREATE TABLE `#__categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `section` varchar(50) NOT NULL DEFAULT '',
  `image_position` varchar(30) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor` varchar(50) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) TYPE=MyISAM AUTO_INCREMENT=41;
--
-- Create table components
--

DROP TABLE IF EXISTS `#__components`;
CREATE TABLE `#__components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `menuid` int(11) unsigned NOT NULL DEFAULT '0',
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  `admin_menu_link` varchar(255) NOT NULL DEFAULT '',
  `admin_menu_alt` varchar(255) NOT NULL DEFAULT '',
  `option` varchar(50) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `admin_menu_img` varchar(255) NOT NULL DEFAULT '',
  `iscore` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parent_option` (`parent`,`option`(32))
) TYPE=MyISAM AUTO_INCREMENT=37;

--
-- Dumping data for table `pii_components`
--

INSERT INTO `#__components` (`id`, `name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES
(1, 'Banners', '', 0, 0, '', 'Banner Management', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, 'track_impressions=0\ntrack_clicks=0\ntag_prefix=\n\n', 1),
(2, 'Banners', '', 0, 1, 'option=com_banners', 'Active Banners', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, '', 1),
(3, 'Clients', '', 0, 1, 'option=com_banners&c=client', 'Manage Clients', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(4, 'Web Links', 'option=com_weblinks', 0, 0, '', 'Manage Weblinks', 'com_weblinks', 0, 'js/ThemeOffice/component.png', 0, 'show_comp_description=1\ncomp_description=\nshow_link_hits=1\nshow_link_description=1\nshow_other_cats=1\nshow_headings=1\nshow_page_title=1\nlink_target=0\nlink_icons=\n\n', 1),
(5, 'Links', '', 0, 4, 'option=com_weblinks', 'View existing weblinks', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, '', 1),
(6, 'Categories', '', 0, 4, 'option=com_categories&section=com_weblinks', 'Manage weblink categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(7, 'Contacts', 'option=com_contact', 0, 0, '', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/component.png', 1, 'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n', 1),
(8, 'Contacts', '', 0, 7, 'option=com_contact', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/edit.png', 1, '', 1),
(9, 'Categories', '', 0, 7, 'option=com_categories&section=com_contact_details', 'Manage contact categories', '', 2, 'js/ThemeOffice/categories.png', 1, 'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n', 1),
(10, 'Polls', 'option=com_poll', 0, 0, 'option=com_poll', 'Manage Polls', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(11, 'News Feeds', 'option=com_newsfeeds', 0, 0, '', 'News Feeds Management', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(12, 'Feeds', '', 0, 11, 'option=com_newsfeeds', 'Manage News Feeds', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, 'show_headings=1\nshow_name=1\nshow_articles=1\nshow_link=1\nshow_cat_description=1\nshow_cat_items=1\nshow_feed_image=1\nshow_feed_description=1\nshow_item_description=1\nfeed_word_count=0\n\n', 1),
(13, 'Categories', '', 0, 11, 'option=com_categories&section=com_newsfeeds', 'Manage Categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(14, 'User', 'option=com_user', 0, 0, '', '', 'com_user', 0, '', 1, '', 1),
(15, 'Search', 'option=com_search', 0, 0, 'option=com_search', 'Search Statistics', 'com_search', 0, 'js/ThemeOffice/component.png', 1, 'enabled=0\n\n', 1),
(16, 'Categories', '', 0, 1, 'option=com_categories&section=com_banner', 'Categories', '', 3, '', 1, '', 1),
(17, 'Wrapper', 'option=com_wrapper', 0, 0, '', 'Wrapper', 'com_wrapper', 0, '', 1, '', 1),
(18, 'Mail To', '', 0, 0, '', '', 'com_mailto', 0, '', 1, '', 1),
(19, 'Media Manager', '', 0, 0, 'option=com_media', 'Media Manager', 'com_media', 0, '', 1, 'upload_extensions=bmp,csv,doc,epg,gif,ico,jpg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,EPG,GIF,ICO,JPG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\nupload_maxsize=10000000\nfile_path=images\nimage_path=images/stories\nrestrict_uploads=1\nallowed_media_usergroup=3\ncheck_mime=1\nimage_extensions=bmp,gif,jpg,png\nignore_extensions=\nupload_mime=image/jpeg,image/gif,image/png,image/bmp,application/x-shockwave-flash,application/msword,application/excel,application/pdf,application/powerpoint,text/plain,application/x-zip\nupload_mime_illegal=text/html\nenable_flash=0\n\n', 1),
(20, 'Articles', 'option=com_content', 0, 0, '', '', 'com_content', 0, '', 1, 'show_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=0\nshow_modify_date=0\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\nfeed_summary=0\nfilter_tags=\nfilter_attritbutes=\n\n', 1),
(21, 'Configuration Manager', '', 0, 0, '', 'Configuration', 'com_config', 0, '', 1, '', 1),
(22, 'Installation Manager', '', 0, 0, '', 'Installer', 'com_installer', 0, '', 1, '', 1),
(23, 'Language Manager', '', 0, 0, '', 'Languages', 'com_languages', 0, '', 1, '', 1),
(24, 'Mass mail', '', 0, 0, '', 'Mass Mail', 'com_massmail', 0, '', 1, 'mailSubjectPrefix=\nmailBodySuffix=\n\n', 1),
(25, 'Menu Editor', '', 0, 0, '', 'Menu Editor', 'com_menus', 0, '', 1, '', 1),
(27, 'Messaging', '', 0, 0, '', 'Messages', 'com_messages', 0, '', 1, '', 1),
(28, 'Modules Manager', '', 0, 0, '', 'Modules', 'com_modules', 0, '', 1, '', 1),
(29, 'Plugin Manager', '', 0, 0, '', 'Plugins', 'com_plugins', 0, '', 1, '', 1),
(30, 'Template Manager', '', 0, 0, '', 'Templates', 'com_templates', 0, '', 1, '', 1),
(31, 'User Manager', '', 0, 0, '', 'Users', 'com_users', 0, '', 1, 'allowUserRegistration=1\nnew_usertype=Registered\nuseractivation=1\nfrontend_userparams=1\n\n', 1),
(32, 'Cache Manager', '', 0, 0, '', 'Cache', 'com_cache', 0, '', 1, '', 1),
(33, 'Control Panel', '', 0, 0, '', 'Control Panel', 'com_cpanel', 0, '', 1, '', 1),
(35, 'K2', 'option=com_k2', 0, 0, 'option=com_k2', 'K2', 'com_k2', 0, 'components/com_k2/images/system/k2-icon.png', 0, 'enable_css=1\nimagesQuality=0\nitemImageXS=100\nitemImageS=150\nitemImageM=189\nitemImageL=189\nitemImageXL=189\nitemImageGeneric=189\ncatImageWidth=189\ncatImageDefault=1\nuserImageWidth=70\nuserImageDefault=1\ncommenterImgWidth=48\nuserName=1\nuserImage=1\nuserDescription=1\nuserURL=0\nuserEmail=0\nuserFeed=0\nuserItemCount=4\nuserItemTitle=1\nuserItemTitleLinked=1\nuserItemDateCreated=1\nuserItemImage=1\nuserItemIntroText=1\nuserItemCategory=1\nuserItemTags=1\nuserItemCommentsAnchor=1\nuserItemReadMore=1\nuserItemK2Plugins=1\ngenericItemCount=10\ngenericItemTitle=1\ngenericItemTitleLinked=1\ngenericItemDateCreated=1\ngenericItemImage=1\ngenericItemIntroText=1\ngenericItemCategory=1\ngenericItemReadMore=1\ngenericItemExtraFields=0\ntagOrdering=\ncomments=1\ncommentsOrdering=DESC\ncommentsLimit=4\ncommentsFormPosition=below\ncommentsPublishing=1\ngravatar=1\nrecaptcha=0\nrecaptcha_public_key=\nrecaptcha_private_key=\nrecaptcha_theme=clean\ncommentsFormNotes=1\ncommentsFormNotesText=Make sure you enter the (*) required information where indicated.\\nBasic HTML code is allowed.\nsocialButtonCode=\ntwitterUsername=\ntinyURL=1\nfeedLimit=0\nfeedItemImage=1\nfeedImgSize=S\nfeedItemIntroText=1\nfeedTextWordLimit=\nfeedItemFullText=1\nintroTextCleanup=0\nintroTextCleanupExcludeTags=\nintroTextCleanupTagAttr=\nfullTextCleanup=0\nfullTextCleanupExcludeTags=\nfullTextCleanupTagAttr=\nlinkPopupWidth=900\nlinkPopupHeight=600\nfrontendEditing=1\nshowImageTab=1\nshowImageGalleryTab=1\nshowVideoTab=1\nshowExtraFieldsTab=1\nshowAttachmentsTab=1\nshowK2Plugins=1\nsideBarDisplayFrontend=0\nmergeEditors=1\nsideBarDisplay=1\nattachmentsFolder=\nhideImportButton=0\ntaggingSystem=1\nlockTags=0\ngoogleSearch=0\ngoogleSearchContainer=k2Container\nK2UserProfile=1\nK2UserGroup=1\nredirect=\nadminSearch=simple\nshowItemsCounterAdmin=1\nshowChildCatItems=1\ndisableCompactOrdering=0\nSEFReplacements=Array\nmetaDescLimit=150\nsh404SefLabelCat=\nsh404SefLabelUser=blog\n\n', 1),
(36, 'JA Extensions Manager', 'option=com_jaextmanager', 0, 0, 'option=com_jaextmanager', 'JA Extensions Manager', 'com_jaextmanager', 0, 'components/com_jaextmanager/assets/images/jauc.png', 0, '', 1);

--
-- Create table contact_details
--

DROP TABLE IF EXISTS `#__contact_details`;
CREATE TABLE `#__contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `con_position` varchar(255) DEFAULT NULL,
  `address` text,
  `suburb` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postcode` varchar(100) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `misc` mediumtext,
  `image` varchar(255) DEFAULT NULL,
  `imagepos` varchar(20) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `default_con` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(255) NOT NULL DEFAULT '',
  `webpage` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`)
) TYPE=MyISAM AUTO_INCREMENT=2;
--
-- Create table content
--

DROP TABLE IF EXISTS `#__content`;
CREATE TABLE `#__content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `title_alias` varchar(255) NOT NULL DEFAULT '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `sectionid` int(11) unsigned NOT NULL DEFAULT '0',
  `mask` int(11) unsigned NOT NULL DEFAULT '0',
  `catid` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL DEFAULT '1',
  `parentid` int(11) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `metadata` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`)
) TYPE=MyISAM AUTO_INCREMENT=80;
--
-- Create table content_frontpage
--

DROP TABLE IF EXISTS `#__content_frontpage`;
CREATE TABLE `#__content_frontpage` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) TYPE=MyISAM;
--
-- Create table content_rating
--

DROP TABLE IF EXISTS `#__content_rating`;
CREATE TABLE `#__content_rating` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(11) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(11) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`content_id`)
) TYPE=MyISAM;
--
-- Create table core_acl_aro
--

DROP TABLE IF EXISTS `#__core_acl_aro`;
CREATE TABLE `#__core_acl_aro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_value` varchar(240) NOT NULL DEFAULT '0',
  `value` varchar(240) NOT NULL DEFAULT '',
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `#__section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `#__gacl_hidden_aro` (`hidden`)
) TYPE=MyISAM AUTO_INCREMENT=18;
--
-- Create table core_acl_aro_groups
--

DROP TABLE IF EXISTS `#__core_acl_aro_groups`;
CREATE TABLE `#__core_acl_aro_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `#__gacl_parent_id_aro_groups` (`parent_id`),
  KEY `#__gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) TYPE=MyISAM AUTO_INCREMENT=31;

--
-- Dumping data for table `pii_core_acl_aro_groups`
--

INSERT INTO `#__core_acl_aro_groups` (`id`, `parent_id`, `name`, `lft`, `rgt`, `value`) VALUES
(17, 0, 'ROOT', 1, 22, 'ROOT'),
(28, 17, 'USERS', 2, 21, 'USERS'),
(29, 28, 'Public Frontend', 3, 12, 'Public Frontend'),
(18, 29, 'Registered', 4, 11, 'Registered'),
(19, 18, 'Author', 5, 10, 'Author'),
(20, 19, 'Editor', 6, 9, 'Editor'),
(21, 20, 'Publisher', 7, 8, 'Publisher'),
(30, 28, 'Public Backend', 13, 20, 'Public Backend'),
(23, 30, 'Manager', 14, 19, 'Manager'),
(24, 23, 'Administrator', 15, 18, 'Administrator'),
(25, 24, 'Super Administrator', 16, 17, 'Super Administrator');

--
-- Create table core_acl_aro_map
--

DROP TABLE IF EXISTS `#__core_acl_aro_map`;
CREATE TABLE `#__core_acl_aro_map` (
  `acl_id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(230) NOT NULL DEFAULT '0',
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`acl_id`,`section_value`,`value`)
) TYPE=MyISAM;
--
-- Create table core_acl_aro_sections
--

DROP TABLE IF EXISTS `#__core_acl_aro_sections`;
CREATE TABLE `#__core_acl_aro_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(230) NOT NULL DEFAULT '',
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(230) NOT NULL DEFAULT '',
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `#__gacl_value_aro_sections` (`value`),
  KEY `#__gacl_hidden_aro_sections` (`hidden`)
) TYPE=MyISAM AUTO_INCREMENT=11;
--
-- Create table core_acl_groups_aro_map
--

DROP TABLE IF EXISTS `#__core_acl_groups_aro_map`;
CREATE TABLE `#__core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(240) NOT NULL DEFAULT '',
  `aro_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) TYPE=MyISAM;
--
-- Create table core_log_items
--

DROP TABLE IF EXISTS `#__core_log_items`;
CREATE TABLE `#__core_log_items` (
  `time_stamp` date NOT NULL DEFAULT '0000-00-00',
  `item_table` varchar(50) NOT NULL DEFAULT '',
  `item_id` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0'
) TYPE=MyISAM;
--
-- Create table core_log_searches
--

DROP TABLE IF EXISTS `#__core_log_searches`;
CREATE TABLE `#__core_log_searches` (
  `search_term` varchar(128) NOT NULL DEFAULT '',
  `hits` int(11) unsigned NOT NULL DEFAULT '0'
) TYPE=MyISAM;
--
-- Create table groups
--

DROP TABLE IF EXISTS `#__groups`;
CREATE TABLE `#__groups` (
  `id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `pii_groups`
--

INSERT INTO `#__groups` (`id`, `name`) VALUES
(0, 'Public'),
(1, 'Registered'),
(2, 'Special');

--
-- Create table jacomment_configs
--

DROP TABLE IF EXISTS `#__jacomment_configs`;
CREATE TABLE `#__jacomment_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(100) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=29;

--
-- Dumping data for table `pii_jacomment_configs`
--

INSERT INTO `#__jacomment_configs` (`id`, `group`, `data`) VALUES
(22, 'general', 'display_message=\nis_notify_admin=1\nis_notify_author=1\nis_enabled_email=1\nccemail=\naccess=0\nis_comment_offline=0\nmail_view_only=0\nis_use_ja_login_form=0\n\n'),
(23, 'comments', 'is_enable_threads=1\nis_allow_voting=1\ntotal_attach_file=5\nmax_size_attach_file=2\nattach_file_type=doc,docx,pdf,txt,zip,rar,jpg,bmp,gif,png\nis_enable_website_field=1\nis_enable_autoexpanding=1\nis_extra_fields_expand=1\nis_enable_email_subscription=1\nis_allow_report=1\nis_allow_approve_new_comment=1\nmaximum_comment_in_item=100\nis_enable_rss=1\n\n'),
(24, 'spamfilters', 'terms_of_usage=Registration to this forum is free! We do insist that you abide by the rules and policies detailed below. If you agree to the terms, please check the ''I agree'' checkbox and press the ''Register'' button below. If you would like to cancel the registration, click here to return to the forums index.\\n\\nForum Rules\\n\\nRegistration to this forum is free! We do insist that you abide by the rules and policies detailed below. If you agree to the terms, please check the ''I agree'' checkbox and press the ''Register'' button below. If you would like to cancel the registration, click here to return to the forums index.\nmin_length=10\nmax_length=1000\ncensored_words=\ncensored_words_replace=\nis_nofollow=1\nnumber_of_links=5\nis_enable_captcha_user=0\nis_use_akismet=0\n\n'),
(25, 'blocked_word_list', '\ndamn'),
(26, 'blacklist_word_list', '\nfuck'),
(27, 'permissions', 'view=all\npost=all\nvote=all\ntype_voting=1\nreport=all\ntotal_to_report_spam=10\ntype_editing=1\n\n'),
(28, 'layout', 'theme=business\nenable_avatar=1\ntype_avatar=0\navatar_size=3\nenable_youtube=1\nis_enable_website_field=0\nform_position=1\nenable_sorting_options=1\ndefault_sort=date\ndefault_sort_type=ASC\nenable_timestamp=1\nfooter_text=\ncustom_css=\nenable_login_rpx=1\nenable_addthis=1\ncustom_addthis=<!-- AddThis Button BEGIN -->\\n<a class="addthis_button" href="http://addthis.com/bookmark.php?v=250&pub=xa-4af3e1272f178ef0"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pub=xa-4af3e1272f178ef0"></script>\\n<!-- AddThis Button END -->\ncustom_addtoany=<a class="a2a_dd" href="http://www.addtoany.com/share_save"><img src="http://static.addtoany.com/buttons/share_save_171_16.png" width="171" height="16" border="0" alt="Share/Bookmark"/></a><script type="text/javascript">a2a_linkname=document.title;a2a_linkurl=location.href;</script><script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>\ncustom_tweetmeme=<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>\nenable_bbcode=1\nenable_smileys=1\nuse_default_avatar=0\nenable_login_button=0\nenable_subscribe_menu=0\nenable_user_rep_indicator=0\nenable_comment_form=0\nenable_addtoany=1\nenable_polldaddy=0\nenable_seesmic=0\nenable_tweetmeme=1\nenable_activity_stream=0\nsmiley=default\nenable_after_the_deadline=0\n\n');

--
-- Create table jacomment_email_templates
--

DROP TABLE IF EXISTS `#__jacomment_email_templates`;
CREATE TABLE `#__jacomment_email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(525) DEFAULT NULL,
  `subject` varchar(525) DEFAULT NULL,
  `content` text,
  `email_from_address` varchar(255) DEFAULT NULL,
  `email_from_name` varchar(255) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0',
  `group` int(11) DEFAULT '0',
  `language` varchar(20) DEFAULT NULL,
  `system` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=36;

--
-- Dumping data for table `pii_jacomment_email_templates`
--

INSERT INTO `#__jacomment_email_templates` (`id`, `name`, `title`, `subject`, `content`, `email_from_address`, `email_from_name`, `published`, `group`, `language`, `system`) VALUES
(10, 'mailheader', 'Header', 'Header', '', '', '', 1, 1, 'en-GB', 1),
(11, 'mailfooter', 'Footer', 'Footer', '<p style="margin: 15px 5px 2px 0pt; text-align: right; color: #aaaaaa"> powered by <span style="font-family: arial; font-style: normal; font-variant: normal; font-weight: normal; font-size: 16px; line-height: normal; font-size-adjust: none; font-stretch: normal; letter-spacing: -1px"><strong>JA<font color="#f47414">Comment</font></strong></span> </p>', '', '', 1, 1, 'en-GB', 1),
(35, 'Jacommentconfirmation_sent_to_new_comment_creator_need_admin_approved', 'Confirmation sent to new comment creator - In cases where admin approval is Required', 'Your comment is pending approval...', '<p>Dear {USERS_USERNAME}, </p><p>This email is to inform that you have just created a new comment on the issue {ITEM_TITLE_WITH_LINK} at {CONFIG.SITE_TITLE} with the following details: </p><p><strong>Comment URL</strong>: {ITEM_LINK} </p><p><strong>Comment details</strong>: {ITEM_DETAILS}.</p><p> Your comment shall be posted after being approved by administrator. Please check your mailbox periodically for updated information. </p><p>Sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0),
(12, 'Jacommentnotify_to_user_new_voice_daily', 'Dailly NEW Comment statistics (to those who subscribe)', '[JA Comment] Daily statistics', '<p>Hi {USERS_USERNAME},</p><p>Here are a quick overview of what has been going on at JA Comment during the last 24 hours: </p>{ITEM_DETAILS}', '', '', 1, 0, 'en-GB', 1),
(19, 'Jacommentnotify_when_new_item_was_post', 'Notify when new item was post', 'Have a new comment!', '<p>Dear {USERS_USERNAME}, </p><p>This email is to inform that a comment has been newly added into the issue {ITEM_TITLE_WITH_LINK} at {CONFIG.SITE_TITLE} with the following details: </p><p><strong>Comment URL:</strong> {ITEM_LINK} </p><p><strong>Comment details:</strong> {ITEM_DETAILS} </p><p>Please click on the link above to view the full details. </p><p>Sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0),
(22, 'Jacommentnotifying_admin_on_a_new_comment_posted', 'Notifying admin on a new comment posted', 'A new comment has been newly added', '<p>Dear {USERS_USERNAME}, </p><p>This email is to inform you that a new comment on {ITEM_TITLE_WITH_LINK} has newly been added at {CONFIG.SITE_TITLE} with the following details: </p><p><strong>Comment URL:</strong> {ITEM_LINK} </p><p><strong>Comment details:</strong> {ITEM_DETAILS} </p><p><strong>Comment creator:</strong> {ITEM_CREATE_BY} </p><p>Please review the above comments and take appropriate actions as soon as possible. </p><p>Yours sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0),
(34, 'Jacommentconfirmation_sent_to_new_comment_creator_dont_need_admin_approved', 'Confirmation sent to new comment creator - In cases where admin approval is NOT required', 'We confirm your comment', '<p>Dear {USERS_USERNAME}, </p><p>This email is to confirm that you have successfully created a new comment on the issue {ITEM_TITLE_WITH_LINK} at {CONFIG.SITE_TITLE} with the following details: </p><p> <strong>Comment URL:</strong> {ITEM_LINK} </p><p><strong>Comment details:</strong> {ITEM_DETAILS}.</p><p>Please check your mailbox periodically as we shall notify you if there is any new reply on this issue.</p><p> Sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0),
(24, 'Jacommentnotifying_comment_creator_if_there_is_a_new_reply_to_his_comment', 'Notifying comment creator if there is a new reply to his comment', 'A new reply has just been posted on your comment', '<p>Dear {USERS_USERNAME}, </p><p>This email is to inform that a new reply has just been posted on the issue {ITEM_TITLE_WITH_LINK} at {CONFIG.SITE_TITLE} with the following details: </p><p><strong>Reply URL</strong>: {ITEM_LINK} </p><p><strong>Reply details</strong>: {ITEM_DETAILS} </p><p><strong>Reply creator:</strong> {REPLY_OWNER} . </p><p>Yours sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0),
(25, 'Jacommentnotifying_those_whose_comment_has_been_deleted', 'Notifying those whose comment has been deleted', 'Your comment has been deleted', '<p>Dear {USERS_USERNAME}, </p><p>We are sorry to inform that your comment on the issue "{ITEM_TITLE_WITH_LINK}', '', '', 1, 0, 'en-GB', 0),
(26, 'Jacommentnotifying_those_whose_comment_has_been_approved', 'Notifying those whose comment has been approved', 'Your Comment has been approved', '<p>Dear {USERS_USERNAME}, </p><p> This email is to inform that your comment on the issue {ITEM_TITLE_WITH_LINK} at {CONFIG.SITE_TITLE} has been approved and published by {SITE_ADMIN} with the following details: </p><p><strong>Comment URL:</strong> {ITEM_LINK} </p><p><strong>Comment details:</strong> {ITEM_DETAILS} </p><p>Please check your mailbox periodically as we shall notify you if there is any reply on this issue Yours. sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0),
(27, 'Jacommentnotifying_admin_of_a_spam_report_on_a_comment', 'Notifying admin of a spam report on a comment', 'A comment has been reported as spam', '<p>Dear {USERS_USERNAME}, </p><p>This email is to inform that the comment on the issue {ITEM_TITLE_WITH_LINK} at {CONFIG.SITE_TITLE} has been reported as spam recently. </p><p><strong>Comment URL:</strong> {ITEM_LINK} </p><p><strong>Comment details:</strong> {ITEM_DETAILS} </p><p><strong>Spam reporter:</strong> {SPAM_REPORTER} </p><p>Kindly review the above comment to see if it is a spam as report or not for further action at your soonest time. </p><p>Yours sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0),
(28, 'Jacommentnotifying_those_whose_comment_is_reported_as_spam', 'Notifying those whose comment is reported as spam', 'You have comment reported as spam', '<p>Dear {USERS_USERNAME}, </p><p>This email is to inform that your comment on the issue {ITEM_TITLE_WITH_LINK} at {CONFIG.SITE_TITLE} has been reported as spam by other user recently. </p><p><strong>Comment URL:</strong> {ITEM_LINK} </p><p><strong>Comment details:</strong> {ITEM_DETAILS} </p><p><strong>Spam reporter:</strong> {SPAM_REPORTER} </p><p>The spam report shall be thoroughly and fairly reviewed by {SITE_ADMIN} before any further action. Kindly continue using our site normally and sorry for any inconveniences that may have caused. </p><p>Yours sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0),
(29, 'Jacommentnotifying_those_whose_comment_is_removed_as_spam_by_admin', 'Notifying those whose comment is removed as spam by admin', 'Your comment has been removed as spam by administrator', '<p>Dear {USERS_USERNAME},</p><p>This email is to inform that your comment on the issue {ITEM_TITLE_WITH_LINK} at {CONFIG.SITE_TITLE} has been removed as spam by {SITE_ADMIN}. </p><p><strong>Comment URL:</strong> {ITEM_LINK} </p><p><strong>Comment details:</strong> {ITEM_DETAILS} </p><p><strong>Moderate Reasons:</strong> {MOD_REASONS} </p><p> Thank you for your understanding and do hope you carefully read the instructions and strictly follow the Terms of Use before posting any comments at {CONFIG.SITE_TITLE} in the time to come.</p><p> Yours sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0),
(30, 'Jacommentnotifying_those_whose_comment_has_been_unapproved', 'Notifying those whose comment has been unapproved', 'You have a comment unapproved', '<p>Dear {USERS_USERNAME}, </p><p>This email is to inform that your comment on the issue {ITEM_TITLE_WITH_LINK} at {CONFIG.SITE_TITLE} has been unapproved by {SITE_ADMIN} due to the following reasons:</p><p> <strong>Comment URL:</strong> {ITEM_LINK} </p><p><strong>Comment details:</strong> {ITEM_DETAILS} </p><p><strong>Unapproved reasons:</strong> {UNAPPROVE_REASONS} </p><p>Thank you for your understanding and do hope you carefully read the instructions and strictly follow the Terms of Use before posting any comments at {CONFIG.SITE_TITLE} in the time to come. </p><p>Yours sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0),
(32, 'Jacommentnotifying_comment_creator_if_there_is_a_new_comment_on_the_issue', 'Notifying comment creator if there is a new comment on the issue', 'A new comment has been added', '<p>Dear {USERS_USERNAME}, </p><p>This email is to inform that a comment has been newly added into the issue {ITEM_TITLE_WITH_LINK} at {CONFIG.SITE_TITLE} with the following details:</p><p> <strong>Comment URL:</strong> {ITEM_LINK} </p><p><strong>Comment details:</strong> {ITEM_DETAILS} </p><p>Please click on the link above to view the full details. </p><p>Sincerely, {CONFIG.SITE_TITLE}</p>', '', '', 1, 0, 'en-GB', 0);

--
-- Create table jacomment_items
--

DROP TABLE IF EXISTS `#__jacomment_items`;
CREATE TABLE `#__jacomment_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `contentid` int(10) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `name` varchar(200) DEFAULT NULL,
  `contenttitle` varchar(200) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL DEFAULT '',
  `website` varchar(100) NOT NULL DEFAULT '',
  `star` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `usertype` mediumtext NOT NULL,
  `option` varchar(50) NOT NULL DEFAULT 'com_content',
  `voted` smallint(6) NOT NULL DEFAULT '0',
  `report` smallint(6) NOT NULL DEFAULT '0',
  `subscription_type` tinyint(4) NOT NULL DEFAULT '0',
  `referer` varchar(255) NOT NULL DEFAULT '',
  `source` varchar(20) NOT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `date_active` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `option` (`option`),
  KEY `contentid` (`contentid`),
  KEY `published` (`published`)
) TYPE=MyISAM AUTO_INCREMENT=15;
--
-- Create table jacomment_logs
--

DROP TABLE IF EXISTS `#__jacomment_logs`;
CREATE TABLE `#__jacomment_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `itemid` int(11) DEFAULT NULL,
  `votes` int(4) NOT NULL DEFAULT '0',
  `reports` int(4) NOT NULL DEFAULT '0',
  `time_expired` int(11) DEFAULT NULL,
  `remote_addr` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=428;
--
-- Create table jaem_log
--

DROP TABLE IF EXISTS `#__jaem_log`;
CREATE TABLE `#__jaem_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ext_id` varchar(50) DEFAULT NULL,
  `check_date` datetime DEFAULT NULL,
  `check_info` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ext_id` (`ext_id`)
) TYPE=MyISAM;
--
-- Create table jaem_services
--

DROP TABLE IF EXISTS `#__jaem_services`;
CREATE TABLE `#__jaem_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ws_name` varchar(255) NOT NULL,
  `ws_mode` varchar(50) NOT NULL DEFAULT 'local',
  `ws_uri` varchar(255) NOT NULL,
  `ws_user` varchar(100) NOT NULL,
  `ws_pass` varchar(100) NOT NULL,
  `ws_default` tinyint(1) NOT NULL DEFAULT '0',
  `ws_core` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3;

--
-- Dumping data for table `pii_jaem_services`
--

INSERT INTO `#__jaem_services` (`id`, `ws_name`, `ws_mode`, `ws_uri`, `ws_user`, `ws_pass`, `ws_default`, `ws_core`) VALUES
(1, 'Local Service', 'local', '', '', '', 1, 1),
(2, 'JoomlArt Updates', 'remote', 'http://update.joomlart.com/service/', '', '', 0, 1);

--
-- Create table k2_attachments
--

DROP TABLE IF EXISTS `#__k2_attachments`;
CREATE TABLE `#__k2_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `titleAttribute` text NOT NULL,
  `hits` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `itemID` (`itemID`)
) TYPE=MyISAM;
--
-- Create table k2_categories
--

DROP TABLE IF EXISTS `#__k2_categories`;
CREATE TABLE `#__k2_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `parent` int(11) DEFAULT '0',
  `extraFieldsGroup` int(11) NOT NULL,
  `published` smallint(6) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `trash` smallint(6) NOT NULL DEFAULT '0',
  `plugins` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`published`,`access`,`trash`),
  KEY `parent` (`parent`),
  KEY `ordering` (`ordering`),
  KEY `published` (`published`),
  KEY `access` (`access`),
  KEY `trash` (`trash`)
) TYPE=MyISAM AUTO_INCREMENT=7;
--
-- Create table k2_comments
--

DROP TABLE IF EXISTS `#__k2_comments`;
CREATE TABLE `#__k2_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `commentDate` datetime NOT NULL,
  `commentText` text NOT NULL,
  `commentEmail` varchar(255) NOT NULL,
  `commentURL` varchar(255) NOT NULL,
  `published` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `itemID` (`itemID`),
  KEY `userID` (`userID`),
  KEY `published` (`published`),
  KEY `latestComments` (`published`,`commentDate`)
) TYPE=MyISAM AUTO_INCREMENT=10;
--
-- Create table k2_extra_fields
--

DROP TABLE IF EXISTS `#__k2_extra_fields`;
CREATE TABLE `#__k2_extra_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `group` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group` (`group`),
  KEY `published` (`published`),
  KEY `ordering` (`ordering`)
) TYPE=MyISAM;

--
-- Dumping data for table `pii_k2_extra_fields`
--


--
-- Create table k2_extra_fields_groups
--

DROP TABLE IF EXISTS `#__k2_extra_fields_groups`;
CREATE TABLE `#__k2_extra_fields_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `pii_k2_extra_fields_groups`
--


--
-- Create table k2_items
--

DROP TABLE IF EXISTS `#__k2_items`;
CREATE TABLE `#__k2_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `catid` int(11) NOT NULL,
  `published` smallint(6) NOT NULL DEFAULT '0',
  `introtext` text NOT NULL,
  `fulltext` text NOT NULL,
  `video` text,
  `gallery` varchar(255) DEFAULT NULL,
  `extra_fields` text,
  `extra_fields_search` text NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL,
  `publish_down` datetime NOT NULL,
  `trash` smallint(6) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `featured` smallint(6) NOT NULL DEFAULT '0',
  `featured_ordering` int(11) NOT NULL DEFAULT '0',
  `image_caption` text NOT NULL,
  `image_credits` varchar(255) NOT NULL,
  `video_caption` text NOT NULL,
  `video_credits` varchar(255) NOT NULL,
  `hits` int(10) unsigned NOT NULL,
  `params` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `metakey` text NOT NULL,
  `plugins` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item` (`published`,`publish_up`,`publish_down`,`trash`,`access`),
  KEY `catid` (`catid`),
  KEY `created_by` (`created_by`),
  KEY `ordering` (`ordering`),
  KEY `featured` (`featured`),
  KEY `featured_ordering` (`featured_ordering`),
  KEY `hits` (`hits`),
  KEY `created` (`created`),
  FULLTEXT KEY `search` (`title`,`introtext`,`fulltext`,`extra_fields_search`,`image_caption`,`image_credits`,`video_caption`,`video_credits`,`metadesc`,`metakey`),
  FULLTEXT KEY `title` (`title`)
) TYPE=MyISAM AUTO_INCREMENT=25;
--
-- Create table k2_rating
--

DROP TABLE IF EXISTS `#__k2_rating`;
CREATE TABLE `#__k2_rating` (
  `itemID` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(11) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(11) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemID`)
) TYPE=MyISAM;
--
-- Create table k2_tags
--

DROP TABLE IF EXISTS `#__k2_tags`;
CREATE TABLE `#__k2_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `published` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `published` (`published`),
  FULLTEXT KEY `name` (`name`)
) TYPE=MyISAM AUTO_INCREMENT=25;
--
-- Create table k2_tags_xref
--

DROP TABLE IF EXISTS `#__k2_tags_xref`;
CREATE TABLE `#__k2_tags_xref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tagID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tagID` (`tagID`),
  KEY `itemID` (`itemID`)
) TYPE=MyISAM AUTO_INCREMENT=76;
--
-- Create table k2_user_groups
--

DROP TABLE IF EXISTS `#__k2_user_groups`;
CREATE TABLE `#__k2_user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3;

--
-- Dumping data for table `pii_k2_user_groups`
--

INSERT INTO `#__k2_user_groups` (`id`, `name`, `permissions`) VALUES
(1, 'Registered', 'comment=1\nfrontEdit=0\nadd=0\neditOwn=0\neditAll=0\npublish=0\ninheritance=0\ncategories=all\n\n'),
(2, 'Site Owner', 'frontEdit=1\nadd=1\neditOwn=1\neditAll=1\npublish=1\ncomment=1\ninheritance=1\ncategories=all\n\n');

--
-- Create table k2_users
--

DROP TABLE IF EXISTS `#__k2_users`;
CREATE TABLE `#__k2_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `gender` enum('m','f') NOT NULL DEFAULT 'm',
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `group` int(11) NOT NULL DEFAULT '0',
  `plugins` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `group` (`group`)
) TYPE=MyISAM AUTO_INCREMENT=9;
--
-- Create table menu
--

DROP TABLE IF EXISTS `#__menu`;
CREATE TABLE `#__menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menutype` varchar(75) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `link` text,
  `type` varchar(50) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  `componentid` int(11) unsigned NOT NULL DEFAULT '0',
  `sublevel` int(11) DEFAULT '0',
  `ordering` int(11) DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL DEFAULT '0',
  `browserNav` tinyint(4) DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `utaccess` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `lft` int(11) unsigned NOT NULL DEFAULT '0',
  `rgt` int(11) unsigned NOT NULL DEFAULT '0',
  `home` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) TYPE=MyISAM AUTO_INCREMENT=130;
--
-- Create table menu_types
--

DROP TABLE IF EXISTS `#__menu_types`;
CREATE TABLE `#__menu_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menutype` varchar(75) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `menutype` (`menutype`)
) TYPE=MyISAM AUTO_INCREMENT=7;
--
-- Create table messages
--

DROP TABLE IF EXISTS `#__messages`;
CREATE TABLE `#__messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_to` int(10) unsigned NOT NULL DEFAULT '0',
  `folder_id` int(10) unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` int(11) NOT NULL DEFAULT '0',
  `priority` int(1) unsigned NOT NULL DEFAULT '0',
  `subject` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) TYPE=MyISAM;
--
-- Create table messages_cfg
--

DROP TABLE IF EXISTS `#__messages_cfg`;
CREATE TABLE `#__messages_cfg` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cfg_name` varchar(100) NOT NULL DEFAULT '',
  `cfg_value` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) TYPE=MyISAM;
--
-- Create table migration_backlinks
--

DROP TABLE IF EXISTS `#__migration_backlinks`;
CREATE TABLE `#__migration_backlinks` (
  `itemid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `sefurl` text NOT NULL,
  `newurl` text NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM;
--
-- Create table modules
--

DROP TABLE IF EXISTS `#__modules`;
CREATE TABLE `#__modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) DEFAULT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `numnews` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL DEFAULT '0',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `control` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) TYPE=MyISAM AUTO_INCREMENT=117;

--
-- Dumping data for table `pii_modules`
--

INSERT INTO `#__modules` (`id`, `title`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `published`, `module`, `numnews`, `access`, `showtitle`, `params`, `iscore`, `client_id`, `control`) VALUES
(1, 'Main Menu', '', 1, 'header', 62, '2011-01-27 06:47:09', 0, 'mod_mainmenu', 0, 0, 1, 'menutype=mainmenu\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n', 1, 0, ''),
(2, 'Login', '', 1, 'login', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 1, ''),
(3, 'Popular', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_popular', 0, 2, 1, '', 0, 1, ''),
(4, 'Recent added Articles', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_latest', 0, 2, 1, 'ordering=c_dsc\nuser_id=0\ncache=0\n\n', 0, 1, ''),
(5, 'Menu Stats', '', 5, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 2, 1, '', 0, 1, ''),
(6, 'Unread Messages', '', 1, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_unread', 0, 2, 1, '', 1, 1, ''),
(7, 'Online Users', '', 2, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_online', 0, 2, 1, '', 1, 1, ''),
(8, 'Toolbar', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 1, 'mod_toolbar', 0, 2, 1, '', 1, 1, ''),
(9, 'Quick Icons', '', 1, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_quickicon', 0, 2, 1, '', 1, 1, ''),
(10, 'Logged in Users', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_logged', 0, 2, 1, '', 0, 1, ''),
(11, 'Footer', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 1, '', 1, 1, ''),
(12, 'Admin Menu', '', 1, 'menu', 0, '0000-00-00 00:00:00', 1, 'mod_menu', 0, 2, 1, '', 0, 1, ''),
(13, 'Admin SubMenu', '', 1, 'submenu', 0, '0000-00-00 00:00:00', 1, 'mod_submenu', 0, 2, 1, '', 0, 1, ''),
(14, 'User Status', '', 1, 'status', 0, '0000-00-00 00:00:00', 1, 'mod_status', 0, 2, 1, '', 0, 1, ''),
(15, 'Title', '', 1, 'title', 0, '0000-00-00 00:00:00', 1, 'mod_title', 0, 2, 1, '', 0, 1, ''),
(17, 'User Menu', '', 0, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 1, 1, 'menutype=usermenu\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n', 1, 0, ''),
(18, 'Login Form', '', 0, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, 'cache=0\nmoduleclass_sfx=\npretext=\nposttext=\nlogin=\nlogout=\ngreeting=1\nname=0\nusesecure=0\n\n', 1, 0, ''),
(19, 'Latest News', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_latestnews', 0, 0, 1, 'count=3\nordering=c_dsc\nuser_id=0\nshow_front=0\nsecid=\ncatid=\nmoduleclass_sfx=_latestnews\ncache=1\ncache_time=900\n\n', 1, 0, ''),
(20, 'Statistics', '', 6, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 0, 1, 'serverinfo=1\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=_noborder\ncache=0\ncache_time=900\n\n', 0, 0, ''),
(21, 'Who''s Online', '', 13, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_whosonline', 0, 0, 1, 'cache=0\nshowmode=0\nmoduleclass_sfx=_green\n\n', 0, 0, ''),
(22, 'Popular', '', 1, 'user7', 62, '2010-10-21 08:20:13', 0, 'mod_mostread', 0, 0, 1, 'moduleclass_sfx=\nshow_front=1\ncount=5\ncatid=\nsecid=\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(23, 'Archive', '', 1, 'content-mass-bottom', 0, '0000-00-00 00:00:00', 0, 'mod_archive', 0, 0, 1, 'count=10\nmoduleclass_sfx=\ncache=1\n\n', 1, 0, ''),
(24, 'Sections', '', 2, 'content-mass-bottom', 0, '0000-00-00 00:00:00', 0, 'mod_sections', 0, 0, 1, 'count=5\nmoduleclass_sfx=\ncache=1\ncache_time=900\n\n', 1, 0, ''),
(26, 'Related Items', '', 7, 'right', 0, '0000-00-00 00:00:00', 0, 'mod_related_items', 0, 0, 1, 'showDate=1\nmoduleclass_sfx=\ncache_items=0\ncache_time=900\n\n', 0, 0, ''),
(27, 'Search', '', 0, 'search', 0, '0000-00-00 00:00:00', 1, 'mod_search', 0, 0, 0, 'moduleclass_sfx=\nwidth=20\ntext=\nbutton=1\nbutton_pos=right\nimagebutton=\nbutton_text=\nset_itemid=\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(28, 'Random Image', '', 16, 'right', 0, '0000-00-00 00:00:00', 0, 'mod_random_image', 0, 0, 1, '', 0, 0, ''),
(29, 'Top Menu', '', 3, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=topmenu\nmenu_style=list_flat\nstartLevel=0\nendLevel=0\nshowAllChildren=1\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=-nav\nmoduleclass_sfx=\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=-1\nindent_image2=-1\nindent_image3=-1\nindent_image4=-1\nindent_image5=-1\nindent_image6=-1\nspacer=\nend_spacer=\n\n', 1, 0, ''),
(30, 'Banner', '', 0, 'hornav', 0, '0000-00-00 00:00:00', 0, 'mod_banners', 0, 0, 0, 'target=1\ncount=1\ncid=1\ncatid=33\ntag_search=0\nordering=random\nheader_text=\nfooter_text=\nmoduleclass_sfx=\ncache=1\ncache_time=15\n\n', 1, 0, ''),
(31, 'Resources', '', 3, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=othermenu\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n', 0, 0, ''),
(32, 'Wrapper', '', 7, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_wrapper', 0, 0, 1, 'moduleclass_sfx=_wrapper\nurl=\nscrolling=yes\nwidth=100%\nheight=200\nheight_auto=1\nadd=1\ntarget=\ncache=0\ncache_time=900\n\n', 0, 0, ''),
(33, 'Footer', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 0, 'cache=1\n\n', 1, 0, ''),
(34, 'Feed Display', '', 3, 'content-mass-bottom', 0, '0000-00-00 00:00:00', 0, 'mod_feed', 0, 0, 1, 'moduleclass_sfx=\nrssurl=\nrssrtl=0\nrsstitle=1\nrssdesc=1\nrssimage=1\nrssitems=3\nrssitemdesc=1\nword_count=0\ncache=0\ncache_time=15\n\n', 1, 0, ''),
(35, 'Breadcrumbs', '', 1, 'breadcrumb', 0, '0000-00-00 00:00:00', 1, 'mod_breadcrumbs', 0, 0, 1, 'moduleclass_sfx=\ncache=0\nshowHome=1\nhomeText=Home\nshowComponent=1\nseparator=\n\n', 1, 0, ''),
(36, 'Syndication', '', 4, 'content-mass-bottom', 0, '0000-00-00 00:00:00', 0, 'mod_syndicate', 0, 0, 1, 'cache=0\ntext=Feed Entries\nformat=rss\nmoduleclass_sfx=\n\n', 1, 0, ''),
(39, 'Example Pages', '', 4, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_mainmenu', 0, 0, 1, 'menutype=keyconcepts\nmenu_style=list_flat\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n', 0, 0, ''),
(40, 'Key Concepts', '', 0, 'footer', 62, '2010-11-01 10:39:58', 0, 'mod_mainmenu', 0, 0, 1, 'menutype=keyconcepts\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n', 0, 0, ''),
(41, 'Welcome to Joomla!', '<div style="padding: 5px">  <p>   Congratulations on choosing Joomla! as your content management system. To   help you get started, check out these excellent resources for securing your   server and pointers to documentation and other helpful resources. </p> <p>   <strong>Security</strong><br /> </p> <p>   On the Internet, security is always a concern. For that reason, you are   encouraged to subscribe to the   <a href="http://feedburner.google.com/fb/a/mailverify?uri=JoomlaSecurityNews" target="_blank">Joomla!   Security Announcements</a> for the latest information on new Joomla! releases,   emailed to you automatically. </p> <p>   If this is one of your first Web sites, security considerations may   seem complicated and intimidating. There are three simple steps that go a long   way towards securing a Web site: (1) regular backups; (2) prompt updates to the   <a href="http://www.joomla.org/download.html" target="_blank">latest Joomla! release;</a> and (3) a <a href="http://docs.joomla.org/Security_Checklist_2_-_Hosting_and_Server_Setup" target="_blank" title="good Web host">good Web host</a>. There are many other important security considerations that you can learn about by reading the <a href="http://docs.joomla.org/Category:Security_Checklist" target="_blank" title="Joomla! Security Checklist">Joomla! Security Checklist</a>. </p> <p>If you believe your Web site was attacked, or you think you have discovered a security issue in Joomla!, please do not post it in the Joomla! forums. Publishing this information could put other Web sites at risk. Instead, report possible security vulnerabilities to the <a href="http://developer.joomla.org/security/contact-the-team.html" target="_blank" title="Joomla! Security Task Force">Joomla! Security Task Force</a>.</p><p><strong>Learning Joomla!</strong> </p> <p>   A good place to start learning Joomla! is the   "<a href="http://docs.joomla.org/beginners" target="_blank">Absolute Beginner''s   Guide to Joomla!.</a>" There, you will find a Quick Start to Joomla!   <a href="http://help.joomla.org/ghop/feb2008/task048/joomla_15_quickstart.pdf" target="_blank">guide</a>   and <a href="http://help.joomla.org/ghop/feb2008/task167/index.html" target="_blank">video</a>,   amongst many other tutorials. The   <a href="http://community.joomla.org/magazine/view-all-issues.html" target="_blank">Joomla!   Community Magazine</a> also has   <a href="http://community.joomla.org/magazine/article/522-introductory-learning-joomla-using-sample-data.html" target="_blank">articles   for new learners</a> and experienced users, alike. A great place to look for   answers is the   <a href="http://docs.joomla.org/Category:FAQ" target="_blank">Frequently Asked   Questions (FAQ)</a>. If you are stuck on a particular screen in the   Administrator (which is where you are now), try clicking the Help toolbar   button to get assistance specific to that page. </p> <p>   If you still have questions, please feel free to use the   <a href="http://forum.joomla.org/" target="_blank">Joomla! Forums.</a> The forums   are an incredibly valuable resource for all levels of Joomla! users. Before   you post a question, though, use the forum search (located at the top of each   forum page) to see if the question has been asked and answered. </p> <p>   <strong>Getting Involved</strong> </p> <p>   <a name="twjs" title="twjs"></a> If you want to help make Joomla! better, consider getting   involved. There are   <a href="http://www.joomla.org/about-joomla/contribute-to-joomla.html" target="_blank">many ways   you can make a positive difference.</a> Have fun using Joomla!.</p></div>', 0, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 2, 1, 'moduleclass_sfx=\n\n', 1, 1, ''),
(42, 'Joomla! Security Newsfeed', '', 6, 'cpanel', 62, '2008-10-25 20:15:17', 1, 'mod_feed', 0, 0, 1, 'cache=1\ncache_time=15\nmoduleclass_sfx=\nrssurl=http://feeds.joomla.org/JoomlaSecurityNews\nrssrtl=0\nrsstitle=1\nrssdesc=0\nrssimage=1\nrssitems=1\nrssitemdesc=1\nword_count=0\n\n', 0, 1, ''),
(80, 'K2 Comments', '', 9, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_k2_comments', 0, 0, 1, 'moduleclass_sfx=_white\nmodule_usage=0\ncatfilter=1\ncategory_id=1\ncomments_limit=5\ncomments_word_limit=10\ncommenterName=1\ncommentAvatar=1\ncommentAvatarWidthSelect=custom\ncommentAvatarWidth=25\ncommentDate=1\ncommentDateFormat=absolute\ncommentLink=1\nitemTitle=0\nitemCategory=0\nfeed=0\ncommenters_limit=5\ncommenterAvatar=1\ncommenterAvatarWidthSelect=custom\ncommenterAvatarWidth=50\ncommenterLink=1\ncommenterCommentsCounter=1\ncommenterLatestComment=1\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(44, 'Who are we?', '<p>Mauris urna risus, tempus eu ultrices id, mattis at tellus. Duis rutrum, quam nec consequat malesuada, ante elit adipiscing velit, non imperdiet nunc felis ac mauris. Duis porttitor elementum mi.</p>\r\n<p class="readmore"><a class="more" href="#"><span>Read more</span></a></p>', 0, 'content-mass-top', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=_icon1\n\n', 0, 0, ''),
(47, 'Our services', '<p>Mauris urna risus, tempus eu ultrices id, mattis at tellus. Duis rutrum, quam nec consequat malesuada, ante elit adipiscing velit, non imperdiet nunc felis ac mauris. Duis porttitor elementum mi.</p>\r\n<p class="readmore"><a class="more" href="#"><span>Read more</span></a></p>', 2, 'content-mass-top', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=_icon2\n\n', 0, 0, ''),
(45, 'What is plugin?', '<img src="images/stories/demo/sam-9.png" alt="Global" align="left" style="margin-right: 10px;" />\r\n\r\n<a href="http://docs.joomla.org/Plugin" title="Plugin" target="_blank">A plugin</a> is a kind of Joomla! extension. Plugins provide routines which are associated with trigger events within Joomla.When a particular <a href="http://docs.joomla.org/Plugin" title="Plugin" target="_blank">...</a>', 0, 'user4', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(46, 'What''s the template?', '<img src="images/stories/demo/sam-5.png" alt="Template" align="left" style="margin-right: 10px;" />\r\n\r\n<a href="http://docs.joomla.org/Tutorial:Introduction_to_Joomla!_templates" title="What''s the template?" target="_blank">A template</a> controls the overall look and layout of a site. It provides the framework that brings together common elements, modules and <a href="http://docs.joomla.org/Tutorial:Introduction_to_Joomla!_templates" title="What''s the template?" target="_blank">...</a>', 1, 'user5', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(48, 'Company profiles', '<p>Mauris urna risus, tempus eu ultrices id, mattis at tellus. Duis rutrum, quam nec consequat malesuada, ante elit adipiscing velit, non imperdiet nunc felis ac mauris. Duis porttitor elementum mi.</p>\r\n<p class="readmore"><a class="more" href="#"><span>Read more</span></a></p>', 3, 'content-mass-top', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=_icon3\n\n', 0, 0, ''),
(58, 'We do it better', '<ul>\r\n<li class="money"><a class="money" href="#">Cras aliquet imperdiet</a></li>\r\n<li class="shopping"><a class="shopping" href="#">Nullam condimentum facilisis</a></li>\r\n<li class="lock"><a class="lock" href="#">Praesent nulla lectus</a></li>\r\n</ul>', 14, 'right', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=_news1\n\n', 0, 0, ''),
(102, 'Send us message', '<div class="clearfix">\r\n<ul class="info-contact" style="width: 220px;">\r\n<p style="margin-top: 0px ! important;">Subscribe to our e-Updates and keep abreast of our portal news.</p>\r\n<li><span style="color: #877460;">Phone:</span> +08 4123456</li>\r\n<li><span style="color: #877460;">Mobile:</span> +08 4123456</li>\r\n<li><span style="color: #877460;">Fax:</span> +08 4123456</li>\r\n<li><span style="color: #877460;">Email:</span> <a href="#">info@joomlart.com</a></li>\r\n<li><span style="color: #877460;">Skype:</span> <a href="#">joomlart</a></li>\r\n</ul>\r\n<div class="form-contact" style="width: 685px;"><form class="cotact-list" style="width: 370px;"> <label><span class="textarea">Name:</span><textarea id="form-message" name="message">You message here .</textarea> </label> </form> <form class="contact-view-list" style="width: 280px;"> <label><span>Name:</span><input class="form-text" maxlength="60" name="name" size="15" type="text" /></label> <label><span>Email:</span><input class="form-text" maxlength="60" name="email" size="15" type="text" /></label> <label><span>Phone:</span><input class="form-text" maxlength="60" name="email" size="15" type="text" /></label> <label><span>Web:</span><input class="form-text" maxlength="60" name="email" size="15" type="text" /></label> <a class="links">Send message</a> </form></div>\r\n</div>', 0, 'user4', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=_register\n\n', 0, 0, ''),
(50, 'How to?', '<ul>\r\n<li><a href="#" title="Sample link">How to Remove ‘Welcome to the Frontpage’?</a></li>\r\n<li><a href="#" title="Sample link">How to Install a Joomla! template?</a></li>\r\n<li><a href="#" title="Sample link">How to Apply a Module Class Suffix in Joomla! 1.5?</a></li>\r\n</ul>', 0, 'user10', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(52, 'The community', '', 0, 'user9', 0, '0000-00-00 00:00:00', 0, 'mod_latestnews', 0, 0, 1, 'count=5\nordering=c_dsc\nuser_id=0\nshow_front=1\nsecid=\ncatid=30\nmoduleclass_sfx=\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(54, 'Download', 'JA Purity II is free. <a title="Go to our Forum for more information" href="http://www.joomlart.com/forums/forumdisplay.php?f=170">Visit our Forum</a> for more information', 1, 'mega1', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(55, 'Features Highlight', '<p>JA Purity II use JA T3 template frameworks, you can:\r\n</p>\r\n<p><strong>- Support multi &amp; flexible layout</strong>\r\n</p>\r\n<p><strong>- Iphone + Handheld support</strong>\r\n</p>\r\n<p><strong>- Menu system is second to none</strong>\r\n</p>\r\n<p><strong>- SEO &amp; Fast loading..</strong>\r\n  <br />\r\n</p>', 1, 'mega2', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(56, 'Images Bottom', '', 0, 'user11', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=_blank\n\n', 0, 0, ''),
(57, 'Vimeo', '<object height="170" width="300" style="background:#000" data="http://vimeo.com/moogaloop.swf?clip_id=7047863&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash"><param value="300" name="width"/><param value="170" name="height"/><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="wmode" value="transparent" /><param name="src" value="http://vimeo.com/moogaloop.swf?clip_id=7047863&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" /></object>', 0, 'vimeo', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(60, 'JA Slideshow2 Module', '', 2, 'slideshow', 0, '0000-00-00 00:00:00', 1, 'mod_jaslideshow2', 0, 0, 0, 'moduleclass_sfx=\nskin=business\nsource=articles\nsource-articles-display_model=modcats\nsource-articles-display_model-modarts-with_keyword=featured\nsource-articles-display_model-modcats-category=34\nsource-articles-sort_order_field=created\nsource-articles-sort_order=DESC\nsource-articles-max_items=5\nsource-images-orderby=0\nsource-images-sort=0\nfolder=images/stories/fruit\ndescription=\nautoplay=0\nmainWidth=970\nmainHeight=170\nstartItem=0\nanimation=fade\ncontainer=0\nduration=400\neffect=Fx.Transitions.Quad.easeInOut\ninterval=5000\nanimationRepeat=yes\nshowdesc=desc-readmore\nshow_readmore=1\nreadmoretext=Our services\ntitle_max_chars=200\nmaxchars=150\nincludeTags=p,h5,h4\ndescOpacity=1\nshowdescwhen=load\nmasker-alignment=right\nmasker-width=auto\nmasker-height=auto\nmasker-transition-style=style\nmarker-transition=Fx.Transitions.linear\ncontrol=1\nnavigation=thumbs\nnavigation-alignment=horizontal\nshowItem=4\nitem-navwidth=20\nitem-navheight=20\nsource-articles-navwidth=240\nsource-articles-navheight=56\nnav_showthumb=1\nthumbWidth=32\nthumbHeight=32\nthumbSpace=1\nthumbOpacity=0.8\nsource-articles-nav_showdate=0\nsource-articles-nav_showdesc=1\nsource-articles-nav_descmaxlength=0\noverlapOpacity=0.4\nenable_cache=0\ncache_time=30\nopen_target=parent\nsource-articles-images-thumbnail_mode=crop\nsource-articles-images-thumbnail_mode-resize-use_ratio=1\n\n', 0, 0, ''),
(61, 'Live Consulation', '<div class="button clearfix">\r\n<h3>Lorem ipsum dolor sit amet</h3>\r\n<a class="button" href="#">Live consultation</a></div>', 6, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(62, 'JA Top Panel Module', '', 0, 'toppanel', 62, '2011-01-26 07:05:50', 1, 'mod_jatoppanel', 0, 0, 0, 'moduleclass_sfx=_raw\ntype=modules\nmodules=ja-toppanel\nmodulename=mod_k2_login\narticle-ids=1, 2, 3, 4\narticle-catid=\nlimit=\nmaxchars=100\nreadmore=1\nshowimage=1\nthumbnail_mode=crop\nresize_use_ratio=1\ntwidth=100\ntheight=100\nalign=left\nduration=500\ndontshowagain=1\ntransparent=0\nauto=0\ndelay=0\nhowmanytimes=-1\ncookie_suffix=jatoppanel_\noverlay=0\ndisplay=ja-toppanel-col\n\n', 0, 0, ''),
(116, 'JA Login', '', 0, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_jalogin', 0, 0, 0, 'cache=0\nmoduleclass_sfx=\npretext=\nposttext=\nlogin=1\nlogout=1\ngreeting=1\nname=0\nusesecure=0\n\n', 0, 0, ''),
(63, 'Mission & Staff', '<ul>\r\n<li><a href="#" title="Sample link">Nunc scelerisque</a></li>\r\n<li><a href="#" title="Sample link">Donec facilisis dictum </a></li>\r\n<li><a href="#" title="Sample link">Praesent hendrerit</a></li>\r\n</ul>', 1, 'user6', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(64, 'Servies', '<ul>\r\n<li><a href="#" title="Sample link">Vivamus</a></li>\r\n<li><a href="#" title="Sample link">Mauris none enim tortor</a></li>\r\n<li><a href="#" title="Sample link">Phasellus ac velit</a></li>\r\n</ul>', 2, 'user7', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(65, 'Other', '<ul>\r\n<li><a href="#" title="Sample link">Press Center</a></li>\r\n<li><a href="#" title="Sample link">Testimonies</a></li>\r\n<li><a href="#" title="Sample link">Aboutus</a></li>\r\n</ul>', 1, 'user9', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(66, 'Wordwide perspectives', '<p>Cras aliquet odio sed nulla euismod eleifend. Quisque volutpat mauris sed orci luctus aliquet ullamcorper sapien molestie.</p>\r\n<ul>\r\n<li><a href="#" title="Sample link">Link One here</a></li>\r\n<li><a href="#" title="Sample link">Second link here</a></li>\r\n<li><a href="#" title="Sample link">Third link</a></li>\r\n</ul>', 0, 'user10', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=_lastbotsl\n\n', 0, 0, ''),
(70, 'Recent News', '<ul class="recent-news clearfix" style="margin-top: 0;">\r\n\r\n<li style="padding-left: 0;">\r\n<h3>Recent News</h3>\r\n<a class="link-tittle" href="#">Suspendisse consectetur tincidunt lectus</a>\r\n<p>Curabitur in leo urna, non varius nunc. Mauris placerat tortor et magna dictum et fringilla nisi pellentesque.</p>\r\n<p class="date">17 July 2010</p>\r\n</li>\r\n\r\n<li> <a class="rss" href="#">Rss feed</a> <a class="link-tittle" href="#">Suspendisse consectetur tincidunt lectus</a>\r\n<p>Curabitur in leo urna, non varius nunc. Mauris placerat tortor et magna dictum et fringilla nisi pellentesque.</p>\r\n<p class="date">18 July 2010</p>\r\n</li>\r\n<li> <a class="archive" href="#">news archive</a> <a class="link-tittle" href="#">Ut est felis, tempor id adipiscing vel</a>\r\n<p>Curabitur in leo urna, non varius nunc. Mauris placerat tortor et magna dictum et fringilla nisi pellentesque.</p>\r\n<p class="date">19 July 2010</p>\r\n</li>\r\n</ul>', 0, 'user4', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(71, 'Newsletter', '<h3>Newsletter</h3>\r\n<p>Subscribe to our e-Updates and keep abreast of our portal news.</p>\r\n<form method="post" action="index.php"> <label><span>Name:</span><input class="form-text" maxlength="60" name="name" size="15" type="text" /></label> <label><span>Email:</span><input class="form-text" maxlength="60" name="email" size="15" type="text" /></label> <a class="links">Subcribe</a> </form>', 2, 'user5', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=_newsletter\n\n', 0, 0, ''),
(72, 'Share on', '<span>Share on:</span>\r\n<a class="share widgget" href="#" target="_blank" title="Add to Widgget">&nbsp;</a>\r\n<a class="share facebook" href="http://www.facebook.com/sharer.php?u=http://www.joomlart.com/index.php?option=com_k2&amp;Itemid=671&amp;id=385&amp;lang=en&amp;view=item" target="_blank" title="Add to Facebook">&nbsp;</a>\r\n<a class="share mail" href="#" target="_blank" title="Add to Mail">&nbsp;</a>\r\n<a class="share twitter" href="#" target="_blank" title="Twitter this">&nbsp;</a>\r\n<a class="share reddit" href="http://reddit.com/submit?url=http://www.joomlart.com/index.php?option=com_k2&amp;Itemid=671&amp;id=385&amp;lang=en&amp;view=item" target="_blank" title="Add to Reddit">&nbsp;</a>', 0, 'bottombar', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(76, 'Press Releases', '<ul>\r\n<h3>Press Releases</h3>\r\n<li> <a class="link-tittle" href="#">Phasellus nec nunc sed orci euismod adipiscing</a></li>\r\n<li> <a class="link-tittle" href="#">Lass aptent taciti sociosqu ad litora torquent per conubia nostra</a></li>\r\n<li> <a class="link-tittle" href="#">Quisque egestas faucibus</a></li>\r\n<li> <a class="link-tittle" href="#">Class aptent taciti sociosqu</a></li>\r\n</ul>\r\n<p><a class="button" href="#">All press releases</a></p>', 2, 'mega2', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=_releases\n\n', 0, 0, ''),
(74, 'Contact us', '<div class="contact-us">+5 123 45 678 <a class="btn-contact" href="index.php?option=com_contact&amp;view=contact&id=1&amp;Itemid=125">Contact us</a></div>', 0, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(75, 'Menu Additional', '<div class="mega1">\r\n<h3>Additional information for this menu item</h3>\r\n<div class="content-mega">\r\n<p><img src="images/stories/demo/sam-1.jpg" border="0" /></p>\r\n<p class="content-mega">Aliquam id ante ac ante rutrum vestibulum ac sed sapien. Nulam sapien nisi, tempus porta luctus a, tempor sed neque.</p>\r\n<p><a class="button" href="#">Action button</a></p>\r\n</div>\r\n</div>', 1, 'mega3', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, ''),
(77, 'Recent News1', '<ul>\r\n<li class="first">\r\n<h3>Recent News</h3>\r\n<p class="date">17 July 2010</p>\r\n<a class="link-tittle" href="#">Vestibulum ante ipsum primis in faucibus orci luctus</a>\r\n<p>Curabitur id dolor mauris.  Aenean ac nibh tortor, quis pellentesque neque. Proin est neque, elementum ut pharetra eget, rhoncus eget magna.</p>\r\n</li>\r\n<li>\r\n<p class="date">18 July 2010</p>\r\n<a class="link-tittle" href="#">Ut neque lacus, mattis a faucibus</a></li>\r\n</ul>\r\n<p><a class="button" href="#">All news</a></p>', 3, 'mega2', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=_mega2\n\n', 0, 0, ''),
(78, 'Our Partner', '<ul class="ourpartner">\r\n<li><a class="icon-joomlart" href="#"> </a></li>\r\n<li><a class="icon-t3framwork" href="#"> </a></li>\r\n<li><a class="icon-joomsolutions" href="#"> </a></li>\r\n<li><a class="icon-jobboard" href="#"> </a></li>\r\n</ul>', 6, 'content-mass-bottom', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=_partner\n\n', 0, 0, ''),
(79, 'For our future clients', '<div class="ja-innerdiv">\r\n<a class="title icon-pdf" href="#" title="Sample title"><span>Brochure: Overview of core services</span></a>\r\n<p>Cras aliquet odio sed nulla euismod eleifend. Quisque volutpat mauris sed orci luctus aliquet ullamcorper sapien molestie.</p>\r\n</div>\r\n\r\n<div class="ja-innerdiv" style="margin-bottom: 0;">\r\n<a class="title icon-excel" href="#" title="Sample title"><span>Nullam Updated pricelist</span></a>\r\n<p>Etiam non rhoncus odio. Morbi purus odio, vestibulum vitae facilisis quis aliquam a quam.</p>\r\n</div>', 15, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=_noborder\n\n', 0, 0, ''),
(81, 'Most popular blog posts', '', 12, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_k2_content', 0, 0, 1, 'moduleclass_sfx=_noborder\ngetTemplate=blog-style\nsource=filter\ncatfilter=1\ncategory_id=1\ngetChildren=0\nitemCount=3\nitemsOrdering=\nFeaturedItems=0\npopularityRange=\nvideosOnly=0\nitem=0\nitemTitle=1\nitemAuthor=0\nitemAuthorAvatar=0\nitemAuthorAvatarWidthSelect=custom\nitemAuthorAvatarWidth=40\nuserDescription=1\nitemIntroText=1\nitemIntroTextWordLimit=15\nitemImage=0\nitemImgSize=XSmall\nitemVideo=0\nitemVideoCaption=0\nitemVideoCredits=0\nitemAttachments=0\nitemTags=0\nitemCategory=0\nitemDateCreated=1\nitemHits=0\nitemReadMore=0\nitemExtraFields=0\nitemCommentsCounter=0\nfeed=0\nitemPreText=\nitemCustomLink=0\nitemCustomLinkURL=http://\nitemCustomLinkTitle=test link\nK2Plugins=1\nJPlugins=1\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(82, 'K2 Login', '', 1, 'mod_toppanel', 0, '0000-00-00 00:00:00', 0, 'mod_k2_login', 0, 0, 1, 'moduleclass_sfx=_login\npretext=\nposttext=\nuserGreetingText=\nname=1\nuserAvatar=1\nuserAvatarWidthSelect=custom\nuserAvatarWidth=50\nlogin=\nlogout=\nusesecure=0\ncache=0\ncache_time=900\n\n', 0, 0, ''),
(83, 'Upcoming events', '', 3, 'right', 0, '0000-00-00 00:00:00', 0, 'mod_k2_tools', 0, 0, 1, 'moduleclass_sfx=_calendar\nmodule_usage=2\narchiveItemsCounter=0\narchiveCategory=0\nauthors_module_category=0\nauthorItemsCounter=0\nauthorAvatar=0\nauthorAvatarWidthSelect=custom\nauthorAvatarWidth=50\nauthorLatestItem=1\ncalendarCategory=0\nhome=\nseperator=\nroot_id=0\nend_level=\ncategoriesListOrdering=\ncategoriesListItemsCounter=1\nroot_id2=0\nwidth=20\ntext=\nbutton=\nimagebutton=\nbutton_text=\nmin_size=75\nmax_size=150\ncloud_limit=15\ncloud_category=2\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(84, 'Popular authors', '', 8, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_k2_users', 0, 0, 1, 'moduleclass_sfx=\ngetTemplate=Default\nsource=specific\nfilter=0\nK2UserGroup=1\nordering=alpha\nlimit=3\nuserIDs=63|64|66|62\nuserName=1\nuserAvatar=1\nuserAvatarWidthSelect=custom\nuserAvatarWidth=70\nuserDescription=1\nuserDescriptionWordLimit=\nuserURL=0\nuserEmail=0\nuserFeed=0\nuserItemCount=0\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(85, 'K2 QuickIcons (admin)', '', 99, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_k2_quickicons', 0, 2, 1, 'modCSSStyling=1\nmodLogo=1\n', 0, 1, ''),
(87, 'Recent activity', '', 6, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_jafacebookactivity', 0, 0, 1, 'site=joomlart.com\nwidth=240\nheight=200\nheader=0\ncolorscheme=light\nfont=\nborder_color=white\nrecommendations=0\n\n', 0, 0, ''),
(88, 'Topsl1', '', 0, 'topsl1', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=_topbd\n\n', 0, 0, ''),
(90, 'From our twitter', '', 0, 'user5', 0, '0000-00-00 00:00:00', 1, 'mod_jatwitter', 0, 0, 1, 'moduleclass_sfx=\ntaccount=joomlart\nshow_username=1\nshow_icon=0\nicon_size=30\nuse_display_taccount=0\nsize_iconaccount=48\nshow_tweet=1\nshow_limit=1\nshow_source=0\nshowtextheading=0\nheadingtext=My Twitter Updates\nuse_friends=0\nsize_iconfriend=24\nmax_friends=10\nshowfollowlink=1\ntypefollowbutton=apiconnect\nstyle_of_follow_button=follow_me-a.png\napikey=5UyY9SoYLNTbfQfQdm82A\nenable_cache=1\ncache_time=5\nlayout=\nfix_oldversion=1\ndisplayitem=1\n\n', 0, 0, ''),
(89, 'Info block with an image in the bottom', '<div class="author-story clearfix">\r\n<div class="left">\r\n<img src="images/stories/story-1.jpg" border="0" alt="Author" class="img-border left" style="width: 90px;" />\r\n<p>Curabitur in leo urna, non varius nunc. Mauris placerat tortor et magna dictum et fringilla nisi pellentesque. Suspendisse consectetur tincidunt lectus. Curabitur in leo urna, non varius nunc.  Mauris placerat tortor...</p>\r\n</div>\r\n\r\n<div class="right">\r\n<p>Curabitur in leo urna, non varius nunc. Mauris placerat tortor et magna dictum et fringilla nisi pellentesque. Suspendisse consectetur tincidunt lectus. Curabitur in leo urna, non varius nunc.</p>\r\n<a class="ja-typo-button-white" href="#">action button here</a></div>\r\n\r\n</div>', 0, 'user4', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(108, 'JA GMap', '<div class="gmap-wrap">{jamap target_lat='''' target_lon='''' to_location=''Ha Noi'' to_location_info='''' from_location='''' maptype=''hybrid'' map_width=''604'' map_height=''200'' zoom=''15'' maptype_control_display=''1'' maptype_control_style=''drop_down'' toolbar_control_display=''1'' toolbar_control_position=''top_right'' display_layer=''none'' display_popup=''0'' display_scale=''1'' }</div>\r\n\r\n<div style="margin: 30px 0 0;">\r\n<img src="images/stories/demo/office.jpg" alt="Office" class="img-border left" style="margin-top: 5px;" />\r\n<p><strong>Nunc tincidunt ac in mattis lacus eget hendrerit pede tincidunt tincidunt. Nibh morbi urna volutpat odio et Sed tortor suscipit felis Integer. Libero Suspendisse Lorem ornare cursus libero consequat justo Vestibulum amet orci. Auctor Aenean sit Nunc est dui at vel felis Vestibulum pretium</strong>\r\n\r\n<p>Augue laoreet elit fringilla urna ut elit a tempor Maecenas eros. Nec et urna tortor consequat Quisque tincidunt fermentum Curabitur magnis lorem. Integer volutpat nunc justo tincidunt molestie <a href="#" title="Sample link">Nulla semper lorem</a> egestas nulla....</p>\r\n</div>', 0, 'content-top', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=_gmap\n\n', 0, 0, ''),
(91, 'Copy of Newsletter', '<h3>Newsletter</h3>\r\n<p>Subscribe to our e-Updates and keep abreast of our portal news.</p>\r\n<form> <label><span>Name:</span><input class="form-text" maxlength="60" name="name" size="15" type="text" /></label> <label><span>Email:</span><input class="form-text" maxlength="60" name="email" size="15" type="text" /></label> <a class="links">Subcribe</a> </form>', 4, 'mega2', 0, '0000-00-00 00:00:00', 0, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=_newsletter\n\n', 0, 0, ''),
(94, 'Poll of this month', '', 17, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_poll', 0, 0, 1, 'id=15\nmoduleclass_sfx=_poll\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(95, 'Contact details', '<div class="contact">\r\n<ul>\r\n<li class="address"><strong>Adress: </strong><span>Joomlart Inc.<br />6401 Stanford Ranch Rd<br />Ha Noi, Viet Nam</span></li>\r\n<li class="email"><strong>Email: </strong><a href="mailto: info@joomlart.com">info@joomlart.com</a> </li>\r\n<li class="phone"><strong>Phone: </strong> (+844) 034 7896 </li>\r\n<li class="skype"><strong>Skype: </strong><span>joomlart</span> </li>\r\n<li class="download"><strong>Download: </strong><a href="#" title="Your V.card">our V.Card</a> </li>\r\n</ul>\r\n</div>', 0, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=_noborder\n\n', 0, 0, ''),
(107, 'Blog Archive', '', 4, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_k2_tools', 0, 0, 1, 'moduleclass_sfx=\nmodule_usage=0\narchiveItemsCounter=1\narchiveCategory=0\nauthors_module_category=0\nauthorItemsCounter=1\nauthorAvatar=1\nauthorAvatarWidthSelect=custom\nauthorAvatarWidth=50\nauthorLatestItem=1\ncalendarCategory=0\nhome=\nseperator=\nroot_id=0\nend_level=\ncategoriesListOrdering=\ncategoriesListItemsCounter=1\nroot_id2=0\nwidth=20\ntext=\nbutton=\nimagebutton=\nbutton_text=\nmin_size=75\nmax_size=150\ncloud_limit=15\ncloud_category=0\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(99, 'Our social profiles', '<div class="social-network">\r\n<ul>\r\n<li class="twitter"><a href="#">Joomlart</a> at Twitter</li>\r\n<li class="linkedln"><a href="#">Joomlart</a> at Linkedln</li>\r\n<li class="facebook"><a href="#">Joomlart</a> at Facebook</li>\r\n<li class="flick"><a href="#">Joomlart</a> at Flick</li>\r\n</ul>\r\n</div>', 2, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=\n\n', 0, 0, ''),
(100, 'Our informations', '<div class="quick-info clearfix">\r\n\r\n\r\n<div class="left-side">\r\n<h3>Visit us</h3>\r\n<p>BizTheme Inc.<br />\r\n5052 College Oak Drive<br />\r\nSacramento, CA 97321</p>\r\n\r\n<p><strong>BizTheme Inc.</strong><br />\r\n5052 College Oak Drive<br />\r\nSacramento, CA 97321</p>\r\n</div>\r\n\r\n<div class="right-side">\r\n<h3>Contact us</h3>\r\n<p>\r\n<span>Phone: </span> (+844) 4123456<br />\r\n<span>Mobile: </span> (+844) 4123456<br />\r\n<span>Fax: </span> (+844) 4123456\r\n</P>\r\n<p>\r\n<span>Email: </span><a href="mailto: info@joomsoluitons.com" title="Send mail">info@joomsolutions.com</a><br />\r\n<span>Skype: </span><a href="#" title="Skype">JoomlArt</a><br />\r\n</P>\r\n\r\n</div>\r\n\r\n</div>\r\n\r\n<div class="office-info">\r\n<img src="images/stories/demo/sam-15.jpg" alt="Our office" class="img-border left" style="width: 100px;" />\r\n<p>Accumsan condimentum mauris consectetuer mauris ante Vestibulum Phasellus Donec adipiscing urna. Wisi semper nisl Curabitur dolor tincidunt id sapien <a href="#" title="Sample link">parturient urna sit</a>...</p>\r\n</div>', 0, 'ja-toppanel', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=_register\n\n', 0, 0, ''),
(103, 'Tag  Cloud', '', 10, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_k2_tools', 0, 0, 1, 'moduleclass_sfx=_noborder\nmodule_usage=7\narchiveItemsCounter=1\narchiveCategory=0\nauthors_module_category=0\nauthorItemsCounter=1\nauthorAvatar=1\nauthorAvatarWidthSelect=custom\nauthorAvatarWidth=50\nauthorLatestItem=1\ncalendarCategory=0\nhome=\nseperator=\nroot_id=0\nend_level=\ncategoriesListOrdering=\ncategoriesListItemsCounter=1\nroot_id2=0\nwidth=20\ntext=\nbutton=\nimagebutton=\nbutton_text=\nmin_size=75\nmax_size=200\ncloud_limit=15\ncloud_category=0\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(105, 'About author', '<div class="about-author">\r\n<img src="images/stories/avatar/avartar2.gif" border="0" alt="sample avartar" />\r\n<h4>Fernando Dixon</h4>\r\n<span>CE0 at JoomMaster Inc.</span>\r\n<p>Mauris placera tortor agna dictum et fringilla nisi penllentesque. Praesent quis nisi vitae arcu elementum sollictiudin. Pallentesque leo nunc.</p>\r\n</div>\r\n\r\n<div class="social-info">\r\n<ul>\r\n<li class="email"><a href="#">Contact author</a></li>\r\n<li class="linked-in"><a href="#">LinkedIn profile</a></li>\r\n</ul>\r\n</div>', 5, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx= author\n\n', 0, 0, ''),
(109, 'Quick contact', '', 2, 'ja-toppanel', 0, '0000-00-00 00:00:00', 1, 'mod_jaquickcontact', 0, 0, 1, 'class_suffix=\nsender_label=Username\nemail_label=Email\nsubject_label=Subject\nmessage_label=Message\nrecipient=\nsubject=\nshow_email_copy=0\nthank_msg=Thank you!\nmax_chars=1000\nredirect_url=index.php\nintro_text=Morbi eget enim condimentum sem et ligula nibh metus mattis tempor. Curabitur vitae leo dolor Aenean tempus eu lacus Nam In tempus. Ut sit neque at iaculis convallis nulla tempus interdum id dui.\nuse_ajax=0\n\n', 0, 0, ''),
(112, 'Free brochure', '<img src="images/stories/demo/free-brochure.jpg" alt="Free our brochure" />\r\n\r\n<p>Metus rhoncus Suspendisse feugiat aliquam leo consequat velit volutpat <a href="#" title="Sample link">auctor consequat</a>...</p>', 0, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 1, 'moduleclass_sfx=_noborder\n\n', 0, 0, ''),
(113, 'Latest comments', '', 0, 'mega1', 0, '0000-00-00 00:00:00', 1, 'mod_k2_comments', 0, 0, 0, 'moduleclass_sfx=_white\nmodule_usage=0\ncatfilter=1\ncategory_id=1\ncomments_limit=4\ncomments_word_limit=7\ncommenterName=0\ncommentAvatar=1\ncommentAvatarWidthSelect=custom\ncommentAvatarWidth=25\ncommentDate=1\ncommentDateFormat=relative\ncommentLink=1\nitemTitle=0\nitemCategory=0\nfeed=0\ncommenters_limit=5\ncommenterAvatar=1\ncommenterAvatarWidthSelect=custom\ncommenterAvatarWidth=50\ncommenterLink=1\ncommenterCommentsCounter=0\ncommenterLatestComment=1\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(114, 'Popular blog posts', '', 0, 'mega2', 0, '0000-00-00 00:00:00', 1, 'mod_k2_content', 0, 0, 0, 'moduleclass_sfx=_noborder\ngetTemplate=blog-style\nsource=filter\ncatfilter=1\ncategory_id=1\ngetChildren=0\nitemCount=3\nitemsOrdering=\nFeaturedItems=0\npopularityRange=\nvideosOnly=0\nitem=0\nitemTitle=1\nitemAuthor=0\nitemAuthorAvatar=0\nitemAuthorAvatarWidthSelect=custom\nitemAuthorAvatarWidth=40\nuserDescription=1\nitemIntroText=1\nitemIntroTextWordLimit=10\nitemImage=0\nitemImgSize=XSmall\nitemVideo=0\nitemVideoCaption=0\nitemVideoCredits=0\nitemAttachments=0\nitemTags=0\nitemCategory=0\nitemDateCreated=1\nitemHits=0\nitemReadMore=0\nitemExtraFields=0\nitemCommentsCounter=0\nfeed=0\nitemPreText=\nitemCustomLink=0\nitemCustomLinkURL=http://\nitemCustomLinkTitle=test link\nK2Plugins=1\nJPlugins=1\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(115, 'Mega video', '<div style="padding: 10px 0;"><img src="images/stories/demo/video.jpg" alt="Sample video" /></div>\r\n\r\n<p style="margin: 0 0 10px;">\r\nNullam mauris mauris, rhoncus non mattis semper, faucibus vulputate metus. Proin nec mi neque, mattis interdum mauris. Aliquam faucibus congue nisl sed vestibulum.<br />\r\n<a class="archive" href="#" title="Sample link">Update Now</a>\r\n</p>', 2, 'mega3', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 0, 0, 'moduleclass_sfx=\n\n', 0, 0, '');

--
-- Create table modules_menu
--

DROP TABLE IF EXISTS `#__modules_menu`;
CREATE TABLE `#__modules_menu` (
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`,`menuid`)
) TYPE=MyISAM;
--
-- Create table newsfeeds
--

DROP TABLE IF EXISTS `#__newsfeeds`;
CREATE TABLE `#__newsfeeds` (
  `catid` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `link` text NOT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `numarticles` int(11) unsigned NOT NULL DEFAULT '1',
  `cache_time` int(11) unsigned NOT NULL DEFAULT '3600',
  `checked_out` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rtl` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `published` (`published`),
  KEY `catid` (`catid`)
) TYPE=MyISAM AUTO_INCREMENT=15;
--
-- Create table plugins
--

DROP TABLE IF EXISTS `#__plugins`;
CREATE TABLE `#__plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `element` varchar(100) NOT NULL DEFAULT '',
  `folder` varchar(100) NOT NULL DEFAULT '',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(3) NOT NULL DEFAULT '0',
  `iscore` tinyint(3) NOT NULL DEFAULT '0',
  `client_id` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) TYPE=MyISAM AUTO_INCREMENT=53;

--
-- Dumping data for table `pii_plugins`
--

INSERT INTO `#__plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
(1, 'Authentication - Joomla', 'joomla', 'authentication', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(2, 'Authentication - LDAP', 'ldap', 'authentication', 0, 2, 0, 1, 0, 0, '0000-00-00 00:00:00', 'host=\nport=389\nuse_ldapV3=0\nnegotiate_tls=0\nno_referrals=0\nauth_method=bind\nbase_dn=\nsearch_string=\nusers_dn=\nusername=\npassword=\nldap_fullname=fullName\nldap_email=mail\nldap_uid=uid\n\n'),
(3, 'Authentication - GMail', 'gmail', 'authentication', 0, 4, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(4, 'Authentication - OpenID', 'openid', 'authentication', 0, 3, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(5, 'User - Joomla!', 'joomla', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'autoregister=1\n\n'),
(6, 'Search - Content', 'content', 'search', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\nsearch_content=1\nsearch_uncategorised=1\nsearch_archived=1\n\n'),
(7, 'Search - Contacts', 'contacts', 'search', 0, 3, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(8, 'Search - Categories', 'categories', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(9, 'Search - Sections', 'sections', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(10, 'Search - Newsfeeds', 'newsfeeds', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(11, 'Search - Weblinks', 'weblinks', 'search', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(12, 'Content - Pagebreak', 'pagebreak', 'content', 0, 10000, 1, 1, 0, 0, '0000-00-00 00:00:00', 'enabled=1\ntitle=1\nmultipage_toc=1\nshowall=1\n\n'),
(13, 'Content - Rating', 'vote', 'content', 0, 4, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(14, 'Content - Email Cloaking', 'emailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'mode=1\n\n'),
(15, 'Content - Code Hightlighter (GeSHi)', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(16, 'Content - Load Module', 'loadmodule', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'enabled=1\nstyle=0\n\n'),
(17, 'Content - Page Navigation', 'pagenavigation', 'content', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'position=1\n\n'),
(18, 'Editor - No Editor', 'none', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(19, 'Editor - TinyMCE', 'tinymce', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', 'theme=advanced\ncleanup=1\ncleanup_startup=0\nautosave=0\ncompressed=0\nrelative_urls=1\ntext_direction=ltr\nlang_mode=0\nlang_code=en\ninvalid_elements=applet\ncontent_css=1\ncontent_css_custom=\nnewlines=0\ntoolbar=top\nhr=1\nsmilies=1\ntable=1\nstyle=1\nlayer=1\nxhtmlxtras=0\ntemplate=0\ndirectionality=1\nfullscreen=1\nhtml_height=550\nhtml_width=750\npreview=1\ninsertdate=1\nformat_date=%Y-%m-%d\ninserttime=1\nformat_time=%H:%M:%S\n\n'),
(20, 'Editor - XStandard Lite 2.0', 'xstandard', 'editors', 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(21, 'Editor Button - Image', 'image', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(22, 'Editor Button - Pagebreak', 'pagebreak', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(23, 'Editor Button - Readmore', 'readmore', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(24, 'XML-RPC - Joomla', 'joomla', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(25, 'XML-RPC - Blogger API', 'blogger', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', 'catid=1\nsectionid=0\n\n'),
(27, 'System - SEF', 'sef', 'system', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(28, 'System - Debug', 'debug', 'system', 0, 3, 1, 0, 0, 0, '0000-00-00 00:00:00', 'queries=1\nmemory=1\nlangauge=1\n\n'),
(29, 'System - Legacy', 'legacy', 'system', 0, 4, 0, 1, 0, 0, '0000-00-00 00:00:00', 'route=0\n\n'),
(30, 'System - Cache', 'cache', 'system', 0, 5, 0, 1, 0, 0, '0000-00-00 00:00:00', 'browsercache=0\ncachetime=15\n\n'),
(31, 'System - Log', 'log', 'system', 0, 6, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(32, 'System - Remember Me', 'remember', 'system', 0, 7, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(33, 'System - Backlink', 'backlink', 'system', 0, 8, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(35, 'JA T3 Framework', 'jat3', 'system', 0, 9, 1, 0, 0, 62, '2010-04-08 08:43:29', 'mode=dev\n\n'),
(36, 'System - Mootools Upgrade', 'mtupgrade', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(42, 'Search - K2', 'k2', 'search', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n'),
(43, 'System - K2', 'k2', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(44, 'User - K2', 'k2', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(45, 'Content - JA Facebook Share', 'plg_jafacebookshare', 'content', 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 'source=com_k2\ncatsid=\nk2catsid=1\nposition=onAfterDisplay\ndisplay_on_list=1\ndisplay_on_home=1\napp_id=\ntype=button\n\n'),
(46, 'Content - JA Retweet Button', 'plg_jaretweet', 'content', 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 'source=com_k2\ncatsid=\nk2catsid=1\nposition=onAfterDisplayContent\ndisplay_on_list=1\ndisplay_on_home=1\ndata-count=horizontal\nlang=en\ndata-via=\ndata-related=\ndata-related-desc=\n\n'),
(47, 'Content - JA Facebook Like It', 'plg_jafacebooklike', 'content', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'source=com_k2\ncatsid=\nk2catsid=1|2|3|4|5|6\nposition=onBeforeDisplayContent\ndisplay_on_list=1\ndisplay_on_home=1\nfb_embed=iframe\napp_id=\nfb_layout=standard\nfb_show_faces=1\nfb_width=500\nfb_height=25\nfb_action=like\nfb_font=arial\nfb_color=light\nfb_align=left\n\n'),
(50, 'System - JA Map', 'plg_jamap', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'api_key=ABQIAAAAoimIIf4nnE7IqJykJ2XrGRRAsdw1R9diEPHz6551ucdaGe87CRRSrxfzPziOCz3Io4RuAZl6j9J9cQ\ndisable_map=0\nto_location=Ha Noi\ntarget_lat=\ntarget_lon=\nto_location_info=\nfrom_location=\nmaptype=hybrid\nmap_width=500\nmap_height=300\nzoom=15\nmaptype_control_display=1\nmaptype_control_style=drop_down\nmaptype_control_position=top_right\ntoolbar_control_display=1\ntoolbar_control_style=small_3d\ntoolbar_control_position=top_right\ndisplay_layer=none\ndisplay_popup=0\npopup_width=640\npopup_height=480\npopup_type=highslide\ndisplay_scale=1\ndisplay_overview=1\nsensor=0\nlist_params=target_lat|target_lon|to_location|to_location_info|from_location|maptype|map_width|map_height|zoom|maptype_control_display|maptype_control_style|toolbar_control_display|toolbar_control_position|display_layer|display_popup|display_scale\ncode_container={jamap target_lat='''' target_lon='''' to_location=''Ha Noi'' to_location_info='''' from_location='''' maptype=''hybrid'' map_width=''500'' map_height=''300'' zoom=''15'' maptype_control_display=''1'' maptype_control_style=''drop_down'' toolbar_control_display=''1'' toolbar_control_position=''top_right'' display_layer=''none'' display_popup=''0'' display_scale=''1'' }\n\n');

--
-- Create table poll_data
--

DROP TABLE IF EXISTS `#__poll_data`;
CREATE TABLE `#__poll_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pollid` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) TYPE=MyISAM AUTO_INCREMENT=25;
--
-- Create table poll_date
--

DROP TABLE IF EXISTS `#__poll_date`;
CREATE TABLE `#__poll_date` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL DEFAULT '0',
  `poll_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `poll_id` (`poll_id`)
) TYPE=MyISAM AUTO_INCREMENT=14;
--
-- Create table poll_menu
--

DROP TABLE IF EXISTS `#__poll_menu`;
CREATE TABLE `#__poll_menu` (
  `pollid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pollid`,`menuid`)
) TYPE=MyISAM;
--
-- Create table polls
--

DROP TABLE IF EXISTS `#__polls`;
CREATE TABLE `#__polls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `voters` int(9) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `lag` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=16;
--
-- Create table sections
--

DROP TABLE IF EXISTS `#__sections`;
CREATE TABLE `#__sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` text NOT NULL,
  `scope` varchar(50) NOT NULL DEFAULT '',
  `image_position` varchar(30) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_scope` (`scope`)
) TYPE=MyISAM AUTO_INCREMENT=7;
--
-- Create table session
--

DROP TABLE IF EXISTS `#__session`;
CREATE TABLE `#__session` (
  `username` varchar(150) DEFAULT '',
  `time` varchar(14) DEFAULT '',
  `session_id` varchar(200) NOT NULL DEFAULT '0',
  `guest` tinyint(4) DEFAULT '1',
  `userid` int(11) DEFAULT '0',
  `usertype` varchar(50) DEFAULT '',
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `client_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `data` longtext,
  PRIMARY KEY (`session_id`(64)),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) TYPE=MyISAM;
--
-- Create table stats_agents
--

DROP TABLE IF EXISTS `#__stats_agents`;
CREATE TABLE `#__stats_agents` (
  `agent` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '1'
) TYPE=MyISAM;
--
-- Create table templates_menu
--

DROP TABLE IF EXISTS `#__templates_menu`;
CREATE TABLE `#__templates_menu` (
  `template` varchar(255) NOT NULL DEFAULT '',
  `menuid` int(11) NOT NULL DEFAULT '0',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menuid`,`client_id`,`template`)
) TYPE=MyISAM;

--
-- Dumping data for table `pii_templates_menu`
--

INSERT INTO `#__templates_menu` (`template`, `menuid`, `client_id`) VALUES
('ja_business', 0, 0),
('khepri', 0, 1),
('ja_purity_iii_blog', 27, 0);

--
-- Create table users
--

DROP TABLE IF EXISTS `#__users`;
CREATE TABLE `#__users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `usertype` varchar(25) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `gid_block` (`gid`,`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) TYPE=MyISAM AUTO_INCREMENT=70;
--
-- Create table weblinks
--

DROP TABLE IF EXISTS `#__weblinks`;
CREATE TABLE `#__weblinks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) TYPE=MyISAM AUTO_INCREMENT=7;
INSERT INTO `#__menu` VALUES (1, 'mainmenu', 'Home', 'home', 'index.php?option=com_content&view=frontpage', 'component', 1, 0, 20, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'num_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\norderby_pri=\norderby_sec=front\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1\nshow_noauth=\nshow_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_item_navigation=\nshow_readmore=\nshow_vote=\nshow_icons=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nshow_hits=\nfeed_summary=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 1);
INSERT INTO `#__menu_types` VALUES (1, 'mainmenu', 'Main Menu', 'The main menu for the site');
INSERT INTO `#__modules_menu` VALUES (1,0);
