<?php
# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

// This section applies the variables set in /etc/apache2/envvars
// It depends on the changes to php.ini configuration and the SetEnv
// lines in the htaccess file.
$getenv = function ( $var ) {
    return $_ENV[$var] ?? die( "$var envvar needed!" );
};
$SECRET_DBPASSWORD = $getenv("WA_DBPASSWORD");
$SECRET_SECRETKEY = $getenv("WA_SECRETKEY");
$SECRET_UPGRADEKEY = $getenv("WA_UPGRADEKEY");
$SECRET_EXTDATADBPASSWORD = $getenv("WA_EXTDATADBPASSWORD");
unset($getenv);

#debugging
// error_reporting( -1 );
// ini_set( 'display_errors', 1 );
$wgShowSQLErrors = true;
$wgDebugDumpSql = true;
$wgShowDBErrorBacktrace = true;
if ( $_GET['debugmenow'] ?? false ) {
	$wgShowExceptionDetails = true;
	$wgShowSQLErrors = true;
	$wgDebugToolbar = true;
	$wgDebugDumpSql = true;
	$wgProfiler['class'] = 'ProfilerXhprof';
	$wgProfiler['output'] = [ 'ProfilerOutputText' ];
	$wgProfiler['visible'] = false;
}
if ( php_sapi_name() === 'cli' ) {
	$wgShowExceptionDetails = true;
}
$wgDebugLogGroups["exception"] = "/var/www/wikiapiary/log/exception.log";
$wgDebugLogGroups["error"] = "/var/www/wikiapiary/log/error.log";
$wgDebugLogGroups["fatal"] = "/var/www/wikiapiary/log/fatal.log";
$wgDebugLogGroups["DBQuery"] = "/var/www/wikiapiary/log/DBQuery.log";
$wgDebugLogGroups["DBConnection"] = "/var/www/wikiapiary/log/DBConnection.log";
$wgDebugLogGroups["DBPerformance"] = "/var/www/wikiapiary/log/DBPerformance.log";
$wgDebugLogGroups["slow-parse"] = "/var/www/wikiapiary/log/slow-parse.log";
$wgDebugLogGroups["exec"] = "/var/www/wikiapiary/log/exec.log";
$wgDebugLogGroups["runJobs"] = "/var/www/wikiapiary/log/runJobs.log";
$wgDebugLogFile = "/var/www/wikiapiary/log/debug.log";

$wgSitename = "WikiApiary";
$wgScriptPath = "/w";
$wgUsePathInfo = true;
$wgArticlePath = "/wiki/$1";
$wgServer = "https://wikiapiary.com";
$wgLogos = [
	'1x' => "/w/images/wikiapiary/thumb/5/5e/WikiApiary_Bee.png/128px-WikiApiary_Bee.png",
	'icon' => "/w/images/wikiapiary/thumb/5/5e/WikiApiary_Bee.png/128px-WikiApiary_Bee.png",
];

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO
$wgEmergencyContact = "admin@wikiapiary.com";
$wgPasswordSender = "admin@wikiapiary.com";
$wgEnotifUserTalk = true; # UPO
$wgEnotifWatchlist = true; # UPO
$wgEmailAuthentication = true;
$wgEmailConfirmToEdit = true;

## Database settings
$wgDBname = "mw_wikiapiary";
$wgDBuser = "mw_wikiapiary";
$wgDBpassword = $SECRET_DBPASSWORD;
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

## Shared memory settings
$wgMainCacheType = CACHE_MEMCACHED;
$wgSessionCacheType = CACHE_MEMCACHED;
$wgSessionsInObjectCache = true;
$wgEnableParserCache = true;
$wgParserCacheExpireTime = 60 * 60 * 24 * 3;

$wgEnableUploads = true;
$wgUploadDirectory = "{$IP}/images/wikiapiary";
$wgUploadPath = "/w/images/wikiapiary";
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";
$wgUseInstantCommons = false;
$wgFileExtensions = array_merge($wgFileExtensions, [
	'svg',
	'doc',
	'docx',
	'xls',
	'xlsx',
	'ppt',
	'pptx',
	'mp4',
	'gz',
	'pdf',
	'zip'
] );
$wgGroupPermissions['autoconfirmed']['upload_by_url'] = true;
$wgAllowCopyUploads = true;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = true;

# Site language code, should be one of the list in ./includes/languages/data/Names.php
$wgLanguageCode = "en";

# Time zone
$wgLocaltimezone = "UTC";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publicly accessible from the web.
$wgCacheDirectory = "/var/www/wikiapiary/cache";
$wgLocalisationCacheConf['store'] = 'array';

$wgSecretKey = $SECRET_SECRETKEY;

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = $SECRET_UPGRADEKEY;

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "http://creativecommons.org/licenses/by-sa/3.0/";
$wgRightsText = "Creative Commons Attribution Share Alike";
$wgRightsIcon = "/w/resources/assets/licenses/cc-by-sa.png";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

$wgCookiePrefix = 'wikiapiary';

$wgAllowUserCss = true;
$wgAllowUserJs = true;
$wgAllowSiteCSSOnRestrictedPages = true;

$wgMiserMode = true;
$wgEnableSidebarCache = true;

define("NS_EXTENSION", 800);
define("NS_EXTENSION_TALK", 801);
$wgExtraNamespaces[NS_EXTENSION] = "Extension";
$wgExtraNamespaces[NS_EXTENSION_TALK] = "Extension_talk";
$wgContentNamespaces[] = NS_EXTENSION;
$wgNamespacesToBeSearchedDefault[NS_EXTENSION] = true;

define("NS_FARM", 802);
define("NS_FARM_TALK", 803);
$wgExtraNamespaces[NS_FARM] = "Farm";
$wgExtraNamespaces[NS_FARM_TALK] = "Farm_talk";
$wgContentNamespaces[] = NS_FARM;
$wgNamespacesToBeSearchedDefault[NS_FARM] = true;
$wgNamespacesWithSubpages[NS_FARM] = true;

define("NS_SKIN", 804);
define("NS_SKIN_TALK", 805);
$wgExtraNamespaces[NS_SKIN] = "Skin";
$wgExtraNamespaces[NS_SKIN_TALK] = "Skin_talk";
$wgContentNamespaces[] = NS_SKIN;
$wgNamespacesToBeSearchedDefault[NS_SKIN] = true;

define("NS_GENERATOR", 808);
define("NS_GENERATOR_TALK", 809);
$wgExtraNamespaces[NS_GENERATOR] = "Generator";
$wgExtraNamespaces[NS_GENERATOR_TALK] = "Generator_talk";
$wgContentNamespaces[] = NS_GENERATOR;
$wgNamespacesToBeSearchedDefault[NS_GENERATOR] = true;
$wgNamespacesWithSubpages[NS_GENERATOR] = true;

define("NS_HOST", 810);
define("NS_HOST_TALK", 811);
$wgExtraNamespaces[NS_HOST] = "Host";
$wgExtraNamespaces[NS_HOST_TALK] = "Host_talk";
$wgContentNamespaces[] = NS_HOST;
$wgNamespacesToBeSearchedDefault[NS_HOST] = true;
$wgNamespacesWithSubpages[NS_HOST] = true;

define("NS_LIBRARY", 812);
define("NS_LIBRARY_TALK", 813);
$wgExtraNamespaces[NS_LIBRARY] = "Library";
$wgExtraNamespaces[NS_LIBRARY_TALK] = "Library_talk";
$wgContentNamespaces[] = NS_LIBRARY;
$wgNamespacesToBeSearchedDefault[NS_LIBRARY] = true;
$wgNamespacesWithSubpages[NS_LIBRARY] = true;

# Enable subpages
# User namespace and all talk namespaces are enabled by default
$wgNamespacesWithSubpages[NS_MAIN] = true;
$wgNamespacesWithSubpages[NS_PROJECT] = true;
$wgNamespacesWithSubpages[NS_TEMPLATE] = true;
	
$wgGroupPermissions['bot']['noratelimit'] = true;

# Disable anonymous editing
$wgGroupPermissions['*']['edit'] = false;

# Create new restriction levels for protecting pages
$wgRestrictionLevels[] = 'editors';
$wgRestrictionLevels[] = 'operators';

# Bots can delete pages
$wgGroupPermissions['bot']['delete'] = true;

# Regular users
$wgGroupPermissions['user']['move'] = false;

# Trusted users
$wgGroupPermissions['trusted-users']['autopatrol'] = true;
$wgGroupPermissions['trusted-users']['autoconfirmed'] = true;
$wgGroupPermissions['trusted-users']['skipcaptcha'] = true;

# Setup editor group
$wgGroupPermissions['editors']['autopatrol'] = true;
$wgGroupPermissions['editors']['autoconfirmed'] = true;
$wgGroupPermissions['editors']['skipcaptcha'] = true;
$wgGroupPermissions['editors']['editors'] = true;
$wgGroupPermissions['editors']['delete'] = true;
$wgGroupPermissions['editors']['move'] = true;
$wgGroupPermissions['editors']['suppressredirect'] = true;

# Setup operator group
$wgGroupPermissions['operators']['autopatrol'] = true;
$wgGroupPermissions['operators']['operators'] = true;
$wgGroupPermissions['operators']['suppressredirect'] = true;

# Make sure sysop are granted these rights as well
$wgGroupPermissions['sysop']['editors'] = true;
$wgGroupPermissions['sysop']['operators'] = true;

$wgMinimalPasswordLength = 8;

# Set global job run rate, this should be done out of process with RunJobs
$wgJobRunRate = 0;

$wgMaxShellMemory = 524288;

$wgDefaultSkin = "foreground";
wfLoadSkin( 'foreground' );
$wgForegroundFeatures = [
	'navbarIcon' => true,
	'showActionsForAnon' => true,
	'NavWrapperType' => 'divonly',
	'showHelpUnderTools' => true,
	'showRecentChangesUnderTools' => true,
	'IeEdgeCode' => 1,
	'showFooterIcons' => true
];

#$wgDefaultSkin = "chameleon";
wfLoadExtension( 'Bootstrap' );
wfLoadSkin( 'chameleon' );
$egChameleonLayoutFile= __DIR__ . '/skins/chameleon/layouts/fixedhead.xml';

wfLoadExtension( 'ParserFunctions' );
$wgPFEnableStringFunctions = true;

wfLoadExtension( 'WikiEditor' );
wfLoadExtension( 'CodeEditor' );
wfLoadExtension( 'SyntaxHighlight_GeSHi' );
wfLoadExtension( 'Scribunto' );
$wgScribuntoUseGeSHi = true;
$wgScribuntoUseCodeEditor = true;

wfLoadExtension( 'PdfHandler' );
$wgPdfProcessor = 'gs';
$wgPdfPostProcessor = $wgImageMagickConvertCommand;
$wgPdfInfo = 'pdfinfo';

wfLoadExtension( 'ConfirmEdit' );
wfLoadExtension( 'ConfirmEdit/QuestyCaptcha' );
// Note: answers are case insensitive
$wgCaptchaQuestions = [
	'What plant is the MediaWiki logo supposed to be?' => [ 'Sunflower', 'a sunflower' ],
	'What programming language does Scribunto allow you to use in templates?' => [ 'Lua' ],
	'If you include wikicode like {{foo}} what page is included?' => [ 'Template:Foo' ],
	'What is the name of the special page that shows the latest changes on a wiki?' => [ 'Special:Recentchanges', 'Recentchanges', 'Recent changes' ],
	'What is the name of the online encyclopedia that made wikis famous?' => ["Wikipedia", "english Wikipedia" ],
	'What sound does a cow make?' => [ 'Moo', 'Moo!' ],
	'What sound does a cat make?' => [ 'hiss', 'Meow', 'Meow!' ],
];
// This will automatically load meta's blacklist.
wfLoadExtension( 'SpamBlacklist' );
$wgGroupPermissions['emailconfirmed']['skipcaptcha'] = true;
$ceAllowConfirmedEmail = true;

wfLoadExtension( 'Gadgets' );

wfLoadExtension( 'Widgets' );
$wgGroupPermissions['sysop']['editwidgets'] = true;

wfLoadExtension( 'UniversalLanguageSelector' );
wfLoadExtension( 'Babel' );
wfLoadExtension( 'Translate' );
$wgGroupPermissions['translator']['translate'] = true;
$wgGroupPermissions['user']['translate'] = true;
$wgGroupPermissions['user']['translate-messagereview'] = true;
$wgGroupPermissions['user']['translate-groupreview'] = true;
$wgGroupPermissions['user']['translate-import'] = true;
$wgGroupPermissions['sysop']['pagetranslation'] = true;
$wgGroupPermissions['sysop']['translate-manage'] = true;
$wgTranslateDocumentationLanguageCode = 'qqq';
$wgExtraLanguageNames['qqq'] = 'Message documentation'; # No linguistic content. Used for documenting messages
$wgTranslateFuzzyBotName = 'Fuzzy Bee';

wfLoadExtension( 'Arrays' );
wfLoadExtension( 'Variables' );
wfLoadExtension( 'MyVariables' );
wfLoadExtension( 'CSS' );
wfLoadExtension( 'Disambiguator' );
wfLoadExtension( 'MagicNoCache' );

wfLoadExtension( 'ExternalData' );
$edgDBServer['apiary'] = "localhost";
$edgDBServerType['apiary'] = "mysql";
$edgDBName['apiary'] = "apiary";
$edgDBUser['apiary'] = "apiary";
$edgDBPass['apiary'] = $SECRET_EXTDATADBPASSWORD;

wfLoadExtension( 'SemanticMediaWiki' );
enableSemantics( 'wikiapiary.com' );
$smwgQEqualitySupport = SMW_EQ_NONE;
$smwgNamespacesWithSemanticLinks[NS_EXTENSION] = true;
$smwgNamespacesWithSemanticLinks[NS_FARM] = true;
$smwgNamespacesWithSemanticLinks[NS_SKIN] = true;
$smwgNamespacesWithSemanticLinks[NS_GENERATOR] = true;
$smwgNamespacesWithSemanticLinks[NS_HOST] = true;
$smwgNamespacesWithSemanticLinks[NS_LIBRARY] = true;
$smwgPageSpecialProperties[] = '_CDAT';
$smwgPageSpecialProperties[] = '_LEDT';
$smwgQUpperbound = 30000;
$smwgQMaxLimit = 30000;
$smwgQMaxSize = 24;
$smwgQMaxDepth = 16;
$smwgQConceptMaxSize = 20;
$smwgQConceptMaxDepth = 8;
$smwgQueryProfiler = array(
	'smwgQueryDurationEnabled' => true,
);

wfLoadExtension( 'SemanticResultFormats' );
$srfgArraySep = "\n";
$srfgArrayPropSep = ',';

wfLoadExtension( 'SemanticExtraSpecialProperties' );
$sespSpecialProperties = [
	'_PAGEID', // Let's get a Page ID
	'_CUSER',  // Creating user
	'_EUSER',  // All contributing users
	'_NREV',   // Number of revisions to page
	'_TNREV',  // Number of revisions to talk page
	'_SUBP',   // Add properties for subpages as well
	'_USERREG' // Add the date the user registered
];
$sespUseAsFixedTables = true;  // Use fixed properties
$wgSESPExcludeBots = true;     // Exclude bots from user stuff, except for creating user

wfLoadExtension( 'SemanticScribunto' );
wfLoadExtension( 'SemanticRating' );

wfLoadExtension( 'PageForms' );
$wgPageFormsRenameMainEditTab = true;
$wgPageFormsAutoCreateUser = 'Bumble Bee';

wfLoadExtension( 'HeaderTabs' );
$htRenderSingleTab = true;
$htEditTabLink = false;

$myWikiApiaryURL = "https://wikiapiary.com/wiki/WikiApiary";
$wgFooterIcons['monitoredby']['wikiapiary'] = [
	"src" => "https://wikiapiary.com/w/images/wikiapiary/b/b4/Monitored_by_WikiApiary.png",
	"url" => "$myWikiApiaryURL?pk_campaign=FooterIcon&pk_kwd=wikiapiary",
	"alt" => "Monitored by WikiApiary"
];

$wgFooterIcons['servedby']['mariadb'] = [
	"src" => "/mariadb-badge-88x31.png",
	"url" => "https://mariadb.org",
	"alt" => "Powered by MariaDB",
];

// Use an external link for SMW logo. It is 15K (more after base64 encoding!)
$wgFooterIcons['poweredby']['semanticmediawiki'] = [
	'src' => '/smw-logo.png',
	'url' => 'https://www.semantic-mediawiki.org/wiki/Semantic_MediaWiki',
	'alt' => 'Powered by Semantic MediaWiki',
	'class' => 'smw-footer'
];


/*
$wgFooterIcons['servedby']['wmfcloud'] = [
	"src" => "/served-by-wmfcloud.png",
	"url" => "https://wikitech.wikimedia.org/wiki/Help:Cloud_Services_Introduction",
	"alt" => "Served by Wikimedia Cloud Services",
];
*/
