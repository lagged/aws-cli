## aws-cli

A small wrapper around AWS' PHP SDK to perform some tasks from the command line.

### Currently Supported

#### Elastic Loadbalancers

You can list all ELBs and register und unregister instances with one:

    $ ./scripts/aws-cli.php --listall
    $ ./scripts/aws-cli.php --elb=name --register=instanceID1,instanceID2
    $ ./scripts/aws-cli.php --elb=name --unregister=instanceID1,instanceID2

#### Others?

Please fork! :-)
