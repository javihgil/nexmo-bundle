JhgNexmoBundle
==================

Integrates <a href="https://www.nexmo.com/">Nexmo</a> services in Symfony2. You require an API key/secret pair (you can try it for free).


Installation
------------

Add this bundle to your `composer.json` file:

    {
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/javihgil/nexmo-bundle.git"
            }
        ],
    
        "require": {
            "javihgil/nexmo-bundle": "dev-master"
        }
    }
    
Register the bundle in 'app/AppKernel.php':

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Jhg\NexmoBundle\JhgNexmoBundle(),
        );
    }
    
    
Configuration 
-------------

Configure your app config in `app/config/parameters.yml`. 

    # app/config/parameters.yml
    nexmo_api_key:      your_nexmo_api_key
    nexmo_api_secret:   your_nexmo_api_key
    nexmo_from_name:    App Name
    
If you want distribute your app in `app/config/parameters.yml.dist` too:

    # app/config/parameters.yml.dist
    nexmo_api_key:      ~
    nexmo_api_secret:   ~
    nexmo_from_name:    ~

Enable the bundle's configuration in `app/config/config.yml`:

    # app/config/config.yml
    jhg_nexmo:
        api_key:    %nexmo_api_key%
        api_secret: %nexmo_api_secret%
        from_name:  %nexmo_from_name%


Usage
-----

### Send SMS with service

    $sender = $this->getContainer()->get('jhg_nexmo_sms');
    $sender->sendText($number, $message, $fromName);

If no $fromName is provided 'jhg_nexmo.from_name' is used. This from name is limited to 11 characters (spaces and special chars are not allowed).

### Send SMS with command

You can send a SMS message using the proviced command

    php app/console nexmo:sms:send +34666555444 MyApp "Hello World!!"


Reference
---------

https://docs.nexmo.com/index.php/messaging-sms-api/send-message
    