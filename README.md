### Xuborx Framework
**Framework Description:** This framework is designed to create web applications in the PHP. The framework core files are located in the directory vendor/xuborx/framework/core. You can develop the web application in the directory app (models, views, controllers) and configure in the directory config. Twig is used as a template engine. You can work with the database through the methods of the parent model or using the built-in library RedBeanPHP (official site: https://redbeanphp.com/). As of today, the framework is terribly underdeveloped and should not be taken seriously at the moment. :smile:

------------


**Installation**

You can deploy a project in the Xuborx framework using the composer package manager.
Just run command **composer create-project xuborx/framework project_name**.

------------


**Dependencies currently in use:**
- PHP (version 7.4 and upper)
- twig/twig (version 3.1 and upper)
- gabordemooij/redbean (version 5.6 and upper)
