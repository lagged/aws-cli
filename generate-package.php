#!/usr/bin/env php
<?php
ini_set('date.timezone', 'Europe/Berlin');
ini_set('display_errors', 'Off');

require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);

$packageName = 'AWS_Cli';

$api_version     = '0.1.0';
$api_state       = 'alpha';

$release_version = '0.1.0';
$release_state   = 'alpha';
$release_notes   = "Initial release!\n";

$description = "{$packageName} is a hopefully sane CLI to AWS services.\n"
    . "Currently supported: \n"
    . " * ELB \n\n"
    . "This is heavy work in progress.\n";

$package = new PEAR_PackageFileManager2();

$package->setOptions(
    array(
        'filelistgenerator' => 'file',
        'simpleoutput'      => true,
        'baseinstalldir'    => '/',
        'packagedirectory'  => './',
        'dir_roles'         => array(
            'src'     => 'php',
            'tests'   => 'test',
            'docs'    => 'doc',
            'scripts' => 'script',
            'etc'     => 'data',
        ),
        'exceptions'        => array(
            'README.md'   => 'doc',
            'phpunit.xml' => 'test',
        ),
        'ignore'            => array(
            '.git*',
            'etc/aws-cli.ini',
            'generate-package.php',
            '*.tgz',
            '*vendor*',
        )
    )
);

$summary = explode("\n", $description);

$package->setPackage($packageName);
$package->setSummary($summary[0]);
$package->setDescription($description);
$package->setChannel('easybib.github.com/pear');
$package->setPackageType('php');
$package->setLicense(
    'New BSD License',
    'http://www.opensource.org/licenses/bsd-license.php'
);

$package->setNotes($release_notes);
$package->setReleaseVersion($release_version);
$package->setReleaseStability($release_state);
$package->setAPIVersion($api_version);
$package->setAPIStability($api_state);

$package->addMaintainer(
    'lead',
    'till',
    'Till Klampaeckel',
    'till@lagged.biz'
);

/**
 * Generate the list of files in {@link $GLOBALS['files']}
 *
 * @param string $path
 *
 * @return void
 */
function readDirectory($path) {
    foreach (glob($path . '/*') as $file) {
        if (!is_dir($file)) {
            $GLOBALS['files'][] = $file;
        } else {
            readDirectory($file);
        }
    }
}

$files = array();
readDirectory(__DIR__ . '/src');

/**
 * @desc Strip this from the filename for 'addInstallAs'
 */
$base = __DIR__ . '/';

foreach ($files as $file) {

    $file2 = str_replace($base, '', $file);

    $package->addReplacement(
        $file2,
        'package-info',
        '@package_version@',
        'version'
    );
    $package->addReplacement(
        $file2,
        'pear-config',
        '@data_dir@',
        'data_dir'
    );

    $package->addInstallAs($file2, str_replace('src/', '', $file2));
}

/**
 * @desc Add some vars to these outside of src/
 */
$otherFiles = array(
    'scripts/aws-cli.php'  => 'aws-cli',
    'README.md'            => null,
    'etc/aws-cli.ini-dist' => 'aws-cli.ini-dist',
);

foreach ($otherFiles as $p => $f) {

    $package->addReplacement($p, 'package-info', '@package_version@', 'version');
    $package->addReplacement($p, 'pear-config', '@cfg_dir@', 'cfg_dir');
    $package->addReplacement($p, 'pear-config', '@php_dir@', 'php_dir');

    if ($f !== null) {
        $package->addInstallAs($p, $f);
    }
}

$package->setPhpDep('5.2.0');

$package->addPackageDepWithChannel(
    'required',
    'SDK',
    'pear.amazonwebservices.com',
    '1.4.2.1'
);

$package->addExtensionDep('required', 'spl');
$package->setPearInstallerDep('1.4.0a7');
$package->generateContents();

if (isset($_GET['make'])
    || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')
) {
    $package->writePackageFile();
} else {
    $package->debugPackageFile();
}
