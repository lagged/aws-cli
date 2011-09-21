## aws-cli

A small wrapper around AWS' PHP SDK to perform some tasks from the command line.

Current version: @package_version@

### Currently Supported

#### Elastic Loadbalancers

You can list all ELBs and register und unregister instances with one:

    $ ./scripts/aws-cli.php --listall
    $ ./scripts/aws-cli.php --elb=name --register=instanceID1,instanceID2
    $ ./scripts/aws-cli.php --elb=name --unregister=instanceID1,instanceID2

#### Others?

_Work in progress!_ (Please fork!)

### Requirements & Setup

 * PHP 5.3+ (curl)
 * setup: clone this repo
 * copy `etc/aws-cli.ini-dist` to `etc/aws-cli.ini` and add your credentials
 * run `scripts/aws-cli.php`

### Support

If you notice anything odd or want to add an improvement, feel free to open an issue and/or send a pull request.

### Todo

 * Refactor option parsing with `getopt()`
 * `--help --help` is unintuitive
